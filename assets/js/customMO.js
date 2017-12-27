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
