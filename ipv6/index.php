<?php
/**
 * @author xzit.online <hallo@xzit.email>
 * @website https://github.com/basteyy
 * @website https://xzit.online
 */

declare(strict_types=1);

// Text header
header('Content-type: text/plain');

// Output ipv4 (in case no ipv4 is found, output N/A)
$ip = $_SERVER['REMOTE_ADDR'];

if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
    echo $ip;
} else {
    echo 'N/A';
}
