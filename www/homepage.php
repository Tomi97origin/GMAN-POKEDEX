<?php 
include "../app/homepage.php";
if($_SESSION['prihlaseni']==1){
    header("location: Pokedex.php");
}
if(isset($_POST["Username"])){
   if($_POST["Heslo"]===$_POST["Heslo2"]){ 
 $spoj = new Database;
 $username=htmlspecialchars($_POST["Username"]);
 $number=$spoj->kontrolaExistence($username);
 $heslo=$_POST["Heslo"];
 $heslo2=$_POST["Heslo2"];
 $email=$_POST["Email"];
 $number2=$spoj->kontrolaExistenceEmail($email);
 if($number2>0){
 echo '<script type="text/javascript">alert("Email je jiz obsazeny");</script>';}
 else{
 if($number>0){
 echo '<script type="text/javascript">alert("Uzivatelske jmeno je jiz obsazeno");</script>';
}else{
$_SESSION['user_id']= $spoj->vlozUzivatele( $username, hash("SHA256", $heslo),  $email, 1);
header("location: login.php"); 
}
 }
}else{
    echo '<script type="text/javascript">alert("Hesla se neschoduji");</script>';
}}
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
            <a class="menu-cell" href="index.php" style="color:white; background-color: #ee1515;">Domů</a>
            <a class="menu-cell" href="login.php">Log in</a>
            <a class="menu-cell" href="Pokedex.php">Pokedex</a>
            <?php if($_SESSION['prihlaseni']==1){echo '<a class="menu-cell" href="odhlasit.php">Odhlasit</a>';} ?>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>

        <div class="login-page">
            <div class="form">
                <form class="register-form" method="POST" action="homepage.php">                 
                    <h2 class="message">Registrace do Pokedexu</h2>
                    <input name="Username" required type="text" placeholder="Jméno"/>
                    <input name="Heslo"  required type="password" placeholder="Heslo"/>
                    <input name="Heslo2"  required type="password" placeholder="Heslo znovu"/>
                    <input name="Email" required pattern="[^ @]*@[^ @]*"type="text" placeholder="E-mail"/>
                    <button type="submit" value="Submit">Vytvořit účet</button>
                    <p class="message">Už máte účet? <a href="login.php">Přihlašte se</a></p>
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
