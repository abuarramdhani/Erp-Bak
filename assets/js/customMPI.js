//------------------------------------------------------PPIC----------------------------------------------------------------
function belumapprovePPIC(th) {
    var dept = $('#dept').val();
    var tanggal1 = $('#tanggal1').val();
    var tanggal2 = $('#tanggal2').val();
    // console.log(dept);

    var request = $.ajax({
        url: baseurl+'MonitoringPicklistPPIC/BelumApprove/searchData',
        data: { dept : dept, tanggal1 : tanggal1,tanggal2 : tanggal2 },
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
}).on('change', function(){
    $('.datepicker').hide();
});;

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
    $('#btnapp'+no).attr('disabled', 'disabled');

    var request = $.ajax({
        url: baseurl+'MonitoringPicklistPPIC/BelumApprove/approveData',
        data: { nojob : nojob, picklist : picklist},
        type: "POST",
        datatype: 'html',
        success: function(data) {
            swal.fire("Berhasil!", "", "success");
            $('#btnapp'+no).attr('disabled', 'disabled');
            $('#btnapp'+no).removeClass('btn-success');
            belumapprovePPIC();
        }
    });
}

function sudahapprovePPIC(th) {
        var dept = $('#dept').val();
        var tanggal1 = $('#tanggal1').val();
        var tanggal2 = $('#tanggal2').val();
        // console.log(tanggal);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistPPIC/SudahApprove/searchData',
                data: { dept : dept, tanggal1 : tanggal1, tanggal2 : tanggal2},
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

    function ceksemua(){
        var cek = $('#tandacekall').val();
        var jml = $('.baris:last').val();
        // console.log(jml);
        if(cek == 'cek') {
            $('#tandacekall').val('uncek');
            $('#cekall').removeClass('fa-square-o').addClass('fa-check-square-o');
            $('.tandasemua').val('uncek');
            $('.printsemua').val('uncek');
            $('.ceka').removeClass('fa-square-o').addClass('fa-check-square-o');
            $('.aktif').addClass('tercek');
            $('.check_semua2').addClass('tercek2');
            $('.bisaprint').addClass('tercek4');
            $('.bisacek').addClass('tercek5');
            $('#appsemua').removeAttr('disabled');
            $('#appsemua').val('Approve Selected ('+jml+')');
            $('#ctksemua').val('Print Selected ('+jml+')');
        } else {
            $('#tandacekall').val('cek');
            $('#cekall').removeClass('fa-check-square-o').addClass('fa-square-o');
            $('.tandasemua').val('cek');
            $('.printsemua').val('cek');
            $('.ceka').removeClass('fa-check-square-o').addClass('fa-square-o');
            $('.aktif').removeClass('tercek');
            $('.check_semua2').removeClass('tercek2');
            $('.bisaprint').removeClass('tercek4');
            $('.bisacek').removeClass('tercek5');
            $('#appsemua').attr('disabled', 'disabled');
            $('#appsemua').val('Approve Selected (0)');
            $('#ctksemua').val('Print Selected (0)');
        }
    }

    function inicek(no) {
        var cek = $('#tandacek'+no).val();
        var btn = $('#appsemua').val();
        var coba1 = btn.slice(18, -1);
        // console.log(coba1);
        if(cek == 'cek') {
            coba2 = 1 + parseInt(coba1);
            $('#tandacek'+no).val('uncek');
            $('#printcek'+no).val('uncek');
            $('#ceka'+no).removeClass('fa-square-o').addClass('fa-check-square-o');
            $('#btnapp'+no).addClass('tercek');
            $('#cek'+no).addClass('tercek2');
            $('#iniprint'+no).addClass('tercek4');
            $('#ceka'+no).addClass('tercek5');
            $('#appsemua').removeAttr('disabled');
            $('#appsemua').val('Approve Selected ('+coba2+')')
            $('#ctksemua').val('Print Selected ('+coba2+')')
        } else {
            coba2 = parseInt(coba1) - 1;
            $('#tandacek'+no).val('cek');
            $('#printcek'+no).val('cek');
            $('#ceka'+no).removeClass('fa-check-square-o').addClass('fa-square-o');
            $('#btnapp'+no).removeClass('tercek');
            $('#cek'+no).removeClass('tercek2');
            $('#iniprint'+no).removeClass('tercek4');
            $('#ceka'+no).removeClass('tercek5');
            $('#appsemua').val('Approve Selected ('+coba2+')')
            $('#ctksemua').val('Print Selected ('+coba2+')')
        }
    }

    function approvePPIC2() {
        var nojob = $('.nojob').map(function(){return $(this).val();}).get();
        var picklist = $('.picklist').map(function(){return $(this).val();}).get();
        var cek = $('.tandasemua').map(function(){return $(this).val();}).get();
    
        var request = $.ajax({
            url: baseurl+'MonitoringPicklistPPIC/BelumApprove/approveData2',
            data: { nojob : nojob, picklist : picklist, cek : cek},
            type: "POST",
            datatype: 'html',
            success: function(data) {
                swal.fire("Berhasil!", "", "success");
                $('.tercek').attr('disabled', 'disabled');
                $('.tercek').removeClass('btn-success');
                belumapprovePPIC();
            }
        });
    }

//------------------------------------------------------FABRIKASI----------------------------------------------------------------
function belumapproveFabrikasi(th) {
        var dept = $('#dept').val();
        var tanggal1 = $('#tanggal1').val();
        var tanggal2 = $('#tanggal2').val();
        // console.log(dept);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistFabrikasi/BelumApprove/searchData',
                data: {dept : dept, tanggal1 : tanggal1, tanggal2 : tanggal2},
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
                $('#tmpfab').val(jml);
        });	
}

function approveFabrikasi(no) {
        var nojob = $('#nojob'+no).val();
        var picklist = $('#picklist'+no).val();
        $('#btnapp'+no).attr('disabled', 'disabled');
    
        var request = $.ajax({
            url: baseurl+'MonitoringPicklistFabrikasi/BelumApprove/approveData',
            data: { nojob : nojob, picklist : picklist },
            type: "POST",
            datatype: 'html',
            success: function(data) {
                swal.fire("Berhasil!", "", "success");
                $('#btnapp'+no).attr('disabled', 'disabled');
                $('#btnapp'+no).removeClass('btn-success');
                $('#cek'+no).removeAttr("onclick");
                $('#ceka'+no).removeClass("ceka");
                $('#iniprint'+no).removeAttr('disabled');
            }
        });
}

function approveFabrikasi2() {
    var nojob = $('.nojob').map(function(){return $(this).val();}).get();
    var picklist = $('.picklist').map(function(){return $(this).val();}).get();
    var cek = $('.tandasemua').map(function(){return $(this).val();}).get();

    var request = $.ajax({
        url: baseurl+'MonitoringPicklistFabrikasi/BelumApprove/approveData2',
        data: { nojob : nojob, picklist : picklist, cek : cek},
        type: "POST",
        datatype: 'html',
        success: function(data) {
            swal.fire("Berhasil!", "", "success");
            $('.tercek').attr('disabled', 'disabled');
            $('.tercek').removeClass('btn-success');
            $('.tercek5').removeClass('ceka');
            $('#ctksemua').removeAttr('disabled');
            $('.tercek4').removeAttr('disabled');
            $('.tercek2').removeAttr("onclick");
        }
    });
}

function sudahapproveFabrikasi(th) {
        var dept = $('#dept').val();
        var tanggal1 = $('#tanggal1').val();
        var tanggal2 = $('#tanggal2').val();
        // console.log(dept);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistFabrikasi/SudahApprove/searchData',
                data: { dept : dept, tanggal1 : tanggal1, tanggal2 : tanggal2 },
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

function notiffabrikasi(th) {
    var dept = $('#dept').val();
    var tampil = $('#tmpfab').val();
    var tanggal1 = $('#tanggal1').val();
    var tanggal2 = $('#tanggal2').val();

    var request = $.ajax({
            url: baseurl+'MonitoringPicklistFabrikasi/BelumApprove/searchData2',
            data: {dept : dept, tanggal1 : tanggal1, tanggal2 : tanggal2},
            type: "POST",
            datatype: 'html',
            success: function(data){
                // console.log(data);
                if (tampil == 0 && data != 0) {
                    var jml = data;
                    $('#notiffabrks').html(jml);
                    $('#notiffabrks').addClass('label-danger');
                }else if (tampil != 0 && data != 0){
                    var jml = data - tampil;
                    if (jml > 0) {
                        $('#notiffabrks').html(jml);
                        $('#notiffabrks').addClass('label-danger');
                    }else{
                        $('#notiffabrks').html('');
                        $('#notiffabrks').removeClass('label-danger');
                    }
                }else{
                    $('#notiffabrks').html('');
                    $('#notiffabrks').removeClass('label-danger');
                }
        }
    });
}


//------------------------------------------------------GUDANG----------------------------------------------------------------
function belumapproveGudang(th) {
        var subinv = $('#subinv').val();
        var tanggal1 = $('#tanggal1').val();
        var tanggal2 = $('#tanggal2').val();
        // console.log(subinv);

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistGudang/BelumApprove/searchData',
                data: { subinv : subinv,  tanggal1 : tanggal1, tanggal2 : tanggal2},
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
        var deliver = $('#deliver'+no).val();

        var request = $.ajax ({
        url : baseurl + "MonitoringPicklistGudang/BelumApprove/modalData",
        data: { no : no, nojob : nojob, picklist : picklist, deliver : deliver},
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
        $('#btn_appgdg').attr('disabled', 'disabled');
        
        var request = $.ajax({
                url: baseurl+'MonitoringPicklistGudang/BelumApprove/approveData',
                data: { nojob : nojob, picklist : picklist },
                type: "POST",
                datatype: 'html',
		success: function(data) {
                $('#mdlapprovegd').modal('hide'); 
                swal.fire("Berhasil!", "", "success");
                belumapproveGudang();
                $("div").removeClass('modal-backdrop');
                $("body").removeClass('modal-open'); 
		}
        });
}

function approveGudang2(th) {
    var nojob = $('.nojob').map(function(){return $(this).val();}).get();
    var picklist = $('.picklist').map(function(){return $(this).val();}).get();
    var cek = $('.tandasemua').map(function(){return $(this).val();}).get();

    var request = $.ajax({
            url: baseurl+'MonitoringPicklistGudang/BelumApprove/approveData2',
            data: { nojob : nojob, picklist : picklist, cek : cek},
            type: "POST",
            datatype: 'html',
    success: function(data) {
            swal.fire("Berhasil!", "", "success");
            belumapproveGudang()
    }
    });
}

function sudahapproveGudang(th) {
        var subinv = $('#subinv').val();
        var tanggal1 = $('#tanggal1').val();
        var tanggal2 = $('#tanggal2').val();

        var request = $.ajax({
                url: baseurl+'MonitoringPicklistGudang/SudahApprove/searchData',
                data: {subinv : subinv,  tanggal1 : tanggal1, tanggal2 : tanggal2},
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


function notifgudang(th) {
    var subinv = $('#subinv').val();
    var tampil = $('.baris:last').val();
    var tanggal1 = $('#tanggal1').val();
    var tanggal2 = $('#tanggal2').val();

    var request = $.ajax({
            url: baseurl+'MonitoringPicklistGudang/BelumApprove/searchData2',
            data: {subinv : subinv, tanggal1 : tanggal1, tanggal2 : tanggal2},
            type: "POST",
            datatype: 'html',
            success: function(data){
                // console.log(subinv);
                if (tampil == 0 && data != 0) {
                    // console.log(data);
                    var jml = data;
                    $('#notifgdg').html(jml);
                    $('#notifgdg').addClass('label-danger');
                }else if (tampil != 0 && data != 0){
                    var jml = data - tampil;
                    if (jml > 0) {
                        $('#notifgdg').html(jml);
                        $('#notifgdg').addClass('label-danger');
                    }else{
                        $('#notifgdg').html('');
                        $('#notifgdg').removeClass('label-danger');
                    }
                }else{
                    $('#notifgdg').html('');
                    $('#notifgdg').removeClass('label-danger');
                }
        }
    });
}
