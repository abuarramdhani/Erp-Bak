//------------------------------------------------------PPIC----------------------------------------------------------------
function belumapprovePPIC(th) {
    var dept = $('#dept').val();
    var tanggal = $('#tanggal').val();
    console.log(dept);

    var request = $.ajax({
        url: baseurl+'MonitoringPicklistPPIC/BelumApprove/searchData',
        data: { dept : dept, tanggal : tanggal },
        type: "POST",
        datatype: 'html'
    });
    $('#tb_blmapproveppic').html('');
    $('#tb_blmapproveppic').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
                
    request.done(function(result){
        $('#tb_blmapproveppic').html(result);
    });	
}

$(document).ready(function () {
$('.datepicklist').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoClose: true
});

$(".deptpicklist").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: baseurl + "MonitoringPicklistPPIC/BelumApprove/getdept",
        dataType: 'json',
        type: "GET",
        data: function (params) {
            var queryParameters = {
                term: params.term
            }
            return queryParameters;
        },
        processResults: function (data) {
            // console.log(data);
            return {
                results: $.map(data, function (obj) {
                return {id:obj.DEPT, text:obj.DEPT+' - '+obj.DESCRIPTION};
                })
            };
        }
    }
});


$(".subinvpicklist").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "MonitoringPicklistGudang/BelumApprove/getsubinv",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                    return {id:obj.SUB_INV_CODE, text:obj.SUB_INV_CODE};
                    })
                };
            }
        }
    });

    
});

function approvePPIC(no) {
    var nojob = $('#nojob'+no).val();
    var picklist = $('#picklist'+no).val();

    var request = $.ajax({
        url: baseurl+'MonitoringPicklistPPIC/BelumApprove/approveData',
        data: { nojob : nojob, picklist : picklist},
        type: "POST",
        datatype: 'html',
        success: function(data) {
            swal.fire("Berhasil!", "", "success");
            $('#btnppic1'+no).attr('disabled', 'disabled');
        }
    });
}

function sudahapprovePPIC(th) {
        var dept = $('#dept').val();
        var tanggal = $('#tanggal').val();
        console.log(tanggal);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistPPIC/SudahApprove/searchData',
                data: { dept : dept, tanggal : tanggal},
                type: "POST",
                datatype: 'html'
        });
        $('#tb_sdhapproveppic').html('');
        $('#tb_sdhapproveppic').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
                
        request.done(function(result){
                $('#tb_sdhapproveppic').html(result);
        });	
}


function recallPPIC(no) {
        var nojob = $('#nojob'+no).val();
        var picklist = $('#picklist'+no).val();
    
        var request = $.ajax({
            url: baseurl+'MonitoringPicklistPPIC/SudahApprove/recallData',
            data: { nojob : nojob, picklist : picklist },
            type: "POST",
            datatype: 'html',
            success: function(data) {
                swal.fire("Berhasil!", "", "success");
                $('#btnppic2'+no).attr('disabled', 'disabled');
            }
        });
    }


//------------------------------------------------------FABRIKASI----------------------------------------------------------------
function belumapproveFabrikasi(th) {
        var dept = $('#dept').val();
        var tanggal = $('#tanggal').val();
        console.log(dept);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistFabrikasi/BelumApprove/searchData',
                data: {dept : dept, tanggal : tanggal},
                type: "POST",
                datatype: 'html'
        });
        $('#tb_blmfabrikasi').html('');
        $('#tb_blmfabrikasi').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
                
        request.done(function(result){
                $('#tb_blmfabrikasi').html(result);
                var jml = 0;
                $('input.jmli').each((i, item) => {
                        if (item.value == false) {
                        return
                }
                jml += Number(item.value);
                        })
                $('#jmlbrs').html(jml);
        });	
}

function approveFabrikasi(no) {
        var nojob = $('#nojob'+no).val();
        var picklist = $('#picklist'+no).val();
    
        var request = $.ajax({
            url: baseurl+'MonitoringPicklistFabrikasi/BelumApprove/approveData',
            data: { nojob : nojob, picklist : picklist },
            type: "POST",
            datatype: 'html',
            success: function(data) {
                swal.fire("Berhasil!", "", "success");
                $('#appfab'+no).attr('disabled', 'disabled');
            }
        });
}

function sudahapproveFabrikasi(th) {
        var dept = $('#dept').val();
        var tanggal = $('#tanggal').val();
        console.log(dept);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistFabrikasi/SudahApprove/searchData',
                data: { dept : dept, tanggal : tanggal },
                type: "POST",
                datatype: 'html'
        });
        $('#tb_sdhfabrikasi').html('');
        $('#tb_sdhfabrikasi').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
                
        request.done(function(result){
                $('#tb_sdhfabrikasi').html(result);
        });	
}

function recallFabrikasi(no) {
        var nojob = $('#nojob'+no).val();
        var picklist = $('#picklist'+no).val();
    
        var request = $.ajax({
            url: baseurl+'MonitoringPicklistFabrikasi/SudahApprove/recallData',
            data: { nojob : nojob, picklist : picklist },
            type: "POST",
            datatype: 'html',
            success: function(data) {
                swal.fire("Berhasil!", "", "success");
                $('#refab'+no).attr('disabled', 'disabled');
            }
        });
}


//------------------------------------------------------GUDANG----------------------------------------------------------------
function belumapproveGudang(th) {
        var subinv = $('#subinv').val();
        var tanggal = $('#tanggal').val();
        console.log(subinv);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistGudang/BelumApprove/searchData',
                data: { subinv : subinv, tanggal : tanggal},
                type: "POST",
                datatype: 'html'
        });
        $('#tb_blmgudang').html('');
        $('#tb_blmgudang').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
                
        request.done(function(result){
                $('#tb_blmgudang').html(result);
        });	
}

function modalapproveGD(no) {
        var nojob = $('#nojob'+no).val();
        var picklist = $('#picklist'+no).val();

        var request = $.ajax ({
        url : baseurl + "MonitoringPicklistGudang/BelumApprove/modalData",
        data: { no : no, nojob : nojob, picklist : picklist},
        type : "POST",
        dataType: "html"
        });
        request.done(function(result){
            // console.log(result);
            $('#dataapprove').html(result);
            $('#mdlapprovegd').modal('show'); 
    });  
}

function approveGudang(th) {
        var nojob       = $('#nojob').val();
        var picklist    = $('#picklist').val();

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistGudang/BelumApprove/approveData',
                data: { nojob : nojob, picklist : picklist },
                type: "POST",
                datatype: 'html',
		success: function(data) {
                $('#mdlapprovegd').modal('hide'); 
                swal.fire("Berhasil!", "", "success");
		}
        });
}

function sudahapproveGudang(th) {
        var subinv = $('#subinv').val();
        var tanggal = $('#tanggal').val();

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistGudang/SudahApprove/searchData',
                data: {subinv : subinv, tanggal : tanggal},
                type: "POST",
                datatype: 'html'
        });
        $('#tb_sdhgudang').html('');
        $('#tb_sdhgudang').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
                
        request.done(function(result){
                $('#tb_sdhgudang').html(result);
        });	
}


function recallGudang(no) {
    var nojob = $('#nojob'+no).val();
    var picklist = $('#picklist'+no).val();

    var request = $.ajax({
        url: baseurl+'MonitoringPicklistGudang/SudahApprove/recallData',
        data: { nojob : nojob, picklist : picklist },
        type: "POST",
        datatype: 'html',
        success: function(data) {
            swal.fire("Berhasil!", "", "success");
            $('#regud'+no).attr('disabled', 'disabled');
        }
    });
}
