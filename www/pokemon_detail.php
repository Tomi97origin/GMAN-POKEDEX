 <?php
mb_internal_encoding("utf-8");
include "../app/pokedex.php";
$spoj = new Database;
//if(isset($_GET['Pridat'])){
//if(isset($_GET['id'])){
//    $a=$spoj->nactiPokemonyUzivatele($User_ID);
//    if(in_array($a[])){
//       $a=$spoj->chytPokemona($User_ID, $Pokemon_ID);   
//    }
//  
//}
//}
if(isset($_GET['smazat'])){
$user=$spoj->nactiUzivatele($_SESSION['username']);
if($user['User_Role']==0){
    $smazat=$spoj->smazPokemona(htmlspecialchars($_GET['smazat']));
    if($smazat){
        header("location: pokedex.php");
    }
}else{
 echo '<script type="text/javascript">alert("Nemate dostatecne opraveneni");</script>';
}
}
if(isset($_GET['id'])){
    $idcko=$_GET['id'];
    $id= $idcko;
$pokomoni=$spoj->nactiPokemony();
$Slabiny=$spoj->nactiTypy($spoj->nactiPokemonSlabiny($idcko));
$Typy=$spoj->nactiTypy($spoj->nactiPokemonTypy($idcko));
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
            <a class="menu-cell" href="Pokedex.php">Pokedex</a>
            <a class="menu-cell" href="ucet.php">Můj učet</a>
            <?php if($_SESSION['prihlaseni']==1){echo '<a class="menu-cell" href="odhlasit.php">Odhlasit</a>';} ?>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>

        <div class="pokemon-stats" style="width: 95.2%;">
            <h1 class="jmeno"><?php echo $pokomoni[$id]["Pokemon_Name"] ?></h1>
            
            <table class="stats" style="color: white;">
                <img <?php echo 'src="'.$pokomoni[$id]["Pokemon_Image"].'"' ?> alt="<?php echo $pokomoni[$id]["Pokemon_Name"] ?>" class="stat-img" style='margin-right: 50px;    ' width="300" height="270">
                 
                <tr>                   
                    <th><h2>Popis</h2></th>
                </tr>
                <tr>
                    <td><?php echo $pokomoni[$id]["Pokemon_Description"] ?></td>
                </tr>
                <tr>
                    <th><h2>Typ pokémona</h2></th>
                </tr>
                <tr>
                    <td><?php 
                    $Typy_length = count($Typy); 
                    for($i=0;$i<$Typy_length;$i++){ 
                        if($i==$Typy_length-1){
                            echo $Typy[$i];
                        }else{
                             echo $Typy[$i].',';
                        }
                        }
                    ?></td>
                </tr>
                
                <tr>
                    <th><h2>Slabiny</h2></th>
                </tr>
                
                <tr>
                    <td><?php 
                    $Slabiny_length = count($Slabiny); 
                    for($i=0;$i<$Slabiny_length;$i++){ 
                        if($i==$Slabiny_length-1){
                            echo $Slabiny[$i];
                        }else{
                             echo $Slabiny[$i].',';
                        }
                        }
                       ?></td>
                </tr>
                
                <tr>
                    <th><h2>Váha</h2></th>
                </tr>
                
                <tr>
                    <td><?php echo $pokomoni[$id]["Pokemon_Weight"] ?> Kg</td>
                </tr>
                
                <tr>
                    <th><h2>Výška</h2></th>
                </tr>
                
                <tr>
                    <td><?php echo $pokomoni[$id]["Pokemon_Height"] ?> cm</td>
                </tr>
                
                <tr>
                    <td><a <?php echo 'href="pokemon_edit.php?id='.$pokomoni[$id]["Pokemon_ID"].'"'?> ><button>Upravit</button></a></td>
                    <td><a <?php echo 'href="pokemon_detail.php?smazat='.$pokomoni[$id]["Pokemon_ID"].'&id='.$pokomoni[$id]["Pokemon_ID"].'"'?> ><button>Smazat</button></a></td>
                </tr>
            </table>
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

