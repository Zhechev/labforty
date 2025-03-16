<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEgn implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidEGN($value)) {
            $fail('Невалидно ЕГН. Моля, въведете валидно ЕГН.');
        }
    }

    /**
     * Check if the provided EGN is valid.
     *
     * @param string $egn
     * @return bool
     */
    private function isValidEGN($egn): bool
    {
        if (empty($egn)) {
            return false;
        }

        if (!is_numeric($egn)) {
            return false;
        }

        if (strlen($egn) != 10) {
            return false;
        }

        // Check foreigner EGN before basic
        $egnarr = str_split($egn);
        if ($egnarr[0] == 1 && $egnarr[1] == 0) {
            return true;
        }

        if (!$this->basicEgnValidation($egn)) {
            return false;
        }

        $t = [2, 4, 8, 5, 10, 9, 7, 3, 6];
        $sum = 0;

        for ($i = 0; $i < 9; ++$i) {
            if ($egnarr[$i] != 0) {
                $sum += ($egnarr[$i] * $t[$i]);
            }
        }

        $last = $sum % 11;
        if (10 == $last) {
            $last = 0;
        }

        return $egnarr[9] == $last;
    }

    /**
     * Perform basic EGN validation (date validation).
     *
     * @param string $egn
     * @return bool
     */
    private function basicEgnValidation($egn): bool
    {
        // Extract date components from EGN
        $year = substr($egn, 0, 2);
        $month = substr($egn, 2, 2);
        $day = substr($egn, 4, 2);

        // Adjust year and month based on month value
        if ($month > 40) {
            // Person born after 2000
            $year = 2000 + intval($year);
            $month = $month - 40;
        } elseif ($month > 20) {
            // Person born between 1800 and 1899
            $year = 1800 + intval($year);
            $month = $month - 20;
        } else {
            // Person born between 1900 and 1999
            $year = 1900 + intval($year);
        }

        // Validate date
        return checkdate($month, $day, $year);
    }
}
