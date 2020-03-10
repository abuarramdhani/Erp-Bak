// Sistem Kendaraan
$(function(){

// Tabel Jenis Kendaraan -------------------------------------------------------------------------
$('#dataTables-fleetJenisKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetServiceKendaraanDeleted').DataTable( {

    });

$('#dataTables-fleetservicekendaraan').DataTable( {

    });
$('#dataTables-fleetJenisKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------

// Tabel Merk Kendaraan --------------------------------------------------------------------------
$('#dataTables-fleetMerkKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#tbl_monitoringservice').dataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scroller": true,
    });
$('#dataTables-fleetMerkKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------

// Tabel Warna Kendaraan -------------------------------------------------------------------------
$('#dataTables-fleetWarnaKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetWarnaKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------

// Tabel Kendaraan ------------------------------------------------------------------------------_

$('#dataTables-fleetKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ],
      fixedColumns:   {
        leftColumns: 3,
      },
      scrollX: true,
    });
$('#dataTables-fleetKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------


// Tabel Pajak ----------------------------------------------------------------------------------_

$('#dataTables-fleetPajak').DataTable({
  "lengthChange": false,
  dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
  });
$('#dataTables-fleetPajakDeleted').DataTable({
  "lengthChange": false,
  dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
  });

$('#dataTables-fleetKir').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

// Tabel PIC Kendaraan ---------------------------------------------------------------------------_

$('#dataTables-fleetPicKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetPicKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------


// Tabel Maintenance Kategori -----------------------------------------------------------------------

$('#dataTables-fleetMaintenanceKategori').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetMaintenanceKategoriDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------


$('#dataTables-fleetMaintenanceKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetKecelakaan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetKecelakaanDetail').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#ManajemenKendaraan-daterangepicker').daterangepicker({
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "OK",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "Hingga",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Mg",
            "Sn",
            "Sl",
            "Rb",
            "Km",
            "Jm",
            "Sa"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus ",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    }
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
});
$('#ManajemenKendaraan-daterangepickersingledate').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "OK",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "Hingga",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Mg",
            "Sn",
            "Sl",
            "Rb",
            "Km",
            "Jm",
            "Sa"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus ",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    }
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
});

$('.ManajemenKendaraan-daterangepickersingledatewithtime').daterangepicker({
    "timePicker": true,
    "timePicker24Hour": true,
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "format": "DD-MM-YYYY HH:mm",
        "separator": " - ",
        "applyLabel": "OK",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "Hingga",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Mg",
            "Sn",
            "Sl",
            "Rb",
            "Km",
            "Jm",
            "Sa"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus ",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    }
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
});

});

setInterval(function() {
  $('#DetailMaintenanceKendaraan tr').each(function (idx) {
      $(this).children("#DetailMaintenanceKendaraan tr td:eq(0)").html(idx + 1);
  });
}, 10);

setInterval(function() {
  $('#DetailKecelakaan tr').each(function (idx) {
      $(this).children("#DetailKecelakaan tr td:eq(0)").html(idx + 1);
  });
}, 10);

var   DataTableMonitoringNomorPolisi      =   $('#dataTables-fleetMonitoringNomorPolisi').dataTable({"sPaginationType": "full_numbers"});
var   DataTableMonitoringKategori         =   $('#dataTables-fleetMonitoringKategori').dataTable({"sPaginationType": "full_numbers"});


function TambahBarisMaintenanceKendaraan(base){
      var e = jQuery.Event( "click" );
      var opt = $('#txtJenisMaintenanceLine1').html();

        var newRow  = jQuery("<tr>"
                                +"<td style='text-align:center; width:'"+"30px"+"'></td>"
                                +"<td align='center' width='60px'>"
                                +"<a onclick='delSpesifikRow(this)' class='del-row btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete Data'><span class='fa fa-times'></span></a>"
                                +"</td>"
                                +"<td>"
                                +"<div class='form-group'>"
                                +"<div class='col-lg-12'>"
                                +"<select class='form-control select-jenis' name='txtJenisMaintenanceLine1[]'' id='txtJenisMaintenanceLine1' style='width: 100%;'>"
                                +"<option></option>"
                                +opt
                                +"</select>"
                                +"</div>"
                                +"</div>"
                                +"</td>"
                                +"<td>"
                                +"<div class='form-group'>"
                                +"<div class='col-lg-12'>"
                                +"<input type='number' placeholder='Jumlah' name='txtJumlahLine1[]' id='txtJumlahLine1' class='form-control input_money' value='1' />"
                                +"</div>"
                                +"</div>"
                                +"</td>"
                                +"<td>"
                                +"<div class='form-group'>"
                                +"<div class='col-lg-12'>"
                                +"<input type='text' placeholder='Biaya' name='txtBiayaLine1[]' id='txtBiayaLine1' class='form-control input_money'/>"
                                +"</div>"
                                +"</div>"
                                +"</td>"
                                +"</tr>");
        jQuery("#tblFleetMaintenanceKendaraanDetail").append(newRow);
        $('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});
        $('.select-jenis').select2({
          tags: true
        });
    }

function TambahBarisKecelakaanDetail(base){
      var e = jQuery.Event( "click" );

          var newRow  = jQuery( "<tr>"
                                  +"<td style='text-align:center; width:'"+"30px"+"'></td>"
                                  +"<td align='center' width='60px'>"
                                    +"<a onclick='delSpesifikRow(this)' class='del-row btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete Data'><span class='fa fa-times'></span></a>"
                                  +"</td>"
                                  +"<td>"
                                    +"<div class='form-group'>"
                                      +"<div class='col-lg-12'>"
                                        +"<input type='text' placeholder='Kerusakan' name='txtKerusakanLine1[]' id='txtKerusakanLine1' class='form-control'/>"
                                      +"</div>"
                                    +"</div>"
                                  +"</td>"
                                +"</tr>");
        jQuery("#tblFleetKecelakaanDetail").append(newRow);
        $('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});
    }

function delSpesifikRow(th) {
    $(th).closest('tr').remove();
    // $('#tblFleetMaintenanceKendaraanDetail #DetailMaintenanceKendaraan tr[row-id="'+rowid+'"]').remove();
}

$("#cmbLihatBerdasarkan").change(function () {
    var str = "";

    str = parseInt($("#cmbLihatBerdasarkan option:selected").val());

        if(str == 1){
          $("#nomor_polisi").show();
          $("#kategori").hide();
        }
        else if(str == 2)
        {
          $("#kategori").show();
          $("#nomor_polisi").hide();
        }
        else
        {
          $("#kategori").hide();
          $("#nomor_polisi").hide();
        }
});

$(document).on('click', '#ProsesMonitoringNomorPolisi',function()
{
    var   Berdasarkan   =   $('#cmbLihatBerdasarkan').val();
    var   NomorPolisi   =   $('#cmbNomorPolisi').val();

    // $('.alert').alert('close');
    // $('body').addClass('noscroll');
    // $('#loadingAjax').addClass('overlay_loading');
    // $('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
    $.ajax(
    {
      type    : 'POST',
      url     : baseurl + 'GeneralAffair/FleetMonitoring/prosesNomorPolisi',
      data    :{
        berdasarkan   : Berdasarkan,
        nomorpolisi   : NomorPolisi,
      },
      success: function(data)
      {
        console.log(data);
        // alert(data);
        var   data  = JSON.parse(data);
        // $('body').removeClass('noscroll');
        // $('#loadingAjax').html('');
        // $('#loadingAjax').removeClass('overlay_loading');
        DataTableMonitoringNomorPolisi.fnClearTable();
        for(i=0; i < data['monitoringNomorPolisi'].length; i++)
        {
        DataTableMonitoringNomorPolisi.fnAddData([
            (i+1),
            data['monitoringNomorPolisi'][i]['kategori'],
            data['monitoringNomorPolisi'][i]['tanggal_asli'],
            'Rp'+parseFloat(data['monitoringNomorPolisi'][i]['biaya']).toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
          ]);
        }
        $('#tabelMonitoringNomorPolisi').show();
        $('table#dataTables-fleetMonitoringNomorPolisi').show();
      }
    });
});

$(document).on('click', '#ProsesMonitoringLastProcessNomorPolisi',function()
{
    var   Berdasarkan   =   $('#cmbLihatBerdasarkan').val();
    var   NomorPolisi   =   $('#cmbNomorPolisi').val();

    // $('.alert').alert('close');
    // $('body').addClass('noscroll');
    // $('#loadingAjax').addClass('overlay_loading');
    // $('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
    $.ajax(
    {
      type    : 'POST',
      url     : baseurl + 'GeneralAffair/FleetMonitoringLast/prosesNomorPolisi',
      data    :{
        berdasarkan   : Berdasarkan,
        nomorpolisi   : NomorPolisi,
      },
      success: function(data)
      {
        console.log(data);
        // alert(data);
        var   data  = JSON.parse(data);
        // $('body').removeClass('noscroll');
        // $('#loadingAjax').html('');
        // $('#loadingAjax').removeClass('overlay_loading');
        DataTableMonitoringNomorPolisi.fnClearTable();
        for(i=0; i < data['monitoringNomorPolisi'].length; i++)
        {
        DataTableMonitoringNomorPolisi.fnAddData([
            (i+1),
            data['monitoringNomorPolisi'][i]['kategori'],
            data['monitoringNomorPolisi'][i]['tanggal'],
            'Rp'+parseFloat(data['monitoringNomorPolisi'][i]['biaya']).toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
          ]);
        }
        $('#tabelMonitoringNomorPolisi').show();
        $('table#dataTables-fleetMonitoringNomorPolisi').show();
      }
    });
});

$(document).on('click', '#ProsesMonitoringKategori',function()
{
    var   Berdasarkan   =   $('#cmbLihatBerdasarkan').val();
    var   Kategori      =   $('#cmbKategori').val();
    var   Periode       =   $('#ManajemenKendaraan-daterangepicker').val();

    // $('.alert').alert('close');
    // $('body').addClass('noscroll');
    // $('#loadingAjax').addClass('overlay_loading');
    // $('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
    $.ajax(
    {
      type    : 'POST',
      url     : baseurl + 'GeneralAffair/FleetMonitoring/prosesKategori',
      data    :{
        berdasarkan   : Berdasarkan,
        kategori      : Kategori,
        periode       : Periode
      },
      success: function(data)
      {
        console.log(data);
        var   data  = JSON.parse(data);

        if (Kategori=='C') {
          $('#buttonDetail').removeClass('hidden');
          $('#buttonExport').removeClass('hidden');
        }else{
          $('#buttonDetail').addClass('hidden');
          $('#buttonExport').addClass('hidden');
        }
        // $('body').removeClass('noscroll');
        // $('#loadingAjax').html('');
        // $('#loadingAjax').removeClass('overlay_loading');
        $('#MainMenuExport').val(Berdasarkan);
        $('#KategoriMonitoringExport').val(Kategori);
        $('#PeriodeMonitoringExport').val(Periode);
        $('#PeriodeMonitoringDetail').val(Periode);

        DataTableMonitoringKategori.fnClearTable();
        for(i=0; i < data['monitoringKategori'].length; i++)
        {
        DataTableMonitoringKategori.fnAddData([
            (i+1),
            data['monitoringKategori'][i]['nomor_polisi'],
            data['monitoringKategori'][i]['tanggal_asli'],
            'Rp'+parseFloat(data['monitoringKategori'][i]['biaya']).toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
          ]);
        }
        $('#tabelMonitoringKategori').show();
        $('table#dataTables-fleetMonitoringKategori').show();
      }
    });
});

$(document).on('click', '#ProsesMonitoringLastProcessKategori',function()
{
    var   Berdasarkan   =   $('#cmbLihatBerdasarkan').val();
    var   Kategori      =   $('#cmbKategori').val();

    // $('.alert').alert('close');
    // $('body').addClass('noscroll');
    // $('#loadingAjax').addClass('overlay_loading');
    // $('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
    $.ajax(
    {
      type    : 'POST',
      url     : baseurl + 'GeneralAffair/FleetMonitoringLast/prosesKategori',
      data    :{
        berdasarkan   : Berdasarkan,
        kategori      : Kategori
      },
      success: function(data)
      {
        console.log(data);
        var   data  = JSON.parse(data);
        // $('body').removeClass('noscroll');
        // $('#loadingAjax').html('');
        // $('#loadingAjax').removeClass('overlay_loading');
        DataTableMonitoringKategori.fnClearTable();
        for(i=0; i < data['monitoringKategori'].length; i++)
        {
        DataTableMonitoringKategori.fnAddData([
            (i+1),
            data['monitoringKategori'][i]['nomor_polisi'],
            data['monitoringKategori'][i]['tanggal'],
            'Rp'+parseFloat(data['monitoringKategori'][i]['biaya']).toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
          ]);
        }
        $('#tabelMonitoringKategori').show();
        $('table#dataTables-fleetMonitoringKategori').show();
      }
    });
});

$(document).on('click', '.deleteUpdate', function(){
  var   id  =   $(this).attr('data-id');
  var ini = $(this);
  if(id!=null || id!='')
  {
    $.ajax(
    {
      type: 'POST',
      url: baseurl+'GeneralAffair/FleetMaintenanceKendaraan/deleteBarisDetail/'+id,
      success: function()
      {
        ini.closest('tr').remove();
      }
    })
  }
});

$(document).on('click', '#deleteUpdateKecelakaan', function(){
  var   id  =   $(this).attr('data-id');
  var ini = $(this);
  if(id!=null || id!='')
  {
    $.ajax(
    {
      type: 'POST',
      url: baseurl+'GeneralAffair/FleetKecelakaan/deleteBarisDetail/'+id,
      success: function()
      {
        ini.closest('tr').remove();
      }
    })
  }
});

function Grafik(canvas, data, labels, color, color2, label) {
    var ctx = $(canvas);
    var canvas = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: []
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min:0,
                    }
                }]
            },
        }
    });

    var countDataset = label.length;
    for(var i = 0; i < countDataset; i++) {
        canvas.data.datasets.push({label: label[i], borderColor: color[i],  data: [] });
        for(var j = 0; j < data[i].length; j++) {
            canvas.data.datasets[i].data.push(data[i][j]);
        }
        canvas.update();
    }
}


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
        display: true, position: 'bottom', labels : { boxWidth : 10, fontSize : 11}
      },
      tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var allData = data.datasets[tooltipItem.datasetIndex].data;
                    var tooltipLabel = data.labels[tooltipItem.index];
                    var tooltipData = allData[tooltipItem.index];
                    return tooltipData;
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

function rekapPajak(tahun) {
    $.ajax({
      type: 'POST',
      data: {
         tahun: tahun
      },
      url: baseurl + 'GeneralAffair/FleetRekapPajak/ambilData',
    })
    .done(function(data){
      var data = JSON.parse(data);
      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['totalPajak'].length; j++) {
          temp.push(data['totalPajak'][j]['total_biaya']);
          bulan.push(data['totalPajak'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapTotalPajak',value,bulan,'#33CC33','#006600', ['Total Pajak Kendaraan']);

      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['frekuensiPajak'].length; j++) {
          temp.push(data['frekuensiPajak'][j]['total_frekuensi']);
          bulan.push(data['frekuensiPajak'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapFrekuensiPajak',value,bulan,'#33CC33','#006600', ['Frekuensi Pajak Kendaraan']);

    });
}

function rekapKIR(tahun)
{
    $.ajax({
      type: 'POST',
      data: {
         tahun: tahun
      },
      url: baseurl + 'GeneralAffair/FleetRekapKIR/ambilData',
    })
    .done(function(data){
      console.log(data);
      var data = JSON.parse(data);
      console.log(data);
      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['totalKIR'].length; j++) {
          temp.push(data['totalKIR'][j]['total_biaya']);
          bulan.push(data['totalKIR'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapTotalKIR',value,bulan,'#33CC33','#006600', ['Total KIR Kendaraan']);

      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['frekuensiKIR'].length; j++) {
          temp.push(data['frekuensiKIR'][j]['total_frekuensi']);
          bulan.push(data['frekuensiKIR'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapFrekuensiKIR',value,bulan,'#33CC33','#006600', ['Frekuensi KIR Kendaraan']);
    });
}

function rekapMaintenance(tahun)
{
    $.ajax({
      type: 'POST',
      data: {
         tahun: tahun
      },
      url: baseurl + 'GeneralAffair/FleetRekapMaintenance/ambilData',
    })
    .done(function(data){
      var data = JSON.parse(data);
      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['totalMaintenance'].length; j++) {
          temp.push(data['totalMaintenance'][j]['total_biaya']);
          bulan.push(data['totalMaintenance'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapTotalMaintenance',value,bulan,'#33CC33','#006600', ['Total Maintenance Kendaraan']);

      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['frekuensiMaintenance'].length; j++) {
          temp.push(data['frekuensiMaintenance'][j]['total_frekuensi']);
          bulan.push(data['frekuensiMaintenance'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapFrekuensiMaintenance',value,bulan,'#33CC33','#006600', ['Frekuensi Maintenance Kendaraan']);

    })
}

function rekapKecelakaan(tahun)
{
    $.ajax({
      type: 'POST',
      data: {
         tahun: tahun
      },
      url: baseurl + 'GeneralAffair/FleetRekapKecelakaan/ambilData',
    })
    .done(function(data){
      var data = JSON.parse(data);
      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['totalKecelakaan'].length; j++) {
          temp.push(data['totalKecelakaan'][j]['total_biaya']);
          bulan.push(data['totalKecelakaan'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapTotalKecelakaan',value,bulan,'#33CC33','#006600', ['Total Kecelakaan']);

      var value = [];
      var bulan = [];
      var temp = [];
      for (var i = 0; i < 1; i++) {
        for (var j = 0; j < data['frekuensiKecelakaan'].length; j++) {
          temp.push(data['frekuensiKecelakaan'][j]['total_frekuensi']);
          bulan.push(data['frekuensiKecelakaan'][j]['bulan']);
        };
        value.push(temp);
      }
      Grafik('#RekapFrekuensiKecelakaan',value,bulan,'#33CC33','#006600', ['Frekuensi Kecelakaan']);
    })
}

function rekapTotal(tahun, bulan)
{
    $.ajax({
      type: 'POST',
      data: {
         tahun: tahun,
         bulan: bulan,
      },
      url: baseurl + 'GeneralAffair/FleetRekapTotal/ambilData',
    })
    .done(function(data){
      var   data = JSON.parse(data);
      var   totalBiayaPajak             =   parseInt(data['biayaTotal'][0]['total_biaya_pajak']);
      var   totalBiayaKIR               =   parseInt(data['biayaTotal'][0]['total_biaya_kir']);
      var   totalBiayaMaintenance       =   parseInt(data['biayaTotal'][0]['total_biaya_maintenance_kendaraan']);
      var   totalBiayaKecelakaan        =   parseInt(data['biayaTotal'][0]['total_biaya_kecelakaan']);

      var   totalFrekuensiPajak         =   parseInt(data['frekuensiTotal'][0]['total_frekuensi_pajak']);
      var   totalFrekuensiKIR           =   parseInt(data['frekuensiTotal'][0]['total_frekuensi_kir']);
      var   totalFrekuensiMaintenance   =   parseInt(data['frekuensiTotal'][0]['total_frekuensi_maintenance_kendaraan']);
      var   totalFrekuensiKecelakaan    =   parseInt(data['frekuensiTotal'][0]['total_frekuensi_kecelakaan']);

      pieChart('#RekapBiayaTotal', [totalBiayaPajak, totalBiayaKIR, totalBiayaMaintenance, totalBiayaKecelakaan], ['#009933', '#ff9900', '#0066ff', '#ff0000'], ['#33cc33', '#ffcc00', '#3399ff', '#ff5050'], ['Total Biaya Pajak', 'Total Biaya KIR', 'Total Biaya Maintenance Kendaraan', 'Total Biaya Kecelakaan']);
      pieChart('#RekapFrekuensiTotal', [totalFrekuensiPajak, totalFrekuensiKIR, totalFrekuensiMaintenance, totalFrekuensiKecelakaan], ['#009933', '#ff9900', '#0066ff', '#ff0000'], ['#33cc33', '#ffcc00', '#3399ff', '#ff5050'], ['Total Frekuensi Pajak', 'Total Frekuensi KIR', 'Total Frekuensi Maintenance Kendaraan', 'Total Frekuensi Kecelakaan']);

    });
}

$(document).ready(function(){
    // $('input[name="OpsiPIC"]').click(function() {
    //    if($('input[name="OpsiPIC"]').is(':checked')) {
    //        var radioValue = $("input[name='OpsiPIC']:checked").val();
    //         if(radioValue == "Seksi"){
    //            $( "#cmbSeksi" ).prop( "disabled", false );
    //            $( "#cmbPekerja" ).prop( "disabled", true );
    //         } else if (radioValue == "Pekerja"){
    //             $( "#cmbSeksi" ).prop( "disabled", true );
    //            $( "#cmbPekerja" ).prop( "disabled", false );
    //         }
    //    }
    // });
    $('input[name="BtnPIC"]').click(function(){
        var values = $(this).val();
        if(values == "Seksi"){
          $( "#cmbSeksi" ).prop( "disabled", false );
          $( "#cmbPekerja" ).prop( "disabled", true );
          $('input[name="BtnPIC"]').removeClass("btn-default");
          $('input[name="BtnPIC"]').removeClass("btn-primary");
          $('input[name="BtnPIC"]').addClass("btn-default");
          $(this).removeClass("btn-default");
          $(this).addClass("btn-primary");
          $('input[name="OpsiPIC"]').val(values);
        } else if (values == "Pekerja"){
          $( "#cmbSeksi" ).prop( "disabled", true );
          $( "#cmbPekerja" ).prop( "disabled", false );
          $('input[name="BtnPIC"]').removeClass("btn-default");
          $('input[name="BtnPIC"]').removeClass("btn-primary");
          $('input[name="BtnPIC"]').addClass("btn-default");
          $(this).removeClass("btn-default");
          $(this).addClass("btn-primary");
          $('input[name="OpsiPIC"]').val(values);
        }
    });

    $('.txtJenisMaintenanceLine1').select2({
        tags: true
    });

    $('#txtJenisMaintenanceLine1').select2({
        tags: true
    });

    $('.select-jenis').select2({
        tags: true
    });

    $('#txtMerkKendaraan').select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: 'Merk Kendaraan',
        ajax: {
          url: baseurl+"GeneralAffair/FleetServiceKendaraan/ambilMerkKendaraan",
          dataType:'json',
          type: "GET",
          data: function (params) {
            return {term: params.term};
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return {
                  id: item.merk_kendaraan_id,
                  text: item.merk_kendaraan
                };
              })

            };
          },
        },
      });
    $('#jenis_service').select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: 'Jenis Service',
        ajax: {
          url: baseurl+"GeneralAffair/FleetServiceKendaraan/ambilJenisService",
          dataType:'json',
          type: "GET",
          data: function (params) {
            return {term: params.term};
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return {
                  id: item.jenis_service_id,
                  text: item.jenis_service
                };
              })

            };
          },
        },
      });

    });


$(document).ready(function(){
    $('input[name="radioAsuransi"]').click(function() {
       if($('input[name="radioAsuransi"]').is(':checked')) {
           var radioValue = $("input[name='radioAsuransi']:checked").val();
            if(radioValue == "1")
            {
               $( "input[name='txtTanggalCekAsuransi']" ).prop( "disabled", false );
               $( "input[name='txtTanggalMasukBengkel']" ).prop( "disabled", false );
               $( "input[name='txtTanggalKeluarBengkel']" ).prop( "disabled", false );
               $( "input[name='FotoMasukBengkel']" ).prop( "disabled", false );
               $( "input[name='FotoKeluarBengkel']" ).prop( "disabled", false );
               $( '#linkFotoMasukBengkel' ).prop( "disabled", false);
               $( '#linkFotoKeluarBengkel' ).prop( "disabled", false);
            }
            else
            {
               $( "input[name='txtTanggalCekAsuransi']" ).prop( "disabled", true );
               $( "input[name='txtTanggalMasukBengkel']" ).prop( "disabled", true );
               $( "input[name='txtTanggalKeluarBengkel']" ).prop( "disabled", true );
               $( "input[name='FotoMasukBengkel']" ).prop( "disabled", true );
               $( "input[name='FotoKeluarBengkel']" ).prop( "disabled", true );
               $( '#linkFotoMasukBengkel' ).prop( "disabled", true);
               $( '#linkFotoKeluarBengkel' ).prop( "disabled", true);
            }
       }
    });
});

//fleet cetak spk
  $('#dataTables-fleetCetakSpk').DataTable({"lengthChange": false});

  function TambahBarisCetakSPK(base){
      var e = jQuery.Event( "click" );
      var opt = $('#txtJenisMaintenanceLine1').html();

      var newRow  = jQuery("<tr>"
                                +"<td style='text-align:center; width:'"+"30px"+"'></td>"
                                +"<td align='center' width='60px'>"
                                +"<a onclick='delSpesifikRow(this)' class='del-row btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete Data'><span class='fa fa-times'></span></a>"
                                +"</td>"
                                +"<td>"
                                +"<div class='form-group'>"
                                +"<div class='col-lg-12'>"
                                +"<select class='form-control select-jenis' name='txtJenisMaintenanceSPK[]' id='txtJenisMaintenanceLine1' style='width: 100%'>"
                                +"<option></option>"
                                +opt
                                +"</select>"
                                +"</div>"
                                +"</div>"
                                +"</td>"
                                +"</tr>");
        jQuery("#tblFleetMaintenanceKendaraanDetail").append(newRow);
        $('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});
        $('.select-jenis').select2({
          tags: true
        });
  }

  $(document).on('click', '.deleteSPKDetail', function(){
    var   id  =   $(this).attr('data-id');
    var ini = $(this);
    if(id!=null || id!='')
    {
      $.ajax(
      {
        type: 'POST',
        url: baseurl+'GeneralAffair/FleetCetakSpk/deleteSPKDetail/'+id,
        success: function()
        {
          ini.closest('tr').remove();
        }
      })
    }
  });

  $('#table-DetailMonitoringMK').DataTable({
    dom: 'frtp',
  });

  $('#tblFleetCetakSpk').DataTable( {
      dom: 'frtp',
    });

  // $(document).ready(function(){
  //   $('#create_form').on('click',function(){
  //       var jarak_awal      = $('#jarak_awal').val();
  //       var kelipatan_jarak = $('#kelipatan_jarak').val();

  //       var lama_awal       = parseInt($('#lama_awal').val());
  //       var kelipatan_waktu = parseInt($('#kelipatan_waktu').val());
  //       var batas_lama      = $('#batas_lama').val();

  //       var div_input = document.getElementById("input_service");

  //       for (var i = 0; i < batas_lama ; i++) {

  //           alert(lama_awal);

  //           // var form2 = document.createElement("label");
  //           // form2.setAttribute("id", "label_service"+i);
  //           // document.getElementById("label_service"+i).innerHTML = jarak_awal+" Km/"+lama_awal+" bulan";

  //           var newForm = document.createElement("input");
  //           newForm.setAttribute("type", "text");
  //           newForm.setAttribute("id", "form"+i);
  //           div_input.appendChild(form2);
  //           div_input.appendChild(newForm);
  //           div_input.appendChild(document.createElement("br"));
  //           div_input.appendChild(document.createElement("br"));

  //           var lama_awal = lama_awal+kelipatan_waktu;
  //           var jarak_awal = jarak_awal+kelipatan_jarak;
  //       }
  //   });
  // });

  $(document).ready(function(){
    $('.form-kendaraaan-ga').on('submit',function(){
      isOk = true;
      $('input[type=file][data-max-size]').each(function(){
        if (typeof this.files[0] !== 'undefined') {
          var maxSize = parseInt($(this).attr('data-max-size'),10);
          size = this.files[0].size;
          name = this.files[0].name;
          size = size/1024;
          isOk = maxSize > size;
          if (isOk == false) {
            if (size < 1024) {
              size = Math.round(size*100)/100;
              alert('File '+name+'('+size+' Kb) Terlalu Besar. maksimal '+maxSize+' Kb');
            }else{
              size = Math.round((size/1024)*100)/100;
              alert('File '+name+'('+size+' Mb) Terlalu Besar. maksimal '+maxSize+' Kb');
            }

          }
          return isOk;
        }
      });
      return isOk;
     });
  });

  $(document).ready(function(){
    $('#slc_pic_kendaraan').select2({
          minimumInputLength: 3,
          allowClear: true,
          placeholder: 'Pilih PIC',
          ajax: {
            url: baseurl+"GeneralAffair/FleetKendaraan/pic_kendaraan",
            dataType:'json',
            type: "GET",
            data: function (params) {
              return {term: params.term};
            },
            processResults: function (data) {
              return {
                results: $.map(data, function (item) {
                  return {
                    id: item.noind+' - '+item.nama,
                    text: item.noind+' - '+item.nama
                  };
                })

              };
            },
          },
    });
  });

  // Pesanan Shutle Dinas
  $(document).ready(function () {
      $('#GA_shutle').datepicker({
          todayHighlight: true,
          autoApply: true,
          autoclose: true,
          minDate: moment(),
          format: "dd-mm-yyyy"
      })
      $('#GA_find_shutle').on('click', function () {
          let wkt = $('#GA_shutle').val()
          var loading = baseurl + 'assets/img/gif/loading14.gif';
          $.ajax({
              type: 'post',
              data: {
                  param: wkt
              },
              url: baseurl + 'GeneralAffair/PemesananShutle/find',
              beforeSend: function () {
                  swal.fire({
                      html : "<div><img style='width: 320px; height: auto;'src='"+loading+"'><br><p>Sedang Memproses....</p></div>",
                      customClass: {popup: 'swal-wide'},
                      showConfirmButton:false,
                      allowOutsideClick: false
                  })
              },
              success: function (data) {
                  swal.close()
                  $('#GA_tabel_Shutle').html(data)
              }
          })
      })
  })
