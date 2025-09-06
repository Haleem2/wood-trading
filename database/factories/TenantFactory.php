<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'domain' => $this->faker->unique()->domainName,
            'database' => 'tenant_' . $this->faker->unique()->slug,
            'settings' => [
                'currency' => 'USD',
                'timezone' => 'UTC',
                'date_format' => 'Y-m-d',
                'company_name' => $this->faker->company,
                'company_address' => $this->faker->address,
                'company_phone' => $this->faker->phoneNumber,
                'company_email' => $this->faker->companyEmail,
            ],
            'is_active' => true,
        ];
    }
}
