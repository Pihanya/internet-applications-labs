function inArray(compared, values) {
  let result = false;
  values.forEach(function(value, index, array) {
    if (value === compared) {
      result = true;
    }
  });

  return result;
}

function isValid(x, y, r) {
  return inArray(x, [-5, -4, -3, -2, -1, 0, 1, 2, 3]) &&
      inArray(r, [2, 3, 4, 5]) &&
      !(y < -3 || y > 3);

}

function handleForm() {
  try {
    let x = parseInt($('input[name="x"]:checked').attr('value'));
    let y = parseFloat($('input[name="y"]').val());
    let r = parseInt($('input[name="r"]:checked').attr('value'));

    let success = isValid(x, y, r);
    if (!success) {
      alert('Ошибка ввода! Попробуйте ещё раз.');
    }

    return success;
  } catch (ex) {
    alert('Во время обработки данных произошла ошибка. Попробуйте еще раз.');
    return false;
  }
}