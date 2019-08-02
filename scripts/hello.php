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

echo '<h1>Ejercicios de operadores</h1>';
echo '<h3>Ejercicio 1</h3>';
echo '<p>Calcula el resultado de 32+3 y 3(2+3). Escribe el procedimiento que empleaste en la sección de discusiones.</p>';
printf("El resultado de la operacion 32 + 3 = %d", 32 + 3);
echo '<br><h3>Ejercicio 2</h3>';
echo '<p>Tomando en cuenta que tenemos una variable llamada $valor, escribe en la sección de discusiones ¿Cómo sería un condicional para las siguientes opciones?<br><br>

    > $valor es mayor que 5 pero menor que 10 <br>
    > $valor es mayor o igual a 0 pero menor o igual a 20 <br>
    > $valor es igual a “10” asegurando que el tipo de dato sea cadena <br>
    > $valor es mayor a 0 pero menor a 5 o es mayor a 10 pero menor a 15 <br>
</p>';
//$valor = rand(0, 30);
// $valor = '10';
$arrayDeValores = [rand(0, 30), '10'];
// referencia: https://www.php.net/manual/es/function.array-rand.php
$valor = $arrayDeValores[array_rand($arrayDeValores)];
echo "La variable \$valor en estos momentos contiene: {$valor} y es de tipo ". gettype($valor) ."<br><br>";
if ( $valor > 5 && $valor < 10 )
    echo "Tu valor es mayor a 5 pero menor que 10. <br> Valor = {$valor} <br>";
if ( $valor >= 0 && $valor <= 20 )
    echo "Tu valor es mayor o igual a 0 pero menor que 20. <br> Valor = {$valor}<br>";
if ( $valor === '10' )
    echo "Valor es de tipo " . gettype($valor) . " y vale {$valor} <br>";
if ( $valor > 0 && $valor < 5 )
    echo "Tu valor es mayor que 0 pero menor que 5. <br> Valor = {$valor}";
elseif ( $valor > 10 && $valor < 15 )
    echo "Tu valor es mayor que 10 pero menor que 15. <br> Valor = {$valor}";

