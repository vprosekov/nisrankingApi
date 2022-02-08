<?php
    //для запроса в бд функция sendQuery(строка запроса)
    //для запроса SELECT функция sendSelectQuery(строка запроса), возвращается ассоциативный массив
    //^ пример возврата: array(array("id"=>1, "name"=>"Sadat"), array("id"=>2, "name"=>"Aisana"))
    
    /*Пример исопльзования sendSelectQuery(). Выводит логин пароль и форматированную дату регистрации всех юзеров
    $array = printResult(sendSelectQuery("SELECT * FROM `users`"));
    for($i = 0; $i < count($array);$i++){
        echo $array[$i]["login"]." ".$array[$i]["password"]." ".date("Y-m-d H:i:s", $array[$i]["reg_date"])."<br>";
    }*/
    
    /*Пример исопльзования sendQuery(). Добавляет пользователя и выводит успешность отправки
    $query="INSERT INTO `users` (`login`, `password`, `reg_date`) VALUES ('login', '".md5("123")."', ".time().")";
        echo (sendQuery($query)?"Okay":"Not Okay");*/
        
    $enabled = "true"; //включен ли апи
        
    require_once "include/dbdriver/dbconnect.php"; //подключение бд
    function out($var, $var_name = ''){
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
    
    if(isset($_GET["request"])){
        $request = $_GET["request"];
        
        if($request == "help"){
            require_once "requests/help.php";
        }
        else if($request == "adduser"){
            require_once("models/users.php");

            require_once "requests/addUser.php";
        }
        else if($request == "auth"){
            require_once("models/users.php");

            require_once "requests/auth.php";
        }
        else if($request == "getuserinfo"){
            require_once("models/users.php");

            require_once "requests/getUserInfo.php";
        }
        else if($request == "getuserapikey"){
            require_once("models/users.php");

            require_once "requests/getUserApiKey.php";
        }
        else if($request == "addadmin"){
            require_once("models/users.php");

            require_once "requests/addAdmin.php";
        }
        else if($request == "removeadmin"){
            require_once("models/users.php");

            require_once "requests/removeAdmin.php";
        }
        else if($request == "removeuser"){
            require_once("models/users.php");

            require_once "requests/removeUser.php";
        }
        else if($request == "addshanyraq"){
            require_once("models/shanyraqs.php");

            require_once "requests/addShanyraq.php";
        }
        else if($request == "getuserachievements"){
            require_once("models/achievements.php");

            require_once "requests/getUserAchievements.php";
        }

        //* test scripts
        else if($request == "test"){
            require_once("models/users.php");
            require_once("models/shanyraqs.php");

            require_once "requests/test.php";
        }


        else{
            echo "{
        \"status\": $enabled,
        \"error\": \"wrongRequest\",
        \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
    }";
        }
        
    }
    else{
        echo "{
    \"status\": $enabled,
    \"error\": \"noRequest\",
    \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
}";
    }
    
    
    
    require_once "include/dbdriver/scriptclose.php"; //закрывает текущую сессию подключения с бд
?>