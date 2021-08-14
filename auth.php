<?php

session_start();

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

if(!isset($_SESSION['username1']) || !isset($_SESSION['password'])){
    header("Location: index.php");
}

if(isset($_SESSION['username1']) || isset($_SESSION['password']) || isset($_SESSION['self'])){


require_once 'vendor/autoload.php';
require_once 'config.php';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$username = $con->real_escape_string($_SESSION['username1']);
$password = $con->real_escape_string($_SESSION['password']);
if($_SESSION['self'] == 1){
    if($con->query("SELECT * FROM tbl_registrazioni WHERE username='$username' AND password='$password' AND stato='1'")->num_rows == 1){
        // Create config object with parameters
        $config =
        (new Config())
            ->set('host', '172.20.10.5')
            ->set('port', 8728)
            ->set('pass', 'Loris991')
            ->set('user', 'admin');

        // Initiate client with config object
        $client = new Client($config);

        /*
        * For the first we need to create new one user
        */

        $username1 = openssl_random_pseudo_bytes(12);
        $username1 = bin2hex($username1);
        $password1 = openssl_random_pseudo_bytes(12);
        $password1 = bin2hex($password1);

        // Build query
        $query =
        (new Query('/ip/hotspot/user/add'))
            ->equal('name', "$username1")
            ->equal('password', "$password1")
            ->equal('profile', 'ospiti');

        // Add user
        $client->query($query)->read();

        $con->query("UPDATE tbl_registrazioni SET stato='0' WHERE username='$username' AND password='$password'");

        header("Location: http://$ip_ros/login?username=$username1&password=$password1");
        session_destroy();
    }else{
        http_response_code(403);
        if(isset($_SESSION['username1'])){
        session_destroy();
        }
    }
}else{
    if($_SESSION['self'] == 0){
        if($con->query("SELECT * FROM tbl_users WHERE username='$username' AND password='$password' AND stato='0'")->num_rows == 1){

// Create config object with parameters
$config =
    (new Config())
        ->set('host', '172.20.10.5')
        ->set('port', 8728)
        ->set('pass', 'Loris991')
        ->set('user', 'admin');

// Initiate client with config object
$client = new Client($config);

/*
 * For the first we need to create new one user
 */

 $username1 = openssl_random_pseudo_bytes(12);
 $username1 = bin2hex($username1);
 $password1 = openssl_random_pseudo_bytes(12);
 $password1 = bin2hex($password1);

// Build query
$query =
    (new Query('/ip/hotspot/user/add'))
        ->equal('name', "$username1")
        ->equal('password', "$password1")
        ->equal('profile', 'ospiti');

// Add user
$client->query($query)->read();

$con->query("UPDATE tbl_users SET stato='1' WHERE username='$username' AND password='$password'");

header("Location: http://$ip_ros/login?username=$username1&password=$password1");
session_destroy();


}
}else{
    http_response_code(403);
    if(isset($_SESSION['username1'])){
    session_destroy();
}
}
}
}

?>
