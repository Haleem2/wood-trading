<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Item;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::factory()->create();
        $this->user = User::factory()->create([
            'tenant_id' => $this->tenant->id,
            'is_active' => true,
        ]);

        // Create permissions and roles
        $permissions = [
            'view_items',
            'create_items',
            'edit_items',
            'delete_items',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $role = Role::create(['name' => 'Test Role', 'guard_name' => 'web']);
        $role->givePermissionTo($permissions);
        $this->user->assignRole($role);
    }

    public function test_user_can_view_items()
    {
        Item::factory()->count(3)->create();

        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/items');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'data' => [
                            '*' => [
                                'id',
                                'code',
                                'name',
                                'species',
                                'grade',
                                'thickness',
                                'width',
                                'length',
                                'unit',
                                'barcode',
                                'moisture_level',
                                'low_stock_threshold',
                                'costing_method',
                                'is_active',
                                'created_at',
                                'updated_at',
                            ],
                        ],
                    ],
                ]);
    }

    public function test_user_can_create_item()
    {
        $itemData = [
            'code' => 'TEST-ITEM-001',
            'name' => 'Test Wood Item',
            'species' => 'Pine',
            'grade' => 'A',
            'thickness' => 38.1,
            'width' => 88.9,
            'length' => 2438.4,
            'unit' => 'piece',
            'barcode' => '1234567890123',
            'moisture_level' => 12.0,
            'low_stock_threshold' => 50.0,
            'costing_method' => 'FIFO',
        ];

        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/items', $itemData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Item created successfully',
                ]);

        $this->assertDatabaseHas('items', [
            'code' => 'TEST-ITEM-001',
            'name' => 'Test Wood Item',
        ]);
    }

    public function test_user_can_update_item()
    {
        $item = Item::factory()->create();

        $updateData = [
            'name' => 'Updated Item Name',
            'species' => 'Oak',
        ];

        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/items/{$item->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Item updated successfully',
                ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'Updated Item Name',
            'species' => 'Oak',
        ]);
    }

    public function test_user_can_delete_item()
    {
        $item = Item::factory()->create();

        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/items/{$item->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Item deleted successfully',
                ]);

        $this->assertSoftDeleted('items', [
            'id' => $item->id,
        ]);
    }

    public function test_user_cannot_create_item_without_permission()
    {
        $this->user->revokePermissionTo('create_items');

        $itemData = [
            'code' => 'TEST-ITEM-002',
            'name' => 'Test Wood Item',
            'species' => 'Pine',
            'grade' => 'A',
            'thickness' => 38.1,
            'width' => 88.9,
            'length' => 2438.4,
            'unit' => 'piece',
            'costing_method' => 'FIFO',
        ];

        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/items', $itemData);

        $response->assertStatus(403);
    }

    public function test_item_validation_rules()
    {
        $token = $this->user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/items', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'code',
                    'name',
                    'unit',
                    'costing_method',
                ]);
    }
}
