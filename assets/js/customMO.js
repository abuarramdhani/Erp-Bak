$('#tblCore').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tblMixing').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tblMoulding').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tblQualityControl').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#tblSelep').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#jobTable').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#rejectTable').DataTable({
    dom: 'frtip'
});
function getCompDescMO(th) {
  var val = $(th).val();
  var desc = val.split('|');
  desc = desc[1];
  $('input[name="component_description"]').val(desc);
}
$(window).load(function() {
    $('.jsSlcComp').select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperation/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function(params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.SEGMENT1 + '|' + obj.DESCRIPTION,
                            text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                        };
                    })
                };
            }
        }
    });
    $('.time-form.ajaxOnChange').on('apply.daterangepicker', function(ev, picker) {
        $.ajax({
            url:baseurl+'ManufacturingOperation/Ajax/getPrintCode',
            type:'post',
            data:{
                tanggal: picker.startDate.format('YYYY/MM/DD')
            },
            beforeSend: function() {
                $('div#print_code_area').html('<img src="'+baseurl+'assets/img/gif/loading5.gif" style="width: auto; padding-left: 25px;">');
            },
            success:function(results){
                $('div#print_code_area').html(results);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        });
    });
    $('.time-form.ajaxOnChange').on('cancel.daterangepicker', function(ev, picker) {
        $('div#print_code_area').html('<div class="col-md-6">'
            +'<small>-- Select production date to generate print code --</small>'
        +'</div>');
    });
});
function getJobData(th) {
    event.preventDefault();
    $.ajax({
        url:baseurl+'ManufacturingOperation/Ajax/getJobData',
        type:'post',
        data: $(th).serialize(),
        beforeSend: function() {
            $('div#jobTableArea').html('<img src="'+baseurl+'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        success:function(results){
            $('div#jobTableArea').html(results);
            $('#jobTable').DataTable({
                dom: 'rtBp',
                buttons: ['excel', 'pdf']
            });
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $('div#jobTableArea').html('');
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    });
}
function modalReject(th,rowid) {
    $('form#rejectForm input[name="rowID"]').val(rowid);

    var jobNumber = $('div#parentData input[name="jobNumber"').val();
    var assyCode = $('div#parentData input[name="assyCode"').val();
    var assyDesc = $('div#parentData input[name="assyDesc"').val();
    var section = $('div#parentData input[name="section"').val();
    $('form#rejectForm input[name="jobNumber"]').val(jobNumber);
    $('form#rejectForm input[name="assyCode"]').val(assyCode);
    $('form#rejectForm input[name="assyDesc"]').val(assyDesc);
    $('form#rejectForm input[name="section"]').val(section);

    var compCode = $(th).closest('tr').find('input[name="compCode"]').val();
    var compDesc = $(th).closest('tr').find('input[name="compDesc"]').val();
    var qty = $(th).closest('tr').find('input[name="qty"]').val();
    var uom = $(th).closest('tr').find('input[name="uom"]').val();
    var subinv = $(th).closest('tr').find('input[name="subinv"]').val();
    $('form#rejectForm input[name="compCode"]').val(compCode);
    $('form#rejectForm input[name="compDesc"]').val(compDesc);
    $('form#rejectForm input[name="qty"]').val(qty);
    $('form#rejectForm input[name="uom"]').val(uom);
    $('form#rejectForm input[name="subinv"]').val(subinv);

    var qtyReject = $(th).closest('tr').find('td.rejectArea').attr('data-reject');
    var maxReturn = Number(qty)-Number(qtyReject);
    $('form#rejectForm input[name="returnQty"]').attr('max', maxReturn);
    $('form#rejectForm input[name="returnQty"]').val('');
    $('form#rejectForm textarea[name="returnInfo"]').val('');

    $('#rejectForm #btnSubmit').html('PROCEED');
    $('#modalReject').modal('show');
}
function proceedRejectComp() {
    event.preventDefault();
    var rowid = $('form#rejectForm input[name="rowID"]').val();
    $.ajax({
        type: 'POST',
        url: baseurl+'ManufacturingOperation/Ajax/setRejectComp',
        data: $('form#rejectForm').serialize(),
        beforeSend: function() {
            $('#rejectForm #btnSubmit').html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
        },
        success:function(results){
            var data = JSON.parse(results);
            $('#rejectTable').DataTable().destroy();
            var rowCount    = $('table#rejectTable tbody tr').length;
            var rowNumb     = rowCount+1;
            var rejectQty   = $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject');
            var picklistQty = $('table#jobTable tbody tr[row-id="'+rowid+'"] input[name="qty"]').val();
            var newRjctQty  = Number(rejectQty)+Number(data[0]['return_quantity']);

            if ($('#generateBtnArea .btnReject').attr('disabled', true)) {
                $('#generateBtnArea .btnReject').attr('disabled', false);
            }
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').html(newRjctQty);
            if (newRjctQty == picklistQty) {
                $('table#jobTable tbody tr[row-id="'+rowid+'"] button').attr('disabled', true);
            }
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject', newRjctQty);

            var deleteSendData = "'"+data[0]['replacement_component_id']+"','"+rowNumb+"','"+rowid+"'";
            var newRow = jQuery("<tr row-id='"+rowNumb+"' data-subinv='"+data[0]['subinventory_code']+"'>"
                                    +"<td>"+ rowNumb +"</td>"
                                    +"<td>"+ data[0]['component_code'] +"</td>"
                                    +"<td>"+ data[0]['component_description'] +"</td>"
                                    +"<td>"+ data[0]['return_quantity'] +"</td>"
                                    +"<td>"+ data[0]['uom'] +"</td>"
                                    +"<td>"+ data[0]['return_information'] +"</td>"
                                    +"<td>"+ data[0]['subinventory_code'] +"</td>"
                                    +"<td>"
                                        +'<a onclick="deleteRejectComp('+deleteSendData+')" class="btn btn-danger btn-block" data-toggle="tooltip" data-placement="left" title="Remove Reject Component"><i class="fa fa-minus"></i></a>'
                                    +"</td>"
                                +"</tr>");
            jQuery("table#rejectTable").append(newRow);
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            $('#modalReject').modal('hide');
            $.toaster('New Reject Component Recorded!', 'Success', 'success');
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $('#modalReject').modal('hide');
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    });
}
function deleteRejectComp(replacement_component_id, rowNumb, rowid) {
    $.ajax({
        url: baseurl+'ManufacturingOperation/Ajax/deleteRejectComp/'+replacement_component_id,
        success:function(results){
            var data = JSON.parse(results);
            // ----- action untuk tabel bawah -----
            $('#rejectTable').DataTable().destroy();
            $('#rejectTable tbody tr[row-id="'+rowNumb+'"]').remove();
            var rowCount = $('table#rejectTable tbody tr').length;
            if (rowCount == 0) {
                $('#generateBtnArea .btnReject').attr('disabled', true);
            }
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            // ----- action untuk tabel atas -----
            var rejectQty   = $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject');
            var picklistQty = $('table#jobTable tbody tr[row-id="'+rowid+'"] input[name="qty"]').val();
            var newRjctQty  = Number(rejectQty)-Number(data[0]['return_quantity']);
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject', newRjctQty);
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').html(newRjctQty);
            if (newRjctQty == picklistQty) {
                $('table#jobTable tbody tr[row-id="'+rowid+'"] button').attr('disabled', true);
            }

            $.toaster('Data was deleted!', 'Deleted', 'success');
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    })
}
function submitJobKIB(th, jobID) {
    window.open(baseurl+'ManufacturingOperation/Job/ReplaceComp/submitJobKIB/'+jobID, '_blank');
}
function submitFormRjc(jobID) {
    $.ajax({
        url: baseurl+'ManufacturingOperation/Ajax/getRejectSubInv/'+jobID,
        success:function(results){
            var data = JSON.parse(results);
            console.log(data);
            var htm = '';
            for (var i = 0; i < data.length; i++) {
                htm += '<input type="radio" name="subinvFormReject" onclick="enaDisBtnFormRjc(this)" value="'+data[i]['subinventory_code']+'"> '+data[i]['subinventory_code']+'<br>';
            }
            $('#modalFormReject #subinvArea').html(htm);
            $('#modalFormReject').modal('show');
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    });
}
function enaDisBtnFormRjc(th) {
    if ($(th).attr('selected', true)) {
        $('#modalFormReject #btnSubmit').attr('disabled', false);
    }
}