window.onload = function() {
    $('.time-form').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('#tbdataplan').DataTable();
    $('#tbdatagroupsection').DataTable();
    $('#tbitemData').DataTable();
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
                temp.push(Number(array[n]['prosentase_plan']));
                temp1.push(Number(array[n]['prosentase_achieve']));
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
                    scaleLabel: {
                        display: true,
                        labelString: "DATE"
                    },
                    gridLines: {
                        display: false,
                        color: "#c6c6c6"
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 100,
                        callback: function(value){return value+ "%"},
                        stepSize: 20,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "PERCENTAGE"
                    },
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
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    var ckBegin = [];
    var ckEnd = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId'+i+'"]').val();

        ckBegin[i] = Number($('input[name="checkpointBegin"][data-secid="'+id[i]+'"]').val());
        ckEnd[i] = Number($('input[name="checkpointEnd"][data-secid="'+id[i]+'"]').val());
        if (ckBegin[i] <= 6 && ckBegin[i] < ckEnd[i]) {
            $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr:first').fadeOut("slow", function() {
                $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr:first').attr('data-showstat', '0');
                var tempElem = $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr').get(0);
                $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr:first').remove();
                $('table[data-secid="'+id[i]+'"] tbody#normalPriority').append(tempElem);
                var tempShowId = $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr[data-showstat*="0"]:first').attr('data-showid');
                $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr[data-showid="'+tempShowId+'"]').fadeIn('fast');
                $('table[data-secid="'+id[i]+'"] tbody#normalPriority tr[data-showid="'+tempShowId+'"]').attr('data-showstat', '1');
            });
        }
    }
}

function getDailyPlan(sectionId){
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId'+i+'"]').val();
        var a = id[i];
        $.ajax({
            url: baseurl+'ProductionPlanning/Monitoring/getDailyPlan',
            data:{
                sectionId: id[i]
            },
            type: 'POST',
        }).done(function(data){
            console.log('update table plans');
            $('table.dailyPlan[data-secid="'+a+'"]').html(data);
        });
    }
}

function getAchieveAllFab(){
    $.ajax({
        url: baseurl+'ProductionPlanning/Monitoring/getAchieveAllFab',
        type: 'POST',
    }).done(function(data){
        $('table#achieveAllFab').html(data);
    });
}

function getInfoJob(){
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId'+i+'"]').val();
        var a = id[i];
        $.ajax({
            url: baseurl+'ProductionPlanning/Monitoring/getInfoJob',
            type: 'POST',
        }).done(function(data){
            $('table.infoJob[data-secid="'+a+'"] tbody').html(data);
        });
    }
}

function getAchievement(){
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId'+i+'"]').val();
        var a = id[i];
        $.ajax({
            url: baseurl+'ProductionPlanning/Monitoring/getAchievement',
            data:{
                sectionId: id[i]
            },
            type: 'POST',
        }).done(function(data){
            $('div.achievement[data-secid="'+a+'"] b').html(data);
        });
    }
}
