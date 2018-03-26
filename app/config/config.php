<?php 
error_reporting(null);
session_start();
if(!isset($_SESSION['prihlaseni'])){
        $_SESSION['prihlaseni']=0;
        }
Class Configuration{


function vytvorSpojeni() {
    $db = new mysqli("localhost", "root", "", "pokemon");
    if ($db->errno > 0) {
        die("Error establishing connection with database.");
    }
    $db->set_charset("utf8");
    return $db;
}
}