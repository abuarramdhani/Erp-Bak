$(document).ready(function() {
    $('#tbdataplan').DataTable();
    $('#tbdatagroupsection').DataTable();
});

window.onload = function() {
    $('.time-form').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}

function getSectionMon(){
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId'+i+'"]').val();
        getDataLineChartPP(id[i], 'month-fabrication'+id[i]);
    }
}

function getDataLineChartPP(section,canvasid){
    $.ajax({
        url: baseurl+'ProductionPlanning/Monitoring/getSumPlanMonth',
        data:{
            section: section
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
        
        chartFabricationMon(canvasid, labels, value, ['rgba(163, 60, 82, 0.5)', 'rgba(94, 169, 218, 0.7)'], ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'], ['% PLAN', '% ACHIEV']);
    });
}

function chartFabricationMon(canvasid, labels, value, color, color2, label) {
    var ctx = document.getElementById(canvasid);
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
    $('canvas#'+canvasid).height("250px");
}

function showHideNormalPlanning(){
    var ckBegin = $('input[name="checkpointBegin"]').val();
    var ckEnd = $('input[name="checkpointEnd"]').val();
     $.ajax({
        url: baseurl+'ProductionPlanning/Monitoring/getSumPlanMonth',
        data:{
            section: section
        },
        type: 'POST',
    }).done(function(data){
        var data = JSON.parse(data);

        var array = $.map(data['plan'], function(value, index) {
            return [value];
        });
    });

    console.log(ckBegin);
    console.log(ckEnd);
}