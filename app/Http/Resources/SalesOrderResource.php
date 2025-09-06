<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SalesOrderResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="order_no", type="string", example="SO-2024-001"),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="order_date", type="string", format="date"),
 *     @OA\Property(property="delivery_date", type="string", format="date"),
 *     @OA\Property(property="subtotal", type="number", format="float", example=2000.00),
 *     @OA\Property(property="tax_amount", type="number", format="float", example=200.00),
 *     @OA\Property(property="total_amount", type="number", format="float", example=2200.00),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="notes", type="string", example="Rush order - deliver ASAP"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class SalesOrderResource extends JsonResource
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
            'order_no' => $this->order_no,
            'customer_id' => $this->customer_id,
            'order_date' => $this->order_date,
            'delivery_date' => $this->delivery_date,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
