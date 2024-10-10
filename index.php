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
<head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IP-Address - Check Your IP Information</title>
    <link rel="apple-touch-icon" sizes="180x180" href="//osob.de/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="//osob.de/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="//osob.de/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="//osob.de/img/favicon/site.webmanifest">
    <meta name="description" content="Find out your IPv4 and IPv6 addresses with a simple and quick lookup tool. Get information about your primary connection type.">
    <meta name="keywords" content="IP address, IPv4, IPv6, check IP, network tool, internet information">
    <meta name="author" content="xzit.online">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags for Social Media -->
    <meta property="og:title" content="IP-Address - Check Your IP Information">
    <meta property="og:description" content="Find out your IPv4 and IPv6 addresses with a simple and quick lookup tool.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://xzit.online/ip-address">
    <meta property="og:image" content="/assets/og-image.jpg">
    <meta property="og:site_name" content="xzit.online">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="IP-Address - Check Your IP Information">
    <meta name="twitter:description" content="Find out your IPv4 and IPv6 addresses with a simple and quick lookup tool.">
    <meta name="twitter:image" content="/assets/twitter-image.jpg">
    <meta name="twitter:site" content="@xzit_online">
    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            gap: 2rem;
            margin: 0;
            padding: 0;
        }


        @media (max-width: 768px) {
            main {
                flex-direction: column;
            }
        }

        main > div {
            padding: 1rem;
            border: 1px solid #000;
            background-color: #fff;
            border-radius: 5px;
            width: 90vw;
            max-width: 32rem;
            text-align: center;
        }

        main > div:hover {
            background-color: #f0f0f0;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            overflow: auto;
        }

        code:hover {
            cursor: copy;
        }

        main > div > p {
            font-size: 0.8rem;
            margin-top: 1rem;
        }

        h2 > span {
            font-size: 0.8rem;
            color: #007bff;
            background-color: #f0f0f0;
            padding: 0.2rem 0.5rem;
            border-radius: 5px;
        }

        footer {
            position: fixed;
            bottom: 0;
            padding: 1rem;
            left: 0;
            right: 0;
            text-align: right;
            background-color: rgba(0, 123, 255, 0.3);
        }

        a {
            color: darkslateblue;
            text-decoration: none;
            border-bottom: 1px dashed darkslateblue;
        }

        a:hover {
            text-decoration: none;
            border-bottom: 1px solid darkslateblue;
        }

        footer a {
            color: black;
        }
    </style>
</head>
<body>
<main>
    <div id="ipv4">
        <h2>IPv4<?= isset($v4) ? ' <span>primary connection</span>' : '' ?></h2>
        <pre><code><?= $v4 ?? 'N/A' ?></code></pre>
        <p>
            <a href="https://ipv4.osob.de" title="See your IPv4" target="_blank">ipv4.osob.de</a>
        </p>
    </div>
    <div id="ipv6">
        <h2>IPv6<?= isset($v6) ? ' <span>primary connection</span>' : '' ?></h2>
        <pre><code><?= $v6 ?? 'N/A' ?></code></pre>
        <p>
            <a href="https://ipv6.osob.de" title="See your IPv6" target="_blank">ipv6.osob.de</a>
        </p>
    </div>
</main>
<footer>
    <a href="//xzit.online/impressum" title="Impressum" target="_blank">Impressum</a> | Background &copy; by <a href="https://picsum.photos" target="_blank">picsum.photos</a>
</footer>
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
    document.querySelectorAll('code').forEach((el) => {
        el.addEventListener('click', () => {
            const code = el.textContent;
            navigator.clipboard.writeText(code).then(() => {
                console.log('Copied to clipboard');
                    el.textContent = 'Copied to clipboard';
                    setTimeout(() => {
                        el.textContent = code;
                    }, 1000);
            }).catch((err) => {
                console.error('Failed to copy: ', err);
            });
        });
    });

    const bg_image_url = 'https://picsum.photos/{$width}/{$height}?blur=2&grayscale=1&random=1';

    let timeout = null;

    function bg(){
        const width = window.innerWidth;
        const height = window.innerHeight;
        document.body.style.backgroundImage = `url(${bg_image_url.replace('{$width}', width).replace('{$height}', height)})`;
    }

    // Detect changes in viewport size
    window.addEventListener('resize', () => {
        clearTimeout(timeout);
        timeout = setTimeout(bg, 500);
    });

    bg();
</script>
</body>
</html>
