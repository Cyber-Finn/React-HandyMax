<?php
    // Database connection details
    $servername = "localhost"; //the machine that the DB is running on. if you're using the PHP on the same server as your mySQL database, this will be localhost
    $username = "root";
    $password = "mysql"; //ensure that password is correct. I kept mine default for this example
    $dbname = "HandyMax";
    $port = "3306"; //ensure that port is correct here. The default would likely be 3306 if you just did a generic install of MySQL
    $dsn = "mysql:host=$servername;port=$port;dbname=$dbname";
?>