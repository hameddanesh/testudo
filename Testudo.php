<?php

/*
 * testudo
 * https://github.com/hameddanesh/testudo
 *
 * Copyright 2024, Hamed Danesh
 *
 * Licensed under the MIT license:
 * https://opensource.org/license/mit/
 *
 */

namespace App\secreturity;

class Testudo
{
    public function form(string $value, string $valueHash)
    {
        $seed = $this->getSeed($valueHash, $value);
        return $this->xor($this->textToBinary($value), $seed);
    }

    public function unform(string $secretret, string $seed)
    {
        return  $this->binaryToText($this->xor($secretret, $seed));
    }

    public function textToBinary(string $text)
    {
        $bin = (string)"";
        $prep = (string)"";

        for ($i = 0; $i < strlen($text); $i++) {
            $bincur = decbin(ord($text[$i]));
            $binlen = strlen($bincur);

            if ($binlen < 8)
                for ($j = 8; $j > $binlen; $binlen++)
                    $prep .= "0";

            $bin .= $prep . $bincur . " ";

            $prep = "";
        }

        return substr($bin, 0, strlen($bin) - 1);
    }

    public function binaryToText(string $binaryString)
    {
        $char = explode(' ', $binaryString);
        $nstr = '';
        foreach ($char as $ch) $nstr .= chr(bindec($ch));
        return $nstr;
    }

    public function getSeed(string $hashBinary, string $valueBinary)
    {
        $rep = ((int)(strlen($valueBinary) / strlen($hashBinary))) + 1;

        $temp = "";

        for ($i = 0; $i < $rep; $i++)
            $temp .= $hashBinary;

        $hashBinary = $temp;
        return $this->textToBinary($hashBinary) . substr(0, strlen($this->textToBinary($valueBinary)));
    }

    public function xor(string $_binaryString, string $_seed)
    {
        $xString = "";
        $binaryString = str_replace(" ", "", $_binaryString);
        $seed = str_replace(" ", "", $_seed);

        $counter = 0;
        for ($i = 0; $i < strlen($binaryString); $i++) {
            $counter++;
            if ($binaryString[$i] != $seed[$i])
                $xString .= "1";
            else
                $xString .= "0";

            if ($counter >= 8) {
                $xString .= " ";
                $counter = 0;
            }
        }
        return $xString;
    }
}
