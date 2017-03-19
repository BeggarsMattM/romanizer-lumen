<?php

namespace Acme;

use Exception;

class RomanNumeral
{
  private $n;
  private $trans;

  public function __construct($n)
  {
    $this->n = $n;
    $this->trans = [
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
  }

  private function isNothing()
  {
    return $this->n === "";
  }

  private function isSingleChar()
  {
    return strlen($this->n) === 1;
  }

  private function isSimple()
  {
    return self::isNothing() || $this->n[0] !== "(";
  }

  private function isComplex()
  {
    return ! self::isSimple();
  }

  public function value()
  {
    if ( ! self::isValidRoman() ) throw new Exception("Illegal character");
    return $this->trans[$this->n];
  }

  private function take($n)
  {
    return substr($this->n, 0, $n);
  }

  private function drop($n)
  {
    return substr($this->n, $n);
  }

  public function isValidRoman()
  {
    return array_key_exists($this->n, $this->trans);
  }

  public function translate()
  {
      if ( self::isNothing() ) return 0;
      if ( self::isComplex() ) return self::complexTranslate();
      if ( self::isSingleChar() ) return self::value();

      $firstTwoChars = new RomanNumeral(self::take(2));
      if ( $firstTwoChars->isValidRoman() ) {
        $tail = new RomanNumeral(self::drop(2));
        return $firstTwoChars->value() + $tail->translate();
      }

      $head = new RomanNumeral(self::take(1));
      $tail = new RomanNumeral(self::drop(1));
      return $head->value() + $tail->translate();
  }

  public function complexTranslate()
  {
      $complex = new ComplexRomanNumeral($this->n);
      return $complex->translate();
  }
}
