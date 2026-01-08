<?php
//Utilise switch puis réécris avec match

switch ($status) {
    case 'standby':
        echo '<span style="color: orange;">Votre commande est en attente de traitement.</span>';
        break;
    case 'validated':
        echo '<span style="color: green;">Votre commande a été validé.</span>';
        break;
    case 'shipped':
        echo '<span style="color: blue;">Votre commande a été expédié.</span>';
        break;
    case 'delivered':
        echo '<span style="color: purple;">Votre commande a été livré.</span>';
        break;
    case 'canceled':
        echo '<span style="color: red;">Votre commande a été annulée.</span>';
        break;
}
echo match ($status) {
    'standby' => '<span style="color: orange;">Votre commande est en attente de traitement.</span>',
    'validated' => '<span style="color: green;">Votre commande a été validé.</span>',
    'shipped' => '<span style="color: blue;">Votre commande a été expédié.</span>',
    'delivered' => '<span style="color: purple;">Votre commande a été livré.</span>',
    'canceled' => '<span style="color: red;">Votre commande a été annulée.</span>',
    default => '<span style="color: gray;">Statut inconnu.</span>',
};

