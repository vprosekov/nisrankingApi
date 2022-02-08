<?php
    require_once("models/achievements.php");
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_POST["userId"]) && isset($_POST["apiKey"])){
        $userId = $_POST["userId"];
        $apiKey = $_POST["apiKey"];
        
        $userData = getUserAchievements($apiKey, $userId, false);

        if($userData === "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idError\"
            }";
            exit();
        }
        else if($userData === "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idNotExists\"
            }";
            exit();
        }
        else if($userData === "apiKeyError"){
            echo "{
                \"status\": false,
                \"error\": \"apiKeyError\"
            }";
            exit();
        }
        else{
            echo "{
                \"status\": true,
                \"userData\": ".json_encode($userData)."
            }";
            exit();
        }
    }
    else if(isset($_POST["iin"]) && isset($_POST["apiKey"])){
        $iin = $_POST["iin"];
        $apiKey = $_POST["apiKey"];
        $userData = getUserAchievements($apiKey, false, $iin);

        if($userData === "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idError\"
            }";
            exit();
        }
        else if($userData === "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idNotExists\"
            }";
            exit();
        }
        else if($userData === "apiKeyError"){
            echo "{
                \"status\": false,
                \"error\": \"apiKeyError\"
            }";
            exit();
        }
        else{
            echo "{
                \"status\": true,
                \"userData\": ".json_encode($userData)."
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
