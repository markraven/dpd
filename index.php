<html>
<form name="points" method="post">
    <h3>Point A:</h3>
    <label for="latitude_a">Latitude</label>
    <input type="text" name="latitude_a">
    <label for="longitude_a">Longitude</label>
    <input type="text" name="longitude_a">

    <h3>Point B:</h3>
    <label for="latitude_b">Latitude</label>
    <input type="text" name="latitude_b">
    <label for="longitude_b">Longitude</label>
    <input type="text" name="longitude_b">

    <input type="submit" name="calculate" value="Calculate">
</form>


<?php
if (isset($_POST["submit"])) {
    $a_x = $_POST["latitude_a"];
    $a_y = $_POST["longitude_a"];

    $b_x = $_POST["longitude_b"];
    $b_y = $_POST["longitude_b"];

    $c_x = $_POST["latitude_b"];
    $c_y = $_POST["longitude_a"];

    $d_x = $_POST["latitude_a"];
    $d_y = $_POST["longitude_b"];
} else {
    $a_x = 0;
    $a_y = 0;
    $b_x = 0;
    $b_y = 0;
    $c_x = 0;
    $c_y = 0;
    $d_x = 0;
    $d_y = 0;
}


?>

<h3>Point C: <?php echo $c_x;
    echo "  " . $c_y; ?></h3>
<h3>Point D: <?php echo $d_x;
    echo "  " . $d_y; ?></h3>

<h3>Permieter: <?php
    echo (distance($a_x, $a_y, $c_x, $c_y, "K") + distance($a_x, $a_y, $d_x, $d_y, "K")) * 2 . " Meter<br>"; ?> </h3>
<h3>Area : <?php echo distance($a_x, $a_y, $c_x, $c_y, "K") * distance($a_x, $a_y, $d_x, $d_y, "K") ?> squaremeter</h3>


<h3>EUR : <?php
    if (!is_null($a_x) && $a_x!=0) {
        echo idk((distance($a_x, $a_y, $c_x, $c_y, "K") + distance($a_x, $a_y, $d_x, $d_y, "K")) * 2);
    }
    ?>
    EURO</h3>

</html>

<?php
function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    } else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1609.344);
        }
    }
}

function idk($permieter)
{
    $euro = 0;
    require_once "constants.php";
    //sarok oldalanként - 100 cm
    //4 db sarok elem
    $per_cm = $permieter * 100;
    //4db kapu 5 m/db
    $per_cm = $per_cm - (SAROK * 4) - KAPU_OSZLOP;
    $per_cm = $per_cm / (DROT + OSZLOP);
    $euro += $per_cm * (OSZLOP_EUR + DROT_EUR);

    //minden példában fizetendő összeg
    $euro += (4 * SAROK_EUR) + (4 * KAPU_OSZLOP_EUR);

    return $euro;
}


?>