<?php

namespace App\Traits;

trait HasDefaultPassword
{
    public function generatePassword ($length = 8) {
        $_alphaSmall = 'abcdefghijklmnopqrstuvwxyz';
        $_alphaCaps  = strtoupper($_alphaSmall);
        $_numerics   = '1234567890';
        $_specialChars = '`~!@#$%^&*()-_=+]}[{;:,<.>/?\'"\|';
        $_container = $_alphaSmall.$_alphaCaps.$_numerics.$_specialChars;
        $password = ''; 

        $password = substr(str_shuffle($_container), 0, $length);

        return $password;
    }
}