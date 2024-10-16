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
    <title>IP-Address - Check Your IP Information</title>
    <link rel="apple-touch-icon" sizes="180x180" href="//osob.de/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="//osob.de/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="//osob.de/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="//osob.de/img/favicon/site.webmanifest">
    <meta name="description" content="Find out your IPv4 and IPv6 addresses with a simple and quick lookup tool. Get information about your primary connection type.">
    <meta name="keywords" content="IP address, IPv4, IPv6, check IP, network tool, internet information">
    <meta name="author" content="xzit.online">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="IP-Address - Check Your IP Information">
    <meta property="og:description" content="Find out your IPv4 and IPv6 addresses with a simple and quick lookup tool.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://xzit.online/ip-address">
    <meta property="og:image" content="/assets/og-image.jpg">
    <meta property="og:site_name" content="xzit.online">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="IP-Address - Check Your IP Information">
    <meta name="twitter:description" content="Find out your IPv4 and IPv6 addresses with a simple and quick lookup tool.">
    <meta name="twitter:image" content="/assets/twitter-image.jpg">
    <meta name="twitter:site" content="@xzit_online">
    <link rel="stylesheet" href="/assets/style.min.css">
</head>
<body>
<div id="jssupport">Please enable JavaScript to allow this page to work correctly.</div>
<script> document.getElementById('jssupport').style.display = 'none';</script>
<main>
    <div id="ipv4">
        <h2>IPv4<?= isset($v4) ? ' <span>primary connection</span>' : '' ?></h2>
        <pre><code><?= $v4 ?? 'N/A' ?></code></pre>
        <p><a href="https://ipv4.osob.de" title="See your IPv4" target="_blank">ipv4.osob.de</a></p>
    </div>
    <div id="ipv6">
        <h2>IPv6<?= isset($v6) ? ' <span>primary connection</span>' : '' ?></h2>
        <pre><code><?= $v6 ?? 'N/A' ?></code></pre>
        <p><a href="https://ipv6.osob.de" title="See your IPv6" target="_blank">ipv6.osob.de</a></p>
    </div>
    <div id="hardware">
        <h2>Hardware</h2>
        <h3>Browser</h3>
        <div class="row">
            <div><pre><code id="browser">please wait</code></pre></div>
            <div><pre><code id="browser_version"></code></pre></div>
        </div>
        <p><a href="/browser.php" title="See your Browser" target="_blank">ip.osob.de/browser.php</a></p>
        <h3>Platform</h3>
        <div class="row">
            <div><pre><code id="platform">please wait</code></pre></div>
            <div><pre><code id="platform_version"></code></pre></div>
        </div>
        <p><a href="/platform.php" title="See your Platform (OS)" target="_blank">ip.osob.de/platform.php</a></p>
    </div>
    <div class="d-none" id="geoip">
        <h2>IP Location</h2>
        <h3>Postal / City</h3>
        <div class="row">
            <div><pre><code id="postal">please wait</code></pre></div>
            <div><pre><code id="city">please wait</code></pre></div>
        </div>
        <h3>Country</h3>
        <pre><code id="country">please wait</code></pre>
        <h3>Continent / Timezone</h3>
        <div class="row">
            <div><pre><code id="continent">please wait</code></pre></div>
            <div><pre><code id="timezone">please wait</code></pre></div>
        </div>
        <h3>Latitude / Longitude</h3>
        <div class="row">
            <div><pre><code id="latitude">please wait</code></pre></div>
            <div><pre><code id="longitude">please wait</code></pre></div>
        </div>
        <p><a href="/geoip.php?ip=<?= $v4 ?? $v6 ?>" title="See your GeoIP Data" target="_blank">ip.osob.de/geoip.php</a></p>
    </div>
</main>
<footer>
    Background &copy; by <a href="https://picsum.photos" target="_blank">picsum.photos</a> |
    GeoIp by <a href="https://www.maxmind.com" target="_blank">MaxMind</a> |
    <a href="https://github.com/basteyy/ip.osob.de/" title="Source Code" target="_blank">Source Code</a> |
    <a href="//xzit.online/impressum" title="Impressum" target="_blank">Impressum</a>
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

    fetch('/browser.php')
        .then((response) => response.json())
        .then((data) => {
            document.getElementById('browser').textContent = data.browser;
            document.getElementById('browser_version').textContent = data.version;
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    fetch('/platform.php')
        .then((response) => response.json())
        .then((data) => {
            document.getElementById('platform').textContent = data.platform;
            document.getElementById('platform_version').textContent = data.version;
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    // Get the json response from geoip.php with the primary IP
    fetch('/geoip.php?ip=<?= $v4 ?? $v6 ?>')
        .then((response) => response.json())
        .then((data) => {

            if (data.error) {
                console.error('Error:', data.error);
                return;
            }
            document.getElementById('geoip').classList.remove('d-none');
            document.getElementById('postal').textContent = data.geoip.postal;
            document.getElementById('city').textContent = data.geoip.city;
            document.getElementById('country').textContent = data.geoip.country;
            document.getElementById('continent').textContent = data.geoip.continent;
            document.getElementById('latitude').textContent = data.geoip.latitude;
            document.getElementById('longitude').textContent = data.geoip.longitude;
            document.getElementById('timezone').textContent = data.geoip.timezone;
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

    function bg() {
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
