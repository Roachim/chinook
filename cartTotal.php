<?php
session_start();


if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_SESSION['cart'])){
        $cart = [$_POST['trackId']];
        $_SESSION['cart'] = $cart;
        
    }else{
        array_push($_SESSION['cart'], $_POST['trackId']);
    }
}

?>