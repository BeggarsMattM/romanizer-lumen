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

        $levels = floor(log10($n) / 3);

        while ($levels >= 0) {
          $thislevel = (int) floor($n / pow(1000, $levels));
          $result[$levels] = $thislevel;
          $n -= $thislevel * pow(1000, $levels);
          $levels -= 1;
        }

        self::$result = $result;
        return self::$_instance;
    }

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
