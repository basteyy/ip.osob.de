<?php
/**
 * @author xzit.online <hallo@xzit.email>
 * @website https://github.com/basteyy
 * @website https://xzit.online
 */

declare(strict_types=1);

use GeoIp2\Database\Reader;

if (!file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    die('Please run `composer install` first.');
}

include $autoload;

// Load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Json header
header('Content-type: application/json');

try {
    if (!isset($_SERVER['MAXMIND_DB_PATH'])) {
        throw new Exception('MAXMIND_DB_PATH not set');
    }

    if (!is_dir($maxmind_dir = $_SERVER['MAXMIND_DB_PATH'])) {
        throw new Exception('MAXMIND_DB_PATH is not a directory');
    }

    if (!is_readable($maxmind_dir)) {
        throw new Exception('MAXMIND_DB_PATH is not readable');
    }

    if (!isset($_GET['ip'])) {
        throw new Exception('IP not set');
    }

    if (!filter_var($_GET['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !filter_var($_GET['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        throw new Exception('Invalid IP');
    }

    $cityDbReader = new Reader($maxmind_dir . 'GeoLite2-City.mmdb');

    $record = $cityDbReader->city($_GET['ip']);

    echo json_encode([
        'status' => 'success',
        'ip' => $_GET['ip'],
        'geoip' => [
            'ip' => $_GET['ip'],
            'city' => $record->city->name,
            'country' => $record->country->name,
            'continent' => $record->continent->name,
            'latitude' => $record->location->latitude,
            'longitude' => $record->location->longitude,
            'postal' => $record->postal->code,
            'timezone' => $record->location->timeZone,
        ],
    ]);

} catch (Exception $e) {
    die(json_encode(['error' => $e->getMessage()]));
}
