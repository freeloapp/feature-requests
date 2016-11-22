<?php

define("DB_HOST", "localhost");
define("DB_USER", "username");
define("DB_PASS", "password");
define("DB_NAME", "database");

define("CONFIG_URL", "https://wwww.freelo.cz/");
define("CONFIG_EMAIL", "hello@world.tld");

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if( !$db )
{
    file_put_contents('log.txt', print_r($_POST, true), FILE_APPEND );
}

mysqli_select_db($db, DB_NAME);
mysqli_query($db, "SET NAMES utf8");