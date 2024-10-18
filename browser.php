<?php
/**
 * @author xzit.online <hallo@xzit.email>
 * @website https://github.com/basteyy
 * @website https://xzit.online
 */

declare(strict_types=1);

if (!file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    die('Please run `composer install` first.');
}

include $autoload;

// Json header
header('Content-type: application/json');

try {
    $ip_agent_hash = hash('sha256', $_SERVER['HTTP_USER_AGENT']);

    // In apcu_cache?
    if (apcu_exists($ip_agent_hash)) {
        $agent = apcu_fetch($ip_agent_hash);
    } else {
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        apcu_store($ip_agent_hash, $agent, 3600);
    }

    $agent->setHttpHeaders($_SERVER);

    $browser = $agent->browser();
    $version = $agent->version($browser);

    echo json_encode(
        [
            'status'   => 'success',
            'browser' => $browser,
            'version'  => $version ? $version : ''
        ]
    );
} catch (\Exception $e) {
    $agent = null;
}