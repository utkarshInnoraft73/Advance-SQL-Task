<?php

// Start the session.
session_start();

// Distroy the session.
session_destroy();
header("Location: ./../Login/Login.php");
exit;
