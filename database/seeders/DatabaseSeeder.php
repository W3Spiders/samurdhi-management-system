<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\FamilyUnit;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WardSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(OccupationTypeSeeder::class);
        $this->call(WardSeeder::class);
        $this->call(GnDivisionSeeder::class);
        $this->call(FamilyUnitStatusSeeder::class);
        $this->call(FamilyUnitSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(PaymentRequestStatusSeeder::class);

        $this->select_primary_member_for_each_family_unit();
    }

    public function select_primary_member_for_each_family_unit()
    {
        $familyUnits = FamilyUnit::all();

        foreach ($familyUnits as $unit) {
            // Select primary eligible member as 25 or older one.
            $primaryEligibleMember = Member::where('family_unit_id', '=', $unit->id)->where('birthday', '<=', Carbon::now()->subYears(25))->first();

            if ($primaryEligibleMember) {
                $unit->primary_member_id = $primaryEligibleMember->id;
                $unit->update();
            }
        }
    }
}
