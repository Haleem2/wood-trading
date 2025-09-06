<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="StockLotResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="lot_no", type="string", example="LOT2024001"),
 *     @OA\Property(property="qty_on_hand", type="integer", example=100),
 *     @OA\Property(property="qty_reserved", type="integer", example=10),
 *     @OA\Property(property="qty_available", type="integer", example=90),
 *     @OA\Property(property="cost", type="number", format="float", example=25.50),
 *     @OA\Property(property="received_at", type="string", format="date-time"),
 *     @OA\Property(property="expires_at", type="string", format="date-time"),
 *     @OA\Property(property="warehouse", ref="#/components/schemas/WarehouseResource"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class StockLotResource extends JsonResource
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
            'lot_no' => $this->lot_no,
            'qty_on_hand' => $this->qty_on_hand,
            'qty_reserved' => $this->qty_reserved,
            'qty_available' => $this->qty_available,
            'cost' => $this->cost,
            'received_at' => $this->received_at,
            'expires_at' => $this->expires_at,
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
