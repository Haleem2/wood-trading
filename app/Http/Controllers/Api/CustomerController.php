<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:view_customers')->only(['index', 'show']);
        $this->middleware('permission:create_customers')->only(['store']);
        $this->middleware('permission:edit_customers')->only(['update']);
        $this->middleware('permission:delete_customers')->only(['destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Get list of customers",
     *     tags={"Customers"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for name or contact person",
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
     *         description="Customers retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CustomerResource"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => CustomerResource::collection($customers),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Create a new customer",
     *     tags={"Customers"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Construction Corp."),
     *             @OA\Property(property="contact_person", type="string", example="John Builder"),
     *             @OA\Property(property="email", type="string", format="email", example="john@constructioncorp.com"),
     *             @OA\Property(property="phone", type="string", example="+1-555-2000"),
     *             @OA\Property(property="address", type="string", example="500 Build Street, Construction City, CC 50000"),
     *             @OA\Property(property="tax_id", type="string", example="CUST001"),
     *             @OA\Property(property="credit_limit", type="number", format="float", example=100000.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerResource")
     *         )
     *     )
     * )
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'data' => new CustomerResource($customer),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Get customer by ID",
     *     tags={"Customers"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerResource")
     *         )
     *     )
     * )
     */
    public function show(Customer $customer): JsonResponse
    {
        $customer->load(['quotations', 'salesOrders', 'invoices', 'payments']);

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer),
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update customer",
     *     tags={"Customers"},
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
     *             @OA\Property(property="name", type="string", example="Updated Construction Corp."),
     *             @OA\Property(property="contact_person", type="string", example="John Builder"),
     *             @OA\Property(property="email", type="string", format="email", example="john@constructioncorp.com"),
     *             @OA\Property(property="phone", type="string", example="+1-555-2000"),
     *             @OA\Property(property="address", type="string", example="500 Build Street, Construction City, CC 50000"),
     *             @OA\Property(property="tax_id", type="string", example="CUST001"),
     *             @OA\Property(property="credit_limit", type="number", format="float", example=100000.00),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/CustomerResource")
     *         )
     *     )
     * )
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully',
            'data' => new CustomerResource($customer),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Delete customer",
     *     tags={"Customers"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Customer deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
        ]);
    }
}
