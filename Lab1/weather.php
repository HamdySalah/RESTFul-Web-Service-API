<?php 
ini_set('memory_limit','-1');

$string = file_get_contents("city.list.json");
$json_cities = json_decode($string , true);

$egypt_cities = array_filter($json_cities, function($city) {
    return $city['country'] === 'EG';
});
$data = null;

if(isset($_POST["submit"])){
    $apiKey = "9813e2db9a64e2870835bd367a7545b6";
    $cityId = $_POST["city"];
    $ApiUrl = "https://api.openweathermap.org/data/2.5/weather?id=".$cityId."&units=metric&appid=".$apiKey;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_URL,$ApiUrl);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    $res = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($res);
    // header("Content-Type: application/json");
    var_dump($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Egypt Weather App</title>
</head>
<body>
    <h2>Weather Report of Egyptian Cities</h2>

    <?php if($data && isset($data->main)): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:20px;">
            <h3><?= htmlspecialchars($data->name) ?> Weather</h3>
            <p><strong>Temperature:</strong> <?= $data->main->temp_min ?>°C - <?= $data->main->temp_max ?>°C</p>
            <p><strong>Humidity:</strong> <?= $data->main->humidity ?>%</p>
            <p><strong>Condition:</strong> <?= $data->weather[0]->main ?> (<?= $data->weather[0]->description ?>)</p>
        </div>
    <?php elseif(isset($_POST["submit"])): ?>
        <p style="color:red;"> Failed to fetch weather data. Please try again.</p>
    <?php endif; ?>

    <form method="post">
        <label for="city">Choose a city:</label>
        <select name="city" id="city" required>
            <option value="">-- Select City --</option>
            <?php foreach($egypt_cities as $city): ?>
                <option value="<?= $city['id'] ?>" <?= (isset($_POST["city"]) && $_POST["city"] == $city['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($city['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="submit" value="Get Weather">
    </form>
</body>
</html>
