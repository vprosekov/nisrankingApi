
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
    
    if(isset($_POST["apiKey"])&&isset($_POST["shanyraqName"]) && isset($_POST["curatorName"])&& isset($_POST["curatorPhone"])){

        $apiKey = $_POST["apiKey"];
        $shanyraqName = $_POST["shanyraqName"];
        $curatorName = $_POST["curatorName"];   
        $curatorPhone = $_POST["curatorPhone"];
        

        $addNewShanyraq = addNewShanyraq($apiKey,$shanyraqName, $curatorName, $curatorPhone);
        // var_dump($addNewShanyraq);
        if($addNewShanyraq === true){
            echo "{
                \"status\": true,
                \"shanyraqId\": ".getLastInsertID()."
            }";
            exit();
        }
        else if($addNewShanyraq === "noRights"){
            echo "{
                \"status\": false,
                \"error\": \"noRights\"
            }";
            exit();
        }
        else if($addNewShanyraq === "apiKeyNotExists"){
            echo "{
                \"status\": false,
                \"error\": \"apiKeyNotExists\"
            }";
            exit();
        }
        else{
            echo "{
                \"status\": true
            }";
            exit();
        }
    }else{
        echo "{
            \"status\": false,
            \"error\": \"noData\",
			\"help\": \"Full documentation on http://$_SERVER[HTTP_HOST]/api.php?request=help\"
        }";
        exit();
    }
    
?>