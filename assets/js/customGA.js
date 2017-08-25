// Sistem Kendaraan
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


$('#dataTables-fleetPajak').DataTable({"lengthChange": false});
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
$('#dataTables-fleetKecelakaan').DataTable( {
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
});