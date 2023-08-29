$(document).ready(function(){
  // Статистика чтения библии
  $(".bible_statistic_btn").click(function () {
    $('#spinner').modal("show");
    fetch("ajax/ftt_attendance_ajax.php?type=get_bible_statistic&trainee_id=" + $("#modalAddEdit").attr("data-member_key"))
    .then(response => response.json())
    .then(commits => {
      if (commits.result.length > 0) {
        $("#bible_statistic_list").find("canvas").remove();
        $("#bible_statistic_list").append("<canvas></canvas>");
        const brc = $("#bible_statistic_list").find("canvas")[0].getContext('2d');
        let books = [];
        let capters = [];
        let persent = [];
        for (var i = 0; i < commits.result.length; i++) {
          for (let column in commits.result[i]) {
              if (commits.result[i].hasOwnProperty(column)) {
                if (i === 0) {
                  books.push(commits.result[i][column]);
                } else if (i === 1) {
                  capters.push(commits.result[i][column]);
                } else if (i === 2) {
                  persent.push(commits.result[i][column]);
                }
              }
          }
        }

        new Chart(brc, {
          type: "bar",
          data: {
            labels: books,
            datasets: [{
              label: '100%',
              data: persent,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    });

    // статистика с датами
    fetch("ajax/ftt_attendance_ajax.php?type=get_bible_statistic_dates&trainee_id=" + $("#modalAddEdit").attr("data-member_key"))
    .then(response => response.json())
    .then(commits => {
      console.log(commits.result);
      if (commits.result.length > 0) {
        $("#bible_statistic_list_dates").find("canvas").remove();
        $("#bible_statistic_list_dates").append("<canvas></canvas>");
        const brc = $("#bible_statistic_list_dates").find("canvas")[0].getContext('2d');
        let books = [];
        let capters = [];
        let persent = [];
        for (var i = 0; i < commits.result.length; i++) {
          for (let column in commits.result[i]) {
              if (commits.result[i].hasOwnProperty(column)) {
                if (i === 0) {
                  books.push(commits.result[i][column] + " " + commits.result[i+3][column]);
                } else if (i === 1) {
                  capters.push(commits.result[i][column]);
                } else if (i === 2) {
                  persent.push(commits.result[i][column]);
                } else if (i === 3) {
                  persent.push(commits.result[i][column]);
                }
              }
          }
        }

        new Chart(brc, {
          type: "bar",
          data: {
            labels: books,
            datasets: [{
              label: '100%',
              data: persent,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
      $('#spinner').modal("hide");
    });

    setTimeout(function () {
      $("body").addClass("modal-open");
      $("body").attr("style", "padding-right: 15px;");
    }, 500);
    $("#mdl_bible_statistic").on("hide.bs.modal", function () {
      setTimeout(function () {
        $("body").addClass("modal-open");
      }, 500);
    });
  });

});
