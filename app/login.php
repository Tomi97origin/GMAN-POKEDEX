<?php
mb_internal_encoding("utf-8");
include "database.php";

Class Login {
    function prihlaseni($User_Name, $User_Password) {
        $username =htmlspecialchars($User_Name); 
        $password = hash("SHA256", $User_Password);
        $db = new Database;
        $db_user = $db->nactiUzivatele($User_Name);
        if ($password==$db_user['User_Password']) {
          $_SESSION["prihlaseni"]=1;
           $_SESSION["username"]=$username;
           $_SESSION['role']=$db_user['User_Role'];
           $_SESSION['user']=$db_user;
         header("location: ucet.php");
          
}else{
  echo '<script type="text/javascript">alert("prihlaseni bylo neuspesne");</script>';
}
        }
       function zmenaHesla($User_Password, $New_Password,$New_Password2) {
        if($New_Password===$New_Password2){
        $username =$_SESSION['username']; 
        $password = hash("SHA256", $User_Password);
        $db = new Database;
        $user = $db->nactiUzivatele($username);
       // var_dump($user);
        if ($password==$user['User_Password']) {
          $zmenaHesla=$db->zmenHeslo($user['User_ID'], hash("SHA256", $New_Password));
          if($zmenaHesla){
            header("location: ucet.php");   
            //echo '<script type="text/javascript">alert("Zmena hesla byla uspesna");</script>';
          }else{
            echo '<script type="text/javascript">alert("Zmena hesla byla neuspesne");</script>';
          }
}else{
  echo '<script type="text/javascript">alert("Zmena hesla byla neuspesne");</script>';
}
        }else{
          echo '<script type="text/javascript">alert("Hesla se neshoduji");</script>';
        }
      } 
    }
?>