<?php

namespace Database\Seeders;

use App\Models\Member;
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
        // Iterate number of family units
        for ($familyUnitId = 1; $familyUnitId <= 6; $familyUnitId++) {

            // Iterate number of members that this family unit owns
            for ($j = 1; $j <= 4; $j++) {

                $this->createSingleMember($familyUnitId);
            }
        }
    }

    public function createSingleMember($familyUnitId)
    {
        Member::factory()->create([
            'family_unit_id' => $familyUnitId,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birthday' => fake()->dateTimeBetween('-70 years', '-20 years'),
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