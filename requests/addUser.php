
<?php
    require_once("models/users.php");


    function out($var, $var_name = '')
    {
        echo '<pre style="outline: 1px dashed 
                red;padding:5px;margin:10px;color:white;background:black;">';
        if (!empty($var_name)) {
            echo '<hr3>' . $var_name . '</h3>';
        }
        if (is_string($var)) {
            $var = htmlspecialchars($var);
        }
        print_r($var);
        echo '</pre>';
    }



    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    if(isset($_POST["apiKey"])&&isset($_POST["iin"]) && isset($_POST["name"])&& isset($_POST["password"]) && isset($_POST["gradeId"])){

        $iin = $_POST["iin"];
        $name = $_POST["name"];
        $gradeId = $_POST["gradeId"];
        $password = $_POST["password"];
        $apiKey = $_POST["apiKey"];
        

        $addNewUser = addUser($apiKey,$iin,$name,$password,$gradeId);
        // var_dump($addNewUser);
        if($addNewUser === true){
            echo "{
                \"status\": true,
                \"userId\": ".getLastInsertID()."
            }";
            exit();
        }
        else if($addNewUser === "noRights"){
            echo "{
                \"status\": true,
                \"error\": \"noRights\"
            }";
            exit();
        }
        else if($addNewUser === "apiKeyNotExists"){
            echo "{
                \"status\": true,
                \"error\": \"apiKeyNotExists\"
            }";
            exit();
        }
        else{
            echo "{
                \"status\": false,
                \"error\": \"$addNewUser\"
            }";
            exit();
        }
        

        // if(strlen($iin) != 12){
        //     echo "{
        //         \"status\": false,
        //         \"error\": \"iinError\",
		// 		\"help\": \"Full documentation on http://$_SERVER[HTTP_HOST]/api.php?request=help\"
        //     }";
        //     exit();
        // }

        // $fb = sendSelectQuery("SELECT `iin` FROM `users` WHERE `iin`='$iin'");
        
        // if($fb && $fb[0]["iin"]!="")
        // {
        //     echo "{
        //         \"status\": false,
        //         \"error\": \"userExists\",
		// 		\"help\": \"Full documentation on http://$_SERVER[HTTP_HOST]/api.php?request=help\"
        //     }";
        //     exit();
        // }
        // else //все норм
        // {

        //     $apiKey = implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 6));

        //     if(sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")){
        //         //echo sendSelectQuery("SELECT `id` FROM `users` WHERE `apiKey`='$apiKey'")."<br>";
        //         echo "{
        //             \"status\": false,
        //             \"error\": \"Repeat again\",
		// 			\"help\": \"Full documentation on http://$_SERVER[HTTP_HOST]/api.php?request=help\"
        //         }";
        //         exit();
        //     }
        //     // $query = "INSERT INTO `users` (`name`, `grade`, `iin`, `password`, `type`, `publishedCourses`, `payedCourses`, `favouriteCourses`, `apiKey`, `history`) VALUES ('$name', '$grade', '$iin', '".md5($password)."','$type', '$publishedCourses', '$payedCourses', '$favouriteCourses', '$apiKey', '')";
        //     $query = "INSERT INTO `users`(`iin`, `password`, `name`, `gradeId`, `apiKey`) VALUES ('$iin','".md5($password)."','$name',$gradeId,'$apiKey')";
        //     // out($query);
        //     if(sendQuery($query)){
        //         echo "{
        //             \"status\": false
        //         }";
        //         exit();
        //     }
        //     else{
        //         echo "{
        //             \"status\": false
        //         }";
        //         exit();
        //     }


        // }

    }else{
        echo "{
            \"status\": false,
            \"error\": \"noData\",
			\"help\": \"Full documentation on http://$_SERVER[HTTP_HOST]/api.php?request=help\"
        }";
        exit();
    }
    
?>