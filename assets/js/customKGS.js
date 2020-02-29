//---------------------------------------------------------INPUT--------------------------------------------------------------------------------- 
function inputPSPB(th) {
	$(document).ready(function(){
    var no_spb      = $('input[name="no_spb[]"]').map(function(){return $(this).val();}).get();
    var btn_urgent  = $('input[name="btn_urgent[]"]').map(function(){return $(this).val();}).get();
    var btn_bon     = $('input[name="btn_bon[]"]').map(function(){return $(this).val();}).get();
    var btn_langsung = $('input[name="btn_langsung[]"]').map(function(){return $(this).val();}).get();
    // console.log(btn1);
    $("#mdlloading").modal({
                backdrop: 'static',
                keyboard: true, 
                show: true
        }); 
	var request = $.ajax({
        url: baseurl+'KapasitasGdSparepart/Input/',
        data: {no_spb : no_spb, btn_urgent : btn_urgent, btn_bon : btn_bon, btn_langsung : btn_langsung},
        type: "POST",
        datatype: 'html',
        success: function(data){
            $("#mdlloading").modal("hide"); 
			window.location.reload();
	    }
	});
	});
}

function btnUrgent(no) {
    var valBtn = $('#btn'+no).val();
    if (valBtn == 'Urgent') {
        $('#btn'+no).val('Batal');
        $('#btn'+no).removeClass('btn-warning').addClass('btn-success');
        document.getElementById('btn'+no).removeAttribute("style");
    }else if (valBtn == 'Batal') {
        $('#btn'+no).val('Urgent');
        $('#btn'+no).removeClass('btn-success').addClass('btn-warning');
        document.getElementById('btn'+no).style.color = 'black';
    }
}

function btnBonKgs(no) {
    var valbon = $('#btnbon'+no).val();
    if (valbon == 'Bon') {
        $('#btnbon'+no).val('Batal');
        $('#btnbon'+no).removeClass('btn-default').addClass('btn-danger');
    }else if (valbon == 'Batal') {
        $('#btnbon'+no).val('Bon');
        $('#btnbon'+no).removeClass('btn-danger').addClass('btn-default');
    }
}

function btnLangsungKgs(no) {
    var langsung = $('#btnlangsung'+no).val();
    if (langsung == 'Langsung') {
        $('#btnlangsung'+no).val('Batal');
        $('#btnlangsung'+no).removeClass('btn-info').addClass('btn-danger');
    }else if (langsung == 'Batal') {
        $('#btnlangsung'+no).val('Langsung');
        $('#btnlangsung'+no).removeClass('btn-danger').addClass('btn-info');
    }
}

function btnCancelKGS(no) {
    var jenis = $('#jenis'+no).val();
    var nodoc = $('#nodoc'+no).val();
    console.log(jenis);
    Swal.fire({
        title: 'Apakah Anda Yakin Akan Melakukan Cancel?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $('#baris'+no).css('display', 'none');
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Input/cancelSPB",
                data: { no : no , jenis : jenis, nodoc : nodoc},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "", "success");
                    }
                });
    }})   
    
}

function btnPendingSpb(no) {
    var jenis = $('#jenis'+no).val();
    var nodoc = $('#nodoc'+no).val();
    var bon = $('#bon'+no).val();
    console.log(jenis);
    if (bon == 'PENDING') {
        Swal.fire({
            title: 'Apakah Anda Yakin Akan Menghapus Pending?',
            type: 'question',
            showCancelButton: true,
            allowOutsideClick: false
        }).then(result => {
            if (result.value) {  
                $.ajax ({
                    url : baseurl + "KapasitasGdSparepart/Tracking/deletependingSPB",
                    data: { no : no , jenis : jenis, nodoc : nodoc},
                    type : "POST",
                    dataType: "html",
                    success: function(data){
                        swal.fire("Berhasil!", "", "success");
                        window.location.reload();
                        }
                    });
        }}) 
    }else {
        Swal.fire({
            title: 'Apakah Anda Yakin Akan Melakukan Pending?',
            type: 'question',
            showCancelButton: true,
            allowOutsideClick: false
        }).then(result => {
            if (result.value) {  
                $.ajax ({
                    url : baseurl + "KapasitasGdSparepart/Tracking/pendingSPB",
                    data: { no : no , jenis : jenis, nodoc : nodoc},
                    type : "POST",
                    dataType: "html",
                    success: function(data){
                        swal.fire("Berhasil!", "", "success");
                        window.location.reload();
                        }
                    });
        }}) 
    }
      
    
}

//----------------------------------------------------------ADMIN----------------------------------------------------------------------------------

function btnAdminSPB(th) {
    var valBtn = $('#btnAdmin').val();
    var hoursLabel   = document.getElementById("hours");
    var minutesLabel = document.getElementById("minutes");
    var secondsLabel = document.getElementById("seconds");
    var totalSeconds = 0;
    //  console.log(valBtn, hoursLabel);
    if (valBtn == 'Mulai Allocate') {
        var d    = new Date();
        var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        var unix = Math.round((new Date()).getTime() / 1000);
        var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        $('#btnAdmin').each(function() {
            $('#btnAdmin').val('Selesai'); 
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#idunix').val(unix); 
            $('#mulai').val(wkt); 
            $("#btnAdmin").attr("disabled", true);
            setInterval(setTime, 1000);

            function setTime(){
                ++totalSeconds;
                secondsLabel.innerHTML = pad(totalSeconds%60);
                minutesLabel.innerHTML = pad(parseInt(totalSeconds/60));
                hoursLabel.innerHTML   = pad(parseInt(totalSeconds/(60*60)));
            }

            function pad(val) {
                var valString = val + "";
                if(valString.length < 2){
                    return "0" + valString;
                }else{
                    return valString;
                }
            }
        })

        $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Admin/saveAdmin",
            data: { date : date , valBtn : valBtn, unix : unix},
            type : "POST",
            dataType: "html"
            });
        
    }else if(valBtn == 'Selesai'){
        var jml_spb = $('#jml_spb').val();
        var unix    = $('#idunix').val();
        var mulai   = $('#mulai').val();
        var d       = new Date();
        var date    = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        var wkt     = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
        $('#btnAdmin').each(function() {
            $('#btnAdmin').val('Mulai Allocate'); 
            $(this).removeClass('btn-danger').addClass('btn-success');

        })
        
        $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Admin/",
        data: { date : date, valBtn : valBtn, jml_spb : jml_spb, unix : unix, mulai : mulai, wkt : wkt},
        type : "POST",
        dataType: "html"
        });
        window.location.reload();
    }
    
}

$('.inputQTY').change(function(){
	$('#btnAdmin').removeAttr("disabled");
})

function saveJmlSpb(th) {
    var jml_spb = $('#jml_spb').val();
    // console.log(jml_spb);

    $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Admin/saveAdminSpb",
        data: {jml_spb : jml_spb},
        type : "POST",
        dataType: "html"
        });
}




//---------------------------------------------------------PELAYANAN---------------------------------------------------------------------------

function btnPelayananSPB(no) {
    var valBtn = $('#btnPelayanan'+no).val();
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    $("#btnrestartSPB"+no).on('click',function() {
        if (timer) {
            totalSeconds = 0;
            stop();
        }
    });

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
     $('#btnPelayanan'+no).on('click',function() {
            
    })

    if (valBtn == 'Mulai') {
        $('#btnPelayanan'+no).each(function() {
            $('#btnPelayanan'+no).val('Selesai'); 
            $('#mulai'+no).val(wkt); 
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#pic'+no).prop("disabled", true); 

            if (!timer) {
                timer = setInterval(setTime, 1000);
            }
        })
        $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Pelayanan/updateMulai",
            data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
            type : "POST",
            dataType: "html"
            });
        
    }else if(valBtn == 'Selesai'){
            $('#btnPelayanan'+no).attr("disabled", "disabled"); 
            $('#btnrestartSPB'+no).attr("disabled", "disabled"); 
            var mulai  = $('#mulai'+no).val();
            $('#timer'+no).css('display','none');     

            $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Pelayanan/updateSelesai",
            data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
            type : "POST",
            dataType: "html"
            });
    }
    
}

function btnRestartPelayanan(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     console.log(jenis, no_spb);

        // console.log(jenis);
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text : 'Restart akan dilakukan...',
            type: 'question',
            showCancelButton: true,
            allowOutsideClick: false
        }).then(result => {
            if (result.value) {  
                $('#mulai'+no).val(wkt); 
                $("#btnrestartSPB"+no).removeClass('btn-info').addClass('btn-warning');
                $.ajax ({
                    url : baseurl + "KapasitasGdSparepart/Pelayanan/updateMulai",
                    data: {jenis : jenis, no_spb : no_spb, date : date, pic : pic},
                    type : "POST",
                    dataType: "html",
                    success: function(data){
                        swal.fire("Berhasil!", "Restart telah dilakukan.", "success");
                    }
                });
        }})  
}

function btnPausePelayanan(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var mulai  = $('#mulai'+no).val();
    var d    = new Date();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();   

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text : 'Pause akan dilakukan...',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $('#timer'+no).css('display','none');  
            $('#btnrestartSPB'+no).attr("disabled", "disabled"); 
            $('#btnPelayanan'+no).attr("disabled", "disabled"); 
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pelayanan/pauseSPB",
                data: {jenis : jenis, no_spb : no_spb, wkt : wkt, mulai : mulai},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Waktu telah ditunda.", "success");
                }
            });
    }})
}

$(document).ready(function () {
	$(".picSPB").select2({
        allowClear: false,
        placeholder: "",
        minimumInputLength: 2,
        ajax: {
            url: baseurl + "KapasitasGdSparepart/Pelayanan/getPIC",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.PIC, text:obj.PIC};
                    })
                };
            }
		}
	});
});

//----------------------------------------------------------PENGELUARAN--------------------------------------------------------------------------

function btnPengeluaranSPB(no) {
    var valBtn = $('#btnPengeluaran'+no).val();
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    $("#btnrestartSPB"+no).on('click',function() {
        if (timer) {
            totalSeconds = 0;
            stop();
        }
    });

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
     $('#btnPengeluaran'+no).on('click',function() {
            
    })

    if (valBtn == 'Mulai') {
        $('#btnPengeluaran'+no).each(function() {
            $('#btnPengeluaran'+no).val('Selesai'); 
            $('#mulai'+no).val(wkt); 
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#pic'+no).prop("disabled", true); 

            if (!timer) {
                timer = setInterval(setTime, 1000);
            }
        })
        $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateMulai",
            data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
            type : "POST",
            dataType: "html"
            });
        
    }else if(valBtn == 'Selesai'){
            $('#btnPengeluaran'+no).attr("disabled", "disabled"); 
            $('#btnrestartSPB'+no).attr("disabled", "disabled"); 
            var mulai  = $('#mulai'+no).val();
            $('#timer'+no).css('display','none');      

            $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateSelesai",
            data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
            type : "POST",
            dataType: "html"
            });
    }
}

function btnRestartPengeluaran(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     console.log(jenis, no_spb);

     Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: 'Restart akan dilakukan...',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $('#mulai'+no).val(wkt); 
            $("#btnrestartSPB"+no).removeClass('btn-info').addClass('btn-warning');
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateMulai",
                data: {jenis : jenis, no_spb : no_spb, date : date, pic : pic},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Restart telah dilakukan.", "success");
                }
            });
    }})  
}

function btnPausePengeluaran(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var mulai  = $('#mulai'+no).val();
    var d      = new Date();
    var wkt    = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $('#timer'+no).css('display','none'); 
            $('#btnPengeluaran'+no).attr("disabled", "disabled"); 
            $('#btnrestartSPB'+no).attr("disabled", "disabled");  
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pengeluaran/pauseSPB",
                data: {jenis : jenis, no_spb : no_spb, wkt : wkt, mulai : mulai},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Waktu telah ditunda.", "success");
                    }
            });
    }})    
}

//----------------------------------------------------------PACKING--------------------------------------------------------------------------------


function btnPackingSPB(no) {
    var valBtn = $('#btnPacking'+no).val();
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    $("#btnrestartSPB"+no).on('click',function() {
        if (timer) {
            totalSeconds = 0;
            stop();
        }
    });

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
     $('#btnPacking'+no).on('click',function() {
            
    })

    if (valBtn == 'Mulai') {
        $('#btnPacking'+no).each(function() {
            $('#btnPacking'+no).val('Selesai'); 
            $('#mulai'+no).val(wkt); 
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#pic'+no).prop("disabled", true); 
            $('#btnPack'+no).css('display', '');

            if (!timer) {
                timer = setInterval(setTime, 1000);
            }
        })
        $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Packing/updateMulai",
            data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
            type : "POST",
            dataType: "html"
            });
        
    }else if(valBtn == 'Selesai'){
            $('#btnPacking'+no).attr("disabled", "disabled"); 
            $('#btnrestartSPB'+no).attr("disabled", "disabled"); 
            var mulai  = $('#mulai'+no).val();
            $('#timer'+no).css('display','none');     
            $('#btnPack'+no).attr("disabled", "disabled"); 
                   
            $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Packing/updateSelesai",
            data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
            type : "POST",
            dataType: "html"
            });

        //     var mulai  = $('#mulai'+no).val();   
                   
        //     var request = $.ajax ({
        //     url : baseurl + "KapasitasGdSparepart/Packing/modalColly",
        //     data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic, no : no},
        //     type : "POST",
        //     dataType: "html"
        //     });
        //     request.done(function(result){
        //         $('#datahidden').html(result);
        //         $('#mdlcolly').modal({
        //             backdrop: 'static',
        //             keyboard: true, 
        //             show: true
        //     }); 
        // });
    }
}

function modalPacking(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var mulai  = $('#mulai'+no).val();  
    
    var request = $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Packing/modalColly",
        data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic, no : no},
        type : "POST",
        dataType: "html"
        });
        request.done(function(result){
            $('#datahidden').html(result);
            $('#mdlcolly').modal('show');
    });
}

function savePacking(th) {
    var no_spb       = $('#no_spb').val();
    var jenis_kemasan    = $('#jenis_kemasan').val();   
    var berat        = $('#berat').val();   
    var no           = $('#no').val();   
    
    if (berat == '' || jenis_kemasan == '') {
        $('#peringatan').html('Mohon Isi Konfirmasi Packing!!');
    }else{
        // $('#peringatan').html('Sudah save');
        $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Packing/saveberatPacking",
            data: { no_spb : no_spb, jenis_kemasan : jenis_kemasan, berat : berat},
            type : "POST",
            dataType: "html",
            success: function(data){
                $("#mdlcolly").modal("hide");
                $('#berat').val('');
                $('#jenis_kemasan').select2("val", "");
                $('#peringatan').html('');
                // $('#btnPacking'+no).attr("disabled", "disabled"); 
                // $('#btnrestartSPB'+no).attr("disabled", "disabled"); 
                // $('#timer'+no).css('display','none');
            }
        });  
    }
}

function btnRestartPacking(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     console.log(jenis, no_spb);

     Swal.fire({
        title: 'Apakah Anda Yakin Akan Melakukan Restart?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $('#mulai'+no).val(wkt); 
            $("#btnrestartSPB"+no).removeClass('btn-info').addClass('btn-warning');
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Packing/updateMulai",
                data: {jenis : jenis, no_spb : no_spb, date : date, pic : pic},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Restart telah dilakukan.", "success");
                }
            });
    }})  
}

function btnPausePacking(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var mulai  = $('#mulai'+no).val();
    var d    = new Date();
    var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

    Swal.fire({
        title: 'Apakah Anda Yakin Akan Melakukan Pause?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $('#btnPacking'+no).attr("disabled", "disabled");  
            $('#btnrestartSPB'+no).attr("disabled", "disabled");
            $('#timer'+no).css('display','none');  
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Packing/pauseSPB",
                data: {jenis : jenis, no_spb : no_spb, wkt : wkt, mulai : mulai},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Waktu telah ditunda.", "success");
                    }
                });
    }})   
    
}

//----------------------------------------------------MONITORING-------------------------------------------------------------------------

function addDoSpb(th){
	var title = $(th).text();
	$('#DoSpb').slideToggle('slow');
}

function addDoSpb2(th, num){
	var title = $(th).text();
	$('#DoSpb'+num).slideToggle('slow');
}

function addRinPelayanan1(th){
	var title = $(th).text();
	$('#RinPelayanan1').slideToggle('slow');
	$('#RinPelayanan2').slideToggle('slow');
}

function addRinPelayanan2(th, num){
	var title = $(th).text();
	$('#RinPelayanan1'+num).slideToggle('slow');
	$('#RinPelayanan2'+num).slideToggle('slow');
}

function addRinPengeluaran1(th){
	var title = $(th).text();
	$('#RinPengeluaran1').slideToggle('slow');
	$('#RinPengeluaran2').slideToggle('slow');
}

function addRinPengeluaran2(th, num){
	var title = $(th).text();
	$('#RinPengeluaran1'+num).slideToggle('slow');
	$('#RinPengeluaran2'+num).slideToggle('slow');
}

function addRinPacking1(th){
	var title = $(th).text();
	$('#RinPacking1').slideToggle('slow');
	$('#RinPacking2').slideToggle('slow');
}

function addRinPacking2(th, num){
	var title = $(th).text();
	$('#RinPacking1'+num).slideToggle('slow');
	$('#RinPacking2'+num).slideToggle('slow');
}


function schMonitoringSPB(th) {
	$(document).ready(function(){
	var tglAkh = $('#tglAkhir').val();
	var tglAwl = $('#tglAwal').val();
	// console.log(tglAwl);
	var request = $.ajax({
        url: baseurl+'KapasitasGdSparepart/Monitoring/searchSPB',
        data: {	tglAkh : tglAkh, tglAwl : tglAwl },
        type: "POST",
        datatype: 'html'
	});
	$('#tb_MonSPB').html('');
	$('#tb_MonSPB').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_MonSPB').html('');
        $('#tb_MonSPB').html(result);
        
        })
	});
}

//------------------------------------------------------------ PENYERAHAN ---------------------------------------------------------------------

function getDataPenyerahan(th) {
    var tglAwal = $('#tglAwal').val();

    var request = $.ajax({
        url: baseurl+'KapasitasGdSparepart/Penyerahan/getData',
        data: {tglAwal : tglAwal },
        type: "POST",
        datatype: 'html'
	});
	$('#tb_penyerahan').html('');
	$('#tb_penyerahan').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_penyerahan').html('');
        $('#tb_penyerahan').html(result);
        
    })
}
