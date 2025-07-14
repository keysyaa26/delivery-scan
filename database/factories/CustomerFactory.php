<?php

namespace Database\Factories;

use App\Models\Customers\HpmCustomer;
use App\Models\Customers\HinoCustomer;
use App\Models\Customers\AdmCustomer;
use App\Models\Customers\SuzukiCustomer;
use App\Models\Customers\TmminCustomer;
use App\Models\Customers\MmkiCustomer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // Add default attributes for the customer model here
            // Example:
            // 'name' => $this->faker->name,
        ];
    }

    public static function createCustomerInstance(string $customer) {
        return match ($customer) {
            'hpm' => new HpmCustomer(),
            'hino' => new HinoCustomer(),
            'adm' => new AdmCustomer(),
            'suzuki' => new SuzukiCustomer(),
            'tmmin' => new TmminCustomer(),
            'mmki' => new MmkiCustomer(),
            default => throw new \InvalidArgumentException("Invalid customer type: $customer"),
        };
    }
}
