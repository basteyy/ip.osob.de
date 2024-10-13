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

// Text header
header('Content-type: text/plain');

try {
    $ip_agent_hash = password_hash($_SERVER['HTTP_USER_AGENT'], PASSWORD_ARGON2ID);

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

    if ($version) {
        $browser .= ' ' . $version;
    }

    echo $browser;
} catch (\Exception $e) {
    $agent = null;
}