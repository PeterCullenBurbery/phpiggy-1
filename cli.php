<?php

require __DIR__ . "/vendor/autoload.php";

use Framework\Database;
use Dotenv\Dotenv;
use App\Config\Paths;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

// Debug: Print environment variables
echo "DB_DRIVER: " . $_ENV['DB_DRIVER'] . PHP_EOL;
echo "DB_HOST: " . $_ENV['DB_HOST'] . PHP_EOL;
echo "DB_PORT: " . $_ENV['DB_PORT'] . PHP_EOL;
echo "DB_NAME: " . $_ENV['DB_NAME'] . PHP_EOL;
echo "DB_USER: " . $_ENV['DB_USER'] . PHP_EOL;
echo "DB_PASS: " . $_ENV['DB_PASS'] . PHP_EOL;

// Debug DSN
$dsn = "{$_ENV['DB_DRIVER']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";
echo "DSN: $dsn" . PHP_EOL;

try {
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "Database connection successful!" . PHP_EOL;
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage() . PHP_EOL);
}

$db = new Database($_ENV['DB_DRIVER'], [
  'host' => $_ENV['DB_HOST'],
  'port' => $_ENV['DB_PORT'],
  'dbname' => $_ENV['DB_NAME']
], $_ENV['DB_USER'], $_ENV['DB_PASS']);

$sqlFile = file_get_contents("./database.sql");

$db->query($sqlFile);
