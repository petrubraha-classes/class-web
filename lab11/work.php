<?php
define("URL_IP", "https://api.ipify.org/?format=json");
define("URL_GEO", "http://ip-api.com/json/");
define("URL_WEATHER", "https://historical-forecast-api.open-meteo.com/v1/forecast");

$opt = [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CONNECTTIMEOUT => 10,
  CURLOPT_TIMEOUT => 10,
  CURLOPT_FAILONERROR => true,
  CURLOPT_FOLLOWLOCATION => false
];


//call api pentru IP address
$c_ip = curl_init(URL_IP);
curl_setopt_array($c_ip, $opt);
$res_ip = curl_exec($c_ip);

$codHTTP = curl_getinfo($c_ip, CURLINFO_RESPONSE_CODE);

if ($codHTTP == 200) {
  echo "Am aflat IP-ul!" . "<br>";
} else {
  http_response_code($codHTTP);
  echo $codHTTP;
}

$ipData = json_decode($res_ip, true);
if (isset($ipData["ip"])) {
  $ip_addr = $ipData["ip"];
  echo "IP-ul este: " . $ip_addr . "<br>";
} else {
  echo "Raspunsul JSON nu contine campul \"ip\".";
}
echo "IP-ul local: " . $_SERVER["REMOTE_ADDR"] . "<br>";
curl_close($c_ip);


//call api pentru aflarea geolocatiei
$url_location = URL_GEO
  . urlencode($ip_addr)
  # . "?fields=status,country,city,lat,lon,timezone";
  . "?fields=1065169";

$c_location = curl_init($url_location);
curl_setopt_array($c_location, $opt);
$res_location = curl_exec($c_location);
$codHTTP = curl_getinfo($c_location, CURLINFO_RESPONSE_CODE);

if ($codHTTP == 200) {
  echo "Am aflat Adresa!" . "<br>";
} else {
  http_response_code($codHTTP);
  echo "Status code: " . $codHTTP;
}

$locationData = json_decode($res_location, true);
echo "Adresa ta este: " . $locationData["country"] . ", " . $locationData["city"] . "<br>";
$long = $locationData["lon"];
$lat = $locationData["lat"];
echo "Latitudine: " . $lat . "<br>" . "Longitudine: " . $long . "<br>";


//call api pentru vreme
$url_weather = URL_WEATHER
  . "?latitude=$lat&longitude=$long"
  #. "&hourly=temperature_2m&timezone=auto&forecast_days=1";
  . "&start_date=2025-05-09&end_date=2025-05-10&daily=temperature_2m_max,temperature_2m_min,sunrise,sunset&hourly=temperature_2m,relative_humidity_2m,rain&timezone=Europe%2FBerlin";

$c_weather = curl_init($url_weather);
curl_setopt_array($c_weather, $opt);
$res_weather = curl_exec($c_weather);
$codHTTP = curl_getinfo($c_weather, CURLINFO_RESPONSE_CODE);

if ($codHTTP == 200) {
  echo "Am aflat vremea!" . "<br>";
} else {
  http_response_code($codHTTP);
  echo "Status code: " . $codHTTP;
}

$hourly = array();
$weatherData = json_decode($res_weather, true);
$hourly = $weatherData["hourly"];
echo $hourly["temperature_2m"][0];
