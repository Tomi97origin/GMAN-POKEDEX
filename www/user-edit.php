<?php 
mb_internal_encoding("utf-8");
include "../app/login.php";
if(!$_SESSION['prihlaseni']==1){
    header("location: homepage.php");
}
if(isset($_POST['oldpass'])){
$Prihlaseni = new login;
$Prihlaseni->zmenaHesla($_POST['oldpass'],$_POST['password'],$_POST['confirm_password']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pokedex</title>
        <link rel="shortcut icon" href="assets/images/logov2.png" type="image/png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/css1.css" rel="stylesheet">
    </head>
    <body>
               <div class="topnav" id="myTopnav">
            <a href="Pokedex.php" class="logo"><img src="assets/images/menuicon.jpg" class="imglogo"></a>
                 <?php if(!$_SESSION['prihlaseni']==1){
                 echo '<a class="menu-cell" href="index.php" >Domů</a>';
                 echo '<a class="menu-cell" href="login.php">Log in</a>';
                 } ?>
            <a class="menu-cell" href="Pokedex.php">Pokedex</a>
            <a class="menu-cell" href="ucet.php" style="color:white; background-color: #ee1515;">Můj učet</a>
            <?php if($_SESSION['prihlaseni']==1){echo '<a class="menu-cell" href="odhlasit.php">Odhlasit</a>';} ?>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>


        <div class="login-page">
            <div class="form">
                <form class="register-form" method="POST">                 
                    <h2 class="message">Změna hesla</h2>
                    <input required name="oldpass" type="password" placeholder="Staré heslo"/>
                    <input required name="password" id="password" type="password" placeholder="Nové heslo" />
                    <input required type="password" name="confirm_password" id="confirm_password" placeholder="Heslo znovu" />
                    <button type="submit">Změnit</button>
                    
                </form>

            </div>
        </div>

    </body>
<script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>

</html>
