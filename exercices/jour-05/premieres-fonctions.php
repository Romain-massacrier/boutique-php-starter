<?php  

function greet(): void {
    echo "Bienvenue sur RétroLand !</br>";
}

function greetClient($name): void {
    echo "Bienvenue sur RétroLand, " . $name . " !</br>";
}   

greet();
greet();   
greetClient("Alice");
greetClient("Bob");
?>  