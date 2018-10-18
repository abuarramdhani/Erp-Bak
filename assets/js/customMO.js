//var baseurl = document.location.origin;



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
$('#masterItem').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#MasterPersonal').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
$('#masterScrap').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});
// $('#tglBerlaku').datepicker({
//     format: 'mm/dd/yyyy',
//     container: container,
//     todayHighlight: true,
//     autoclose: true,
// });

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
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function(params) {
                var queryParameters = {
                    term: params.term
                }
                console.log(params);
                return queryParameters;
            },
            processResults: function(data) {
                console.log(data);
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.kode_barang + '|' + obj.nama_barang,
                            text: obj.kode_barang + " | " + obj.nama_barang
                        };
                    })
                };
            },
            error:function(error,status){
                console.log(error);
            }
        }
    });



    $('.jsSlcEmpl').select2({
        allowClear: true,
        placeholder: "Choose Employee",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
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
                            id: obj.no_induk + '|' + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    });

     $('.jsSlcScrap').select2({
        allowClear: true,
        placeholder: "Choose Employee",
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getScrap",
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
                            id: obj.scrap_code + '|' + obj.description,
                            text: obj.scrap_code + " | " + obj.description
                        };
                    })
                };
            }
        }
    });


    $('.add_emp').click(function(){
                        $('.jsSlcEmpl').select2('destroy').end();
                        $(this).parent().clone(true).appendTo($("#container-employee"));
                        $('.remove_emp').show();
                        $('.jsSlcEmpl').select2({
                                allowClear: true,
                                placeholder: "Choose Employee",
                                minimumInputLength: 3,
                                ajax: {
                                    url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
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
                                                    id: obj.no_induk + '|' + obj.nama,
                                                    text: obj.no_induk + " | " + obj.nama
                                                };
                                            })
                                        };
                                    }
                                }
                            });
                    });


     $('.remove_emp').click(function(){
                var count = $('#container-employee').children().length;
                console.log(count);
                c = count-parseInt(1);
                console.log(c);

                if(count>1){
                    $(this).parent().remove();
                }

                if(c==1){
                    $('.remove_emp').hide()
                }
            });

    $('.time-form.ajaxOnChange').on('apply.daterangepicker', function(ev, picker) {
        $.ajax({
            url:baseurl+'ManufacturingOperationUP2L/Ajax/getPrintCode',
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
        url:baseurl+'ManufacturingOperationUP2L/Ajax/getJobData',
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
        url: baseurl+'ManufacturingOperationUP2L/Ajax/setRejectComp',
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

            var deleteSendData = data[0]['replacement_component_id']+","+rowNumb+","+rowid;
            var newRow = jQuery("<tr row-id='"+rowNumb+"'>"
                                    +"<td>"+ rowNumb +"</td>"
                                    +"<td>"+ data[0]['component_code'] +"</td>"
                                    +"<td>"+ data[0]['component_description'] +"</td>"
                                    +"<td>"+ data[0]['return_quantity'] +"</td>"
                                    +"<td>"+ data[0]['uom'] +"</td>"
                                    +"<td>"+ data[0]['return_information'] +"</td>"
                                    +"<td>"+ data[0]['subinventory_code'] +"</td>"
                                    +"<td>"
                                        +"<a onclick='deleteRejectComp("+deleteSendData+");' class='btn btn-danger btn-block' data-toggle='tooltip' data-placement='left' title='Remove Reject Component'><i class='fa fa-minus'></i></a>"
                                    +"</td>"
                                +"</tr>");
            jQuery("table#rejectTable").append(newRow);
            var subInvData = $('#modalFormReject input[name="subInvData"]').val();
            if (subInvData.trim() == '') {
                $('#modalFormReject input[name="subInvData"]').val(data[0]['subinventory_code']);
                $('#modalFormReject #subinvArea').html('<input type="radio" value="'+data[0]['subinventory_code']+'"> '+data[0]['subinventory_code']);
            }else{
                var subInvDataArr = subInvData.split(',');
                if (jQuery.inArray(data[0]['subinventory_code'], subInvDataArr) == -1) {
                    var subInvDataVal = subInvData+','+data[0]['subinventory_code'];
                    $('#modalFormReject input[name="subInvData"]').val(subInvDataVal);
                    $('#modalFormReject #subinvArea').html('<input type="radio" value="'+data[0]['subinventory_code']+'"> '+data[0]['subinventory_code']);
                }
            }
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
        url: baseurl+'ManufacturingOperationUP2L/Ajax/deleteRejectComp/'+replacement_component_id,
        success:function(results){
            var data = JSON.parse(results);
            $('table#rejectTable tbody tr[row-id="'+rowNumb+'"]').remove();
            $('#rejectTable').DataTable().destroy();
            var rowCount = $('table#rejectTable tbody tr').length;
            if (rowCount == 0) {
                $('#generateBtnArea .btnReject').attr('disabled', true);
            }
            var rejectQty   = $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject');
            var newRjctQty  = Number(rejectQty)+Number(data[0]['return_quantity']);
            $('table#jobTable tbody tr[row-id="'+rowid+'"] td.rejectArea').attr('data-reject', newRjctQty);
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            $.toaster('Data was deleted!', 'Deleted', 'success');
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    });
}
function submitJobKIB(th, jobID) {
    window.open(baseurl+'ManufacturingOperationUP2L/Job/ReplaceComp/submitJobKIB/'+jobID, '_blank');
}

function deleteMasterItem(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $('tr[row-id="'+rowid+'"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled',true);
        $.ajax({
            url: baseurl+'ManufacturingOperationUP2L/Ajax/deleteItem/'+id,
            success:function(results){
                var data = JSON.parse(results);
                $('table#masterItem').DataTable().destroy();
                $('table#masterItem tbody tr[row-id="'+rowid+'"]').remove();
                $('table#masterItem').DataTable({
                                            dom: 'Bfrtip',
                                            buttons: ['excel', 'pdf']
                                        });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
                 $('tr[row-id="'+rowid+'"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled',false);

            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}

function deleteMasterScrap(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $('tr[row-id="'+rowid+'"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled',true);
        $.ajax({
            url: baseurl+'ManufacturingOperationUP2L/Ajax/deleteScrap/'+id,
            success:function(results){
                var data = JSON.parse(results);
                $('table#masterScrap').DataTable().destroy();
                $('table#masterScrap tbody tr[row-id="'+rowid+'"]').remove();
                $('table#masterScrap').DataTable({
                                            dom: 'Bfrtip',
                                            buttons: ['excel', 'pdf']
                                        });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
                 $('tr[row-id="'+rowid+'"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled',false);

            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}

function deleteMasterPersonal(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $('tr[row-id="'+rowid+'"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled',true);
        $.ajax({
            url: baseurl+'ManufacturingOperationUP2L/Ajax/deletePerson/'+id,
            success:function(results){
                var data = JSON.parse(results);
                $('table#MasterPersonal').DataTable().destroy();
                $('table#MasterPersonal tbody tr[row-id="'+rowid+'"]').remove();
                $('table#MasterPersonal').DataTable({
                                            dom: 'Bfrtip',
                                            buttons: ['excel', 'pdf']
                                        });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
                 $('tr[row-id="'+rowid+'"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled',false);

            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}

function editMasterItem(id) {
    $.ajax({
        url: baseurl+'ManufacturingOperationUP2L/Ajax/editItem/'+id,
        success:function(results){
                console.log(results);
                $('#editMasterItem').html(results);
        },
        error: function(results){
            console.log('error');
        }
    })
}

function editMasterScrap(id) {
    $.ajax({
        url: baseurl+'ManufacturingOperationUP2L/Ajax/editScrap/'+id,
        success:function(results){
                console.log(results);
                $('#editMasterScrap').html(results);
        },
        error: function(results){
            console.log('error');
        }
    })
}

function editMasterPerson(id) {
    $.ajax({
        url: baseurl+'ManufacturingOperationUP2L/Ajax/editPerson/'+id,
        success:function(results){
                console.log(results);
                $('#editMasterPerson').html(results);
        },
        error: function(results){
            console.log('error');
        }
    })
}

function checkQuantity(th){
    var date = $('#production_date').text();
    var scrap = $('#scrap_qty').val();
    var quantity = $('#checking_qty').val();
    var mould_qty = $('#mould_qty').val();
    var print_code = $('#print_code').text();
    var component = $('#component_code').text();
    var id = $('#mould_id').val();
    
    console.log(scrap);
    console.log(date);
    console.log(print_code);    

    if((parseInt(scrap) + parseInt(quantity)) > parseInt(mould_qty)){
        alert('Jumlah melebihi quantity');
    }else{

        var remain = parseInt(mould_qty) - (parseInt(scrap) + parseInt(quantity));

        $.ajax({
            type: 'post',
            url: baseurl+'ManufacturingOperationUP2L/Ajax/addQuality',
            data:{ SCRAP:scrap,
                   CHECK:quantity,
                   REMAIN:remain,
                   PRINT_CODE:print_code,
                   CHECKING_DATE:date,
                   COMPONENT:component,
                   ID:id
            },
            success:function(results){
               window.location.replace(baseurl+'ManufacturingOperationUP2L/QualityControl');
            },
            error:function(error,status){
                console.log(error);
            }
        });
    }
}

$('.add_scrap').click(function(){
    var type = $('#txtScrap').val();
    var qty = $('#scrap_qty').val();
    var mould_qty = $('#mould_qty').val();
    var id = $('#mould_id').val();
    var jml = $('#jumlah_scrap').val();
    if(jml=='-'){
        total=parseInt(0);
    }else{
        total=jml;
    }
    var jumlah = parseInt(qty)+parseInt(total);

    console.log(jumlah);
    if(jumlah>mould_qty){
        alert('Jumlah scrap melebihi quantity moulding');
    }else{
        $.ajax({
            type: 'post',
            url: baseurl+'ManufacturingOperationUP2L/Ajax/addScrap/',
            data:{ id:id,
                   qty:qty,
                   type:type 
            },
            success:function(results){
               location.reload();
            },
            error:function(results){
                alert('error');
            }
        });
    }
})

$('.add_bongkar').click(function(){
    var qty = $('#bongkar_qty').val();
    var mould_qty = $('#mould_qty').val();
    var id = $('#mould_id').val();
    var jml = $('#jumlah_bongkar').val();
    
    console.log(qty);
    console.log(mould_qty);
    console.log(id);
    console.log(jml);
    
    if(jml=='-'){
        total=parseInt(0);
    }else{
        total=jml;
    }
    
    var jumlah = parseInt(qty)+parseInt(total);

    console.log(jumlah);
    if(jumlah>mould_qty){
        alert('Jumlah scrap melebihi quantity moulding');
    }else{
        $.ajax({
            type: 'post',
            url: baseurl+'ManufacturingOperationUP2L/Ajax/addBongkar/',
            data:{ id:id,
                   qty:qty
            },
            success:function(results){
               location.reload();
            },
            error:function(results){
                alert('error');
            }
        });
    }
})

$("#tanggal_cetak").on("click", function() {

   var val = $('.time-form').val();
   console.log(val);

   $.ajax({
        url:baseurl+'ManufacturingOperationUP2L/Ajax/getDatePrintCode',
        type:'post',
        dataType:'json',
        data: {TANGGAL:val},
        beforeSend: function() {
            $('div#jobTableArea').html('<img src="'+baseurl+'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        complete:function(){

        },
        success:function(results){
            $("#tableQuality").empty();
            var html = '';
             console.log(results);
            $.each(results,function(i,data){
                html += "<tr><td align='center'>"+ 1 +"</td>"+
                        "<td align='center'>" +
                            "<a style='margin-right:4px' href='"+baseurl+"/ManufacturingOperationUP2L/QualityControl/read_detail/"+data.moulding_id+"' data-toggle='tooltip' data-placement='bottom' title='Read Data'><span class='fa fa-list-alt fa-2x'></span></a>" +
                        "</td>" +
                        "<td>"+ data.component_code +"</td>" +
                        "<td>"+ data.component_description +"</td>" +
                        "<td>"+ data.production_date +"</td>" +
                        "<td>"+ data.moulding_quantity+"</td>" +
                        "<td>"+ data.print_code +"</td></tr>";
            });

            $("#tableQuality").append(html);
            
        },
        error:function(textStatus, errorThrown){
            $('div#jobTableArea').html('');
            console.log(textStatus);
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
   });
});

