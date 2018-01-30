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
    $('form#rejectForm input[name="compCode"]').val(compCode);
    $('form#rejectForm input[name="compDesc"]').val(compDesc);
    $('form#rejectForm input[name="qty"]').val(qty);
    $('form#rejectForm input[name="uom"]').val(uom);

    var qtyReject = $(th).closest('tr').find('td.rejectArea').attr('data-reject');
    var maxReturn = Number(qty)-Number(qtyReject);
    $('form#rejectForm input[name="returnQty"]').attr('max', maxReturn);
    $('form#rejectForm input[name="returnQty"]').val('');
    $('form#rejectForm textarea[name="returnInfo"]').val('');

    $('#rejectForm #btnSubmit').html('PROCEED');
    $('#modalReject').modal('show');
}
function proceedRejectComp(argument) {
    event.preventDefault();
    var rowid = $('form#rejectForm input[name="rowID"]').val();
    $('#rejectForm #btnSubmit').html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
    if ($('table#rejectTable tbody tr td').hasClass('dataTables_empty')) {
        $('table#rejectTable tbody tr').remove();
    }
    var rowCount    = $('table#rejectTable tbody tr').length;
    var rowNumb     = rowCount+1;
    $.ajax({
        type: 'POST',
        url: baseurl+'ManufacturingOperation/Ajax/setRejectComp',
        data: $('form#rejectForm').serialize(),
        beforeSend: function() {
            $('div#jobTableArea').html('<img src="'+baseurl+'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        success:function(results){
            $('#rejectTable').DataTable().destroy();

            var rejectQty   = $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject');
            var picklistQty = $('table#jobTable tbody tr[row-id="'+rowid+'"] input[name="qty"]').val();

            var data = JSON.parse(results);
            var newRjctQty = Number(rejectQty)+Number(data[0]['return_quantity']);
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').html(newRjctQty);

            if (newRjctQty == picklistQty) {
                $('table#jobTable tbody tr[row-id="'+rowid+'"] button').attr('disabled', true);
            }
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject', newRjctQty);
            $('#modalReject').modal('hide');
            var newRow = jQuery("<tr>"
                                    +"<td>"+ rowNumb +"</td>"
                                    +"<td>"+ data[0]['component_code'] +"</td>"
                                    +"<td>"+ data[0]['component_description'] +"</td>"
                                    +"<td>"+ data[0]['return_quantity'] +"</td>"
                                    +"<td>"+ data[0]['uom'] +"</td>"
                                    +"<td>"+ data[0]['return_information'] +"</td>"
                                    +"<td>"
                                        +"<a onclick='deleteRejectComp("+data[0]['replacement_component_id']+");' class='btn btn-danger btn-block' data-toggle='tooltip' data-placement='left' title='Remove Reject Component'><i class='fa fa-minus'></i></a>"
                                    +"</td>"
                                +"</tr>");
            jQuery("table#rejectTable").append(newRow);
            $.toaster('New Reject Component Recorded!', 'Success', 'success');
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $('#modalReject').modal('hide');
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    });
}
function deleteRejectComp(argument) {
    $.ajax({
        type: 'POST',
        url: baseurl+'ManufacturingOperation/Ajax/deleteRejectComp/',
        success:function(results){

        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $('#modalReject').modal('hide');
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    })
}