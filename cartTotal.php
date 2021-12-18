<?php
session_start();


if( $_SERVER['REQUEST_METHOD'] === 'POST'){

    $_SESSION['cartTotal'] = floatval($_SESSION['cartTotal']) + floatval($_POST['price']);
}
?>