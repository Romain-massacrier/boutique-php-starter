<?php
$categories = ["Vêtements", "Chaussures", "Accesoires", "Sport"];

// in_array vérifie si une valeur existe dans un tableau

if (in_array("Chaussures", $categories)) {
    echo "Chaussures : Trouvé !<br>";
    } else {
        echo "Chaussures : Non trouvé<br>";
    }

    if (in_array("Electronique", $categories)) {
    echo "Electronique : Trouvé !<br>";
    } else {
        echo "Electronique : Non trouvé<br>";
    }

    $indexSport = array_search("Sport", $categories);

    echo "Index de sport : " . $indexSport;