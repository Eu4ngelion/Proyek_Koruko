<?php
// session destroy
session_unset();
session_destroy();


// remove cookies
session_start();
session_destroy();


// start lagi session
session_start();
$_SESSION["login"] = false;
header("Location: index.php");
exit();