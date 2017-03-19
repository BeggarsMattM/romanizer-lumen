<?php

namespace Acme;

class Romanizer
{
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

    public function toRoman($n)
    {
        if ($n <= 0) { throw new \Exception; }
        return $this->_toRoman($n);
    }

    public function _toRoman($n)
    {
        if ($n == 0) return "";

        foreach ($this->trans as $arabic => $roman) {
          if ($n >= $arabic) {
            return $roman . $this->_toRoman($n - $arabic);
          }
        }
    }

    public function toBiggerRoman($n)
    {
      if ($n <= 0) { throw new \Exception; }
      return $this->_toBiggerRoman($n);
    }

    public function _toBiggerRoman($n)
    {
        if ($n == 0) return "";

        $components = PowersOfThousands::convert($n)->get();

        return array_map(function($component) {
          return $this->_toRoman($component);
        }, $components);
    }

}
