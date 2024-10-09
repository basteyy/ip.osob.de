<?php
/**
 * @author xzit.online <hallo@xzit.email>
 * @website https://github.com/basteyy
 * @website https://xzit.online
 */

declare(strict_types=1);

$ip = $_SERVER['REMOTE_ADDR'];

$v4 = null;
$v6 = null;

if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    $v4 = $ip;
} elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
    $v6 = $ip;
}

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IP-Address</title>
    <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            gap: 2rem;
        }

        main > div {
            padding: 1rem;
            border: 1px solid #000;
            border-radius: 5px;
            width: 100%;
            max-width: 32rem;
            text-align: center;
        }

        main > div:hover {
            background-color: #f0f0f0;
            cursor: copy;
        }
    </style>
</head>
<body>
<main>
    <div id="ipv4">
        <h2>IPv4</h2>
        <pre><code><?= $v4 ?? 'N/A' ?></code></pre>
    </div>
    <div id="ipv6">
        <h2>IPv6</h2>
        <pre><code><?= $v6 ?? 'N/A' ?></code></pre>
    </div>
</main>
<script>
    const ipv4_url = 'https://ipv4.osob.de';
    const ipv6_url = 'https://ipv6.osob.de';

    // Fetch IP-Address
    fetch(ipv4_url)
        .then((response) => response.text())
        .then((data) => {
            document.getElementById('ipv4').querySelector('code').textContent = data;
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    fetch(ipv6_url)
        .then((response) => response.text())
        .then((data) => {
            document.getElementById('ipv6').querySelector('code').textContent = data;
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    // Copy to clipboard
    document.querySelectorAll('div').forEach((el) => {
        el.addEventListener('click', () => {
            const code = el.querySelector('code').textContent;
            navigator.clipboard.writeText(code).then(() => {
                console.log('Copied to clipboard');
                    el.querySelector('code').textContent = 'Copied to clipboard';
                    setTimeout(() => {
                        el.querySelector('code').textContent = code;
                    }, 2000);
            }).catch((err) => {
                console.error('Failed to copy: ', err);
            });
        });
    });
</script>
</body>
</html>
