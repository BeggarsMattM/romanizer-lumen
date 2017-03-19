<?php

namespace Acme;

use Exception;

class ComplexRomanNumeral {

  private $n;
  private $level;
  private $roman;
  private $tail;

  public function __construct($n)
  {
    $this->n = $n;
    self::parse();
  }

  public function translate()
  {
    return pow(1000, $this->level) * $this->roman->translate()
      + $this->tail->translate();
  }

  public function parse()
  {
      $pattern = '/(\(+)(\w+)\)*(.*)/';
      preg_match($pattern, $this->n, $matches);

      $this->level = strlen($matches[1]);
      $this->roman = new RomanNumeral($matches[2]);
      $this->tail  = new RomanNumeral($matches[3]);
  }

}
