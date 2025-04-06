<?php

namespace Core;

use Dotenv\Dotenv;

class Config
{
    private static $config = [];
    private static $envLoaded = false;

    private static function loadConfig()
    {
        if (empty(self::$config)) {
            self::$config = require __DIR__ . '/../config/config.php';
        }
    }

    private static function loadEnv()
    {
        if (!self::$envLoaded) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
            self::$envLoaded = true;
        }
    }

    public static function get($key, $default = null)
    {
        self::loadConfig();
        self::loadEnv();

        // Check .env first
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        // Check config.php for nested keys
        $keys = explode('.', $key);
        $value = self::$config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }
}
