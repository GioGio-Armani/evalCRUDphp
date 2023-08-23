<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
} else {
    session_destroy();
    header('Location: /');
}
exit();