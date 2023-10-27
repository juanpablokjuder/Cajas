<?php
    require "app/app.php";
session_start();
session_destroy();
header("location: ".$GLOBALS['pathInicio'] );