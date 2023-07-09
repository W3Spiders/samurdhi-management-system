<?php

namespace Database\Seeders;

use App\Models\FamilyUnit;
use App\Models\FamilyUnitStatus;
use App\Models\GnDivision;
use Illuminate\Database\Seeder;

use function App\Helpers\generate_family_unit_ref;

class FamilyUnitSeeder extends Seeder
{

    private $family_unit_statuses = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->family_unit_statuses = FamilyUnitStatus::all();

        // Iterate number of GN divisions
        for ($gn_division_id = 1; $gn_division_id <= 2; $gn_division_id++) {

            // Iterate number of family units that this GN division owns
            for ($j = 1; $j <= 50; $j++) {

                $this->create_single_family_unit($gn_division_id);
            }
        }
    }

    public function create_single_family_unit($gn_division_id)
    {

        $gn_division = GnDivision::find($gn_division_id);
        $house_no = fake()->buildingNumber();
        $gn_division_no = $gn_division->gn_division_no;

        $status_id = count($this->family_unit_statuses) > 0 ? fake()->randomElement($this->family_unit_statuses)->id : 1;

        FamilyUnit::factory()->create([
            'gn_division_id' => $gn_division_id,
            'primary_member_id' => null,
            'family_unit_ref' => generate_family_unit_ref($gn_division_no, $house_no),
            'house_no' => $house_no,
            'address_line_1' => fake()->buildingNumber(),
            'address_line_2' => fake()->streetAddress(),
            'city' => fake()->city(),
            'postal_code' => '12345', 
            'status_id' => $status_id
        ]);
    }
}