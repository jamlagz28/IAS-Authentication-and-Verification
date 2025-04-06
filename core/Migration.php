<?php 
namespace Core;
use Core\Database; 

class Migration {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function up() {}
    public function down() {}
}
