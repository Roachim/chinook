<?php
session_start();

if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_SESSION['cart'])){
        //maybe be assoc array instead? damn json string convert.
        $cart = [$_POST['trackId'] => $_POST['trackId']];
        $_SESSION['cart'] = $cart;
        
    }else{
        $newArray = [$_POST['trackId'] => $_POST['trackId']];
        $_SESSION['cart'] = array_merge($_SESSION['cart'], $newArray);
        //array_push($_SESSION['cart'], $_POST['trackId'] => $_POST['trackId']);
    }
  }


?>