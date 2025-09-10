<?php
session_start();
session_destroy();
header("Location: s_login.php");
exit;
