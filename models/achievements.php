<?php
require_once("models/users.php");
require_once("models/shanyraqs.php");

function getUserAchievements($apikey, $userId, $iin=false){
    //check if apikey exists. If not return false
    if(getUserIdByApiKey($apikey) ===false){
        return 'apiKeyError';
    }

    if($userId === false){

        $tmpUsr = getUserInfo(false, $iin);
        if($tmpUsr == "iinNotExists"){
            return "iinNotExists";
        }
        else if($tmpUsr == "iinError"){
            return "iinError";
        }
        $returnVar = queryDB('SELECT * FROM `achievements` WHERE userId=?', "i", $tmpUsr['userId']);
        if($returnVar){
            return $returnVar;
        }
        else{
            return false;
        }

    }
    else{
        $tmpUsr = getUserInfo($userId);
        if($tmpUsr == "idNotExists"){
            return "idNotExists";
        }
        else if($tmpUsr == "idError"){
            return "idError";
        }
        $returnVar = queryDB('SELECT * FROM `achievements` WHERE userId=?', "i", $userId);
        if($returnVar !== false){
            return $returnVar;
        }
        else{
            return false;
        }
    }
    
}