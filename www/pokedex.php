<?php
mb_internal_encoding("utf-8");
include "../app/pokedex.php";
 $spoj = new Database;
 if(isset($_GET['search'])){
$search=htmlspecialchars($_GET['search']);
$pokomoni=$spoj->search($search);
 }else{
    $pokomoni=$spoj->nactiPokemony();
 }
 
 $typy=$spoj->nactiVsechnyTypy();
 if(isset($_GET['typ'])){
$typ=array_search(htmlspecialchars($_GET['typ']), $typy)+1;
$pokomoni=$spoj->nactiPokemonyDletypu($typ);
//$pokomoni=$spoj->nactiPokemonIdDleTypu($typ);
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
         <script src="assets/js/jquery-3.2.1.min.js"></script>
         <script>
        $(document).ready(  function(){
             $(".login-form2").slideUp();
            $(".btn1").hide();
            $(".btn1").click(function(){
                $(".login-form2").slideUp();
                $(".btn2").show();
                 $(".btn1").hide();
            });
            $(".btn2").click(function(){
                $(".login-form2").slideDown();
                $(".btn1").show();
                 $(".btn2").hide();
            });
        });
         </script>
    </head>
    <body onload="function(){
                $(".login-form2").slideUp();
            });">

        <div class="topnav" id="myTopnav">
            <a href="Pokedex.php" class="logo"><img src="assets/images/menuicon.jpg" class="imglogo"></a>
                            <?php if(!$_SESSION['prihlaseni']==1){
                 echo '<a class="menu-cell" href="index.php" >Domů</a>';
                 echo '<a class="menu-cell" href="login.php">Log in</a>';
                 } ?>
            <a class="menu-cell" href="Pokedex.php" style="color:white; background-color: #ee1515;">Pokedex</a>
             <?php if($_SESSION['prihlaseni']==1){
                 echo '<a class="menu-cell" href="ucet.php">Můj učet</a>';
                 echo '<a class="menu-cell" href="pokemon-add.php">Přidat pokemona</a>';
                if($_SESSION['role']==0){ echo '<a class="menu-cell" href="type_add.php">Přidat typ pokemona</a>';}
                 } ?>
            
            <?php if($_SESSION['prihlaseni']==1){echo '<a class="menu-cell" href="odhlasit.php">Odhlasit</a>';} ?>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>

        <form method="GET" class="vyhledavani">
            <input type="text" name="search" placeholder="Hledat..." class="search">

        </form>
        <div class="login-page2">
            <div class="form2">

                <form class="login-form2">
                <input class="typc" type='submit' name='' value="Všichni">
                    <?php
                    $typ_leght=count($typy);
                    for($i=0;$i<$typ_leght;$i++){
                        echo "<input class='typc' type='submit' name='typ' value=".$typy[$i]."> ";
                        //echo "<button style='width:50%;' name='typ' value=".$i." type='submit'>".$typy[$i]."</button>";
                    }
                     ?>
                </form>
                 <?php /*echo '<a>'.var_dump($pokomoni).'</a>'; */  ?>
                 <button class="btn1">Zasunout menu</button>
<button class="btn2">Vysunout menu</button>
            </div>
        </div>
        <div class="main-gal">
          <?php
           //$pokomoni_length = count($pokomoni); 
        //for($i=0;$i<$pokomoni_length;$i++){
        foreach($pokomoni as $i){
        echo '<div class="gallery">
                <a href="pokemon_detail.php?id='.$i["Pokemon_ID"].'"><img src="'.$i["Pokemon_Image"].'" width="300" height="200" ></a>
                <div class="desc">'.$i["Pokemon_Name"].'</div>
            </div>';
            }//$pokomoni[$i]
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
