<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

ini_set('memory_limit', '-1');

class Weather {
    private $apiKey;
    private $baseUrl;
    private $client;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
        $this->baseUrl = "https://api.openweathermap.org/data/2.5/weather";
        $this->client = new Client();
    }

    public function getWeather($cityId) {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'id' => $cityId,
                'units' => 'metric',
                'appid' => $this->apiKey
            ]
        ]);
        return json_decode($response->getBody());
    }
}
$data = null;
$string = file_get_contents("city.list.json");
$json_cities = json_decode($string, true);
$egypt_cities = array_filter($json_cities, function ($city) {
    return $city['country'] === 'EG';
});

if (isset($_POST["submit"])) {
    $cityId = $_POST["city"];
    $weather = new Weather("9813e2db9a64e2870835bd367a7545b6");
    $data = $weather->getWeather($cityId);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Egyptian Cities Weather</title>
</head>
<body>
    <h2>Weather Report for Egyptian Cities</h2>

    <?php if ($data && isset($data->main)): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:20px;">
            <h3><?= htmlspecialchars($data->name) ?> Weather</h3>
            <p><strong>Temperature:</strong> <?= $data->main->temp_min ?>°C - <?= $data->main->temp_max ?>°C</p>
            <p><strong>Humidity:</strong> <?= $data->main->humidity ?>%</p>
            <p><strong>Condition:</strong> <?= $data->weather[0]->main ?> (<?= $data->weather[0]->description ?>)</p>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="city">Choose a city:</label>
        <select name="city" id="city" required>
            <option value="">-- Select City --</option>
            <?php foreach ($egypt_cities as $city): ?>
                <option value="<?= $city['id'] ?>" <?= (isset($_POST["city"]) && $_POST["city"] == $city['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($city['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="submit" value="Get Weather">
    </form>
</body>
</html>