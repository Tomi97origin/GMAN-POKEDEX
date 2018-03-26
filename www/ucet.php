<?php
include "../app/database.php";
mb_internal_encoding("utf-8");
if($_SESSION['prihlaseni']==1){
 $spoj = new Database;
 $user=$spoj->nactiUzivatele($_SESSION["username"]);
 $number=$spoj->kolikPokemonuMaUzivatel($user["User_ID"]);
 $pokomoni=$spoj->nactiPokemonyUzivatele($user["User_ID"]);
 if($number==null){
$number=0;
 }
}else{
    header("location: homepage.php");
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

        <div class="header">

            <div class="banner-info">
                <div class="col-md-7 header-right">
                    <h1><?php echo $user["User_Name"];?></h1>

                    <ul class="address">

                        <li>
                            <ul class="address-text">
                                <li><b>Jmeno: </b><?php echo $user["User_Name"];?></li>

                            </ul>
                        </li>

                        <li>
                            <ul class="address-text">
                                <li><b>Pokemoni: </b><?php echo $number;?></li>

                            </ul>
                        </li>
                        <li>
                            <ul class="address-text">
                                <li><b>E-MAIL: </b><?php echo $user["User_Email"];?></li>

                            </ul>
                        </li>
                         <li>
                                                    <ul class="address-text">
                                <li><a href="user-edit.php" class="ucetedit">Změna hesla</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
        </div>


        <div class="main-gal">
        <?php
        foreach($pokomoni as $i){
        echo '<div class="gallery">
                <a href="pokemon_detail.php?id='.$i["Pokemon_ID"].'"><img src="'.$i["Pokemon_Image"].'" width="300" height="200" ></a>
                <div class="desc">'.$i["Pokemon_Name"].'</div>
            </div>';
            }
            ?>
                       
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
