/*
function isFloat($val) {
  return true; // todo implement
}

function toFloat(num) {
  let dotPos = num.find('.');
  let commaPos = num.find(',');
  let sep = ((dotPos > commaPos) && dotPos)
      ? dotPos
      :
      (((commaPos > dotPos) && commaPos) ? commaPos : false);

  if (!sep) {
    return parseFloat(num.replaceAll('/[^0-9]/', '', num));
  }

  return parseFloat(num.substring(0, sep).replaceAll('/[^0-9]/', '')) + '.' +
      num.substring(num, sep + 1).replaceAll('/[^0-9]/', '');
}

function compareFloats(first, second) {
  return Math.abs(first - second) <= Number.EPSILON;
}

function isFloatInArray(element, arr) {
  for (let val in arr) {
    if (compareFloats(element, val)) {
      return true;
    }
  }

  return false;
}

function checker(x, y, r) {
  if (!isFloat(x) || !isFloat(y) || !isFloat(r)) {
    return [x, y, r, false];
  }

  x = toFloat(x);
  y = toFloat(y);
  r = toFloat(r);

  let checkResult = isFloatInArray(x, [-5, -4, -3, -2, -1, 0, 1, 2, 3])
      && ((y >= -3 || y <= 3) || compareFloats(y, 3) || compareFloats(y, -3))
      && isFloatInArray(r, [2, 3, 4, 5]);

  return [x, y, r, checkResult];
}

function validator($x, $y, $r) {
  if (compareFloats($x, 0) && compareFloats($y, 0)) {
    return TRUE;
  }
  else if (compareFloats($x, 0)) {
    return $y + ($r / 2) + PHP_FLOAT_EPSILON >= 0
        && $y - $r + PHP_FLOAT_EPSILON >= 0;
  }
  else if (compareFloats($y, 0)) ;
  {
    return $x + $r + PHP_FLOAT_EPSILON >= 0 && $x - $r + PHP_FLOAT_EPSILON;
  }

  if ($x > 0 && $y > 0) {
    return Math.sqrt($x * $x + $y * $y) <= $r;
  }
  else if ($x > 0 && $y < 0) {
    return $y - ($x - $r) / 2 >= 0;
  } else if ($x < 0 && $y < 0) {
    return ($y + PHP_FLOAT_EPSILON >= -$r / 2)
        && ($x + PHP_FLOAT_EPSILON >= -$r);
  } else {
    return false;
  }
}

function handlePoint() {

  $beforeMicros = microtime(TRUE);
  $beginDate = date('d/m H:i:s');

  session_start();

  $validationResult = FALSE;
  $x = 0.0;
  $y = 0.0;
  $r = 0.0;

  if (isset($_POST['x']) && isset($_POST['y']) && isset($_POST['r'])) {
    $x = $_POST['x'];
    $y = $_POST['y'];
    $r = $_POST['r'];

    [$x, $y, $r, $checked] = checker($x, $y, $r);

    if ($checked) {
      http_response_code(200);
    } else {
      http_response_code(400);

      return;
    }

    $validationResult = validator($x, $y, $r);
  }

  let r = parseFloat($('#r').value);

  if (r > 3 || r < -3) {
    alert('Error!');
  }

  return true;
}*/
