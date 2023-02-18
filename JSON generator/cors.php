<?php
    header('Access-Control-Allow-Origin: http://localhost/*');
    header('Content-Type: application/json; charset=utf-8');
    die(file_get_contents('latest-release.json'));
?>