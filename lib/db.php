<?php

//访问数据库
$pdo = new PDO('mysql:host=localhost;dbname=restful','root','');
return $pdo;