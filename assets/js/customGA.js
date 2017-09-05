// Sistem Kendaraan
// var base_url = 'http://192.168.168.50/khs-erp/';
$(function(){

// Tabel Jenis Kendaraan -------------------------------------------------------------------------
$('#dataTables-fleetJenisKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
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
      ]
    });
$('#dataTables-fleetKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------


// Tabel Pajak ----------------------------------------------------------------------------------_

$('#dataTables-fleetPajak').DataTable({"lengthChange": false});
$('#dataTables-fleetPajakDeleted').DataTable({"lengthChange": false});

// -----------------------------------------------------------------------------------------------

// Tabel Kir ------------------------------------------------------------------------------------_

$('#dataTables-fleetKir').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetKirDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------


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

// Tabel Maintenance Kendaraan ---------------------------------------------------------------------

$('#dataTables-fleetMaintenanceKendaraan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-fleetMaintenanceKendaraanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------

// Tabel Kendaraan ---------------------------------------------------------------------------------

$('#dataTables-fleetKecelakaan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-fleetKecelakaanDeleted').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
// -----------------------------------------------------------------------------------------------

// Tabel Monitoring ---------------------------------------------------------------------------------




$('#dataTables-fleetKecelakaanDetail').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#daterangepicker').daterangepicker({
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

$('#daterangepickersingledate').daterangepicker({
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
$('#daterangepickersingledatewithtime').daterangepicker({
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


function TambahBarisMaintenanceKendaraan(base){  
      var e = jQuery.Event( "click" );
      // var rowid = $('#DetailMaintenanceKendaraan tr:last').attr('row-id');
      // var rowid = $('#DetailMaintenanceKendaraan tr').length;      
      // alert(rowid);
      // counter = Number(rowid)+1;
      // alert(counter);

          // var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
          //           +"<td >"+ counter +" </td>"
          //           +"<td>"
          //             +"<input id='segment' name='txtSegment[]' class='form-control segment' placeholder='Nama Bagian'> "
          //             +"<input type='hidden' name='idSegment[]'' value='0'>"
          //           +"</td>"
          //           +"</tr>");

          var newRow  = jQuery("<tr>"
                                +"<td style='text-align:center; width:'"+"30px"+"'></td>"
                                +"<td align='center' width='60px'>"
                                +"<a onclick='delSpesifikRow(this)' class='del-row btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete Data'><span class='fa fa-times'></span></a>"
                                +"</td>"
                                +"<td>"
                                +"<div class='form-group'>"
                                +"<div class='col-lg-12'>"
                                +"<input type='text' placeholder='Jenis Maintenance' name='txtJenisMaintenanceLine1[]' id='txtJenisMaintenanceLine1' class='form-control'/>"
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
    }

function TambahBarisKecelakaanDetail(base){  
      var e = jQuery.Event( "click" );
      // var rowid = $('#DetailMaintenanceKendaraan tr:last').attr('row-id');
      // var rowid = $('#DetailMaintenanceKendaraan tr').length;      
      // alert(rowid);
      // counter = Number(rowid)+1;
      // alert(counter);

          // var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
          //           +"<td >"+ counter +" </td>"
          //           +"<td>"
          //             +"<input id='segment' name='txtSegment[]' class='form-control segment' placeholder='Nama Bagian'> "
          //             +"<input type='hidden' name='idSegment[]'' value='0'>"
          //           +"</td>"
          //           +"</tr>");

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
        var   html  = '';
        for(i = 0; i < data['monitoringNomorPolisi'].length; i++){
          html  +=  '<tr>';
          html  +=    '<td>'+(i+1)+'</td>';
          html  +=    '<td>'+data['monitoringNomorPolisi'][i]['kategori']+'</td>';
          html  +=    '<td>'+data['monitoringNomorPolisi'][i]['tanggal_asli']+'</td>';
          html  +=    '<td>Rp'+parseFloat(data['monitoringNomorPolisi'][i]['biaya']).toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")+'</td>'
          html  +=  '</tr>';
        }
        $('tbody#isiMonitoringNomorPolisi').empty();
        $('tbody#isiMonitoringNomorPolisi').append(html);
        $('#tabelMonitoringNomorPolisi').show();
        $('table#dataTables-fleetMonitoringNomorPolisi').show();
        $('#dataTables-fleetMonitoringNomorPolisi').DataTable().fnDestroy();        
        $('#dataTables-fleetMonitoringNomorPolisi').DataTable( {
          dom: 'Bfrtip',
          buttons: [
            'excel'
          ]
        });
      }
    });
});

$(document).on('click', '#ProsesMonitoringKategori',function()
{
    var   Berdasarkan   =   $('#cmbLihatBerdasarkan').val();
    var   Kategori      =   $('#cmbKategori').val();
    var   Periode       =   $('#daterangepicker').val();
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
        var   html  = '';
        for(i = 0; i < data['monitoringKategori'].length; i++){
          html  +=  '<tr>';
          html  +=    '<td>'+(i+1)+'</td>';
          html  +=    '<td>'+data['monitoringKategori'][i]['nomor_polisi']+'</td>';
          html  +=    '<td>'+data['monitoringKategori'][i]['tanggal_asli']+'</td>';
          html  +=    '<td>Rp'+parseFloat(data['monitoringKategori'][i]['biaya']).toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")+'</td>'
          html  +=  '</tr>';
        }
        $('tbody#isiMonitoringKategori').empty();
        $('tbody#isiMonitoringKategori').append(html);
        $('#tabelMonitoringKategori').show();
        $('table#dataTables-fleetMonitoringKategori').show();
        $('#dataTables-fleetMonitoringKategori').DataTable().fnDestroy();        
        $('#dataTables-fleetMonitoringKategori').DataTable( {
          dom: 'Bfrtip',
          buttons: [
            'excel'
          ]
        });
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

$(document).on('change','#TahunPeriodePajak', function()
{
    var value = $(this).val();
    $.ajax({
      type: 'POST',
      data: {
         value: value
      },
      url: baseurl + 'GeneralAffair/FleetRekapPajak/RekapPajak', 
    })
    .done(function(data){
      console.log(data);
      var data = JSON.parse(data);
      console.log(data);
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
      Grafik('#RekapTotalPajak',value,bulan,'#0033CC','#0033CC', ['Total Pajak Kendaraan']);

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
      Grafik('#RekapFrekuensiPajak',value,bulan,'#0033CC','#0033CC', ['Frekuensi Pajak Kendaraan']);

    })
});

$(document).on('change','#TahunPeriodeKIR', function()
{
    var value = $(this).val();
    $.ajax({
      type: 'POST',
      data: {
         value: value
      },
      url: baseurl + 'GeneralAffair/FleetRekapKIR/RekapKIR', 
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
      Grafik('#RekapTotalKIR',value,bulan,'#0033CC','#0033CC', ['Total KIR Kendaraan']);

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
      Grafik('#RekapFrekuensiKIR',value,bulan,'#0033CC','#0033CC', ['Frekuensi KIR Kendaraan']);

    })
});

$(document).on('change','#TahunPeriodeMaintenance', function()
{
    var value = $(this).val();
    $.ajax({
      type: 'POST',
      data: {
         value: value
      },
      url: baseurl + 'GeneralAffair/FleetRekapMaintenance/RekapMaintenance', 
    })
    .done(function(data){
      console.log(data);
      var data = JSON.parse(data);
      console.log(data);
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
      Grafik('#RekapTotalMaintenance',value,bulan,'#0033CC','#0033CC', ['Total Maintenance Kendaraan']);

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
      Grafik('#RekapFrekuensiMaintenance',value,bulan,'#0033CC','#0033CC', ['Frekuensi Maintenance Kendaraan']);

    })
});

$(document).on('change','#TahunPeriodeKecelakaan', function()
{
    var value = $(this).val();
    $.ajax({
      type: 'POST',
      data: {
         value: value
      },
      url: baseurl + 'GeneralAffair/FleetRekapKecelakaan/RekapKecelakaan', 
    })
    .done(function(data){
      console.log(data);
      var data = JSON.parse(data);
      console.log(data);
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
      Grafik('#RekapTotalKecelakaan',value,bulan,'#0033CC','#0033CC', ['Total Kecelakaan']);

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
      Grafik('#RekapFrekuensiKecelakaan',value,bulan,'#0033CC','#0033CC', ['Frekuensi Kecelakaan']);

    })
});

$(document).on('click','#ProsesRekapTotal', function()
{
    var tahun   = $('#TahunPeriodeTotal').val();
    var bulan   = $('#BulanPeriodeTotal').val();
    $.ajax({
      type: 'POST',
      data: {
         tahun: tahun,
         bulan: bulan,
      },
      url: baseurl + 'GeneralAffair/FleetRekapTotal/RekapTotal', 
    })
    .done(function(data){
      var data = JSON.parse(data);
      console.log(data);
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
      Grafik('#RekapTotalMaintenance',value,bulan,'#0033CC','#0033CC', ['Total Maintenance Kendaraan']);

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
      Grafik('#RekapFrekuensiMaintenance',value,bulan,'#0033CC','#0033CC', ['Frekuensi Maintenance Kendaraan']);

      var   data  =   $.parseJSON(data);
      var   

    })
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
                    return tooltipData + '%'; 
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