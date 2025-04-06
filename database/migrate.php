<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Database;

$pdo = Database::getInstance(); 

$files = glob(__DIR__ . "/migrations/*.php");

$rollback = in_array('--down', $argv);

if ($rollback) {
    $files = array_reverse($files);
}

foreach ($files as $file) {
    require_once $file;

    $filename = pathinfo($file, PATHINFO_FILENAME);
    $className = "Database\\Migrations\\$filename";

    if (class_exists($className)) {
        echo $rollback ? "Rolling back: $className\n" : "Running migration: $className\n";
        $migration = new $className();
        
        if ($rollback) {
            $migration->down(); 
        } else {
            $migration->up(); 
        }
    } else {
        echo "Error: Migration class $className not found in $file\n";
    }
}

echo $rollback ? "Rollback completed.\n" : "All migrations executed successfully.\n";
