<?php
session_start();

require 'vendor/autoload.php'; 

use Core\AppRouter;

AppRouter::run();



