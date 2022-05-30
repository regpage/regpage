// ДОЛЖНА БЫТЬ РАЗРАБОТАНА И ПРИНЯТА ОДНА СИСТЕМА ГРИДА ДЛЯ СТАНДАРТНЫХ ОБРАЩЕНИЙ ПО СТЕПЕНИ ВЛОЖЕННОСТИ.
// GRID BUILDER Задавать стандартные стили таблице, ширину колонок и при необходимости передавать код для вставок типа span и тп
// grid (колонка-номер, 0ИЛИатрибуты-classANDdata-item, 0ИЛИсодержание-htmlANDпеременные, колонка-номер, 0ИЛИатрибуты-classANDdata-item, 0ИЛИсодержание-htmlANDпеременные);
function gridData(rowArray, column, attr, data, column1, attr1, data1, column2, attr2, data2, column3, attr3, data3, column4, attr4, data4, column5, attr5, data5, column6, attr6, data6, column7, attr7, data7) {
    var codeHTML = '';
    arr = [column, attr, data, column1, attr1, data1, column2, attr2, data2, column3, attr3, data3, column4, attr4, data4, column5, attr5, data5, column6, attr6, data6, column7, attr7, data7];
    if (rowArray) {
      for (var i = 0; i < rowArray.length; i++) {
        codeHTML += '<tr>';
      if (column) {
        for (var ii = 0; ii < arr.length; ii += 3) {
          if (arr[ii]) {
              codeHTML += '<td '+ arr[ii+1] +'>'+arr[ii+2]+'</td>';
            }
          }
        }
        codeHTML += '</tr>';
      }
    }
    return codeHTML
}
/*
// TEMPLATE
dataString = 'data-item="'+data.item+'" class="row '+someClassItem+'"';
tableRows.push('<tr>'+
    '<td></td>' +
    '<td><div></div></td>'+
    '<td></td></tr>'
);

phoneRows.push('<tr>'+
  '<td></td>' +
  '<td><div></div></td>'+
  '<td></td></tr>'
  '</tr>'
);
}
*/
