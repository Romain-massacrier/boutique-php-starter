<?php
$a = 0;
$b = "";
$c = null;
$d = false;
$e = "0";

// Compare $a avec $b, $c, $d, $e en utilisant == puis ===
// Utilise var_dump() pour chaque comparaison

echo "<pre>";

echo "\$a == \$b : "; var_dump($a == $b);
echo "\$a === \$b: "; var_dump($a === $b);
echo "\n";

echo "\$a == \$c : "; var_dump($a == $c);
echo "\$a === \$c: "; var_dump($a === $c);
echo "\n";

echo "\$a == \$d : "; var_dump($a == $d);
echo "\$a === \$d: "; var_dump($a === $d);
echo "\n";

echo "\$a == \$e : "; var_dump($a == $e);
echo "\$a === \$e: "; var_dump($a === $e);