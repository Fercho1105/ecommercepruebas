<?php
session_start();
require 'includes/config.php';

// Marcar para resetear stock en la próxima visita
$_SESSION['reset_stock'] = true;
?>