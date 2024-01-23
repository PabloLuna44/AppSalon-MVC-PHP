<?php

function debugger($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}


//Funcion que revisa que el usuario esta autenticado

function isAuth():void{

    if(!isset($_SESSION['login'])){
    header('Location: /');
    }
}


function isAdmin():void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}


function verifyDate($date){

if(is_int($date[2]) && is_int($date[1]) && is_int($date[0])){   
    return true;
    
}


return false;

}