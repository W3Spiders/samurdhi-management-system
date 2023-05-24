<?php

namespace Database\Seeders;

use App\Models\FamilyUnit;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $familyUnits = FamilyUnit::all();

        // Iterate number of family units
        for ($familyUnitId = 1; $familyUnitId <= count($familyUnits); $familyUnitId++) {

            // Iterate number of members that this family unit owns
            for ($j = 1; $j <= 4; $j++) {

                $this->createSingleMember($familyUnitId);
            }
        }
    }

    public function createSingleMember($familyUnitId)
    {

        $birthday = Carbon::create(fake()->dateTimeBetween('-70 years', '-12 years'));
        $birthdayString = $birthday->toDateString(); // 1999-01-01
        $birthdayFirst4Digits = substr($birthdayString, 0, 4); // Remove '-' chars

        $nic = null;

        // Create NIC for people more than 16 years old.
        if ($birthday->diffInYears(Carbon::now()) > 16) {
            $nic = $birthdayFirst4Digits . fake()->randomNumber(8, true);
        }

        Member::factory()->create([
            'family_unit_id' => $familyUnitId,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birthday' => $birthday,
            'nic'=> $nic,
            'email' => fake()->email(),
            'phone' => $this->randomPhoneNumber()
        ]);
    }

    public function randomPhoneNumber() {

        $generalPhoneNumber = fake()->phoneNumber();

        $phoneNumber = $this->removeChars($generalPhoneNumber, ['-','(',')',' ', '+', '.']);

        $phoneNumber = substr($phoneNumber, 0, 10);

        return $phoneNumber;

    }

    private function removeChars($text,$chars = []) {

        $currentText = $text;

        foreach($chars as $char) {

            $currentText = str_replace($char, '', $currentText);

        }

        return $currentText;
    }
}