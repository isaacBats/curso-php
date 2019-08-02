<?php
/**
 * Short description for hello.php
 *
 * @package hello
 * @author daniel <daniel@daniel-lap-dell-l3560>
 * @version 0.1
 * @copyright (C) 2019 daniel <daniel@daniel-lap-dell-l3560>
 * @license MIT
 */

echo 'Hello php';
$hola = array(
    'llave' => 'Esto es un string',
    'puerto' => 125634,
    'funct' => function () { return 'Saludo'; },
);

echo '<pre>';
var_dump($hola);
echo '</pre>';
