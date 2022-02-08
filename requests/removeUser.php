<?php
    require_once("models/users.php");
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_POST["apiKey"]) && isset($_POST["iin"])){
        $apiKey = $_POST["apiKey"];
        $iin = $_POST["iin"];
        
        $userData = removeUser($apiKey, $iin);

        if($userData === "apiKeyNotExists"){
            echo "{
                \"status\": false,
                \"error\": \"apiKeyNotExists\"
            }";
            exit();
        }
        else if($userData === "iinNotExists"){
            echo "{
                \"status\": false,
                \"error\": \"iinNotExists\"
            }";
            exit();
        }
        else if($userData === "iinError"){
            echo "{
                \"status\": false,
                \"error\": \"iinError\"
            }";
            exit();
        }
        else if($userData === "userNotAdmin"){
            echo "{
                \"status\": false,
                \"error\": \"userNotAdmin\"
            }";
            exit();
        }
        else{
            echo "{
                \"status\": true
            }";
            exit();
        }


    }
    else{
        echo "{
            \"status\": false,
            \"error\": \"noData\"
            }";
        exit();
    }
