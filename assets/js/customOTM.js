
$(document).ready(function () {
    var siapa = $('#siapa').val(); // resp yg dibuka user login
    var cariotm = document.getElementById("ordertoolmaking");
    if (cariotm) {
        $.ajax({ // tampilkan tabel data modifikasi
            url: baseurl + 'OrderToolMaking/MonitoringOrder/TblModifikasi',
            data : { siapa : siapa},
            type: 'POST',
            beforeSend: function() {
              $('div#tb_modifikasiorder' ).html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
            },
            success: function(result) {
                $('div#tb_modifikasiorder').html(result);
                var tabel = $('#tbmodif').DataTable({
                    "scrollX": true,
                });
                $('#search_otm').on( 'keyup', function () {
                    tabel.search( this.value ).draw()
                } );
            }
        });
        
        $.ajax({ // tampilkan tabel data rekondisi
            url: baseurl + 'OrderToolMaking/MonitoringOrder/TblRekondisi',
            data : { siapa : siapa},
            type: 'POST',
            beforeSend: function() {
                $('div#tb_rekondisiorder' ).html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
            },
            success: function(result) {
                $('div#tb_rekondisiorder').html(result);
                var tabel = $('#tbrekon').DataTable({
                    "scrollX": true,
                });
                $('#search_otm').on( 'keyup', function () {
                    tabel.search( this.value ).draw();
                } );
            }
        })
    
        $.ajax({ // tampilkan tabel data baru
            url: baseurl + 'OrderToolMaking/MonitoringOrder/TblBaru',
            data : { siapa : siapa},
            type: 'POST',
            beforeSend: function() {
                $('div#tb_baruorder' ).html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
            },
            success: function(result) {
                $('div#tb_baruorder').html(result);
                var tabel = $('#tbbaru').DataTable({
                    "scrollX": true,
                });
                $('#search_otm').on( 'keyup', function () {
                    tabel.search( this.value ).draw();
                } );
            }
        })
    }

    // $(document).on("ifChecked", ".ganti", function () { //request order modifikasi / rekondisi 
    $(".ganti").change(function(){ //request order modifikasi / rekondisi 
        $('.baru').css('display','none');
        $('.modifrekon').css('display','');
        $('.baru2').prop('required',false);
        $('.modifrekon2').prop('required',true);
        $('.barukhususgauge2').prop('required',false);
        $('#user_baru').select2('val','');
        $('#user_baru').prop('required',false);
        $('#user_mr').prop('required',true);
    })
    
    // $(document).on("ifChecked", ".gantibaru", function () { // request order baru
    $(".gantibaru").change(function(){ // request order baru
        $('.baru').css('display','');
        $('.modifrekon').css('display','none');
        $('.baru2').prop('required',true);
        $('.modifrekon2').prop('required',false);
        $('.barukhususgauge2').prop('required',false);
        $('#user_mr').select2('val','');
        $('#user_baru').prop('required',true);
        $('#user_mr').prop('required',false);
        var jenis = $('#jenis').val(); // tampilkan inputan khusus baru berdasarkan jenis (misal sudah pilih jenis)
        if (jenis == 'GAUGE') {
            $('.khususdies').css('display', 'none');
            $('.khususgauge').css('display', '');
            $('.barukhususgauge2').prop('required',false);
        }else if(jenis == 'DIES'){
            $('.khususdies').css('display', '');
            $('.khususgauge').css('display', 'none');
            $('.barukhususgauge2').prop('required',true);
        }else{
            $('.khususgauge').css('display', 'none');
            $('.khususdies').css('display', 'none');
            $('.barukhususgauge2').prop('required',false);
        }
    })
    $("#jenis").change(function(){ // pilih jenis
        var jenis = $('#jenis').val();
        var keterangan = $('input[name="order"]:checked').val(); // order baru/ modifikasi/ rekondisi
        // console.log(keterangan);
        if (jenis == 'FIXTURE') {
            $('#inputjenis').removeClass('col-md-7').addClass('col-md-4');
            $('#tambahinputan' ).html('<input id="ture" name= "fixture" class="form-control" placeholder="fixture" required>' );
            $('#dimensi').attr('disabled', 'disabled');
            $('.khususgauge').css('display', 'none');
            $('.khususdies').css('display', 'none');
            $('.material').attr('disabled', 'disabled');
            $('.lembar').attr('disabled', 'disabled');
            $('.lembar').val('');
        }else if (jenis == 'MASTER') {
            $('#inputjenis').removeClass('col-md-7').addClass('col-md-4');
            $('#tambahinputan' ).html('<input id="ter" name="master" class="form-control" placeholder="master" required>' );
            $('#dimensi').attr('disabled', 'disabled');
            $('.khususgauge').css('display', 'none');
            $('.khususdies').css('display', 'none');
            $('.material').attr('disabled', 'disabled');
            $('.lembar').attr('disabled', 'disabled');
            $('.lembar').val('');
        }else if (jenis == 'GAUGE') {
            $('#inputjenis').removeClass('col-md-7').addClass('col-md-4');
            $('#tambahinputan' ).html('<input id="uge" name="gauge" class="form-control" placeholder="gauge" required>' );
            $('#dimensi').removeAttr('disabled');
            if (keterangan == 'BARU') { // khusus order 'baru'
                $('.khususgauge').css('display', '');
            }
            $('.khususdies').css('display', 'none');
            $('.material').attr('disabled', 'disabled');
            $('.lembar').attr('disabled', 'disabled');
            $('.lembar').val('');
        }else if (jenis == 'ALAT LAIN') {
            $('#inputjenis').removeClass('col-md-7').addClass('col-md-4');
            $('#tambahinputan' ).html('<input class="form-control" id="lain" name="alat_lain" placeholder="alat lain" autocomplete="off" required>' );
            $('#dimensi').attr('disabled', 'disabled');
            $('.khususgauge').css('display', 'none');
            $('.khususdies').css('display', 'none');
            $('.material').attr('disabled', 'disabled');
            $('.lembar').attr('disabled', 'disabled');
            $('.lembar').val('');
        }else if(jenis == 'DIES'){
            $('#inputjenis').removeClass('col-md-4').addClass('col-md-7');
            $('#tambahinputan' ).html('');
            $('.khususgauge').css('display', 'none');
            if (keterangan == 'BARU') { // khusus order 'baru'
                $('.khususdies').css('display', '');
            }
            $('.material').removeAttr('disabled');
            $('.iradio_flat-blue').removeClass('disabled');
            $('#dimensi').attr('disabled', 'disabled');
        }else{
            $('#inputjenis').removeClass('col-md-4').addClass('col-md-7');
            $('#tambahinputan' ).html('');
            $('#dimensi').attr('disabled', 'disabled');
            $('.khususgauge').css('display', 'none');
            $('.khususdies').css('display', 'none');
            $('.material').attr('disabled', 'disabled');
            $('.lembar').attr('disabled', 'disabled');
            $('.lembar').val('');
        }
    });

    // $(document).on("ifChecked", "#lembar", function () {
    $("#lembar").change(function(){
        $('.lembar').removeAttr('disabled');
    })

    // $(document).on("ifChecked", "#afval", function () {
    $("#afval").change(function(){
        $('.lembar').attr('disabled', 'disabled');
        $('.lembar').val('');
    })

    // $(document).on("ifChecked", "#multi", function () {
    $("#multi").change(function(){
        $('#isi_multi').removeAttr('disabled');
    })

    // $(document).on("ifChecked", "#tunggal", function () {
    $("#tunggal").change(function(){
        $('#isi_multi').attr('disabled', 'disabled');
        $('#isi_multi').val('');
    })


    $(".userorder").select2({
        allowClear: true,
        placeholder: "user",
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "OrderToolMaking/MonitoringOrder/getUser",
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
                        return {id:obj.NAMA_USER, text:obj.NAMA_USER};
                    })
                };
            }
        }
    });
    
    $(".assignorder").select2({
        allowClear: true,
        placeholder: "assign approval",
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "OrderToolMaking/MonitoringOrder/getAssign",
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
                        return {id:obj.user_name, text:obj.user_name+' - '+obj.employee_name};
                    })
                };
            }
        }
    });

    // preview gambar setelah dipilih
    $("#img_gamker").change(function(){
        readURLGamker(this);
    });
    $("#img_skets").change(function(){
        readURLSkets(this);
    });

    
})

function readURLGamker(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#view_gamker').css("display","block");             
            $('#previewgamker').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function readURLSkets(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#view_skets').css("display","block");             
            $('#previewskets').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function viewmodif(no) { // view detail tabel modifikasi
    var no_order 	= $('#no_order_modif'+no).val();
    var status 	    = $('#status_modif'+no).val();
    var apa         = 'Modifikasi'; // tabel modifikasi
    var siapa 	    = $('#siapa').val(); // resp yg dibuka user login
    if (siapa == 'Kasie Pengorder') { // resp order tool making
        var tujuan = 'OrderToolMaking/MonitoringOrder/ViewModifikasi';
    }else{
        var tujuan = 'ApprovalToolMaking/MonitoringOrder/ViewModifikasi';
    }
    var request = $.ajax({
        url: baseurl+tujuan,
        data: { no_order : no_order, siapa : siapa, status : status},
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datamodifrekon').html(result);
        $('#mdlOrderMonitoring').modal('show');
        $('.datepickorder').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoClose: true
        }).on('change', function(){
            $('.datepicker').hide();
        });
        revisiorderyuhuuu(apa, siapa);
    });
}

function viewrekon(no) { // view detail tabel rekondisi
    var no_order 	= $('#no_order_rekon'+no).val();
    var status 	    = $('#status_rekon'+no).val();
    var apa         = 'Rekondisi'; // tabel rekondisi
    var siapa 	    = $('#siapa').val(); // resp yg dibuka user login
    if (siapa == 'Kasie Pengorder') { // resp order tool making
        var tujuan = 'OrderToolMaking/MonitoringOrder/ViewRekondisi';
    }else{
        var tujuan = 'ApprovalToolMaking/MonitoringOrder/ViewRekondisi';
    }
    var request = $.ajax({
        url: baseurl+tujuan,
        data: { no_order : no_order, siapa : siapa, status : status},
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datamodifrekon').html(result);
        $('#mdlOrderMonitoring').modal('show');
        $('.datepickorder').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoClose: true
        }).on('change', function(){
            $('.datepicker').hide();
        });
        revisiorderyuhuuu(apa, siapa);
    });
}

function viewbaru(no) { // view detail tabel baru
    var no_order 	= $('#no_order_baru'+no).val();
    var status  	= $('#status_baru'+no).val();
    var apa         = 'Baru'; // tabel baru
    var siapa 	    = $('#siapa').val(); // resp yg dibuka user login
    if (siapa == 'Kasie Pengorder') { // resp. order tool making
        var tujuan = 'OrderToolMaking/MonitoringOrder/ViewBaru';
    }else{
        var tujuan = 'ApprovalToolMaking/MonitoringOrder/ViewBaru';
    }
    var request = $.ajax({
        url: baseurl+tujuan,
        data: { no_order : no_order, siapa : siapa, status : status},
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datamodifrekon').html(result);
        $('#mdlOrderMonitoring').modal('show');
        $('.datepickorder').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoClose: true
        }).on('change', function(){
            $('.datepicker').hide();
        });
        revisiorderyuhuuu(apa, siapa);
    });
}

var i = 2;
function addrevkolom() { // tambah baris revisi di modal view detail
    var apa = $('#ket').val(); // view tabel yg dibuka (baru, modifikasi, rekondisi)
    var siapa = $('#siapa').val(); // resp. yg dibuka user login
    $('#tambahTarget').append('<div class="tambahtarget" ><br><br><br><div class="col-md-3"><select class="form-control select2 revisi" id="revisi'+i+'" name="revisi[]" style="width:100%"><option></option></select></div><div class="col-md-8 ganti"><input class="form-control isi_rev" id="isi_rev" name="isi_rev[]" placeholder="masukkan hasil revisi"></div><div class="col-md-1" style="text-align:left"><button class = "btn btn-default tombolhapus'+i+'" type="button"><i class = "fa fa-minus" ></i></button></div></div></div></div>');
    // ubah tinggi modal sesuai pertambahan baris revisi
    var height = $("#tinggi").val();
    var h = parseInt(height);
    var tambah_tinggi = h + 60;
    $('#tinggi').val(tambah_tinggi);
    document.getElementById('panelbiru').style.height = tambah_tinggi+'px';
    // hapus baris revisi
    $(document).on('click', '.tombolhapus'+i,  function() {
		$(this).parents('.tambahtarget').remove()
        var height = $("#tinggi").val(); // ubah tinggi modal sesuai pengurangan baris revisi
        var t = parseInt(height);
        var kurang_tinggi = t - 60;
        $('#tinggi').val(kurang_tinggi);
        document.getElementById('panelbiru').style.height = kurang_tinggi+'px';
	});
    revisiorderyuhuuu(apa, siapa);

    i++; 
}


function revisiorderyuhuuu(apa, siapa) {
    $.ajax({
        url: baseurl+("ApprovalToolMaking/MonitoringOrder/daftarrevisi"),
        data: { apa : apa, siapa : siapa, jenis : $('#jenis').val()},
        type: "POST",
        datatype: 'html',
        success : function (result) {
            $(".revisi:last").html(result);
        }
    })

    $(document).on('change', '.revisi:last',  function() {
        var rev = $('.revisi:last').val();
        var d    = new Date();
        // console.log(rev, i)
        if (rev == 'Gambar Kerja') { // hal yg direvisi
            $('.ganti:last').html('<input type="file" class="form-control" name="gamker" accept=".jpg, .png">'); // yg ditampilkan
        }else if (rev == 'Skets') {
            $('.ganti:last').html('<input type="file" class="form-control" name="skets" accept=".jpg, .png">');
        }else if (rev == 'Usulan Order Selesai') {
            $('.ganti:last').html('<div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input name="isi_rev[]" class="form-control datepickorder" placeholder="example: '+d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+'" style="width:100%" autocomplete="off"></div>');
            $('.datepickorder').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoClose: true
            }).on('change', function(){
                $('.datepicker').hide();
            });
        }else if (rev == 'Tanggal Rilis Gambar') {
            $('.ganti:last').html('<div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input name="isi_rev[]" class="form-control datepickorder" placeholder="example: '+d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+'" style="width:100%" autocomplete="off"></div>');
            $('.datepickorder').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoClose: true
            }).on('change', function(){
                $('.datepicker').hide();
            });
        }else if (rev == 'User') {
            $.ajax({
                url: baseurl+("ApprovalToolMaking/MonitoringOrder/selectUser"),
                type: "POST",
                datatype: 'html',
                success :function(result) {
                    $('.ganti:last').html(result)
                }
            });
        }else if (rev == 'Acuan Alat Bantu') {
            $('.ganti:last').html('<input type="radio" name="isi_rev[]" value="Produk">Produk <input type="radio" name="isi_rev[]" value="Gambar Produk" style="margin-left: 25px">Gambar Produk');
        }else if (rev == 'Layout Alat Bantu') {
            $('.ganti:last').html('<input type="radio" name="isi_rev[]" id="tunggal1" style="margin-left: -313px" value="Tunggal">Tunggal <input type="radio" name="isi_rev[]" id="multi1" value="Multi" style="margin-left: 23px">Multi <div class="col-md-6" style="margin-left: 130px"><input type="number" name="multi" id="isi_multi1" class="form-control" style="margin-left:20px" disabled autocomplete="off"></div>');
            $('#multi1').change(function(e) { 
                $('#isi_multi1').removeAttr('disabled');
            })

            $('#tunggal1').change(function(e) { 
                $('#isi_multi1').attr('disabled', 'disabled');
                $('#isi_multi1').val('');
            })
        }else if (rev == 'Material Blank (Khusus DIES)') {
            $('.ganti:last').html('<input type="radio" name="isi_rev[]" class="material" id="afval1" style="margin-left: -333px" value="Afval" >Afval <input style="margin-left: 38px" type="radio" name="isi_rev[]" class="material" id="lembar0" value="Lembaran">Lembaran<div class="col-md-3" style="margin-left: 150px"><input type="number" name="lembar1" class="form-control lembar1" disabled autocomplete="off"></div><div class="col-md-1 text-center" style="margin-left:-20px;margin-right:-50px"><label>X</label></div><div class="col-md-3"><input type="number" name="lembar2" class="form-control lembar1" disabled autocomplete="off"></div>');
            $('#lembar0').change(function(e) { 
                $('.lembar1').removeAttr('disabled');
            })
    
            $('#afval1').change(function(e) { 
                $('.lembar1').attr('disabled', 'disabled');
                $('.lembar1').val('');
            })
        }else if (rev == 'Tipe Produk') {
            $.ajax({
                url: baseurl+("ApprovalToolMaking/MonitoringOrder/selectTipeProduk"),
                type: "POST",
                datatype: 'html',
                success :function(result) {
                    $('.ganti:last').html(result)
                }
            });
        }else{
            $('.ganti:last').html('<input class="form-control" name="isi_rev[]" placeholder="masukkan hasil revisi" autocomplete="off">');
        }
    })
}

$(document).keypress(
function(event){
    if (event.which == '13') {
    event.preventDefault();
    }
});