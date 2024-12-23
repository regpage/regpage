// подготавливаем номер телефона
function phone_number_prepare(tel) {
  let result = "+";
  for (let i = 0; i < tel.length; i++) {
    if (i === 0 || i === 3 || i === 6) {
      result += tel[i] + " ";
    } else {
      result += tel[i];
    }
  }
  return result;
}

// последовательный ввод номера телефона с клавиатуры маска +0 000 000 0000 (курсор на последней позиции)
function tel_mask_input(elem, e, selection_position) {
  // перехватываем ввод и запрещаем в случае необходимости
  if (e.key === '+' && (elem.val().includes('+') || elem.val().length > 0)) {
    e.preventDefault();  // Не допускаем повторения плюса
    return;
  } else if (!/[0-9]/.test(e.key) && e.key !== '+') {
    e.preventDefault();  // блокируем если это не цифра
    return;
  } else if (elem.val().length > 14) {
    e.preventDefault();  // превышен размер
    return;
  }
  if (elem.val().length === 0 && e.key !== '+') {
    e.preventDefault();  // добавляем +
    elem.val("+" + e.key + " ");
  }

  // добавляем пробел после блока символов
  if ((elem.val().length === 2 || elem.val().length === 6 || elem.val().length === 10) /* && (elem.value.length === selection_position || elem.value.length === 2)*/) {
    elem.val(elem.val() + " ");
  }
}

// ввод номера телефона с клавиатуры маска +0 000 000 0000 (курсор НЕ на последней позиции)
function tel_mask_edit(elem, e, selection_position) {
  // перехватываем ввод и запрещаем в случае необходимости
  if (e.key === '+' && (elem.val().includes('+') || elem.val().length > 0)) {
    e.preventDefault();  // Не допускаем повторения плюса
    return;
  } else if (!/[0-9]/.test(e.key) && e.key !== '+') {
    e.preventDefault();  // блокируем если это не цифра
    return;
  } else if (elem.val().length > 14) {
    e.preventDefault();  // превышен размер
    return;
  }
  if (elem.val().length === 0 && e.key !== '+') {
    e.preventDefault();  // добавляем +
    elem.val("+" + e.key + " ");
  }
  // проверка номера
  setTimeout(function () {
    let text = e.target.value.replace(/\s/g, '');
    // если отсутствует + в номере
    if (elem.val().includes('+') && elem.val()) {
      text = text.replaceAll("+", '');
      selection_position++;
    }
    text = phone_number_prepare(text);
    elem.val(text);
    // позиция курсора
    e.target.setSelectionRange(selection_position, selection_position);
  }, 10);
}

// удаление номера телефона с клавиатуры маска +0 000 000 0000 (курсор на любой позиции)
// стирать пробел автоматически если курсор на последеней позиции
function tel_mask_delete(elem, e, selection_position) {
  /*
  if (!elem.val() || selection_position === elem.val().length) {
    return;
  }

  setTimeout(function () {
    let text = e.target.value;
    if (text[0] === "+") {
      text = text.slice(1);
    }
    text = text.replace(/\s/g, '');
    text = phone_number_prepare(text);
    if (selection_position === 0) {
      elem.val(text.slice(1));
    } else {
      elem.val(text);
    }

    // позиция курсора
    if (e.key === "Backspace" && selection_position !== 0) {
      selection_position -= 1;
    }
    e.target.setSelectionRange(selection_position, selection_position);
  }, 10);
  */
// если на предыдщей bacspace или последующей dlt позиции есть пробел, автоматом его удалять
// не удалять первую позицию "+" если строка заполнена "+" удалять последним, так же можно перебрасывать курсор или удалять и после подставлять "+" в случае необходимости
}

// вставка
function tel_mask_paste(elem, e, selection_position) {
  // проверка номера
  setTimeout(function () {
    let text = e.target.value.replace(/[^0-9]/g, '');
    text = phone_number_prepare(text);
    elem.val(text);
    // позиция курсора
    e.target.setSelectionRange(selection_position, selection_position);
  }, 10);
}
