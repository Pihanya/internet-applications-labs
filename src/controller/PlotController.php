<?php

namespace App\Controller;

if (isset($_POST["x"])
    && isset($_POST["y"])
    && isset($_POST["r"])
) {
    $_SESSION["x"]     = $_POST["x"];
    $_SESSION["y"]     = $_POST["y"];
    $_SESSION["r"]     = $_POST["r"];
    $_SESSION["table"] = $_POST["table"];

    array_push(
        $_SESSION["table"],
        [$_SESSION["x"], $_SESSION["y"], $_SESSION["r"], "No"]
    );
}

$x     = $_SESSION["x"];
$y     = $_SESSION["y"];
$r     = $_SESSION["r"];
$table = $_SESSION["table"];

/*if ( ! isset( $_POST["x"] )
     && ! isset( $_POST["y"] )
     && ! isset( $_POST["r"] )
) {
	$_POST["x"] = $_SESSION["x"];
	$_POST["y"] = $_SESSION["y"];
	$_POST["r"] = $_SESSION["r"];
}*/

//header( "Location: /lab1/public/index.php" );
header("Location: ../src/PlotController.php");
header("Content-Type: text/json");

if ( ! is_numeric($x)
    || ! is_numeric($y)
    || ! is_numeric($r)
    || $r < 0
) {
    http_response_code(400);
} else {
    http_response_code(200);
}


echo "{\"x\":$x, \"y\":$y, \"r\":$r, \"table\":$table}";

return;

$val = false;
if ($x >= 0 && $y >= 0) {
    $val = (pow($x, 2) + pow($y, 2) <= pow($r, 2));
} elseif ($x >= 0 && $y <= 0) {
    $val = ($y >= ($x - $r) / 2);
} elseif ($x <= 0 && $y <= 0) {
    $val = $y >= -$r / 2 && $x >= -$r;
}

if ( ! $val) {
//	http_response_code( 200 );
    $http_response_header = "";
} else {
//	echo "Nice! ";
}