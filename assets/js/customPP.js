$(document).ready(function() {
    $('#tbdataplan').DataTable();
    $('#tbdatagroupsection').DataTable();
    $('.mon-fab-table').DataTable({
        // "paging": false,
        // "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "pageLength": 5
    });
});

window.onload = function() {
    $('.time-form').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}

function chartFabricationMon() {
    var ctx = document.getElementById('month-fabrication').getContext('2d');
    var hari_kerja = [];
    var currentTime = new Date();
    var currentMonth = currentTime.getMonth() + 1;
    var currentYear = currentTime.getFullYear();
    var maxTime = new Date(currentYear, currentMonth, 0);
    var maxday = maxTime.getDate();
    for (var i = 1; i <= maxday; i++) {
        hari_kerja.push(i);
    }
    var data = [{
        label: '% PLAN',
        backgroundColor: 'rgb(123, 170, 247)',
        borderColor: 'rgb(123, 170, 247)',
        borderWidth: 1,
        data: [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30
        ],
        fill: false
    }, {
        label: '% Achiev',
        backgroundColor: 'rgb(123, 247, 204)',
        borderColor: 'rgb(123, 247, 204)',
        borderWidth: 1,
        data: [
            1, 2, 3, 10, 5, 6, 7, 8, 25, 10, 11, 12, 35, 14, 15, 16, 20, 18, 19, 15, 21, 22, 23, 35, 25, 26, 15, 28, 35, 30, 50
        ],
        fill: false
    }];
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: hari_kerja,
            datasets: data
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        color: "#c6c6c6"
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: "#c6c6c6"
                    }
                }]
            },
            maintainAspectRatio: false,
        }
    });
    Chart.defaults.global.defaultFontColor = 'white';
}