//INCREMENT FORM
	$('.increment-form').TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'glyphicon glyphicon-plus',
      verticaldownclass: 'glyphicon glyphicon-minus'
    });

$('#dataTables-masterStatusKerja').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterJabatan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterSeksi').DataTable( {
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-kantorAsal').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-lokasiKerja').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterBankInduk').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterBank').DataTable({
	  dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
	});
$('#dataTables-masterSekolahAsal').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-setgajiump').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-settarifpekerjasakit').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-standartJamTkpw').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-standartJamUmum').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-masterParamBpjs').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterParamPtkp').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-masterParameterTarifPph').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	

$('#dataTables-riwayatPenerimaKonpensasiLembur').DataTable( {
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-masterParamKompJab').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-masterParamPengurangPajak').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-masterPekerja').DataTable( {
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-riwayatSetAsuransi').DataTable( {
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });	

$('#dataTables-masterParamKompUmum').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-riwayatParamKoperasi').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-transaksiKlaimSisaCuti').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-transaksiHitungThr').DataTable( {
      dom: 'Bfrtip',
      "scrollX": true,
      buttons: [
        'excel'
      ]
    });

$('#dataTables-transaksiHitungThrImport').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-transaksiHutang').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-daftarPekerjaSakit').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-dataGajianPersonalia').DataTable( {
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel','pdf'
      ]
    });
	
$('#txtTanggal').datepicker({ autoclose: true });
$('#txtTglJamRecord').datepicker({ autoclose: true });
$('#txtTanggal').datepicker({ autoclose: true });
$('#txtTglTransaksi').datepicker({ autoclose: true });
$('#txtDiangkat').datepicker({ autoclose: true });
$('#txtTanggal').datepicker({ autoclose: true });
$('#txtTglBerlaku').datepicker({ autoclose: true });
$('#txtTglTberlaku').datepicker({ autoclose: true });
$('#txtTglRecord').datepicker({ autoclose: true });
$('#txtTglBerlaku').datepicker({ autoclose: true });
$('#txtTglTberlaku').datepicker({ autoclose: true });
$('#txtTglRec').datepicker({ autoclose: true });
$('#txtTglRecord').datepicker({ autoclose: true });
$('#txtTglLahir').datepicker({ autoclose: true });
$('#txtTglNikah').datepicker({ autoclose: true });
$('#txtDiangkat').datepicker({ autoclose: true });
$('#txtMasukKerja').datepicker({ autoclose: true });
$('#txtAkhKontrak').datepicker({ autoclose: true });
$('#txtTglSpsi').datepicker({ autoclose: true });
$('#txtTglKop').datepicker({ autoclose: true });
$('#txtTglKeluar').datepicker({ autoclose: true });
$('#txtBatasMaxJkn').datepicker({ autoclose: true });
$('#txtBatasMaxJpn').datepicker({ autoclose: true });
$('#txtTglJamRecord').datepicker({ autoclose: true });
$('#txtTglTberlaku').datepicker({ autoclose: true });
$('#txtTglRec').datepicker({ autoclose: true });
$('#txtTglBerlaku').datepicker({ autoclose: true });
$('#txtTglRec').datepicker({ autoclose: true });

$(document).ready(function() {
  $('#txtPeriodeHitung').datepicker({
    autoclose: true,
    format: "yyyy-mm",
    viewMode: "months", 
    minViewMode: "months"
  });
  $('#cmbKdBank').select2();
  $('#cmbKdHubunganKerja').select2();
  $('#cmbKdStatusKerja').select2();
  $('#cmbKdJabatan').select2();
  $('#cmbNoind').select2();
  $('#cmbStat').select2();
  $('#cmbIdLokasiKerja').select2();
  $('#cmbNoind').select2({
    placeholder: "No Induk",
    allowClear: true,
    minimumInputLength: 2,
    ajax: {   
      url:baseurl+"PayrollManagement/getNoind",
      dataType: 'json',
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term
        }
        return queryParameters;
      },
      processResults: function (data) {
        return {
          results: $.map(data, function(obj) {
            return { id:obj.noind, text:obj.noind+' - '+obj.nama};
          })
        };
      }
    }
  });
});

function getMaxHutang(noind){
  alert(noind);
}