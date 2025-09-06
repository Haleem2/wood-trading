<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ItemResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="WOOD001"),
 *     @OA\Property(property="name", type="string", example="Oak Hardwood Plank"),
 *     @OA\Property(property="species", type="string", example="Oak"),
 *     @OA\Property(property="grade", type="string", example="A"),
 *     @OA\Property(property="thickness", type="number", format="float", example=2.5),
 *     @OA\Property(property="width", type="number", format="float", example=6.0),
 *     @OA\Property(property="length", type="number", format="float", example=96.0),
 *     @OA\Property(property="unit", type="string", example="pieces"),
 *     @OA\Property(property="barcode", type="string", example="1234567890123"),
 *     @OA\Property(property="moisture_level", type="number", format="float", example=12.5),
 *     @OA\Property(property="low_stock_threshold", type="integer", example=100),
 *     @OA\Property(property="costing_method", type="string", example="FIFO"),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="total_stock", type="integer", example=500),
 *     @OA\Property(property="available_stock", type="integer", example=450),
 *     @OA\Property(property="reserved_stock", type="integer", example=50),
 *     @OA\Property(property="is_low_stock", type="boolean", example=false),
 *     @OA\Property(property="stock_lots", type="array", @OA\Items(ref="#/components/schemas/StockLotResource")),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'species' => $this->species,
            'grade' => $this->grade,
            'thickness' => $this->thickness,
            'width' => $this->width,
            'length' => $this->length,
            'unit' => $this->unit,
            'barcode' => $this->barcode,
            'moisture_level' => $this->moisture_level,
            'low_stock_threshold' => $this->low_stock_threshold,
            'costing_method' => $this->costing_method,
            'is_active' => $this->is_active,
            'total_stock' => $this->when(isset($this->total_stock), $this->total_stock),
            'available_stock' => $this->when(isset($this->available_stock), $this->available_stock),
            'reserved_stock' => $this->when(isset($this->reserved_stock), $this->reserved_stock),
            'is_low_stock' => $this->when(isset($this->is_low_stock), $this->is_low_stock),
            'stock_lots' => StockLotResource::collection($this->whenLoaded('stockLots')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
