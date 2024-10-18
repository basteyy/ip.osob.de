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

    $ip_geo_hash = password_hash('geo.' . $_SERVER['IP'], PASSWORD_ARGON2ID);

    if (apcu_exists($ip_geo_hash)) {
        $record = apcu_fetch($ip_geo_hash);
        $data = [
            'city'      => $record['city'],
            'country'   => $record['country'],
            'continent' => $record['continent'],
            'latitude'  => $record['latitude'],
            'longitude' => $record['longitude'],
            'postal'    => $record['postal'],
            'timezone'  => $record['timezone'],
        ];
    } else {
        $cityDbReader = new Reader($maxmind_dir . 'GeoLite2-City.mmdb');
        $record = $cityDbReader->city($_GET['ip']);
        $data = [
            'city'      => $record->city->name,
            'country'   => $record->country->name,
            'continent' => $record->continent->name,
            'latitude'  => $record->location->latitude,
            'longitude' => $record->location->longitude,
            'postal'    => $record->postal->code,
            'timezone'  => $record->location->timeZone,
        ];

        apcu_store($ip_geo_hash, $data, 3600);
    }

    echo json_encode([
        'status' => 'success',
        'ip'     => $_GET['ip'],
        'geoip'  => $data,
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage(),
    ]);
}
