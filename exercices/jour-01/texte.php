<?php

$brand = "Nike";
$model = "Air Max";

/* concaténation (.) */
echo "Chaussures " . $brand . " " . $model . "<br>";

/* interpolation ("...") */
echo "Chaussures $brand $model<br>";

/* sprintf() */
echo sprintf("Chaussures %s %s<br>", $brand, $model);

/*  différence entre guillemets doubles et simples */
$price = 99.99;

echo "Prix : $price €<br>";
echo 'Prix : $price €<br>';
