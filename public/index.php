<?php

function isFloat($val)
{
    return is_numeric($val) || is_float($val);
}

function toFloat(String $num)
{
    $sign     = $num[0] == '-' ? -1 : 1;
    $dotPos   = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep      = (($dotPos > $commaPos) && $dotPos)
        ? $dotPos
        : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    if ( ! $sep) {
        return $sign * floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return $sign * floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
    );
}

function compareFloats(float $first, float $second)
{
    return abs($first - $second) <= PHP_FLOAT_EPSILON;
}

function isFloatInArray(float $element, array $array)
{
    foreach ($array as $val) {
        if (compareFloats($element, $val)) {
            return true;
        }
    }

    return false;
}

function checker($x, $y, $r)
{
    if ( ! isFloat($x) || ! isFloat($y) || ! isFloat($r)) {
        return (object)array(
            "success" => false,
            "x"       => $x,
            "y"       => $y,
            "r"       => $r,
        );
    }

    $x = toFLoat($x);
    $y = toFloat($y);
    $r = toFloat($r);

    $checkResult = isFloatInArray($x, [-5, -4, -3, -2, -1, 0, 1, 2, 3]);

    $checkResult &= ($y >= -3 || $y <= 3);
    $checkResult |= (compareFloats($y, 3) || compareFloats($y, -3));

    $checkResult &= isFloatInArray($r, [2, 3, 4, 5]);

    return (object)array(
        "success" => $checkResult,
        "x"       => $x,
        "y"       => $y,
        "r"       => $r,
    );
}

function validator($x, $y, $r)
{
    $sign_x = bccomp($x, 0);
    $sign_y = bccomp($y, 0);
    $sign_r = bccomp($r, 0);

    if ($sign_r === 0) {
        return false;
    } elseif ($sign_x === 0 && $sign_y === 0) {
        return true;
    } elseif ($sign_x === 0) {
        return bccomp($y, bcmul($r, -0.5)) >= 0 && bccomp($y, $r) <= 0;
    } elseif ($sign_y === 0) {
        return bccomp($x, bcmul($r, -1)) >= 0;
    }

    if ($sign_x === 1 && $sign_y === 1) {
        return bccomp(bcadd(bcpow($x, 2), bcpow($y, 2)), bcpow($r, 2)) <= 0;
    } elseif ($sign_x == 1 && $sign_y === -1) {
        return bccomp($y, bcdiv(bcsub($r, $x), 2)) >= 0;
    } elseif ($sign_x === -1 && $sign_y === -1) {
        return bccomp($y, bcmul($r, -0.5)) >= 0
            && bccomp($x, bcmul($r, -1)) >= 0;
    } elseif ($sign_x === -1 && $sign_y === 1) {
        return false;
    } else {
        return false;
    }
}

function script($x, $y, $r)
{
    $checkResult = checker($x, $y, $r);

    $checkSuccess = $checkResult->success;
    $x            = $checkResult->x;
    $y            = $checkResult->y;
    $r            = $checkResult->r;

    echo "<script>alert($x + \" \" + $y + \" \" + $r);</script>";

    $validationSuccess = validator($x, $y, $r);

    return (object)array(
        "success" => $checkSuccess,
        "isValid" => $validationSuccess,
        "x"       => $x,
        "y"       => $y,
        "r"       => $r,
    );
}

session_start();

if ( ! isset($_SESSION["table"])) {
    $_SESSION["table"] = [];
}

$beforeMicros = microtime(true);
$beginDate    = date("d/m H:i:s");

if (isset($_POST["x"]) && isset($_POST["y"]) && isset($_POST["r"])) {
    $res = script($_POST["x"], $_POST["y"], $_POST["r"]);

    if ($res->success) {
        http_response_code(200);
        $afterMicros = microtime(true);

        array_push(
            $_SESSION["table"],
            [
                $res->x,
                $res->y,
                $res->r,
                round(($afterMicros - $beforeMicros) * 1000, 3),
                $beginDate,
                $res->isValid ? "Yes" : "No",
            ]
        );
    } else {
        http_response_code(400);
    }
}
?>

<!DOCTYPE HTML>
<html lang="en"
>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Mikhail Gostev">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Лабораторная работа №1</title>

    <link href="styles/styles.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script'
          rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Roboto"
          rel="stylesheet">


    <!--<script type="application/javascript" src="./js/bootstrap.js"></script>-->
    <!--    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="./js/validator.js"></script>
</head>
<body>
<table class="absolute-frame main-frame">
    <tr class="header-row">
        <td>
            <table class="header-content-panel">
                <tr class="header-content-box">
                    <td class="logo-box">
                        <img src="assets/itmo_logo.png">
                    </td>

                    <td>
                        <table class="student-info-panel">
                            <tr>
                                <td>Работу выполнил студент группы P3201
                            <tr>
                                <td>Гостев Михаил Владимирович (вариант 18103)
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr class="content-row">
        <td class="content-box">
            <table class="content-container">
                <tr>
                    <td class="left-side-panel-box">
                        <table>
                            <tr class="upper-side-row">
                                <td class="upper-side-panel">
                                    <table class="upper-side-box">
                                        <tr>
                                            <td>
                                                <div class="content-panel">
                                                    <h1 class="header">Валидатор
                                                        координат</h1>

                                                    <div class="text">
                                                        <p>Приветствуем вас! Вы
                                                            попали в валидатор
                                                            координат.</p>

                                                        <p>
                                                            С помощью валидатора
                                                            координат вы сможете
                                                            проверить,
                                                            подходит ли ваша
                                                            точка к заданному
                                                            графику.
                                                        </p>

                                                        <p>
                                                            Вводя координаты
                                                            точки, вы можете
                                                            увидеть введенные
                                                            значения
                                                            в "Истории запросов"
                                                        </p>
                                                    </div>

                                                    <div class="plot-image-container">
                                                        <img src="assets/plot_a.png"
                                                             alt="Graph">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="data-form-box">
                                                <div class="content-panel">
                                                    <h1 class="header">Ввод
                                                        координат</h1>

                                                    <form id="form"
                                                          onsubmit="return handleForm()"
                                                          class="data-form"
                                                          action="index.php"
                                                          method="POST">
                                                        <table class="data-form-content-box">
                                                            <tr>
                                                                <td class="input-box">
                                                                    <div class="title">
                                                                        Координата
                                                                        X
                                                                    </div>
                                                                    <table class="input-element-box">
                                                                        <tr>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="xm5">-5
                                                                                    <input class="radio-button"
                                                                                           id="xm5"
                                                                                           name="x"
                                                                                           type="radio"
                                                                                           value="-5">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="xm4">-4
                                                                                    <input class="radio-button"
                                                                                           id="xm4"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="-4">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="xm3">-3
                                                                                    <input class="radio-button"
                                                                                           id="xm3"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="-3">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="xm2">-2
                                                                                    <input class="radio-button"
                                                                                           id="xm2"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="-2">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="xm1">-1
                                                                                    <input class="radio-button"
                                                                                           id="xm1"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="-1">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="x0">0
                                                                                    <input class="radio-button"
                                                                                           id="x0"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="0">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="x1">1
                                                                                    <input class="radio-button"
                                                                                           id="x1"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="1">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="x2">2
                                                                                    <input class="radio-button"
                                                                                           id="x2"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="2">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>

                                                                            <td class="radio-box">
                                                                                <label class="radio-box-label"
                                                                                       for="x3">3
                                                                                    <input class="radio-button"
                                                                                           id="x3"
                                                                                           type="radio"
                                                                                           name="x"
                                                                                           value="3">
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="input-box">
                                                                    <div class="title">
                                                                        Координата
                                                                        Y
                                                                    </div>

                                                                    <input type="text"
                                                                           name="y"
                                                                           class="question input-element-box"
                                                                           id="name"
                                                                           required
                                                                           autocomplete="off">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="input-box">
                                                                    <div class="title">
                                                                        Константа
                                                                        R
                                                                    </div>

                                                                    <div class="input-element-box">
                                                                        <table class="centred-input-box">
                                                                            <tr class="input-element-box input-box">
                                                                                <td class="radio-box">
                                                                                    <label class="radio-box-label">2
                                                                                        <input type="radio"
                                                                                               name="r"
                                                                                               value="2">
                                                                                        <span class="checkmark"></span>
                                                                                    </label>
                                                                                </td>

                                                                                <td class="radio-box">
                                                                                    <label class="radio-box-label">3
                                                                                        <input type="radio"
                                                                                               name="r"
                                                                                               value="3">
                                                                                        <span class="checkmark"></span>
                                                                                    </label>
                                                                                </td>

                                                                                <td class="radio-box">
                                                                                    <label class="radio-box-label">4
                                                                                        <input type="radio"
                                                                                               name="r"
                                                                                               value="4">
                                                                                        <span class="checkmark"></span>
                                                                                    </label>
                                                                                </td>

                                                                                <td class="radio-box">
                                                                                    <label class="radio-box-label">5
                                                                                        <input type="radio"
                                                                                               name="r"
                                                                                               value="5">
                                                                                        <span class="checkmark"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <div class="input-element-box">
                                                                        <input value="Проверить"
                                                                               type="submit"
                                                                               class="submit-button-box submit-button">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td class="right-side-panel-box">
                        <table>
                            <tr>
                                <td>
                                    <div class="content-panel">
                                        <h1 class="header">История запросов</h1>

                                        <div class="result-table-container">
                                            <table class="result-table">
                                                <tr>
                                                    <th>X
                                                    <th>Y
                                                    <th>R
                                                    <th>Время выполнения, nsecs
                                                    <th>Время
                                                    <th>Вердикт
                                                </tr>

                                                <?php
                                                $table = $_SESSION["table"];
                                                foreach ($table as $row) {

                                                    $x             = $row[0];
                                                    $y             = $row[1];
                                                    $r             = $row[2];
                                                    $executionTime = $row[3];
                                                    $beginDate     = $row[4];
                                                    $verdict       = $row[5];

                                                    echo "<tr>
                                                            <td>$x</td>
                                                            <td>$y</td>
                                                            <td>$r</td>
                                                            <td>$executionTime</td>
                                                            <td>$beginDate</td>
                                                            <td>$verdict</td>
                                                         </tr>";
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr class="footer-row">
        <td class="footer-box">
            Университет ИТМО 2018
        </td>
    </tr>
</table>
</body>
</html>