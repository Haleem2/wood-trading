<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="QuotationResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="quotation_no", type="string", example="QUO-2024-001"),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="quotation_date", type="string", format="date"),
 *     @OA\Property(property="valid_until", type="string", format="date"),
 *     @OA\Property(property="subtotal", type="number", format="float", example=1000.00),
 *     @OA\Property(property="tax_amount", type="number", format="float", example=100.00),
 *     @OA\Property(property="total_amount", type="number", format="float", example=1100.00),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="notes", type="string", example="Special pricing for bulk order"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class QuotationResource extends JsonResource
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
            'quotation_no' => $this->quotation_no,
            'customer_id' => $this->customer_id,
            'quotation_date' => $this->quotation_date,
            'valid_until' => $this->valid_until,
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
