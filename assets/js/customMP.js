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