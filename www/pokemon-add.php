<?php
mb_internal_encoding("utf-8");
include "../app/pokedex.php";
if(!$_SESSION['prihlaseni']==1){
    header("location: homepage.php");
}
 $spoj = new Database;
 $typy=$spoj->nactiVsechnyTypy();
 if(!empty($_POST)){
    $a=sha1_file($_FILES['upfile']['tmp_name']);

try {
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }
    if ($_FILES['upfile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['upfile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }
    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf('C:/xampp/htdocs/Pokedex/www/assets/images/pokemon/%s.%s',
            sha1_file($_FILES['upfile']['tmp_name']),   
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
    echo 'File is uploaded successfully.';
} catch (RuntimeException $e) {

    echo $e->getMessage();

}
    
    $image="assets/images/pokemon/".$a.'.'.$ext;
    $pridat=$spoj->vlozPokemona(htmlspecialchars($_POST['Jmeno']), htmlspecialchars($_POST['vaha']), htmlspecialchars($_POST['vyska']), htmlspecialchars($_POST['popis']), $image);
     $user=$spoj->nactiUzivatele($_SESSION["username"]);
    $chyt=$spoj->chytPokemona($user['User_ID'], $pridat);
      $typy_length=count($typy);
      for($i=0;$i<$typy_length;$i++){ 
        if(isset($_POST["typ".$i.""])){
            $b=$spoj->pridejTypeToPokemon($pridat,$_POST["typ".$i.""]+1);
        }
      }
      for($i=0;$i<$typy_length;$i++){
        if(isset($_POST["slabina".$i.""])){
            $b=$spoj->pridejWeaknessesToPokemon($pridat,$_POST["typ".$i.""]+1);
        }
      }
    if($chyt){
         header("location: pokedex.php");
    }
   

 }

?>


<html>
    <head>
        <title>Pokedex</title>
        <link rel="shortcut icon" href="assets/images/logov2.png" type="image/png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="assets/js/jquery-3.2.1.min.js"></script>
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
            <div class="form">
                <h1 class="jmeno">Pridani Pokemona</h1>
                <form class="login-form" enctype="multipart/form-data" method="POST" action="">

                    <input type="text" name="Jmeno" required placeholder="Jmeno">

                    <img src="assets/images/placeholder.png" class="stat-img"  width="300" height="270" alt="Image preview..." id="myImg">
                    <input name="upfile" required type="file"/><br>


                    <h2 class="message">Popis</h2> 
                    <input type="text" name="popis" required  placeholder="Popis">
                    <h2 class="message">Typ</h2> 
<?php 
                    $typy_length=count($typy);
                                        for($i=0;$i<$typy_length;$i++){
                                            if($i%2==0){
                                                echo '<p>';
                                            }
                                             echo '<input type="checkbox"  value="'.$i.'" id="test'.$i.'" name="typ'.$i.'"/>
                                            <label for="test'.$i.'">'.$typy[$i].'</label>';  
                                             if($i%2==1){
                                                echo '</p>';
                                             }
                                           
                                        }

                     ?>

                    <h2 class="message">Slabiny</h2> 
                    <?php 
                    $typy_length=count($typy);
                                        for($i=0;$i<$typy_length;$i++){
                                            if($i%2==0){
                                                echo '<p>';
                                            }
                                            $a=$i+$typy_length;
                                             echo '<input type="checkbox"  value="'.$i.'" id="test'.$a.'" name="slabina'.$i.'"/>
                                            <label for="test'.$a.'">'.$typy[$i].'</label>';  
                                             if($i%2==1){
                                                echo '</p>';
                                             }
                                           
                                        }

                     ?>
                    <h2 class="message">Vaha</h2> 
                    <input type="text" name="vaha" required placeholder="vaha">
                    <h2 class="message">Vyska</h2> 
                    <input type="text" name="vyska" required placeholder="vyska">
                    <button type="submit" value="submit">Potvrdit</button>

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
            $(":file").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });

            function imageIsLoaded(e) {
                $('#myImg').attr('src', e.target.result);
            }
            ;
            
            function typadd(value) {

                document.getElementById("typy1").value+=value+",";
                 document.getElementById("typy2").value+=value+",";
                 
                

            }


        </script>


    </body>
</html>