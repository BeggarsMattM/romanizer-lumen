<?php

namespace Acme;

use Exception;

class ArabicNumeral
{
    private $n;
    private $trans = [
      1000 => 'M',
       900 => 'CM',
       500 => 'D',
       400 => 'CD',
       100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
         9 => 'IX',
         5 => 'V',
         4 => 'IV',
         1 => 'I'
    ];

    public function __construct($n)
    {
        $this->n = $n;
        if ( self::isInvalid() ) throw new Exception('Unromanizable number');
    }

    private function isZero()
    {
      return $this->n === 0;
    }

    private function isComplex()
    {
      return $this->n >= 4000;
    }

    private function isInvalid()
    {
      return $this->n <= 0;
    }

    private function value()
    {
      return $this->trans[$this->n];
    }

    private function reducedBy($val) {
      return new ArabicNumeral($this->n - $val);
    }

    private function exceedsOrEquals($val) {
      return $this->n >= $val;
    }

    public function translate()
    {
      if ( self::isComplex() ) return self::complexTranslate();

      foreach ($this->trans as $value => $romanNumber)
      {
        if (self::exceedsOrEquals($value))
        {
          try {
            $reducedValue = self::reducedBy($value);
          }
          catch (Exception $e) {
            return $romanNumber;
          }
          return $romanNumber . $reducedValue->translate();
        }
      }
    }

    private function complexTranslate()
    {
      $components = PowersOfThousands::convert($this->n)
        ->romanize()->get();

      return array_map(function($component) {
        try {
          return (new ArabicNumeral($component))->translate();
        }
        catch (Exception $e) {
          return "";
        }
      }, $components);
    }
}
