<?php

//function to get data of all users from db if apikey exists. If not, returns false.
function getAllUsers($apikey){
    //check if apikey exists. If not return false
    if(!getUserIdByApiKey($apikey)){
        return 'apiKeyError';
    }

    $query = "SELECT userId, iin, name, gradeId FROM `users`";
    $result = queryDB($query);
    if($result){
        // return result as json
        return $result;
    }
    else{
        return [];
    }
}

// * function to get user info
function getUserInfo($userId, $iin = false){
    if($userId != false){
        if(!is_numeric($userId)){
            return "idError";
        }
        $fb = queryDB("SELECT userId, iin, name, gradeId FROM `users` WHERE userId=?", "i", $userId);
        //print_r($fb);
        if(!$fb || $fb[0]["userId"]=="")
        {
            return "idNotExists";
        }
        else //все норм
        {
            return $fb[0];
        }
    }
    else if($iin != false){
        if(strlen($iin)!=12){
            return "iinError";
        }
        $fb = queryDB("SELECT userId, iin, name, gradeId FROM `users` WHERE iin=?", "s", $iin);
        //print_r($fb);
        if(!$fb || $fb[0]["userId"]=="")
        {
            return "iinNotExists";
        }
        else //все норм
        {
            return $fb[0];
        }
    }
    
}

//function to return userId by apiKey
function getUserIdByApiKey($apiKey){
    $fb = queryDB("SELECT userId FROM `users` WHERE apiKey=?", "s", $apiKey);
    if(!$fb || $fb[0]["userId"]=="")
    {
        return false;
    }
    else //все норм
    {
        return $fb[0]["userId"];
    }
}
// function to return is user admin or not. Selects userId by apiKey. Returns true if user is in admins table
function isAdmin($apiKey){
    $userId = getUserIdByApiKey($apiKey);
    if($userId == "apiKeyNotExists"){
        return false;
    }
    $fb = queryDB("SELECT userId FROM `admins` WHERE userId=?", "i", $userId);
    if(!$fb || $fb[0]["userId"]=="")
    {
        return false;
    }
    else //все норм
    {
        return true;
    }
}

// Thanks to Github Copilot ^_^
function getUserApiKey($iin, $password){
    if(strlen($iin)!=12){
        return "iinError";
    }
    //select apiKey from database where iin = $iin and password = md5($password)
    $fb = queryDB("SELECT userId, apiKey FROM `users` WHERE iin=? AND password=?", "ss", $iin, md5($password));
    // var_dump(md5($password));
    //If userId does not exists in database, return "wrongCredentials"
    if(!$fb || $fb[0]["userId"]=="")
    {
        return "wrongCredentials";
    }
    //else if $iin exists in database and password is equal to cached password and apiKey is not exists in database return generate apiKey and insert it to database and after return it.
    else if(!$fb[0]["apiKey"]){
        $apiKey = implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 6));
        //update $apiKey in database where iin = $iin and password = md5($password)
        queryDB("UPDATE `users` SET apiKey=? WHERE iin=? AND password=?", "sss", $apiKey, $iin, md5($password));
        return $apiKey;
    }
    else{
        return $fb[0]["apiKey"];
    }
}

// function to add new user to database
function addUser($apiKey, $iin, $name, $password, $gradeId){
    $tmpUserId = getUserIdByApiKey($apiKey);
    if($tmpUserId == "apiKeyNotExists"){
        return "apiKeyNotExists";
    }
    if(isAdmin($apiKey)){
        if(strlen($iin) != 12){
            return "iinError";
        }

        $fb = queryDB("SELECT `iin` FROM `users` WHERE `iin`=?", "s", $iin);
        
        if($fb && $fb[0]["iin"]!="")
        {
            // ! user exists error
            return "userExists";
        }
        else // * all okay
        {

            $apiKey = implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 6));

            if(queryDB("SELECT `id` FROM `users` WHERE `apiKey`=?", "s", $apiKey)){
                //echo sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")."<br>";
                return "Repeat again";
            }
            // $query = "INSERT INTO `users` (`name`, `grade`, `iin`, `password`, `type`, `publishedCourses`, `payedCourses`, `favouriteCourses`, `apiKey`, `history`) VALUES ('$name', '$grade', '$iin', '".md5($password)."','$type', '$publishedCourses', '$payedCourses', '$favouriteCourses', '$apiKey', '')";
            // out($query);
            if(queryDB("INSERT INTO `users`(`iin`, `password`, `name`, `gradeId`, `apiKey`) VALUES (?,?,?,?,?)", "sssis", $iin, md5($password),$name, $gradeId, $apiKey)){
                return true;
            }
            else{
                return false;
            }
        }
    }
    else{
        return "noRights";
    }
}

// function addAdmin($apiKey, $userId) to add userId to admins list. $tmpUserId is userId from users table where apikey = $apiKey. Check if userId is admin or not. If yes, add userId to admins list.
function addAdmin($apiKey, $iin){

    $tmpUserId = getUserIdByApiKey($apiKey);
    if($tmpUserId == "apiKeyNotExists"){
        return "apiKeyNotExists";
    }
    if(isAdmin($apiKey)){
        // userId is userId from users table where iin = $iin. Check if iin in table users exists or not
        $userId = getUserInfo(false, $iin);
        if($userId == "iinNotExists"){
            return "iinNotExists";
        }
        else if($userId == "iinError"){
            return "iinError";
        }
        $fb = queryDB("SELECT userId FROM `admins` WHERE userId=?", "i", $userId);
        if(!$fb || $fb[0]["userId"]=="")
        {
            queryDB("INSERT INTO `admins`(`userId`) VALUES (?)", "i", $userId);
            return true;
        }
        else{
            return "userIdAlreadyAdmin";
        }
    }
    else{
        return "userNotAdmin";
    }
}

function removeAdmin($apiKey, $iin){
    $tmpUserId = getUserIdByApiKey($apiKey);
    if($tmpUserId == "apiKeyNotExists"){
        return "apiKeyNotExists";
    }
    if(isAdmin($apiKey)){
        // userId is userId from users table where iin = $iin. Check if iin in table users exists or not
        $userId = getUserInfo(false, $iin);
        if($userId == "iinNotExists"){
            return "iinNotExists";
        }
        else if($userId == "iinError"){
            return "iinError";
        }

        //check if userId in admins table exists or not
        $fb = queryDB("SELECT userId FROM `admins` WHERE userId=?", "i", $userId);

        if(!$fb || $fb[0]["userId"]=="")
        {
            return "userIdNotAdmin";
        }
        else{
            queryDB("DELETE FROM `admins` WHERE userId=?", "i", $userId);
            return true;
        }
    }
    else{
        return "userNotAdmin";
    }
}


// function removeUser($apiKey, $iin) to remove user from users list. $tmpUser is userId from users table where iin = $iin. Checking if apiKey is admin. If it is admin, delete user from users table with usersId = $tmpUser.
function removeUser($apiKey, $iin){
    $tmpUserId = getUserIdByApiKey($apiKey);
    if($tmpUserId == "apiKeyNotExists"){
        return "apiKeyNotExists";
    }
    if(isAdmin($apiKey)){
        // userId is userId from users table where iin = $iin. Check if iin in table users exists or not
        $userId = getUserInfo(false, $iin);
        if($userId == "iinNotExists"){
            return "iinNotExists";
        }
        else if($userId == "iinError"){
            return "iinError";
        }
        if(queryDB("DELETE FROM `users` WHERE iin=?", "i", $iin)){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return "userNotAdmin";
    }
}

