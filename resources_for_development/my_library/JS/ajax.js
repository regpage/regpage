//Give me checked checkboxes
function getCheckedCheckBoxesBooks(dwnld) {
  var minLength = 24; // checking length the checkboxesChecked

  //Notice warning
  function hiddenAlert() {
    var elementWarningToHide = document.getElementById("alertAtention");
    elementWarningToHide.classList.remove("show");
    elementWarningToHide.setAttribute("style", "display: none;");
  }

  //Notice warning
  function notifications(content) {
    var elementWarning = document.getElementById("alertAtention");
    elementWarning.innerHTML = content;
    elementWarning.setAttribute("style", "display:block;");
    elementWarning.classList.add("show");
    //setTimeout(hiddenAlert, 4000);
  }
  // Check the fields of date are not empty
  if (document.getElementById('startDate').value == '' || document.getElementById('endDate').value == '') {
    notifications('<strong>Проблема.</strong> Пожалуйста, укажите даты начала и окончания чтения в соответствующих полях.');
    return
  }
  //Check the fields of date are correct
  if (document.getElementById('startDate').value > document.getElementById('endDate').value) {
    //Notice warning
    notifications('<strong>Проблема.</strong> Дата начала чтения не может быть познее даты окончания.');
    return
  }
  var checkboxesChecked = '';
  //Add dates to var
  checkboxesChecked = checkboxesChecked + ' ' + document.getElementById('startDate').value + ' ';
  checkboxesChecked = checkboxesChecked + document.getElementById('endDate').value + ' ';
  //Add OT Books
  var checkboxesCheckedOT = '';
  //Add all or some OT Books
  if (document.getElementById('allOldTestamentID').checked) {
    checkboxesChecked = checkboxesChecked + "--ot" + ' ';
  };
  if (document.getElementById('allNewTestamentID').checked) {
    checkboxesChecked = checkboxesChecked + "--nt" + ' ';
  };
  if (document.getElementById('formatCheckedTodolist').checked) {
    checkboxesChecked = checkboxesChecked + "--format todoist" + ' ';
    minLength = minLength + 18;
  };
  if (!document.getElementById('allOldTestamentID').checked) {
      var checkboxes = document.getElementsByClassName('checkboxBooksOT');
      for (var index = 0; index < checkboxes.length; index++) {
        if (checkboxes[index].checked) {
          checkboxesCheckedOT = checkboxesCheckedOT + checkboxes[index].value + ' ';
        }
      }
      if (checkboxesCheckedOT !='') {
        checkboxesChecked = checkboxesChecked + "--books \"" + ' ';
        checkboxesChecked = checkboxesChecked + checkboxesCheckedOT;
      }
    };
    //Add all or some NT Books
  checkboxesCheckedNT = '';
  if (document.getElementById('allNewTestamentID').checked) {
    if (checkboxesCheckedOT !='') {
      checkboxesChecked = checkboxesChecked + "\"";
    }
    //checkboxesChecked = checkboxesChecked + "--nt" + ' ';
  } else {
      var checkboxes = document.getElementsByClassName('checkboxBooksNT');
      for (var index = 0; index < checkboxes.length; index++) {
        if (checkboxes[index].checked) {
          checkboxesCheckedNT = checkboxesCheckedNT + checkboxes[index].value + ' ';
          }
        }
        if (checkboxesCheckedNT !='' && checkboxesCheckedOT =='') {
          checkboxesChecked = checkboxesChecked + "--books \"" + ' ';
          checkboxesChecked = checkboxesChecked + checkboxesCheckedNT + "\"";
        } else if (checkboxesCheckedNT =='' && checkboxesCheckedOT !='') {
          checkboxesChecked = checkboxesChecked + "\"";
        } else if (checkboxesCheckedNT !='' && checkboxesCheckedOT !='') {
          checkboxesChecked = checkboxesChecked + checkboxesCheckedNT + "\"";
        }
      }
  console.log(checkboxesChecked);
  if (checkboxesChecked.length < minLength) {
    //Notice warning
    notifications('<strong>Проблема.</strong> Пожалуйста, выберите хотя бы одну книгу из списка.');
    return
  }

  hiddenAlert();

  //Ajax button giveMePlan
  function giveMePlan() {
            if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                if (!dwnld) {
                    document.getElementById("status").innerHTML = this.responseText;
                } else if (document.getElementById('formatChecked').checked) {
                    downloadPlan(this.responseText, 'Plan.txt', 'text/plain');
                } else {
                    downloadPlan(this.responseText, 'Plan.csv', 'text/csv');
                }
              }
          };
          xmlhttp.open("GET","master.php?q=" + checkboxesChecked, true);
          xmlhttp.send();
  }
  // show extra buttons
  if (!dwnld) {
    var buttonCopyPaste = document.getElementById("copyMyPlan");
    buttonCopyPaste.classList.add("on-show");
  }

  giveMePlan();
}

// download txt/csv Plan
function downloadPlan(data, filename, type) {
  data = data.substr(17, data.length - 37);
  if (document.getElementById('formatCheckedTodolist').checked) {
    data = data.split(/\n/);
    data = data.join(',\n');
  }
  console.log(data);
  var file = new Blob([data], {type: type});
  if (window.navigator.msSaveOrOpenBlob) // IE10+
      window.navigator.msSaveOrOpenBlob(file, filename);
  else { // Others
      var a = document.createElement("a"),
              url = URL.createObjectURL(file);
      a.href = url;
      a.download = filename;
      document.body.appendChild(a);
      a.click();
      setTimeout(function() {
          document.body.removeChild(a);
          window.URL.revokeObjectURL(url);
      }, 0);
    }
}

// disable OT Books & NT Books
function TestamentChecked(classTestament, idCheckbox) {
  var checkboxesCndt = document.getElementsByClassName(classTestament);
  if (document.getElementById(idCheckbox).checked) {
    for (var index = 0; index < checkboxesCndt.length; index++) {
      checkboxesCndt[index].setAttribute("disabled", "");
    }
  } else {
    for (var index = 0; index < checkboxesCndt.length; index++) {
      checkboxesCndt[index].removeAttribute("disabled");
    }
  }
}

// The clear button
function clearMyForm() {
  var checkboxesClear = document.getElementsByTagName('input');
  for (var index = 0; index < checkboxesClear.length; index++) {
    if (checkboxesClear[index].type == "checkbox") {
      checkboxesClear[index].checked = false;
      checkboxesClear[index].removeAttribute("disabled");
    }
    if (checkboxesClear[index].type == "date") {
      checkboxesClear[index].value = '';
    }
  }
  if (!document.getElementById("formatChecked").checked) {
    document.getElementById("formatChecked").checked = true;
  }
  document.getElementById('status').innerHTML = '';
  var buttonCopyPasteOff = document.getElementById("copyMyPlan");
  buttonCopyPasteOff.classList.remove("on-show");
}

// The copy/paste button
function copyMyPlans() {
    //нашли наш контейнер
    function dubleDuble() {
    var ta = document.getElementById('status');
    //производим его выделение
    var range = document.createRange();
    range.selectNode(ta);
    window.getSelection().addRange(range);
    //пытаемся скопировать текст в буфер обмена
    var mySuccess;
    try {
    document.execCommand('copy');
    } catch(err) {
    }
    //очистим выделение текста, чтобы пользователь "не парился"
    window.getSelection().removeAllRanges();
  }
  // Двойной вызов для Хром, иначе глючит
  dubleDuble();
  dubleDuble();

};
