<?php

/**
 * Ejercicio 1
 */
printf("El resultado de la operacion 32 + 3 = %d", 32 + 3);
// variable
$valor = array_rand(rand(0, 30), '10');
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
