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
    dom: 'frtip',
    buttons: ['excel', 'pdf']
});


function MPdelete(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'/MonitoringPEIA/C_AccountReceivables/deleteSeksi/'+id,
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
            url: baseurl+'/MonitoringPEIA/C_AccountReceivables/deleteOrder/'+id,
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
            url: baseurl+'/MonitoringPEIA/C_AccountReceivables/deleteJenisOrder/'+id,
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
            url: baseurl+'/MonitoringPEIA/C_AccountReceivables/deleteLaporan/'+id,
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