<?php
$url = 'http://backend.navionics.io/tile/get_key/Navionics_internalpurpose_00001/webapp.navionics.com';
$referer = 'https://webapp.navionics.com';
$mapsource = '<?xml version="1.0" encoding="UTF-8"?>
<customMapSource>
<name>Eniro + Navionics Boating</name>
<layers>
<layer>
<url>http://{$serverpart}.eniro.no/geowebcache/service/tms1.0.0/map2x/{$z}/{$x}/{$invY}.png</url>
<serverParts>map01 map02 map03 map04</serverParts>
</layer>
<layer>
<url>http://backend.navionics.io/tile/{$z}/{$x}/{$y}?LAYERS=config_1_6.00_0&TRANSPARENT=TRUE&UGC=TRUE&navtoken={$navtoken}</url>
</layer>
</layers>
</customMapSource>';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_REFERER, $referer);
$navtoken = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($info["http_code"] == 200) {
    header('Content-type: application/x-galileo');
    echo str_replace('{$navtoken}', urlencode($navtoken), $mapsource);
} else {
    header('Content-type: text/plain');
    echo 'Something went wrong';
}