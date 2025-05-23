<?php
session_start();         // Fur session-ka
session_unset();         // Tirtir dhamaan session values
session_destroy();       // Demi session-ka

header("Location: index.php"); // U dir user-ka bogga login
exit();
?>
