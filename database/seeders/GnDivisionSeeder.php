<?php

namespace Database\Seeders;

use App\Models\GNDivision;
use App\Models\User;
use Database\Seeders\Data\UserData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach($gnDivisions as $key=>$gnDivision) {

            $gnUser = $gnUsers[$key];
            $snUser = $snUsers[$key];

            GNDivision::factory()->create([
                'ward_no' => $gnDivision['ward_no'],
                'gn_division_no' => $gnDivision['gn_division_no'],
                'gn_division_name' => $gnDivision['gn_division_name'],
                'gn_user_id'=>$gnUser->id,
                'sn_user_id'=>$snUser->id
            ]);
        }
    }

    public function getGnDivisions() {
        return [
            array(
                'ward_no' => 1, 
                'gn_division_no' => '606A',
                'gn_division_name' => 'Welmilla'
            ),
            array(
                'ward_no' => 1, 
                'gn_division_no' => '606C',
                'gn_division_name' => 'Halapitiya'
            ),
           
        ];
    }
}