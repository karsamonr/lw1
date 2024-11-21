<?php
require_once('../dbconnect.php');
session_start();
if (str_ends_with($_SERVER['REQUEST_URI'], 'command')) {
    require_once('../controllers/CommandController.php');
} else if (str_ends_with($_SERVER['REQUEST_URI'], 'type')) {
    require_once('../controllers/TypeController.php');
} else if (str_ends_with($_SERVER['REQUEST_URI'], 'example')) {
    require_once('../controllers/ExampleController.php');
} else if (str_ends_with($_SERVER['REQUEST_URI'], 'profile')) {
    require_once('../controllers/ProfileController.php');
}