<?php
session_start();
mb_internal_encoding("utf-8");
if($_SESSION["prihlaseni"]==1){
$_SESSION["prihlaseni"]=0;
unset($_SESSION);
}
header("location: login.php"); 
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>TODO write content</div>
    </body>
</html>