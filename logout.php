<?php
session_start();
unset($_SESSION['logged_in']);
header("refresh:1;url=index.php"); ?>