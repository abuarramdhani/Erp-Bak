//---------------------------------------------- Pengeluaran ----------------------------------------------------

$('#no_dokumen').on("keypress",function(e){
    if (e.keyCode == 13) {
        return false;
    }
}); 

function cekPengeluaranKGP(th) {
    var subinv = $('#subinv').val();
    var no_dokumen = $('#no_dokumen').val();

    var request = $.ajax({
        url: baseurl+'KapasitasGdPusat/Pengeluaran/cek_data',
        data: {
            no_dokumen  : no_dokumen,
            subinv  : subinv
        },
        type: "POST",
        datatype: 'html'
    });
    $('#tb_pengeluaran').html('');
	$('#tb_pengeluaran').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
	request.done(function(result){
        // console.log(result);
        $('#tb_pengeluaran').html(result);

        // var length = no_dokumen.length
        // if(length == 12){
        //     var awl = no_dokumen.substring(0, 1);
        //     if (awl == 'D') {
        //         $('#jenis_dokumen').val('PICKLIST').trigger('change')
        //     }else{
        //         $('#jenis_dokumen').val('IO').trigger('change')
        //      }
        // }else if(length == 9) {
        //     $('#jenis_dokumen').val('BON').trigger('change')
        // }else if(length == 7) {
        //     $('#jenis_dokumen').val('MO').trigger('change')
        // }else{
        //     $('#jenis_dokumen').val('').trigger('change')
        // }
    })
}

var pengeluaran = document.getElementById("tb_data_pengeluaran");
if (pengeluaran) {
    var request = $.ajax({
        url: baseurl+'KapasitasGdPusat/Pengeluaran/get_data_pengeluaran',
        type: "POST",
        datatype: 'html'
    });

    $('#tb_data_pengeluaran').html('');
	$('#tb_data_pengeluaran').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
    
    request.done(function(result){
        $('#tb_data_pengeluaran').html(result);
        $('#tbl_pglr_kgp').dataTable();

        $(".picKGP").select2({
            allowClear: true,
            placeholder: "",
            minimumInputLength: 0,
            ajax: {
                url: baseurl + "KapasitasGdPusat/Pengeluaran/getPIC",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                            term: params.term,
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    // console.log(data);
                    return {
                        results: $.map(data, function (obj) {
                            return {id:obj.PIC, text:obj.PIC};
                        })
                    };
                }
            }
        });

        $(".picKGP2").select2({
            allowClear: true,
            placeholder: "",
            minimumInputLength: 0,
            ajax: {
                url: baseurl + "KapasitasGdPusat/Pengeluaran/getPIC",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                            term: params.term,
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    // console.log(data);
                    return {
                        results: $.map(data, function (obj) {
                            return {id:obj.PIC, text:obj.PIC};
                        })
                    };
                }
            }
        });
    })
}

function savePIC(no_dokumen) {
    // var ket = 'kirim_qc';
    var pic = $('#pic'+no_dokumen).val();
    console.log(pic);
    if(!pic){
        return;
    }
    $.ajax ({
        url : baseurl + "MonitoringGdSparepart/Monitoring/saveJmlOk",
        data: {
            no_dokumen: no_dokumen, 
            pic : pic
        },
        type : "POST",
        dataType: "html"
    });

}

function btnDeleteKGP(no) {
    var jenis_dokumen = $('#jenis_dokumen'+no).val();
    var no_dokumen = $('#no_dokumen'+no).val();

    Swal.fire({
        title: "Anda Yakin?",
        text: "Data Akan Di Hapus",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        // console.log(result);
        if (result.value) {
            var request = $.ajax({
              url: baseurl + "KapasitasGdPusat/Pengeluaran/deleteDokumen",
              data: {
                jenis_dokumen: jenis_dokumen,
                no_dokumen: no_dokumen,
              },
              type: "POST",
              datatype: "html",
            });
            request.done(function (result) {
              Swal.fire({
                position: "top",
                type: "success",
                title: "Berhasil Dihapus",
                showConfirmButton: false,
                timer: 1500,
              }).then(() => {
                window.location.reload();
              });
            });
        }
    })
}

//----------------------------------------- Mulai 1 -----------------------------------------------

function btnTimerKGP(no) {
    var valBtn = $('#btnTimerKGP'+no).val();
    var jenis_dokumen = $('#jenis_dokumen'+no).val();
    var no_dokumen = $('#no_dokumen'+no).val();
    var pic = $('#pic'+no).val();
    var d = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var waktu  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    // console.log(jenis_dokumen);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    function setTime() {
        totalSeconds++;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }

    if (valBtn == 'Mulai') {
        $('#btnTimerKGP'+no).each(function() {
            $('#btnTimerKGP'+no).val('Selesai'); 
            $('#mulai'+no).val(waktu); 
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#pic'+no).prop("disabled", true); 

            if (!timer) {
                timer = setInterval(setTime, 1000);
            }
        })
        $.ajax ({
            url : baseurl + "KapasitasGdPusat/Pengeluaran/getMulai",
            data: { 
                date : date , 
                jenis_dokumen : jenis_dokumen, 
                no_dokumen : no_dokumen, 
                pic : pic
            },
            type : "POST",
            dataType: "html"
        });
    }else if(valBtn == 'Selesai'){
        testmodal(no);
    }
}

function testmodal(no) {
    $('#modalDetailDOK').modal();

    var no_dokumen = $('#no_dokumen'+no).val();

    $.ajax({
        url: baseurl + 'KapasitasGdPusat/Pengeluaran/getDetail',
        type: 'POST',
        datatype: 'html',
        data: {
            no_dokumen: no_dokumen
        },
        beforeSend: function() {
            $('#loadingAreaDetail').show();
            $('div.table_detail').hide();
        },
        success: function(result) {
            $('#loadingAreaDetail').hide();
            $('div.table_detail').show();
            $('div.table_detail').html(result);
            getDetailItem(no_dokumen);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
        }
    });
}

//------------------------------------------ Mulai Checked ------------------------------------------------

function checkdokumenKGP(no) {
    var val = $('#tandacheck'+no).val();
    // console.log(val);

    if (val == 'check') {
        $('#tandacheck'+no).val('uncheck');
        $('#checka'+no).removeClass('fa-square-o').addClass('fa-check-square-o');
        $('#no_dokumen'+no).addClass('noall');
        $('#pic'+no).addClass('picall');
    }else{
        $('#tandacheck'+no).val('check');
        $('#checka'+no).removeClass('fa-check-square-o').addClass('fa-square-o');
        $('#no_dokumen'+no).removeClass('noall');
        $('#pic'+no).removeClass('picall');
    }
}

function startselectedKGP() {
    var no = $('.noall').map(function(){return $(this).val();}).get();
    for (let i = 0; i < no.length; i++) {
        const n = no[i];
        MulaiChecked(n);        
    }
}

function MulaiChecked(no) {
    var valBtn = $('#btnTimerKGP'+no).val();
    var jenis_dokumen = $('#jenis_dokumen'+no).val();
    var no_dokumen = $('#no_dokumen'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var waktu = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    // console.log(jenis_dokumen);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    function setTime() {
        totalSeconds++;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
    }
    
    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
        return "0" + valString;
        } else {
        return valString;
        }
    }

    if (valBtn == 'Mulai') {
        $('#btnTimerKGP'+no).each(function() {
            $('#btnTimerKGP'+no).val('Selesai'); 
            $('#mulai'+no).val(waktu); 
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#pic'+no).prop("disabled", true); 

            if (!timer) {
                timer = setInterval(setTime, 1000);
            }
        })
        $.ajax ({
            url : baseurl + "KapasitasGdPusat/Pengeluaran/getMulai",
            data: { 
                date : date , 
                jenis_dokumen : jenis_dokumen, 
                no_dokumen : no_dokumen, 
                pic : pic
            },
            type : "POST",
            dataType: "html"
            });
        
    }
}

//----------------------------------------- Selesai Checked -----------------------------------------------
function finishselectedKGP() {
    // $('#modalDetailDOK').modal({backdrop: 'static', keyboard: false}); //disable allow outside click
    $('#modalDetailDOK').modal();

    var no_dokumen = $('.noall').map(function(){return $(this).val();}).get();
    // console.log(no_dokumen);

    $.ajax({
        url: baseurl + 'KapasitasGdPusat/Pengeluaran/getDetail',
        type: 'POST',
        data: {
            no_dokumen: no_dokumen
        },
        beforeSend: function() {
            $('#loadingAreaDetail').show();
            $('div.table_detail').hide();
        },
        success: function(result) {
            $('#loadingAreaDetail').hide();
            $('div.table_detail').show();
            $('div.table_detail').html(result);
            run99();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
        }
    });
}

async function run99(){
    var no_dokumen = $('.noall').map(function(){return $(this).val();}).get();
    // console.log(no_dokumen.length);
    for (let i = 0; i < no_dokumen.length; i++) {
      const cek = await getDetailItem(no_dokumen[i]); 
      
    }
}

function getDetailItem(no) {
    return new Promise((resolve, reject) =>{
        var no_dokumen = $('#no_dok'+no).val();
        $.ajax({
            url: baseurl + 'KapasitasGdPusat/Pengeluaran/getDetailItem',
            type: 'POST',
            datatype: 'html',
            data: {
                no_dokumen: no_dokumen
            },
            beforeSend: function() {
                // console.log(no, 'sedang mengambil')
                $('#loadingAreaDetail2').show();
                $('div.table_detail_item_'+no).hide();
            },
            success: function(result) {
                $('#loadingAreaDetail2').hide();
                $('div.table_detail_item_'+no).show();
                $('div.table_detail_item_'+no).html(result); 
                // console.log(result, 'hasilnya');
                resolve(1);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
            }
        });
    })
}

//----------------------------------------- Modal -----------------------------------------------

function btnHapusDetailKGP(nodok, no) {
    var no_dokumen = $('#no_dokumen_'+nodok+'_'+no).val();
    var item = $('#item_'+nodok+'_'+no).val();
    // console.log(no_dokumen, item);

    Swal.fire({
        title: "Anda Yakin?",
        text: "Data Akan Di Hapus",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        // console.log(result);
        if (result.value) {
            var request = $.ajax({
                url: baseurl + "KapasitasGdPusat/Pengeluaran/hpsDetailDok",
                data: {
                    no_dokumen: no_dokumen,
                    item: item
                },
                type: "POST",
                datatype: "html",
            });
            request.done(function (result) {
                Swal.fire({
                    position: "top",
                    type: "success",
                    title: "Berhasil Dihapus",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    // window.location.reload();
                    $.ajax({
                        url: baseurl + 'KapasitasGdPusat/Pengeluaran/getDetailItem',
                        type: 'POST',
                        data: {
                            no_dokumen: no_dokumen
                        },
                        beforeSend: function() {
                            $('#loadingAreaDetail2').show();
                            $('div.table_detail_item_'+no_dokumen).hide();
                        },
                        success: function(result) {
                            $('#loadingAreaDetail2').hide();
                            $('div.table_detail_item_'+no_dokumen).show();
                            $('div.table_detail_item_'+no_dokumen).html(result);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.error();
                        }
                    })
                });
            });
        }
    })
    
}

function btnEditQtyKGP(nodok, no) {
    // console.log(nodok, no);
    var no_dokumen = $('#no_dokumen_'+nodok+'_'+no).val();
    var item = $('#item_'+nodok+'_'+no).val();
    var desc = $('#desc_'+nodok+'_'+no).val();
    var qty = $('#qty_'+nodok+'_'+no).val();
    // console.log(no_dokumen, item, qty);
    Swal.fire({
        title: 'Edit Quantity '+item+' ('+desc+')',
        input: 'text',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        inputValue: qty,
        inputPlaceholder: 'Masukkan Quantity Baru',
    }).then(function (result) {
        if (result.value) {
            var request = $.ajax({
                url: baseurl + "KapasitasGdPusat/Pengeluaran/editQty",
                data: {
                    no_dokumen: no_dokumen,
                    item: item,
                    qty : result.value
                },
                type: "POST",
                datatype: "html",
            });
            request.done(function (result) {
                Swal.fire({
                    position: "top",
                    type: "success",
                    title: "Berhasil Diupdate",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    // window.location.reload();
                    $.ajax({
                        url: baseurl + 'KapasitasGdPusat/Pengeluaran/getDetailItem',
                        type: 'POST',
                        data: {
                            no_dokumen: no_dokumen
                        },
                        beforeSend: function() {
                            $('#loadingAreaDetail2').show();
                            $('div.table_detail_item_'+no_dokumen).hide();
                        },
                        success: function(result) {
                            $('#loadingAreaDetail2').hide();
                            $('div.table_detail_item_'+no_dokumen).show();
                            $('div.table_detail_item_'+no_dokumen).html(result);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.error();
                        }
                    })
                });
            });
        }
    });
}

function selesaikan(){
    var no = $('.no_dok_selesai').map(function(){return $(this).val();}).get();
    var pic = $('.pic_selesai').map(function(){return $(this).val();}).get();
    var pic_finish = $('#picfinish').val();
    // console.log(no, pic, 'pic_all', pic_finish);
    $("#modalDetailDOK").modal('hide');
    var j = 0;
    for (let i = 0; i < no.length; i++) {
        if (pic[i] == pic_finish) {
            j = j + 1;
            // console.log(j);
        }       
    }
    for (let i = 0; i < no.length; i++) {
        const n = no[i];
        SelesaiSemua(n, pic_finish, j);  
    }
}

function SelesaiSemua(no, pic_finish, j) {
    var valBtn = $('#btnTimerKGP'+no).val();
    var jenis_dokumen = $('#jenis_dokumen'+no).val();
    var no_dokumen = $('#no_dokumen'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var waktu  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    // console.log(valBtn, jenis_dokumen, no_dokumen, pic, waktu);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    function setTime() {
        totalSeconds++;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
    }
    
    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
        return "0" + valString;
        } else {
        return valString;
        }
    }

    if(valBtn == 'Selesai' && pic == pic_finish){
        $('#btnTimerKGP'+no).attr("disabled", "disabled"); 
        var mulai  = $('#mulai'+no).val();
        $('#timer'+no).css('display','none');     

        $.ajax ({
        url : baseurl + "KapasitasGdPusat/Pengeluaran/getSelesai2",
        data: { 
            date : date,
            jenis_dokumen : jenis_dokumen,
            no_dokumen : no_dokumen, 
            mulai : mulai,
            waktu : waktu, 
            pic : pic, 
            j : j
        },
        success: function (response) {
            location.reload();
        },
        type : "POST",
        dataType: "html"
        });
    }
}

//------------------------------------------- Monitoring Pengeluaran -------------------------------------------
$(document).ready(function () {
    $(".picKGP").select2({
        allowClear: false,
        placeholder: "",
        minimumInputLength: 2,
        ajax: {
            url: baseurl + "KapasitasGdPusat/Pengeluaran/getPIC",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.PIC, text:obj.PIC};
                    })
                };
            }
        }
    });
});

$('#search_by_kgp').change(function(){
    var value = $('#search_by_kgp').val()

    if(value == "dokumen"){
        $('#slcnodoc').css('display', '')
        $('#slcjenis').css('display', '')
        $('#slcTgl').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('#pic').select2('val','');
        $('#jenis_dokumen').select2('val','');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('input[name="item"]').val('');
    }else if(value == "tanggal"){
        $('#slcTgl').css('display', '')
        $('#slcnodoc').css('display', 'none');
        $('#slcjenis').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('#pic').select2('val','');
        $('input[name="no_document"]').val('');
        $('#jenis_dokumen').select2('val','');
        $('input[name="item"]').val('');
    }else if(value == "pic"){
        $('#slcPIC').css('display', '')
        $('#slcTgl').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcjenis').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('#jenis_dokumen').select2('val','');
        $('input[name="item"]').val('');
    }else if(value == "item"){
        $('#slcItem').css('display', '')
        $('#slcTgl').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcjenis').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('#pic').select2('val','');
        $('#jenis_dokumen').select2('val','');
    }else if(value == "export"){
        $('#slcjenis').css('display', '')
        $('#slcTgl').css('display', '');
        $('#slcDokumen').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('#jenis_dokumen').select2('val','');
        $('input[name="item"]').val('');
        $('#pic').select2('val','');
    }else if(value == "belumterlayani" || value == 'tanpa_surat'){
        $('#slcjenis').css('display', 'none')
        $('#slcTgl').css('display', 'none');
        $('#slcDokumen').css('display', 'none');
        $('#slcPIC').css('display', 'none');
        $('#slcnodoc').css('display', 'none');
        $('#slcItem').css('display', 'none');
        $('input[name="no_document"]').val('');
        $('input[name="tglAwal"]').val('');
        $('input[name="tglAkhir"]').val('');
        $('#jenis_dokumen').select2('val','');
        $('input[name="item"]').val('');
        $('#pic').select2('val','');
    }
})

$('.dateKGP').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
    todayHighlight: true
})

$('.dateKGPRekap').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true
})

function getMonPengeluaran(th) {
    var search_by       = $('#search_by_kgp').val();
    var jenis_dokumen   = $('#jenis_dokumen').val();
    var no_dokumen      = $('input[name="no_dokumen"]').val();
    var tglAwal         = $('input[name="tglAwal"]').val();
    var tglAkhir        = $('input[name="tglAkhir"]').val();
    var pic             = $('#pic').val();
    var item            = $('input[name="item"]').val();
    var subinv          = $('#subinv').val();

    var request = $.ajax({
        url: baseurl+'KapasitasGdPusat/MonitoringPengeluaran/getMonPengeluaran',
        data: {
            search_by       : search_by,
            jenis_dokumen   : jenis_dokumen, 
            no_dokumen      : no_dokumen, 
            tglAwal         : tglAwal, 
            tglAkhir        : tglAkhir, 
            pic             : pic, 
            item            : item,
            subinv          : subinv
        },
        type: "POST",
        datatype: 'html'
	});
	$('#tbl_monpengeluaran').html('');
	$('#tbl_monpengeluaran').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
	request.done(function(result){
        $('#tbl_monpengeluaran').html(result);
    })
}

function addDetailKGP(no){
	$('#detail'+no).slideToggle('slow');
}

//------------------------------------------ Pasang Ban ------------------------------------------------------
$(document).ready(function () {
    var siap1 = document.getElementById("persiapan_line1");
    if (siap1) {
        view_pasangban('siap1', 'persiapan_line1', 'primary');
    }
    var siap2 = document.getElementById("persiapan_line2");
    if (siap2) {
        view_pasangban('siap2', 'persiapan_line2', 'primary');
    }
    var pasang1 = document.getElementById("pasang_line1");
    if (pasang1) {
        view_pasangban('pasang1', 'pasang_line1', 'success');
    }
    var pasang2 = document.getElementById("pasang_line2");
    if (pasang2) {
        view_pasangban('pasang2', 'pasang_line2', 'success');
    }

    
    $(document).on('change', '.no_induk_siap1:last',  function() {
        var noind = $('.no_induk_siap1:last').val();
        get_username(noind, 'siap1');
    })
    $(document).on('change', '.no_induk_siap2:last',  function() {
        var noind = $('.no_induk_siap2:last').val();
        get_username(noind, 'siap2');
    })
    $(document).on('change', '.no_induk_pasang1:last',  function() {
        var noind = $('.no_induk_pasang1:last').val();
        get_username(noind, 'pasang1');
    })
    $(document).on('change', '.no_induk_pasang2:last',  function() {
        var noind = $('.no_induk_pasang2:last').val();
        get_username(noind, 'pasang2');
    })
})

function view_pasangban(ket, id_lokasi, warna) {
    $.ajax({
        url: baseurl + "KapasitasGdPusat/PasangBan/view_pasangban",
        type: 'POST',
        dataType: 'html',
        data: { ket : ket, warna : warna},
        cache: false,
        beforeSend: function() {
            $('#'+id_lokasi).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"></center>' );
        },
        success : function(result) {
            $('#'+id_lokasi).html(result);
            $(".getPICBan").select2({
                allowClear: false,
                placeholder: "",
                minimumInputLength: 2,
                ajax: {
                    url: baseurl + "KapasitasGdPusat/PasangBan/getUser",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                            term: params.term,
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        // console.log(data);
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.noind, text:obj.noind+' - '+obj.nama};
                            })
                        };
                    }
                }
            });
        }
    })
}

var i = 1;
function add_new_line(ket, ket2, warna) {
    $('#'+ket+'_'+ket2).append('<tr class="'+ket+'_'+ket2+'"><td><select id="no_induk" name="no_induk_'+ket+'[]" class="form-control no_induk_'+ket+' select2 getPICBan" ></select></td><td><input id="nama" name="nama_'+ket+'[]" class="form-control nama_'+ket+'" readonly></td><td><button type="button" class="btn btn-'+warna+' tombolhapus'+i+'"><i class="fa fa-minus"></i></button></td><tr>');

    $(document).on('click', '.tombolhapus'+i,  function() {
		$(this).parents('.'+ket+'_'+ket2).remove()
	});
	$(".getPICBan").select2({
        allowClear: false,
        placeholder: "",
        minimumInputLength: 2,
        ajax: {
            url: baseurl + "KapasitasGdPusat/PasangBan/getUser",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.noind, text:obj.noind+' - '+obj.nama};
                    })
                };
            }
		}
    });
}

function get_username(noind, ket) {
    $.ajax({
        url: baseurl + "KapasitasGdPusat/PasangBan/getUsername",
        type: 'POST',
        dataType: 'html',
        data: { noind : noind},
        cache: false,
        success : function(result) {
            $('.nama_'+ket+':last').val(result);
        }
    })
}

function pasangban_timer(no, ket) {
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

    var hoursLabel   = document.getElementById("hours_"+no);
    var minutesLabel = document.getElementById("minutes_"+no);
    var secondsLabel = document.getElementById("seconds_"+no);
    var totalSeconds = 0;
    var timer = null;
    // console.log(timer);

    function setTime() {
        totalSeconds++;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
        return "0" + valString;
        } else {
        return valString;
        }
    }

    if (!timer) {
        timer = setInterval(setTime, 1000);
    }
        
    if (ket == 'mulai') {
        $('#button_mulai_'+no).css('display','none');
        $('#button_selesai_'+no).css('display','');
    
        $.ajax({
            url: baseurl + "KapasitasGdPusat/PasangBan/save_mulai",
            type: 'POST',
            // dataType: 'JSON',
            data: {
                noind : $('[name="no_induk_'+no+'[]"]').map(function(){return $(this).val();}).get(),
                nama : $('[name="nama_'+no+'[]"]').map(function(){return $(this).val();}).get(),
                ket : no,
                date : date
            },
            cache: false,
        })
    }
    else if(ket == 'selesai'){
        if (timer) {
            clearInterval(timer);
        }
        Swal.fire({
            title: 'Jumlah Aktual : ',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'OK',
            showLoaderOnConfirm: true,
        }).then(result => {
            if (result.value) {
                $('#button_selesai_'+no).attr('disabled','disabled');
                $('#button_pause_'+no).attr('disabled','disabled');
                $('#button_restart_'+no).attr('disabled','disabled');

                $.ajax({
                    type: "POST",
                    url: baseurl + "KapasitasGdPusat/PasangBan/save_selesai",
                    data: { 
                        noind : $('[name="no_induk_'+no+'[]"]').map(function(){return $(this).val();}).get(),
                        ket : no,
                        date : date,
                        wkt : wkt,
                        jumlah: result.value 
                    },
                    success: function (response) {
                        location.reload();
                    },
                });
        }})
        
    }
    
}

//---------------------------------------------- Rekap ----------------------------------------------------
function addRinKOM(th){
	var title = $(th).text();
	$('#RinSelesaiKOM').slideToggle('slow');
	$('#RinTanggunganKOM').slideToggle('slow');
}

function addRinPNL(th){
	var title = $(th).text();
	$('#RinSelesaiPNL').slideToggle('slow');
	$('#RinTanggunganPNL').slideToggle('slow');
}

function addRinFG(th){
	var title = $(th).text();
	$('#RinSelesaiFG').slideToggle('slow');
	$('#RinTanggunganFG').slideToggle('slow');
}

function addRinPasangBan(th){
	var title = $(th).text();
	$('#RinPasangBan').slideToggle('slow');
}

function addRinKOM_src(th, num){
	var title = $(th).text();
	$('#RinSelesaiKOM'+num).slideToggle('slow');
	$('#RinTanggunganKOM'+num).slideToggle('slow');
}

function addRinPNL_src(th, num){
	var title = $(th).text();
	$('#RinSelesaiPNL'+num).slideToggle('slow');
	$('#RinTanggunganPNL'+num).slideToggle('slow');
}

function addRinFG_src(th, num){
	var title = $(th).text();
	$('#RinSelesaiFG'+num).slideToggle('slow');
	$('#RinTanggunganFG'+num).slideToggle('slow');
}

function addRinPasangBan_src(th, num){
	var title = $(th).text();
	$('#RinPasangBan'+num).slideToggle('slow');
}

function schRekap(th) {
	$(document).ready(function(){
	var tglAkh = $('#tglAkhir').val();
	var tglAwl = $('#tglAwal').val();
	// console.log(tglAwl);
	var request = $.ajax({
        url: baseurl+'KapasitasGdPusat/Rekap/searchRekap',
        data: {	
            tglAkh : tglAkh, 
            tglAwl : tglAwl },
        type: "POST",
        datatype: 'html'
	});
	$('#tb_Rekap').html('');
	$('#tb_Rekap').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_Rekap').html('');
        $('#tb_Rekap').html(result);
        
        })
	});
}