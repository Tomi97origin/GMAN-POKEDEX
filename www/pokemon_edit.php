<?php
mb_internal_encoding("utf-8");
include "../app/pokedex.php";
if(!$_SESSION['prihlaseni']==1){
    header("location: login.php");
}
if(isset($_GET['id'])){
    $idcko=$_GET['id'];
    $id=$idcko;
$spoj = new Database;
$pokomoni=$spoj->nactiPokemony();
$Slabiny=$spoj->nactiTypy($spoj->nactiPokemonSlabiny($idcko));
$Typy=$spoj->nactiTypy($spoj->nactiPokemonTypy($idcko));
$typy=$spoj->nactiVsechnyTypy();
if(!empty($_POST)){
$Pokemon_Weight = ($_POST['vaha']=="") ? $pokomoni[$id]["Pokemon_Weight"] : $_POST['vaha'];
$Pokemon_Height = ($_POST['vyska']=="") ? $pokomoni[$id]["Pokemon_Height"] :$_POST['vyska'];
$Pokemon_Description = ($_POST['popis']=="") ? $pokomoni[$id]["Pokemon_Description"] : $_POST['popis'];
$update=$spoj->upraveniPokemona($idcko, $Pokemon_Weight,$Pokemon_Height, $Pokemon_Description);
      $typy_length=count($typy);
      for($i=0;$i<$typy_length;$i++){ 
        if(isset($_POST["typ".$i.""])){
           if(($key = array_search($typy[$_POST["typ".$i.""]], $Typy)) !== false){

             unset($Typy[$key]);
        }else{
            var_dump($_POST["typ".$i.""]+1);
             $b=$spoj->pridejTypeToPokemon($pokomoni[$id]["Pokemon_ID"],$_POST["typ".$i.""]+1);
        }
      }elseif(!empty($Typy)){
        //if(in_array($typy[$i],$Typy)){
        if(($key = array_search($typy[$i], $Typy)) !== false){
            $b=$spoj->smazTypePokemona($pokomoni[$id]["Pokemon_ID"],$i+1);
            //$b=$spoj->smazTypePokemona(20,4);
        }
        }
        if(isset($_POST["slabina".$i.""])){
           if(($key = array_search($typy[$_POST["slabina".$i.""]], $Slabiny)) !== false){

             unset($Slabiny[$key]);
        }else{
            var_dump($_POST["slabina".$i.""]+1);
             $b=$spoj->pridejWeaknessesToPokemon($pokomoni[$id]["Pokemon_ID"],$_POST["slabina".$i.""]+1);
        }
      }elseif(!empty($Slabiny)){
        //if(in_array($typy[$i],$Typy)){
        if(($key = array_search($typy[$i], $Slabiny)) !== false){
            $b=$spoj->smazSlabinuPokemona($pokomoni[$id]["Pokemon_ID"],$i+1);
            //$b=$spoj->smazTypePokemona(20,4);
        }
        }

        }  


if($update){
   header("location: pokemon_detail.php?id=".$idcko."");
}
}
}else{
header("location: pokedex.php");
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
            <a class="menu-cell" href="Pokedex.php" style="color:white; background-color: #ee1515;">Pokedex</a>
            <a class="menu-cell" href="ucet.php">Můj učet</a>
            <a class="menu-cell" href="pokemon-add.php">Přidat pokemona</a>
            <?php if($_SESSION['prihlaseni']==1){echo '<a class="menu-cell" href="odhlasit.php">Odhlasit</a>';} ?>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>


        <div class="login-page">
                        <?php //var_dump($Typy);  ?>
                        <?php //var_dump(in_array('travni',$Typy));   ?>

            <div class="form">
                <h1 class="jmeno"><?php echo $pokomoni[$id]["Pokemon_Name"] ?></h1>
                <form class="login-form" method="POST" action="">
                    <img <?php echo 'src="'.$pokomoni[$id]["Pokemon_Image"].'"' ?> alt="Pikachu" class="stat-img" width="300" height="270">
                    <h2 class="message">Popis</h2> 
                    <input type="text" name="popis" <?php echo "placeholder='".$pokomoni[$id]["Pokemon_Description"]."'" ?>>
                    <h2 class="message">Typ</h2> 
                    <input type="text" name="typ" disabled="disabled" placeholder=<?php 
                    $Typy_length = count($Typy); 
                    for($i=0;$i<$Typy_length;$i++){ 
                        if($i==$Typy_length-1){
                            echo $Typy[$i];
                        }else{
                             echo $Typy[$i].',';
                        }
                        }
                    ?>>
                    <?php 
                    $typy_length=count($typy);
                                        for($i=0;$i<$typy_length;$i++){
                                            if($i%2==0){
                                                echo '<p>';
                                            }
                                             echo '<input type="checkbox" '.((in_array($typy[$i],$Typy))?'checked':"").' value="'.$i.'" id="test'.$i.'" name="typ'.$i.'"/>
                                            <label for="test'.$i.'">'.$typy[$i].'</label>';  
                                             if($i%2==1){
                                                echo '</p>';
                                             }
                                           
                                        }

                     ?>
                   

                    <h2 class="message">Slabiny</h2> 
                    <input type="text" name="slabiny" disabled="disabled" placeholder=<?php 
                    $Slabiny_length = count($Slabiny); 
                    for($i=0;$i<$Slabiny_length;$i++){ 
                        if($i==$Slabiny_length-1){
                            echo $Slabiny[$i];
                        }else{
                             echo $Slabiny[$i].',';
                        }
                        }
                       ?>>
                                           <?php 
                    $typy_length=count($typy);
                                        for($i=0;$i<$typy_length;$i++){
                                            if($i%2==0){
                                                echo '<p>';
                                            }
                                            $a=$i+$typy_length;
                                             echo '<input type="checkbox" '.((in_array($typy[$i],$Slabiny))?'checked':"").' value="'.$i.'" id="test'.$a.'" name="slabina'.$i.'"/>
                                            <label for="test'.$a.'">'.$typy[$i].'</label>';  
                                             if($i%2==1){
                                                echo '</p>';
                                             }
                                           
                                        }

                     ?>
                                        
                    <h2 class="message">Vaha</h2> 
                    <input type="text" name="vaha" placeholder=<?php echo $pokomoni[$id]["Pokemon_Weight"] ?>>
                    <h2 class="message">Vyska</h2> 
                    <input type="text" name="vyska" placeholder=<?php echo $pokomoni[$id]["Pokemon_Height"] ?>>



                    <button type="submit" value="Submit">Potvrdit</button>

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
