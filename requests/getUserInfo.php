<?php
    require_once("models/users.php");
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_POST["userId"])){
        $userId = $_POST["userId"];
        
        $userData = getUserInfo($userId);

        if($userData == "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idError\"
            }";
            exit();
        }
        else if($userData == "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idNotExists\"
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


        // * old code
        // if(!is_numeric($userId)){
        //     echo "{
        //         \"status\": false,
        //         \"error\": \"idError\"
        //     }";
        //     exit();
        // }
        // $fb = sendSelectQuery("SELECT userId, name, gradeId FROM `users` WHERE userId=$userId");
        // //print_r($fb);
        // if(!$fb || $fb[0]["userId"]=="")
        // {
        //     echo "{
        //         \"status\": false,
        //         \"error\": \"idNotExists\"
        //         }";
        //     exit();
        // }
        // else //все норм
        // {
        //     echo "{
        //         \"status\": false,
        //         \"userData\": ".json_encode($fb[0])."
        //     }";
        //     exit();
        // }

    }
    else if(isset($_POST["iin"])){
        $iin = $_POST["iin"];
        
        $userData = getUserInfo(false, $iin);

        if($userData == "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idError\"
            }";
            exit();
        }
        else if($userData == "idError"){
            echo "{
                \"status\": false,
                \"error\": \"idNotExists\"
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
