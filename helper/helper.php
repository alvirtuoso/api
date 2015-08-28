<?php 
function fixDate($date, $default="0000-00-00") {
    $fixed_date = $default;
    $date = trim($date);
    $phone_country_code = 1;
    if (preg_match("'^[0-9]{1,4}[/.-][0-9]{1,2}[/.-][0-9]{1,4}$'", $date)) {
        $dmy = preg_split("'[/.-]'", $date);
        if ($dmy[0] > 99) {
            $fixed_date = sprintf("%04u-%02u-%02u", $dmy[0], $dmy[1], $dmy[2]);
        } else {
            if ($dmy[0] != 0 || $dmy[1] != 0 || $dmy[2] != 0) {
              if ($dmy[2] < 1000) $dmy[2] += 1900;
              if ($dmy[2] < 1910) $dmy[2] += 100;
            }
            // phone_country_code indicates format of ambiguous input dates.
            if ($phone_country_code == 1)
              $fixed_date = sprintf("%04u-%02u-%02u", $dmy[2], $dmy[0], $dmy[1]);
            else
              $fixed_date = sprintf("%04u-%02u-%02u", $dmy[2], $dmy[1], $dmy[0]);
        }
    }

    return $fixed_date;
}
 ?>