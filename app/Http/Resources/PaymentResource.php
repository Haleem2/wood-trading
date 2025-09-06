<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PaymentResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="payment_no", type="string", example="PAY-2024-001"),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="invoice_id", type="integer", example=1),
 *     @OA\Property(property="payment_date", type="string", format="date"),
 *     @OA\Property(property="amount", type="number", format="float", example=1000.00),
 *     @OA\Property(property="payment_method", type="string", example="bank_transfer"),
 *     @OA\Property(property="reference_no", type="string", example="TXN123456789"),
 *     @OA\Property(property="notes", type="string", example="Payment for invoice INV-2024-001"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class PaymentResource extends JsonResource
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
            'payment_no' => $this->payment_no,
            'customer_id' => $this->customer_id,
            'invoice_id' => $this->invoice_id,
            'payment_date' => $this->payment_date,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'reference_no' => $this->reference_no,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
