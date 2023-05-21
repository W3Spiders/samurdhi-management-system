<?php

namespace Database\Seeders;

use App\Models\FamilyUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Iterate number of GN divisions
        for ($gnDivisionId = 1; $gnDivisionId <= 3; $gnDivisionId++) {

            // Iterate number of family units that this GN division owns
            for ($j = 1; $j <= 3; $j++) {

                $this->createSingleFamilyUnit($gnDivisionId);
            }
        }
    }

    public function createSingleFamilyUnit($gnDivisionId)
    {
        FamilyUnit::factory()->create([
            'gn_division_id' => $gnDivisionId,
            'primary_member_id' => null,
            'address_line_1' => fake()->buildingNumber(),
            'address_line_2' => fake()->streetAddress(),
            'city' => fake()->city(),
            'postal_code' => '12345'
        ]);
    }
}