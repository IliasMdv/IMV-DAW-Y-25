<?php
session_start();
session_destroy();
header('Location: /club-montepalma/public/login.php');
exit;