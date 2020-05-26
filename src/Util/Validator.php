<?php

namespace App\Util;

/**
 * Утилиты валидации.
 */
class Validator
{
    /**
     * Валидация биткоин кошелька.
     *
     * @param string $wallet
     *
     * @return bool
     */
    public static function validateBitcoin(string $wallet): bool
    {
        try {
            $decoded = self::decodeBase58($wallet);

            $d1 = \hash("sha256", \substr($decoded, 0, 21), true);
            $d2 = \hash("sha256", $d1, true);

            if (\substr_compare($decoded, $d2, 21, 4)) {
                throw new \Exception("bad digest");
            }
        }
        catch (\Exception $e) {
            return false;
        }


        return true;
    }

    /**
     * Валидация WMZ кошелька.
     *
     * @param string $wallet
     *
     * @return bool
     */
    public static function validateWMZ(string $wallet): bool
    {
        return preg_match("/^[ZER][0-9]{12}$/", $wallet);
    }

    /**
     * Декодировщик base58.
     *
     * @param $input
     *
     * @return string
     * @throws \Exception
     */
    private static function decodeBase58($input): string
    {
        $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

        $out = \array_fill(0, 25, 0);
        for ($i = 0; $i < \strlen($input); $i++) {
            if (($p = \strpos($alphabet, $input[$i])) === false) {
                throw new \Exception("invalid character found");
            }
            $c = $p;
            for ($j = 25; $j--;) {
                $c += (int)(58 * $out[$j]);
                $out[$j] = (int)($c % 256);
                $c /= 256;
                $c = (int)$c;
            }
            if ($c != 0) {
                throw new \Exception("address too long");
            }
        }

        $result = "";
        foreach ($out as $val) {
            $result .= \chr($val);
        }

        return $result;
    }
}