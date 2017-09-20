$(document).ready(function() {
    $('#tbdataplan').DataTable();
    $('#tbdatagroupsection').DataTable();
    // $('.mon-fab-table').DataTable({
    //     // "paging": false,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": false,
    //     "info": false,
    //     "autoWidth": false,
    //     "pageLength": 5
    // });
});

window.onload = function() {
    $('.time-form').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}

function chartFabricationMon(labels, value, color, color2, label) {
    var ctx = document.getElementById('month-fabrication').getContext('2d');
    var chartMF = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: []
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

    var count = label.length;
    for(var i = 0; i < count; i++) {
        chartMF.data.datasets.push({borderWidth: 1, fill: false, label: label[i], backgroundColor: color[i], borderColor: color2[i], data: []});
        for(var j = 0; j < value[i].length; j++) {
            chartMF.data.datasets[i].data.push(value[i][j]);
        }
        chartMF.update();
    }
}

function getDataLineChartPP(){
    $.ajax({
        url: baseurl+'ProductionPlanning/Monitoring/getSumPlanMonth',
        data:{
            section: 9
        },
        type: 'POST',
    }).done(function(data){
        var data = JSON.parse(data);

        var array = $.map(data['plan'], function(value, index) {
            return [value];
        });

        var labels = [];
        var temp = [];
        var temp1 = [];
        var value = [];
        for (var i = 0; i < 1; i++) {
            for (var n = 0; n < array.length; n++) {
                labels.push(Number(array[n]['label']));
                temp.push(Number(array[n]['plan_qty']));
                temp1.push(Number(array[n]['achieve_qty']));
            }
            value.push(temp);
            value.push(temp1);
        }
        
        chartFabricationMon(labels, value, ['rgba(163, 60, 82, 0.5)', 'rgba(94, 169, 218, 0.7)'], ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'], ['% PLAN', '% ACHIEV']);
    });
}