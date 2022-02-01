<?php
    /*//подключение к бд (ip, username, pwd, dbname)
    $mysqli = new mysqli("localhost", "id15304173_vsekov", "z123456654321Z!", "id15304173_database");
    
    //запрос в бд (запрос)
    $mysqli -> query("SET NAMES 'utf-8'");
    
    $success = $mysqli -> query("запрос SQL");
    
    if($success){
        echo "okay";
    }
    else {
        echo "error";
    }
    
    //Закрытие соединения с бд
    $mysqli -> close();*/
    
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    
    
    $conn = mysqli_connect("localhost", "prv_nisrnk", "TcveB1AgDdut", "prv_proj");
    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }
    $conn -> set_charset("utf8");
    
    // * copypasted function 
    function queryDB($sql, $datatypes = "", ...$parameters)
    {
        global $conn;
        
        $stmt = mysqli_prepare ($conn, $sql);
        
        // Check statement
        if (!$stmt) {
            return false;
        }
        
        if(!empty($datatypes) && strlen($datatypes) == count($parameters))
        {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$parameters);
        }
        
        $success = mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        if($result===false)
        {
            mysqli_stmt_close($stmt);
            return $success;
        }
        else if($success && mysqli_num_rows($result)>=0)
        {
            mysqli_stmt_close($stmt);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else
        {
            mysqli_stmt_close($stmt);
            return false;
        }
    }

    function getLastInsertID()
    {
        global $conn;
        
        return mysqli_insert_id($conn);
    }

    // * not prevented sql injection
    // function sendSelectQuery($queryString){
    //     Global $mysqli;
    //     $queryString = htmlspecialchars($queryString);
    //     $success = $mysqli -> query($queryString);
    //     if($success){
    //         $result_set = $success;
    //         $result_array = array();
    //         while(($row = $result_set->fetch_assoc())!=false){
    //             $result_array[] = $row;
    //         }
    //         return $result_array;
    //     }
    //     else {
    //         return false;
    //     }
    // }
    
    
    // function sendQuery($queryString){
    //     Global $mysqli;
    //     $queryString = htmlspecialchars($queryString);
    //     $success = $mysqli -> query($queryString);
    
    //     if($success){
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }
