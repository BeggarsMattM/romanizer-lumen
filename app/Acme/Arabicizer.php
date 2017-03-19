<?php

namespace Acme;

class Arabicizer
{
    private $trans = [
      'M'  => 1000,
      'CM' => 900,
      'D'  => 500,
      'CD' => 400,
      'C'  => 100,
      'XC' => 90,
      'L'  => 50,
      'XL' => 40,
      'X'  => 10,
      'IX' => 9,
      'V'  => 5,
      'IV' => 4,
      'I'  => 1
     ];
 
    public function toArabic($n)
    {
        if (strlen($n) === 0) return 0;
        if (strlen($n) === 1) return $this->trans[$n];

        $firstTwoChars = substr($n, 0, 2);
        if (array_key_exists($firstTwoChars, $this->trans)) {
          $tail = substr($n, 2);
          return $this->trans[$firstTwoChars] + $this->toArabic($tail);
        }

        $head = $n[0];
        $tail = substr($n, 1);

        return $this->trans[$head] + $this->toArabic($tail);
    }

    private function parse($n)
    {
        $pattern = '/(\(+)(\w+)\)*(.*)/';
        preg_match($pattern, $n, $matches);

        return [
          'level' => strlen($matches[1]),
          'roman' => $matches[2],
          'tail'  => $matches[3]
        ];
    }

    public function toBiggerArabic($n)
    {
        if (strlen($n) === 0 || $n[0] !== "(") return $this->toArabic($n);

        $parsed = $this->parse($n);

        return pow(1000, $parsed['level']) * $this->toArabic($parsed['roman'])
          + $this->toBiggerArabic($parsed['tail']);
    }
}
