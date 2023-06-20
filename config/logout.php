<?php 

require('config/vars.php');

if (!isset($_SESSION['id'])) {session_start();}
session_destroy();
route('login');

?>