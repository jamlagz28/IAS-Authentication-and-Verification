<?php

namespace Database\Migrations;

use Core\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
           password VARCHAR(255) NOT NULL,
            verification_code INT NULL,
            verification_status ENUM('pending', 'verified') DEFAULT 'pending',
            verification_requested_at TIMESTAMP NULL,
            request_attempts INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
        echo " Users table created successfully.\n";
    }

    public function down()
    {
        $this->pdo->exec("DROP TABLE IF EXISTS users");
        echo " Users table dropped.\n";
    }
}
