<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockLot;
use App\Models\StockMovement;
use App\Http\Requests\StockAdjustmentRequest;
use App\Http\Resources\StockLotResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:view_stock')->only(['index', 'show']);
        $this->middleware('permission:adjust_stock')->only(['adjust']);
    }

    /**
     * @OA\Get(
     *     path="/api/stock",
     *     summary="Get stock levels",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="item_id",
     *         in="query",
     *         description="Filter by item ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="warehouse_id",
     *         in="query",
     *         description="Filter by warehouse ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="low_stock",
     *         in="query",
     *         description="Show only low stock items",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Stock levels retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/StockLotResource"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = StockLot::with(['item', 'warehouse']);

        if ($request->has('item_id')) {
            $query->where('item_id', $request->get('item_id'));
        }

        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->get('warehouse_id'));
        }

        if ($request->boolean('low_stock')) {
            $query->whereHas('item', function ($q) {
                $q->whereRaw('stock_lots.qty_available <= items.low_stock_threshold');
            });
        }

        $stockLots = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => StockLotResource::collection($stockLots),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/stock/adjust",
     *     summary="Adjust stock levels",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"item_id","warehouse_id","quantity","type","reason"},
     *             @OA\Property(property="item_id", type="integer", example=1),
     *             @OA\Property(property="warehouse_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="number", format="float", example=10.5),
     *             @OA\Property(property="type", type="string", enum={"adjustment"}, example="adjustment"),
     *             @OA\Property(property="movement", type="string", enum={"in","out"}, example="in"),
     *             @OA\Property(property="reason", type="string", example="Physical count adjustment"),
     *             @OA\Property(property="notes", type="string", example="Found additional stock during inventory")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Stock adjusted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Stock adjusted successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/StockLotResource")
     *         )
     *     )
     * )
     */
    public function adjust(StockAdjustmentRequest $request): JsonResponse
    {
        $item = Item::findOrFail($request->item_id);
        $warehouse = \App\Models\Warehouse::findOrFail($request->warehouse_id);

        // Find or create stock lot
        $stockLot = StockLot::where('item_id', $item->id)
            ->where('warehouse_id', $warehouse->id)
            ->where('lot_no', 'ADJ-' . now()->format('YmdHis'))
            ->first();

        if (!$stockLot) {
            $stockLot = StockLot::create([
                'item_id' => $item->id,
                'warehouse_id' => $warehouse->id,
                'lot_no' => 'ADJ-' . now()->format('YmdHis'),
                'qty_on_hand' => 0,
                'qty_reserved' => 0,
                'qty_available' => 0,
                'cost' => 0,
                'received_at' => now(),
            ]);
        }

        // Update stock quantities
        if ($request->movement === 'in') {
            $stockLot->increment('qty_on_hand', $request->quantity);
        } else {
            $stockLot->decrement('qty_on_hand', $request->quantity);
        }

        $stockLot->refresh();

        // Create stock movement record
        StockMovement::create([
            'item_id' => $item->id,
            'warehouse_id' => $warehouse->id,
            'stock_lot_id' => $stockLot->id,
            'type' => $request->type,
            'movement' => $request->movement,
            'quantity' => $request->quantity,
            'unit_cost' => 0,
            'reference_type' => 'adjustment',
            'reference_id' => null,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stock adjusted successfully',
            'data' => new StockLotResource($stockLot->load('item', 'warehouse')),
        ]);
    }
}
