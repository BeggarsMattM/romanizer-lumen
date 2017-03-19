<?php

namespace Acme;

class PowersOfThousands
{
    private static $result;
    private static $_instance;

    public static function convert($n)
    {
        if (self::$_instance === null) {
          self::$_instance = new self;
         }

        /*  The base10 logarithm of our number will
         *  determine for us whether we need to deal with
         *  thousands, millions, thousand millions, etc.
         */
        $levels = floor(log10($n) / 3);

        /* Calculate the value of each "level" starting
         * from the largest, until none is left.
         */
        while ($levels >= 0) {
          $thislevel = (int) floor($n / pow(1000, $levels));
          $result[$levels] = $thislevel;
          $n -= $thislevel * pow(1000, $levels);
          $levels -= 1;
        }

        self::$result = $result;
        return self::$_instance;
    }

    /*   Roman numerals "ascend" to the next level when we
     *   hit 4000, 4000000, etc, rather than 1000, 1m, etc.
     *   This function corrects the result for such values.
     */
    public function romanize()
    {
        foreach (self::$result as $k => $v) {
          if ($k > 0 && $v < 4) {
            unset(self::$result[$k]);
            self::$result[$k - 1] += 1000 * $v;
          }
        }

        return self::$_instance;
    }

    public function get()
    {
      return self::$result;
    }
}
