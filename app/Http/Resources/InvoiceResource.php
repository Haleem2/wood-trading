<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="InvoiceResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="invoice_no", type="string", example="INV-2024-001"),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="invoice_date", type="string", format="date"),
 *     @OA\Property(property="due_date", type="string", format="date"),
 *     @OA\Property(property="subtotal", type="number", format="float", example=2000.00),
 *     @OA\Property(property="tax_amount", type="number", format="float", example=200.00),
 *     @OA\Property(property="total_amount", type="number", format="float", example=2200.00),
 *     @OA\Property(property="paid_amount", type="number", format="float", example=0.00),
 *     @OA\Property(property="balance_due", type="number", format="float", example=2200.00),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="notes", type="string", example="Payment due within 30 days"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class InvoiceResource extends JsonResource
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
            'invoice_no' => $this->invoice_no,
            'customer_id' => $this->customer_id,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'balance_due' => $this->balance_due,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
