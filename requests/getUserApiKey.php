<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_POST["iin"]) && isset($_POST["password"])){
        $iin = $_POST["iin"];
        $password = $_POST["password"];
        
        $apiKey = getUserApiKey($iin, $password);

        if($apiKey === "iinError"){
            echo "{
                \"status\": true,
                \"error\": \"iinError\"
            }";
            exit();
        }
        else if($apiKey === "wrongCredentials"){
            echo "{
                \"status\": true,
                \"error\": \"wrongCredentials\"
            }";
            exit();
        }
        else{
            echo "{
                \"status\": false,
                \"apiKey\": $apiKey
            }";
            exit();
        }

// old code
//         if(strlen($iin) != 12){
//             echo "{
//                 \"status\": true,
//                 \"error\": \"iinError\",
//                 \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
//             }";
//             exit();
//         }
        
//         $fb = sendSelectQuery("SELECT * FROM `users` WHERE `iin`='$iin' AND `password`='$password'");
//         //print_r($fb);
//         if(!$fb || $fb[0]["apiKey"]=="")
//         {
//             echo "{
//                 \"status\": true,
//                 \"error\": \"userNotExists\",
//                 \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
//             }";
//             exit();
//         }
//         else //все норм
//         {
//             $apiKey = $fb[0]["apiKey"];
//             $userId = $fb[0]["userId"];
//             $name = $fb[0]["name"];
//             $iin = $fb[0]["iin"];
//             $gradeId = $fb[0]["gradeId"];
//             echo "{
//     \"status\": true,
//     \"userId\": $userId,
//     \"apiKey\": \"$apiKey\",
//     \"name\":\"$name\",
//     \"grade\":\"$gradeId\"
// }";
//             exit();
//         }

    }
    else{
        echo "{
            \"status\": false,
            \"error\": \"noData\",
            \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
        }";
        exit();
    }
    
?>