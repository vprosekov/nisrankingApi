<?php
require_once("models/users.php");
// function addShanyraq($apiKey, $curatorName, $curatorPhone) to add shanyraq to shanyraqs table. Checking if userId of apiKey is in users inner join with admins table by userId. If it is, add shanyraq to shanyraqs table.
function addNewShanyraq($apiKey, $shanyraqName, $curatorName, $curatorPhone){
    $tmpUserId = getUserIdByApiKey($apiKey);
    if($tmpUserId == "apiKeyNotExists"){
        return "apiKeyNotExists";
    }
    if(isAdmin($apiKey)){
        $userId = getUserIdByApiKey($apiKey);
        if(queryDB("INSERT INTO `shanyraqs`(`name`, `curatorName`, `curatorPhone`) VALUES (?,?,?)", "ssi", $shanyraqName, $curatorName, $curatorPhone)){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return "noRights";
    }
}

//function getAllShanyraqs() to get all shanyraqs from shanyraqs table.
function getAllShanyraqs(){
    $fb = queryDB("SELECT * FROM `shanyraqs`");
    if(!$fb){
        return false;
    }
    else{
        return $fb;
    }
}