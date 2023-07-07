<?php

namespace Database\Seeders;

use App\Models\GNDivision;
use App\Models\User;
use Database\Seeders\Data\GnDivisionData;
use Illuminate\Database\Seeder;

class GnDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $gnDivisions = $this->getGnDivisions();
        $gnUsers = User::where('user_type', 'gn')->get();
        $snUsers = User::where('user_type', 'sn')->get();

        // Create GN Divisions using already created GN and SN Users
        foreach ($gnDivisions as $key => $gnDivision) {

            $gnUser = isset($gnUsers[$key]) ? $gnUsers[$key] : null;
            $snUser = isset($snUsers[$key]) ? $snUsers[$key] : null;

            GNDivision::factory()->create([
                'ward_no' => $gnDivision['ward_no'],
                'gn_division_no' => $gnDivision['gn_division_no'],
                'gn_division_name' => $gnDivision['gn_division_name'],
                'gn_user_id' => $gnUser ? $gnUser->id : null,
                'sn_user_id' => $gnUser ? $snUser->id : null
            ]);
        }
    }

    public function getGnDivisions()
    {
        return GnDivisionData::$gn_division_data;
    }
}
