<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:view_items')->only(['index', 'show']);
        $this->middleware('permission:create_items')->only(['store']);
        $this->middleware('permission:edit_items')->only(['update']);
        $this->middleware('permission:delete_items')->only(['destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/items",
     *     summary="Get list of items",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for name, code, or species",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="species",
     *         in="query",
     *         description="Filter by species",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="grade",
     *         in="query",
     *         description="Filter by grade",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Items retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ItemResource"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Item::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%");
            });
        }

        if ($request->has('species')) {
            $query->where('species', $request->get('species'));
        }

        if ($request->has('grade')) {
            $query->where('grade', $request->get('grade'));
        }

        $items = $query->with(['stockLots' => function ($q) {
            $q->selectRaw('item_id, SUM(qty_on_hand) as total_stock, SUM(qty_available) as available_stock')
              ->groupBy('item_id');
        }])->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => ItemResource::collection($items),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/items",
     *     summary="Create a new item",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code","name","species","grade","thickness","width","length","unit"},
     *             @OA\Property(property="code", type="string", example="PINE-2X4-8"),
     *             @OA\Property(property="name", type="string", example="Pine 2x4 8ft"),
     *             @OA\Property(property="species", type="string", example="Pine"),
     *             @OA\Property(property="grade", type="string", example="A"),
     *             @OA\Property(property="thickness", type="number", format="float", example=38.1),
     *             @OA\Property(property="width", type="number", format="float", example=88.9),
     *             @OA\Property(property="length", type="number", format="float", example=2438.4),
     *             @OA\Property(property="unit", type="string", example="piece"),
     *             @OA\Property(property="barcode", type="string", example="1234567890123"),
     *             @OA\Property(property="moisture_level", type="number", format="float", example=12.0),
     *             @OA\Property(property="low_stock_threshold", type="number", format="float", example=50.0),
     *             @OA\Property(property="costing_method", type="string", enum={"FIFO", "Average"}, example="FIFO")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Item created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ItemResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
        $item = Item::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Item created successfully',
            'data' => new ItemResource($item),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/items/{id}",
     *     summary="Get item by ID",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ItemResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function show(Item $item): JsonResponse
    {
        $item->load(['stockLots.warehouse']);

        return response()->json([
            'success' => true,
            'data' => new ItemResource($item),
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/items/{id}",
     *     summary="Update item",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Pine 2x4 8ft"),
     *             @OA\Property(property="species", type="string", example="Pine"),
     *             @OA\Property(property="grade", type="string", example="A"),
     *             @OA\Property(property="thickness", type="number", format="float", example=38.1),
     *             @OA\Property(property="width", type="number", format="float", example=88.9),
     *             @OA\Property(property="length", type="number", format="float", example=2438.4),
     *             @OA\Property(property="unit", type="string", example="piece"),
     *             @OA\Property(property="barcode", type="string", example="1234567890123"),
     *             @OA\Property(property="moisture_level", type="number", format="float", example=12.0),
     *             @OA\Property(property="low_stock_threshold", type="number", format="float", example=50.0),
     *             @OA\Property(property="costing_method", type="string", enum={"FIFO", "Average"}, example="FIFO"),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Item updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ItemResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $item->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'data' => new ItemResource($item),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/items/{id}",
     *     summary="Delete item",
     *     tags={"Inventory"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Item deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully',
        ]);
    }
}
