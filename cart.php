<?php
session_start();

if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_SESSION['cart'])){
        //maybe be assoc array instead?
        $cart = [$_POST['trackId']];
        $_SESSION['cart'] = $cart;
        
    }else{
        // $newArray = [$_POST['trackId'] => $_POST['trackId']];
        // $_SESSION['cart'] = array_merge($_SESSION['cart'], $newArray);
        array_push($_SESSION['cart'], $_POST['trackId']);
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'GET'){
    //reminder to myself. don't use 5 hours looking for a bug, if all you did was use 'return' instead of 'echo'...
    if(empty($_SESSION['cart'])){
        echo json_encode(false);
    }else{
        echo json_encode($_SESSION['cart']);
    }
    
    //$_SESSION['cart']
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    //unset the cart session so cart is empty
    unset($_SESSION['cart']);
    $_SESSION['cartTotal'] = 0;
}


?>