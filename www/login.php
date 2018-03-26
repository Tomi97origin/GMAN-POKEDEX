<?php 
//error_reporting(null);
include "../app/login.php";
if(isset($_SESSION['prihlaseni'])){
if($_SESSION['prihlaseni']==1){
    header("location: Pokedex.php");
}
}

if(isset($_POST["Heslo"])){
     $username=$_POST["Username"];
     $heslo=$_POST["Heslo"];
    $Prihlaseni = new login;
$Prihlaseni->prihlaseni($username,$heslo);

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
            <a class="menu-cell" href="index.php">Domů</a>
            <a class="menu-cell" href="login.php" style="color:white; background-color: #ee1515;">Log in</a>
            <a class="menu-cell" href="Pokedex.php">Pokedex</a>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>

        <div class="login-page">
            <div class="form">
                <form method="POST" class="login-form">
                    <h2 class="message">Zadejte prosím své jméno a heslo.</h2> 
                    <input name="Username" required type="text" placeholder="Jméno"/>
                    <input name="Heslo" required type="password" placeholder="Heslo"/>
                    <button type="submit" value="submit">Přihlásit se</button>
                    <p class="message">Nejste zaregistrováni? <a href="index.php">Vytvořit účet</a></p>
                </form>
            </div>
        </div>
        
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
        
    </body>
    
</html>

