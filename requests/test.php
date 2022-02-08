<?php
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


echo "<h2>All users list</h2>";
out(getAllUsers("683660237db4bf3cb3b2"));

echo "<h2>Vladislav</h2>";
out(getUserInfo(false, '040403550493'));
out(getUserApiKey("040403550493", 'z123456!'));

echo "<h2>All shanyraqs list</h2>";
out(getAllShanyraqs());

out(getUserIdByApiKey('683660237db4bf3cb3b2'));