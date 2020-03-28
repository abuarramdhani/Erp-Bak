var tanggal = new Date();
var d= tanggal.getDate();
var m= tanggal.getMonth()+1;
var y= tanggal.getFullYear();


$('#tblDataresikoPribadiMP').DataTable({
  dom: 'Bfrtip',
  buttons: [
    {extend:'excel',title:'Data Resiko Pribadi '+d+'-'+m+'-'+y}],
  scrollY: "370px",
  scrollX: true,
  scrollCollapse: true,
  fixedColumns: {
    leftColumns: 3
  }
});

$('#tblRekapKondisiKesehatanMP').DataTable({
  dom: 'Bfrtip',
  buttons: [
    {extend:'excel',title:'Rekap Kondisi Kesehatan '+d+'-'+m+'-'+y}],
  scrollY: "370px",
  scrollX: true,
  scrollCollapse: true,
  fixedColumns: {
    leftColumns: 3
  }
});

$('#tableseksi').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tableorder').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tablejenisorder').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#credit').DataTable({
    dom: 'frtip'
});
$('.TableTarifSPSI').DataTable({

});
$('.TableTarifPerusahaan').DataTable({

});
function MPdelete(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'MonitoringPEIA/C_AccountReceivables/deleteSeksi/'+id,
            success:function(results){

                $('table#tableseksi tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}
function DeleteOrder(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'MonitoringPEIA/C_AccountReceivables/deleteOrder/'+id,
            success:function(results){

                $('table#tableorder tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}
function DeleteJenisOrder(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'MonitoringPEIA/C_AccountReceivables/deleteJenisOrder/'+id,
            success:function(results){

                $('table#tablejenisorder tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}
function DeleteLaporan(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'MonitoringPEIA/C_AccountReceivables/deleteLaporan/'+id,
            success:function(results){

                $('table#credit tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}
function DeleteJobHarian(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'MonitoringPEIA/JobHarian/C_Jobharian/deleteLaporan/'+id,
            success:function(results){
               console.log();
                $('table#credit tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}
$(function() {
    $('input[name="daterange"]').daterangepicker();
});
$('.datepicker_mp').datepicker({
    dateFormat: 'dd-mm-yy'
});
$(".submit-date").click(function(){
    tgl1 = $("#tanggalan1").val();
    tgl2 = $("#tanggalan2").val();
     $.ajax({
            type: 'POST',
            url: baseurl+'MonitoringPEIA/C_AccountReceivables/searchTanggal/',
            data: {
                tgl1:tgl1,
                tgl2:tgl2
            },
            beforeSend: function() {
                $('#credit').DataTable().destroy();
                $('#credit tbody').empty();
            },
            success:function(results){
                $('#credit .table-filter').html(results);
                $('#pdf-buttonArea').html('<button style="width:51px;height:auto;margin-bottom:10px;border:1px solid black" id="exportPDFpe" class="btn btn-default" onclick="generatePDFpe()"><i class="fa fa-file"></i></button>');
                $('#credit').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excel',
                        text:'<img style="width:25px;height:auto" src="'+baseurl+'assets/img/export/excel-vector.png">',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    }]
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
})
$(".submit-datemon").click(function(){
    tgl1 = $("#tanggalan1").val();
    tgl2 = $("#tanggalan2").val();
     $.ajax({
            type: 'POST',
            url: baseurl+'MonitoringPEIA/JobHarian/C_Jobharian/searchTanggal/',
            data: {
                tgl1:tgl1,
                tgl2:tgl2
            },
            beforeSend: function() {
                $('#credit').DataTable().destroy();
                $('#credit tbody').empty();
            },
            success:function(results){
                $('#credit .table-filter').html(results);
                $('#pdf-buttonArea').html('<button style="width:51px;height:auto;margin-bottom:10px;border:1px solid black" id="exportPDFpe" class="btn btn-default" onclick="generatePDFpe()"><i class="fa fa-file"></i></button>');
                $('#credit').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excel',
                        text:'<img style="width:25px;height:auto" src="'+baseurl+'assets/img/export/excel-vector.png">',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    }]
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
})
function generatePDFpe() {
    tgl1 = $("#tanggalan1").val();
    tgl2 = $("#tanggalan2").val();
    window.open(baseurl+'MonitoringPEIA/Laporan/C_Jobharian/buatPDF/'+tgl1+'/'+tgl2, '_blank');
}

$(document).ready(function() {
  $('#Penerima_kasbon').select2({
    allowClear: false,
    placeholder: "Input Noind atau Nama",
    minimumInputLength: 3,
  });
  $('#Menyetujui_kasbon').select2({
    allowClear: false,
    placeholder: "Input Noind atau Nama",
    minimumInputLength: 3,
  });
  $('#selectPekerja').select2({
    allowClear: false,
    placeholder: "Input Noind atau Nama",
    minimumInputLength: 3,
  });

  $('.dataTable-List-Lelayu').DataTable({

  });
})

function MP_simpan_lelayu() {
  var pekerja = $('#selectPekerja').val();
  var waktu = $('#waktu').attr('value');
  var ket = $('#keterangan_Lelayu').val();
  var nomKafan = $('#id_kafan').attr('value');
  var nomDuka = $('#uang_Duka').attr('value');
  var askanit = $('#askanit').attr('value');
  var nomAskanit = $('#nomAskanit').attr('value');
  var totalAskanit = $('#totalAskanit').attr('value');
  var madya = $('#madya').attr('value');
  var nomMadya = $('#nomMadya').attr('value');
  var totMadya = $('#totMadya').attr('value');
  var supervisor = $('#supervisor').attr('value');
  var nomSuper = $('#nomSuper').attr('value');
  var totSuper = $('#totSuper').attr('value');
  var nonStaff = $('#nonStaff').attr('value');
  var nomNon = $('#nomNon').attr('value');
  var totNon = $('#totNon').attr('value');
  var loading = baseurl + 'assets/img/gif/loadingquick.gif';

  console.log(pekerja);
  console.log(waktu);
  console.log(ket);
  console.log(nomKafan);
  console.log(nomDuka);
  console.log(askanit);
  console.log(totalAskanit);
  console.log(madya);
  console.log(nomMadya);
  console.log(totMadya);
  console.log(supervisor);
  console.log(nomSuper);
  console.log(totSuper);
  console.log(nonStaff);
  console.log(nomNon);
  console.log(totNon);

  if (pekerja == 0 || ket == 0) {
    Swal.fire(
			  'Peringatan!',
			  'Data Harap di isi dengan Lengkap!',
			  'warning'
			)
  }else {
			Swal.fire({
				title: 'Apakah Anda Yakin ?',
				text: "Lelayu akan di Proses",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.value) {
          $.ajax({
            type:'POST',
            beforeSend: function(){
              Swal.fire({
                html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
                text : 'Loading...',
                customClass: 'swal-wide',
                showConfirmButton:false
              });
            },
            url: baseurl+"MasterPresensi/Lelayu/save",
            data:{
              nama_lelayu: pekerja,
              tanggal_lelayu: waktu,
              keterangan_Lelayu:ket,
              nomKafan: nomKafan,
              nomDuka: nomDuka,
              askanit: askanit,
              nomAskanit: nomAskanit,
              totalAskanit: totalAskanit,
              madya: madya,
              nomMadya: nomMadya,
              totMadya: totMadya,
              supervisor: supervisor,
              nomSuper: nomSuper,
              totSuper: totSuper,
              nonStaff: nonStaff,
              nomNon: nomNon,
              totNon: totNon
            },
            success:function(result){
              Swal.fire({
                title:'Success',
                text:'Lelayu telah di simpan',
                type: 'success',
                showConfirmButton:false
              });
              // window.location.reload();
            }
          });
          return true;
        }
    });
  }
}

function MP_LelayuDelete(id) {
Swal.fire({
  title: 'Apakah Anda Yakin?',
  text: "Mengapus data ini secara permanent !",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
  	window.location.href = baseurl+"MasterPresensi/Lelayu/ListData/hapus/"+id;
  }
});
return false;
}

function detailLelayu(id) {
  $.ajax({
    method: 'POST',
    url: baseurl+"MasterPresensi/Lelayu/ListData/detail",
    data:{lelayu_id:id},
    dataType: 'json',
    success: function(data) {
      console.log(data);
      $('#Lelayu_id_id').val(data[0].id);
      $('#tanggal_lelayu_id').val(data[0].tgl_lelayu);
      $('#lelayu_pekerja_id').val(data[0].nama);
      $('#keterangan_lelayu_id').val(data[0].keterangan);
      $('#uang_perusahaan_id').val(function() {
        return 'Rp '+ data[0].perusahaan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',-';
      });
      $('#uang_spsi_id').val(function() {
        return  'Rp '+ data[0].spsi.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',-';
      });
      $("#Modal_Lelayu").modal();
    }
  })
}

function ApproveLelayu(id) {
  $('#form-kanban').attr('action','ListData/exportKasBon/'+id);
  $("#Modal_Approv_kasBon").modal();
}

/** add active class and stay opened when selected */
var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.sidebar-menu a').filter(function() {
	 return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.treeview-menu a').filter(function() {
	 return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

$('.duka_dpicker').daterangepicker({
  showDropdowns: true,
 locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});

$('#duka_prk').on('click', function(){
  fakeLoading(0);
  var awal = $('#duka_rekapBegin').val();
  var akhir = $('#duka_rekapEnd').val();
  $.ajax({
    url: baseurl + 'MasterPresensi/Lelayu/getRekap',
    type: "post",
    data: {awal: awal, akhir: akhir},
    success: function (response) {
      $('#duka_table_rekap').html(response);
      duka_init_rekap();
      $('html, body').animate({
        scrollTop: $("#duka_table_rekap").offset().top
      }, 2000);
      fakeLoading(1);
    },
    error: function(jqXHR, textStatus, errorThrown) {
     console.log(textStatus, errorThrown);
   }
 });
});

$('#dk_prk2').on('click', function(){
  fakeLoading(0);
  var awal = $('#duka_rekapBegin2').val();
  var akhir = $('#duka_rekapEnd2').val();
  $.ajax({
    url: baseurl + 'MasterPresensi/Lelayu/getRekapAngelVer',
    type: "post",
    data: {awal: awal, akhir: akhir},
    success: function (response) {
      $('#duka_table_rekap2').html(response);
      $('html, body').animate({
        scrollTop: $("#duka_table_rekap2").offset().top
      }, 2000);
      fakeLoading(1);
    },
    error: function(jqXHR, textStatus, errorThrown) {
     console.log(textStatus, errorThrown);
   }
 });
});

function duka_init_rekap()
{
  var pr = $('#duka_pr_rekap').text();
  $('.duka_tbl_rekap').DataTable({
    dom: 'Bfrtip',
    buttons: [
    {
      extend: 'excelHtml5',
      title: 'Data Rekap '+pr
    },
    {
      extend: 'print',
      title: 'Data Rekap '+pr
    }
    ]
  });
  $('.buttons-excel').addClass('btn-success', 'btn').css('color', 'white').html('<i class="fa fa-file-excel-o"></i> Excel');
}

$('#duka_to_excel').on('click', function(){
  var awal = $('#duka_rekapBegin').val();
  var akhir = $('#duka_rekapEnd').val();
  var ttd = $('#Penerima_kasbon').val();
  if (awal.length > 1 && akhir.length > 1 & ttd.length > 1) {
       window.open(baseurl+"MasterPresensi/Lelayu/RekapLelayuExcel?awal="+awal+"&akhir="+akhir+"&ttd="+ttd, '_blank');
  }else{
    alert('Data Tidak Lengkap');
  }
});

$(document).on('click', '.btnmpkmdlsk', function(){
  var ks = $(this).closest('tr').find('#tdmpkks').text();
  var sk = $(this).closest('tr').find('#tdmpksk').text();
  var st = $(this).closest('tr').find('#tdmpkst').val();
  var alsn = $(this).closest('tr').find('#tdmpkalsn').text();

  $('#mdmpkodesi').text(ks+' - '+sk);
  if (st == 1) {
    $('#mpkst1').iCheck('check');
  }else{
    $('#mpkst0').iCheck('check');
  }

  $('#mdmpkalasan').find('textarea').val(alsn);
  $('#mpkkds').val(ks);
  $('#mdlmpksk').modal('show');
});