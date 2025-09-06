<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CustomerResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="ABC Construction Ltd"),
 *     @OA\Property(property="contact_person", type="string", example="John Smith"),
 *     @OA\Property(property="email", type="string", example="john@abcconstruction.com"),
 *     @OA\Property(property="phone", type="string", example="+1-555-0123"),
 *     @OA\Property(property="address", type="string", example="123 Main St, City, State"),
 *     @OA\Property(property="tax_id", type="string", example="TAX123456789"),
 *     @OA\Property(property="credit_limit", type="number", format="float", example=50000.00),
 *     @OA\Property(property="outstanding_balance", type="number", format="float", example=2500.00),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="quotations", type="array", @OA\Items(ref="#/components/schemas/QuotationResource")),
 *     @OA\Property(property="sales_orders", type="array", @OA\Items(ref="#/components/schemas/SalesOrderResource")),
 *     @OA\Property(property="invoices", type="array", @OA\Items(ref="#/components/schemas/InvoiceResource")),
 *     @OA\Property(property="payments", type="array", @OA\Items(ref="#/components/schemas/PaymentResource")),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'tax_id' => $this->tax_id,
            'credit_limit' => $this->credit_limit,
            'outstanding_balance' => $this->outstanding_balance,
            'is_active' => $this->is_active,
            'quotations' => QuotationResource::collection($this->whenLoaded('quotations')),
            'sales_orders' => SalesOrderResource::collection($this->whenLoaded('salesOrders')),
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
