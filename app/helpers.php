<?php

namespace App\Helpers;

function generate_family_unit_ref($gn_division_no, $house_no) {
    $gn_division_no_cleaned = preg_replace("/[^a-zA-Z0-9]+/", "", $gn_division_no);
    $house_no_cleaned = preg_replace("/[^a-zA-Z0-9]+/", "", $house_no);

    return $gn_division_no_cleaned . $house_no_cleaned;
}