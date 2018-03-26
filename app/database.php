<?php
mb_internal_encoding("utf-8");
include "config/config.php";
Class Database {


function vlozUzivatele($User_Name, $User_Password, $User_Email, $User_Role) {
    $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql = "INSERT INTO user (User_Name, User_Email, User_Password, User_Role) VALUES (?,?,?,?)";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssi", $User_Name, $User_Email, $User_Password, $User_Role);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        $db->close();
        return $id;
    }
    return false;
}


function nactiUzivatele($User_Name) {
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT User_ID,User_Name,User_Email,User_Password,User_Role FROM User  WHERE User_Name='".$User_Name."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
       $stmt->execute();
        $stmt->bind_result($User_ID,$User_Name, $User_Email,$User_Password, $User_Role);
    $stmt->fetch();
        $User=array(
    "User_ID" => $User_ID,
    "User_Name" => $User_Name,
    "User_Password" => $User_Password,
    "User_Email" => $User_Email,
    "User_Role" => $User_Role,
);
        $stmt->close();
        $db->close();
        return $User;
    }
    return false;
}
function kontrolaExistence($User_Name) {
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT User_ID FROM User WHERE User_Name='".$User_Name."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->store_result();
 $number = $stmt->num_rows;
        $stmt->close();
        $db->close();
        return $number;
    }
    return false;
}
function kontrolaExistenceEmail($User_Email) {
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT User_ID FROM User WHERE User_Email='".$User_Email."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->store_result();
 $number = $stmt->num_rows;
        $stmt->close();
        $db->close();
        return $number;
    }
    return false;
}

function nactiHesloUzivatele($User_Name) {
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT User_Password FROM User  WHERE User_Name='".$User_Name."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->bind_result($User_Password);
        $stmt->fetch();
        $stmt->close();
        $db->close();
        return $User_Password;
    }
    return false;
}
function nactiPokemonyUzivatele($User_ID) {
    $idcka=$this->idPokemonuUzivatele($User_ID);
    $pokemons=array();
    for($i=0;$i<$this->kolikPokemonuMaUzivatel($User_ID);$i++){
        $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Pokemon_ID,Pokemon_Name, Pokemon_Weight,Pokemon_Height,Pokemon_Description,Pokemon_Image FROM pokemon  WHERE Pokemon_ID='".$idcka[$i]."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->bind_result($Pokemon_ID,$Pokemon_Name, $Pokemon_Weight,$Pokemon_Height, $Pokemon_Description, $Pokemon_Image);
    $stmt->fetch();
        $pokemons[$i]=array(
    "Pokemon_ID" => $Pokemon_ID,
    "Pokemon_Name" => $Pokemon_Name,
    "Pokemon_Weight" => $Pokemon_Weight,
    "Pokemon_Height" => $Pokemon_Height,
    "Pokemon_Description" => $Pokemon_Description,
    "Pokemon_Image" => $Pokemon_Image
);
        $stmt->close();
        $db->close();
    }
    }  
    return $pokemons;
}
function kolikPokemonuMaUzivatel($User_ID) {
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT * FROM user_has_pokemon  WHERE User_ID='".$User_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->store_result();
 $number = $stmt->num_rows;
        $stmt->close();
        $db->close();
        return $number;
    }
    return false;
}
function idPokemonuUzivatele($User_ID) {//Nefunguje
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Pokemon_ID FROM user_has_pokemon  WHERE User_ID='".$User_ID."'";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
    return $rows;

}
function vsichniPokemoniId() {//Nefunguje
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Pokemon_ID FROM pokemon";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
    return $rows;

}
function nactiPokemony() {
    $idcka=$this->vsichniPokemoniId();
    $idcka_length = count($idcka); 
    $pokemons=array();
    for($i=0;$i<$idcka_length;$i++){
        $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Pokemon_ID,Pokemon_Name, Pokemon_Weight,Pokemon_Height,Pokemon_Description,Pokemon_Image FROM pokemon  WHERE Pokemon_ID='".$idcka[$i]."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->bind_result($Pokemon_ID,$Pokemon_Name, $Pokemon_Weight,$Pokemon_Height, $Pokemon_Description, $Pokemon_Image);
    $stmt->fetch();
        $pokemons[$Pokemon_ID]=array(
    "Pokemon_ID" => $Pokemon_ID,
    "Pokemon_Name" => $Pokemon_Name,
    "Pokemon_Weight" => $Pokemon_Weight,
    "Pokemon_Height" => $Pokemon_Height,
    "Pokemon_Description" => $Pokemon_Description,
    "Pokemon_Image" => $Pokemon_Image
);
        $stmt->close();
        $db->close();
    }
    }  
    return $pokemons;
}
function nactiPokemonSlabiny($Pokemon_ID){
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT PokemonType_ID FROM weaknesses WHERE Pokemon_ID='".$Pokemon_ID."'";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
    return $rows;
}
function nactiPokemonTypy($Pokemon_ID){
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT PokemonType_ID FROM pokemon_types WHERE Pokemon_ID='".$Pokemon_ID."'";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
    return $rows;
}
function nactiTypy($typy){
     $typy_length = count($typy); 
    $rows=array();
    $config = new Configuration;
    $i=0;
    while($i< $typy_length){   
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Type_Name FROM type WHERE PokemonType_ID= '".$typy[$i]."'";//
    $result = $db->query($sql);
        while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
    $i++;
      } 
        return $rows;
}
function nactiVsechnyTypy(){
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Type_Name FROM type";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
        return $rows;
}
function search($search){
     //$typy_length = count($typy); 
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
       $sql = "SELECT Pokemon_ID,Pokemon_Name, Pokemon_Weight,Pokemon_Height,Pokemon_Description,Pokemon_Image FROM pokemon WHERE Pokemon_Name LIKE '%".$search."%'";
    $result = $db->query($sql);
    while($row=$result->fetch_array( MYSQLI_ASSOC)){
    $rows[] = $row;
}
    $result->free();
    $db->close();
        return $rows;
}
function upraveniPokemona($Pokemon_ID, $Pokemon_Weight,$Pokemon_Height, $Pokemon_Description){
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="UPDATE pokemon SET Pokemon_Weight='".$Pokemon_Weight."',Pokemon_Height='".$Pokemon_Height."',Pokemon_Description='".$Pokemon_Description."' WHERE Pokemon_ID='".$Pokemon_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function nactiPokemonyDletypu($PokemonType_ID) {
    $idcka=$this->nactiPokemonIdDleTypu($PokemonType_ID);
    $idcka_length = count($idcka); 
    $pokemons=array();
    for($i=0;$i<$idcka_length;$i++){
        $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Pokemon_ID,Pokemon_Name, Pokemon_Weight,Pokemon_Height,Pokemon_Description,Pokemon_Image FROM pokemon  WHERE Pokemon_ID='".$idcka[$i]."'";//".$idcka[$i]."
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->bind_result($Pokemon_ID,$Pokemon_Name, $Pokemon_Weight,$Pokemon_Height, $Pokemon_Description, $Pokemon_Image);
    $stmt->fetch();
        $pokemons[$i]=array(
    "Pokemon_ID" => $Pokemon_ID,
    "Pokemon_Name" => $Pokemon_Name,
    "Pokemon_Weight" => $Pokemon_Weight,
    "Pokemon_Height" => $Pokemon_Height,
    "Pokemon_Description" => $Pokemon_Description,
    "Pokemon_Image" => $Pokemon_Image
);
        $stmt->close();
        $db->close();
    }
    }  
    return $pokemons;
}
function nactiPokemonIdDleTypu($PokemonType_ID){
    $rows=array();
    $config = new Configuration;
   $db = $config->vytvorSpojeni();
    $sql = "SELECT Pokemon_ID FROM pokemon_types WHERE PokemonType_ID='".$PokemonType_ID."'";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_NUM)){
    $rows[] = $row[0];
}
    $result->free();
    $db->close();
    return $rows;
}
function smazPokemona($Pokemon_ID){
    $a=$this->smazVsechnyTypePokemona($Pokemon_ID);
    $a=$this->smazVsechnySlabinyPokemona($Pokemon_ID);
    $a=$this->smazUzivatelovaPokemona($Pokemon_ID);
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="DELETE FROM `pokemon` WHERE Pokemon_ID='".$Pokemon_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function vlozPokemona($Pokemon_Name, $Pokemon_Weight, $Pokemon_Height, $Pokemon_Description, $Pokemon_Image) {
    $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql = "INSERT INTO pokemon (Pokemon_Name, Pokemon_Weight,Pokemon_Height,Pokemon_Description,Pokemon_Image) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("siiss", $Pokemon_Name, $Pokemon_Weight, $Pokemon_Height, $Pokemon_Description, $Pokemon_Image);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        $db->close();
        return $id;
    }
    return false;
}
function chytPokemona($User_ID, $Pokemon_ID) {
    $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql = "INSERT INTO `user_has_pokemon`(`User_ID`, `Pokemon_ID`) VALUES (".$User_ID.",".$Pokemon_ID.")";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function zmenHeslo($User_ID, $User_Password) {
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="UPDATE `user` SET `User_Password`='".$User_Password."' WHERE `User_ID`='".$User_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function pridejTypeToPokemon($Pokemon_ID,$PokemonType_ID) {
    $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql = "INSERT INTO `pokemon_types`(`Pokemon_ID`, `PokemonType_ID`) VALUES ('".$Pokemon_ID."','".$PokemonType_ID."')";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function pridejWeaknessesToPokemon($Pokemon_ID,$PokemonType_ID) {
    $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql = "INSERT INTO `weaknesses`(`Pokemon_ID`, `PokemonType_ID`) VALUES ('".$Pokemon_ID."','".$PokemonType_ID."')";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function smazTypePokemona($Pokemon_ID,$PokemonType_ID){
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="DELETE FROM `pokemon_types` WHERE `Pokemon_ID`=".$Pokemon_ID." AND `PokemonType_ID`=".$PokemonType_ID."";
    //$sql="DELETE FROM `pokemon_types` WHERE `Pokemon_ID`=20 AND `PokemonType_ID`=".$PokemonType_ID."";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function smazVsechnyTypePokemona($Pokemon_ID){
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="DELETE FROM `pokemon_types` WHERE Pokemon_ID='".$Pokemon_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function smazSlabinuPokemona($Pokemon_ID,$PokemonType_ID){
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="DELETE FROM `weaknesses` WHERE `Pokemon_ID`=".$Pokemon_ID." AND `PokemonType_ID`=".$PokemonType_ID."";
    //$sql="DELETE FROM `weaknesses` WHERE `Pokemon_ID`=1 AND `PokemonType_ID`=3";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function smazVsechnySlabinyPokemona($Pokemon_ID){
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="DELETE FROM `weaknesses` WHERE Pokemon_ID='".$Pokemon_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function smazUzivatelovaPokemona($Pokemon_ID){
      $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql="DELETE FROM `user_has_pokemon` WHERE Pokemon_ID ='".$Pokemon_ID."'";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
function vlozType($Type_Name) {
    $config = new Configuration;
    $db = $config->vytvorSpojeni();
    $sql = "INSERT INTO `type` (`Type_Name`) VALUES ('".$Type_Name."')";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        $db->close();
        return TRUE;
    }
    return false;
}
}
