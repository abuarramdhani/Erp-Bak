//--------------------------------WasteManagementSeksi-------------------------//
$(document).ready(function() {

    $('#txtJenisLimbah').on('change', function() {
        // var satuan = $(this).find(':selected').attr('data-satuan');
        // $('#txtSatuan').val(satuan);
        var id = $('#txtJenisLimbah').val();
        $('#txtSatuan').select2('val', '');

        $.ajax({
            url: baseurl + 'WasteManagementSeksi/InputKirimLimbah/ajaxSatuan',
            data: { id: id },
            method: 'post',
            success: function(data) {
                $('#txtSatuan').html(data);
            }
        })
    });

    $('#txtPengirimLimbah').on('change', function() {
        var nama = $(this).find(':selected').attr('data-name');
        $('#txtNamaPengirim').val(nama);
    });

    $('#txtValueLim').on('change', function() {
        var nilai = $(this).find(':selected').text();
        $('#txtHiddenValue').val(nilai);
    });

    $('#txtValueSek').on('change', function() {
        var nilai = $(this).find(':selected').text();
        $('#txtHiddenValue').val(nilai);
    });

    $('#txtSeksiPengirim').on('change', function() {
        var nilai = $(this).find(':selected').val();
        $.ajax({
            type: 'POST',
            url: baseurl + 'WasteManagementSeksi/InputKirimLimbah/Cari',
            data: { kodesie: nilai },
            success: function(data) {
                $('#txtPengirimLimbah').html(data);
            }
        })
    });

    $('#txtPilihKat').on('change', function() {
        var nilai = $('#txtPilihKat').val();
        if (nilai == 'limbah') {
            $('#txtValueSek').attr("disabled", "");
            $('#txtValueLim').removeAttr("disabled");
        } else {
            $('#txtValueLim').attr("disabled", "");
            $('#txtValueSek').removeAttr("disabled");
        }
    });



});

function pieChart(canvas, data, color, color2, label) {
    var ctx = $(canvas);
    var data = {
        datasets: [{
            data: data,
            backgroundColor: color,
            hoverBackgroundColor: color2
        }],

        labels: label,
    };
    var options = {
        legend: {
            display: true,
            position: 'bottom',
            labels: { boxWidth: 10, fontSize: 11 }
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var allData = data.datasets[tooltipItem.datasetIndex].data;
                    var tooltipLabel = data.labels[tooltipItem.index];
                    var tooltipData = allData[tooltipItem.index];
                    var total = 0;
                    for (var i = 0; i < data.datasets[tooltipItem.datasetIndex].data.length; i++) {
                        total += parseInt(data.datasets[tooltipItem.datasetIndex].data[i]);
                    }

                    var persen = (tooltipData / total) * 100;
                    persen = persen.toFixed(2);
                    return tooltipLabel + " : " + tooltipData + " Kg atau " + persen + " %";
                }
            }
        }
    }
    var canvas = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });
}

function barChart(canvas, data, color, color2, label) {
    var ctx = $(canvas);
    var data = {
        labels: label,
        datasets: [{
            data: data,
            backgroundColor: color,
            hoverBackgroundColor: color2,
            borderColor: color2,
            borderWidth: 4,
            label: 'Berat (Kg)'
        }]


    };
    var options = {
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    offsetGridLines: true
                },
                ticks: {
                    autoSkip: false
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        responsive: true

    }
    var canvas = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}

function showChart() {
    var periode = $('#txtPeriodeInfo').val();
    var kategori = $('#txtPilihKat').val();

    if (kategori == 'limbah') {
        var limbah = $('#txtValueLim').val();
        $.ajax({
            type: 'POST',
            url: baseurl + 'WasteManagementSeksi/InfoKirimLimbah/Chart',
            data: { txtPeriodeInfo: periode, txtValueLim: limbah },
            success: function(data) {
                var data = JSON.parse(data);
                var seksi = [];
                var berat = [];
                var warna = [];
                var warna2 = [];
                for (var i = 0; i < data['chart'].length; i++) {
                    var clr = "";
                    var clr2 = "";
                    seksi.push(data['chart'][i]['section_name']);
                    berat.push(data['chart'][i]['berat']);
                    if (i % 2 == 0) {
                        var hsl = (i + 1) * (Math.round(180 / (data['chart'].length)));
                    } else {
                        var hsl = 180 + ((i + 1) * (Math.round(180 / (data['chart'].length))));
                    }
                    clr = "hsl(" + hsl + ", 100%, 40%)";
                    clr2 = "hsl(" + hsl + ", 100%, 20%)";
                    warna.push(clr);
                    warna2.push(clr2);
                }
                $('#chartInfoLimbahPie').hide();
                // $('#colorInfo').text(warna+" "+warna2);
                barChart('#chartInfoLimbahBar', berat, warna, warna2, seksi);
            }

        });
    } else {
        var seksi = $('#txtValueSek').val();
        $.ajax({
            type: 'POST',
            url: baseurl + 'WasteManagementSeksi/InfoKirimLimbah/Chart',
            data: { txtPeriodeInfo: periode, txtValueSek: seksi },
            success: function(data) {
                var data = JSON.parse(data);
                var jenis = [];
                var berat = [];
                var warna = [];
                var warna2 = [];
                for (var i = 0; i < data['chart'].length; i++) {
                    var clr = "";
                    var clr2 = "";
                    jenis.push(data['chart'][i]['jenis_limbah']);
                    berat.push(data['chart'][i]['berat']);
                    if (i % 2 == 0) {
                        var hsl = (i + 1) * (Math.round(180 / (data['chart'].length)));
                    } else {
                        var hsl = 180 + ((i + 1) * (Math.round(180 / (data['chart'].length))));
                    }
                    clr = "hsl(" + hsl + ", 100%, 55%)";
                    clr2 = "hsl(" + hsl + ", 100%, 35%)";
                    warna.push(clr);
                    warna2.push(clr2);
                }
                $('#chartInfoLimbahBar').hide();
                // $('#colorInfo').text(warna);
                pieChart('#chartInfoLimbahPie', berat, warna, warna2, jenis);


            }

        });
    }
};

$(function() {
    $('#txtTanggalKirimLimbah').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy M dd'

    });

    // $('#txtPeriodeInfo').datepicker({
    // 	"autoclose": true,
    //    	"todayHiglight": true,
    //    	"autoApply": true,
    //    	"format":'MM yyyy',
    //    	"viewMode":'months',
    //    	"minViewMode":'months'
    // });

    $('#txtPeriodeInfo').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    $('input[id="txtPeriodeInfo"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('input[id="txtPeriodeInfo"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });


    $('#txtWaktuKirimLimbah').timepicker({
        maxHours: 24,
        showMeridian: false,
    });

});