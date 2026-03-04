<?php

$week = 604800; 
session_set_cookie_params([
  'lifetime' => $week,
  'path' => '/',
  'domain' => '',
  'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
  'httponly' => true,
  'samesite' => 'Lax'
]);

ini_set('session.gc_maxlifetime', $week);
ini_set('session.cookie_lifetime', $week);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

function getMongoClient()
{
  $url = $_ENV['MONGODB_URI'] ?? getenv('MONGODB_URI');
  return new Client($url);
}

function getAdminDb()
{
  $client = getMongoClient();
  $dbName = $_ENV['MONGODB_DATABASE'] ?? getenv('MONGODB_DATABASE');
  return $client->selectDatabase($dbName);
}

function logDevEvent($event, $status, $details = [])
{
  try {
    $db = getAdminDb();
    $collection = $db->selectCollection('dev-logs');
    $collection->insertOne([
      'event' => $event,
      'status' => $status,
      'details' => $details,
      'timestamp' => new UTCDateTime(),
      'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ]);

    //log failed logins to separate collection for banning if needed
    if ($status === 'fail' && $event === 'login_failed') {
     
    }
  } catch (Exception $e) {
    
  }
}

