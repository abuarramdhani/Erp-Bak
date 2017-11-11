window.onload = function() {
    $('.time-form').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "opens": "left",
        "drops": "down",
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss',
            cancelLabel: 'Clear'
        },
         "autoUpdateInput": false
    });
    $('.time-form').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss'));
    });
    $('.time-form').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    $('.time-form-range').daterangepicker({
        "showDropdowns": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "opens": "left",
        "drops": "down",
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss',
            cancelLabel: 'Clear'
        },
         "autoUpdateInput": false
    });
    $('.time-form-range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss')+' - '+picker.endDate.format('YYYY/MM/DD HH:mm:ss'));
    });
    $('.time-form-range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    $('.date-month-year').datepicker({
        autoclose: true,
        changeMonth: true,
        format: 'MM yyyy',
        startView: "months",
        minViewMode: "months"
    });
    $('#tbdataplan').DataTable({
        dom: 'rtBp',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#tbdatagroupsection').DataTable();
    $('#tbitemData').DataTable();
    $('#tblSection').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel']
    });
}

function getSectionMon() {
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId' + i + '"]').val();
        getDataLineChartPP(id[i], 'month-fabrication' + id[i]);
    }
}

function getDataLineChartPP(section, canvasid) {
    $.ajax({
        url: baseurl + 'ProductionPlanning/Monitoring/getSumPlanMonth',
        data: {
            section: section
        },
        type: 'POST',
    }).done(function(data) {
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
        chartFabricationMon(canvasid, labels, value, ['rgba(231, 76, 60, 1)', 'rgba(51, 122, 183, 1)'], ['rgba(231, 76, 60, 1)', 'rgba(51, 122, 183, 1)'], ['% PLAN', '% ACHIEV']);
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
                        fontWeight: "bold",
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
                        callback: function(value) {
                            return value + "%"
                        },
                        stepSize: 20,
                        fontSize: 14,
                        fontColor: "black",
                        fontWeight: "bold"
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
    Chart.defaults.global.defaultFontColor = '#000';
    var count = label.length;
    for (var i = 0; i < count; i++) {
        chartMF.data.datasets.push({
            borderWidth: 2,
            fill: false,
            label: label[i],
            backgroundColor: color[i],
            borderColor: color2[i],
            data: []
        });
        for (var j = 0; j < value[i].length; j++) {
            chartMF.data.datasets[i].data.push(value[i][j]);
        }
        chartMF.update();
    }
    $('canvas#' + canvasid).height("250px");
}

function showHideNormalPlanningMultiple() {
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    var ckBegin = [];
    var ckEnd = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId' + i + '"]').val();
        ckBegin[i] = Number($('input[name="checkpointBegin"][data-secid="' + id[i] + '"]').val());
        ckEnd[i] = Number($('input[name="checkpointEnd"][data-secid="' + id[i] + '"]').val());
        if (ckBegin[i] <= 6 && ckBegin[i] < ckEnd[i]) {
            $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr:first').fadeOut("slow", function() {
                $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr:first').attr('data-showstat', '0');
                var tempElem = $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr').get(0);
                $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr:first').remove();
                $('table[data-secid="' + id[i] + '"] tbody#normalPriority').append(tempElem);
                var tempShowId = $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr[data-showstat*="0"]:first').attr('data-showid');
                $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr[data-showid="' + tempShowId + '"]').fadeIn('fast');
                $('table[data-secid="' + id[i] + '"] tbody#normalPriority tr[data-showid="' + tempShowId + '"]').attr('data-showstat', '1');
            });
        }
    }
}

function showHideNormalPlanningSingle() {
    var id = $('input[name="sectionId0"]').val();
    var ckBegin = Number($('input[name="checkpointBegin"][data-secid="' + id + '"]').val());
    var ckEnd = Number($('input[name="checkpointEnd"][data-secid="' + id + '"]').val());
    if (ckBegin <= 6 && ckBegin < ckEnd) {
        $('tbody#normalPriority tr:first').fadeOut("slow", function() {
            $('tbody#normalPriority tr:first').attr('data-showstat', '0');
            var tempElem = $('table[data-secid="' + id + '"] tbody#normalPriority tr').get(0);
            $('tbody#normalPriority tr:first').remove();
            $('tbody#normalPriority').append(tempElem);
            var tempShowId = $('table[data-secid="' + id + '"] tbody#normalPriority tr[data-showstat*="0"]:first').attr('data-showid');
            $('tbody#normalPriority tr[data-showid="' + tempShowId + '"]').fadeIn('fast');
            $('tbody#normalPriority tr[data-showid="' + tempShowId + '"]').attr('data-showstat', '1');
        });
    }
}

function showHideNormalPlanningStorage() {
    var ckBegin = Number($('input[name="checkpointBegin"]').val());
    var ckEnd = Number($('input[name="checkpointEnd"]').val());
    if (ckBegin <= 12 && ckBegin < ckEnd) {
        $('tbody#normalPriority tr:first').fadeOut("slow", function() {
            $('tbody#normalPriority tr:first').attr('data-showstat', '0');
            var tempElem = $('table tbody#normalPriority tr').get(0);
            $('tbody#normalPriority tr:first').remove();
            $('tbody#normalPriority').append(tempElem);
            var tempShowId = $('table tbody#normalPriority tr[data-showstat*="0"]:first').attr('data-showid');
            $('tbody#normalPriority tr[data-showid="' + tempShowId + '"]').fadeIn('fast');
            $('tbody#normalPriority tr[data-showid="' + tempShowId + '"]').attr('data-showstat', '1');
        });
    }
}

function getDailyPlan(sectionId) {
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId' + i + '"]').val();
        var a = id[i];
        $.ajax({
            url: baseurl + 'ProductionPlanning/Monitoring/getDailyPlan',
            data: {
                sectionId: id[i]
            },
            type: 'POST',
        }).done(function(data) {
            $('table.dailyPlan[data-secid="' + a + '"]').html(data);
        });
    }
}

function getDailyPlanStorage() {
    id = $('input[name="storage_name"]').val();
    $.ajax({
        url: baseurl + 'ProductionPlanning/StorageMonitoring/getDailyPlanStg',
        data: {
            storage_name: id
        },
        type: 'POST',
    }).done(function(data) {
        $('table.dailyPlan').html(data);
    });
}

function getAchieveAllFab() {
    $.ajax({
        url: baseurl + 'ProductionPlanning/Monitoring/getAchieveAllFab',
        type: 'POST',
    }).done(function(data) {
        $('table#achieveAllFab').html(data);
    });
}

function getInfoJob() {
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId' + i + '"]').val();
        var a = id[i];
        $.ajax({
            url: baseurl + 'ProductionPlanning/Monitoring/getInfoJob',
            type: 'POST',
        }).done(function(data) {
            $('table.infoJob[data-secid="' + a + '"] tbody').html(data);
        });
    }
}

function getAchievement() {
    var count = $('input[name="sectionCount"]').val();
    var id = [];
    for (var i = 0; i < count; i++) {
        id[i] = $('input[name="sectionId' + i + '"]').val();
        var a = id[i];
        $.ajax({
            url: baseurl + 'ProductionPlanning/Monitoring/getAchievement',
            data: {
                sectionId: id[i]
            },
            type: 'POST',
        }).done(function(data) {
            $('div.achievement[data-secid="' + a + '"] b').html(data);
        });
    }
}

function getAchievementStorage() {
    $.ajax({
        url: baseurl + 'ProductionPlanning/StorageMonitoring/getAchievement',
        type: 'POST',
        data: {
            storage_name: $('input[name="storage_name"]').val()
        },
    }).done(function(data) {
        $('div.achievement b').html(data);
    });
}

function groupSectionDelConf(th, id) {
    var elm = $(th).closest('tr').clone();
    $('div.modal-footer a').attr("href", baseurl + "ProductionPlanning/Setting/GroupSection/Delete/" + id);
    $('div#deleteConfirm tbody').html(elm);
    $('div#deleteConfirm tbody td.del-col').remove();
    $('#deleteConfirm').modal('show');
}

function searchDailyPlans(th){
    var section     = $(th).closest('tr').find('select#section').val();
    var planTime    = $(th).closest('tr').find('input#planTime').val();
    var itemCode    = $(th).closest('tr').find('select#itemCode').val();
    var status     = $(th).closest('tr').find('select#Status').val();

    $('div#loadingDailyArea').html('');
    $.ajax({
        type: 'POST',
        url: baseurl + 'ProductionPlanning/DataPlanDaily/searchDailyPlans',
        data: {
            section: section,
            planTime: planTime,
            status: status,
            itemCode: itemCode
        },
        beforeSend: function() {
            $('div#loadingDailyArea').html(
                                    '<div id="loadingDaily" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">'
                                        +'<div class="modal-dialog modal-lg" role="document">'
                                            +'<div style="text-align: center; width: 100%; height: 100%; vertical-align: middle;">'
                                                +'<img src="'+baseurl+'assets/img/gif/loading14.gif" style="display: block; margin: auto; width: 80%;">'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                            +'<script type="text/javascript">'
                                +'$("#loadingDaily").modal("show");'
                            +'</script>');
            $('div#tableDailyArea').html('');
        },
        success: function(data) {
            $('div#loadingDailyArea div#loadingDaily').html('<script type="text/javascript">'
                                                                +'$("#loadingDaily").modal("hide");'
                                                            +'</script>');
            $('div#tableDailyArea').html(data);
            $('#tbdataplan').DataTable({
                dom: 'rtBp',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        }
    });
}