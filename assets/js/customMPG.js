function getMPG(th) {
    // $(document).ready(function(){
    var noDokumen       = $('input[name="noDokumen"]').val();
    var jenis_dokumen   = $('#jenis_dokumen').val();
    // console.log(jenis_dokumen);
    
    var request = $.ajax({
        url: baseurl+'MonitoringGdSparepart/Input/input',
        data: {
            noDokumen       : noDokumen, 
            jenis_dokumen   : jenis_dokumen
        },
        type: "POST",
        datatype: 'html'
    });
    
    $('#tb_GudangSparepart').html('');
	$('#tb_GudangSparepart').html('<tr><td colspan="6"><center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center></td></tr>' );
    
    request.done(function(result){
        $('#tb_GudangSparepart').html('');
        $('#tb_GudangSparepart').html(result);
        // $('#tb_monitorGudang').dataTable({
        //     "retrieve": true,
        //     "paging" : false,
        //     "scrollX": true,
        //     "scrollCollapse": true,
        //     "fixedHeader":true
        //     });
        })
    // });
}
// no dokumen otomatis INPUT
$('#noDokumen').change(function(){
    getAutoFillDocument()
});
$('#noDokumen').keypress(function (e) {
    var key = e.which;
    if(key == 13)  // the enter key code
     {
        getAutoFillDocument()
     }
});   
// jenis dokumen otomatis INPUT
function getAutoFillDocument(){
    var no_document = $('input[name="noDokumen"]').val();

    $('input[name="no_document"]').val(no_document)

    var length = no_document.length
    // console.log(length)
    if(length == 12){
         var awl = no_document.substring(0, 3);
         if (awl == 'FPB') {
            $('#jenis_dokumen').val('FPB').trigger('change')
         }else{
            $('#jenis_dokumen').val('IO').trigger('change')
         }
    }else if(length == 5){
        $('#jenis_dokumen').val('LPPB').trigger('change')
    }else if(length == 9) {
        $('#jenis_dokumen').val('KIB').trigger('change')
    }else{
        var awl = no_document.substring(0, 5);
        if (awl) {
            $('#jenis_dokumen').val('SPBSPI').trigger('change')
        }else{
            $('#jenis_dokumen').val('').trigger('change')
        }
    }
}

function getMGS(th) {
    // $(document).ready(function(){
    var search_by       = $('#search_by').val();
    var jenis_dokumen   = $('#jenis_dokumen').val();
    var no_document     = $('input[name="no_document"]').val();
    var tglAwal         = $('input[name="tglAwal"]').val();
    var tglAkhir        = $('input[name="tglAkhir"]').val();
    var pic             = $('#pic').val();
    var item            = $('input[name="item"]').val();
    // console.log(search_by,jenis_dokumen,no_document,tglAwal,tglAkhir,pic,item);
// if( search_by == 'export'){
//     $('#btnExMGS').css('display', '')
// }else{
//     $('#btnExMGS').css('display', 'none')
// }
    var request = $.ajax({
        url: baseurl+'MonitoringGdSparepart/Monitoring/search',
        data: {
            search_by       : search_by,
            jenis_dokumen   : jenis_dokumen, 
            no_document     : no_document, 
            tglAwal         : tglAwal, 
            tglAkhir        : tglAkhir, 
            pic             : pic, 
            item            : item
        },
        type: "POST",
        datatype: 'html'
    });
    
    $('#tblMGS').html('');
    $('#tblMGS').html('<center><img style="width:150px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"></center>' );
        
    request.done(function(result){
        $('#tblMGS').html('');
        $('#tblMGS').html(result);
        
        $(".getkodebrgsurat").select2({
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "MonitoringGdSparepart/Monitoring/getKodeBarang",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
                        })
                    };
                }
            }
        });	
        $(".picGDSP").select2({
            allowClear: false,
            placeholder: "",
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "MonitoringGdSparepart/Monitoring/getPIC",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                            term: params.term,
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {id:obj.PIC, text:obj.PIC};
                        })
                    };
                }
            }
        });

        });
    // });
}

function addDetailMGS(th, no){
	var title = $(th).text();
	$('#detail'+no).slideToggle('slow');
}

function btnEditMGS(th, no, nomor){
	var title = $(th).text();
	$('#edit'+no+nomor).slideToggle('slow');
}


$('#search_by').change(function(){
    var value = $('#search_by').val()

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
});

$("#frmMGS").keypress(function(e) {   //Enter key   
    if (e.which == 13) {     
        return false;   
    } });


    function saveJmlOk(no, nomor) {
        // var ket = 'kirim_qc';
        var jml_ok = $('#jml_ok'+no+nomor).val();
        var item = $('#item'+no+nomor).val();
        var doc = $('#doc'+no+nomor).val();
        // console.log(no , jml_ok, item);
        if(!jml_ok){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveJmlOk",
            data: {no: no, nomor : nomor, doc : doc, jml_ok : jml_ok, item : item  },
            type : "POST",
            dataType: "html"
        });

    }

    function saveNotOk(no , nomor) {
        // var ket = 'kirim_qc';
        var jml_not_ok = $('#jml_not_ok'+no+nomor).val();
        var item = $('#item'+no+nomor).val();
        var doc = $('#doc'+no+nomor).val();
        // console.log(no , jml_not_ok, item);
        if(!jml_not_ok){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveNotOk",
            data: {no: no, nomor : nomor, doc : doc, jml_not_ok : jml_not_ok, item : item  },
            type : "POST",
            dataType: "html"
        });

    }

    function saveKetr(no , nomor) {
        // var ket = 'kirim_qc';
        var ket = $('#keterangan'+no+nomor).val();
        var item = $('#item'+no+nomor).val();
        var doc = $('#doc'+no+nomor).val();
        // console.log(number , itemid , recnum , po, kirimqc)
        if(!ket){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveKetr",
            data: {no: no, nomor : nomor, doc : doc, ket : ket, item : item  },
            type : "POST",
            dataType: "html"
        });

    }

    function saveAction(no , nomor) {
        // var ket = 'kirim_qc';
        var action = $('#action'+no+nomor).val();
        var item = $('#item'+no+nomor).val();
        var doc = $('#doc'+no+nomor).val();
        // console.log(number , itemid , recnum , po, kirimqc)
        if(!action){
            return;
        }
        $.ajax ({
            url : baseurl + "MonitoringGdSparepart/Monitoring/saveAction",
            data: {no: no, nomor : nomor, doc : doc, action : action, item : item  },
            type : "POST",
            dataType: "html"
        });

    }

    $(document).ready(function () {
        $(".picGDSP").select2({
            allowClear: false,
            placeholder: "",
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "MonitoringGdSparepart/Monitoring/getPIC",
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
    
function adddrekap(th){
	var title = $(th).text();
	$('#drekapmgs').slideToggle('slow');
}

function adddrekap2(no){
	$('#drekapmgs'+no).slideToggle('slow');
}

function schRekapMGS(th) {
	var tglAkh = $('#tglAkhir').val();
	var tglAwl = $('#tglAwal').val();
	// console.log(tglAwl);
	var request = $.ajax({
        url: baseurl+'MonitoringGdSparepart/Rekap/searchRekap',
        data: {	tglAkh : tglAkh, tglAwl : tglAwl },
        type: "POST",
        datatype: 'html'
	});
	$('#tb_RkpMGS').html('');
	$('#tb_RkpMGS').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"></center>' );
	request.done(function(result){
        $('#tb_RkpMGS').html('');
        $('#tb_RkpMGS').html(result);
        
        })
}

function getItemIntransit(th) {
    var param = $('#param').val();

    $.ajax({
        url : baseurl + "MonitoringGdSparepart/ItemIntransit/searchdata",
        data : {param : param},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('#tb_itemintransit' ).html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"></center>' );
        },
        success : function (result) {
            $('#tb_itemintransit').html(result);
            
        }
    })
}


function tmb_tanpa_surat(th) {
    var x = $('.nomor:last').val();
    var x = parseInt(x)+1;
    $.ajax({
        url : baseurl + "MonitoringGdSparepart/Monitoring/tambah_tanpa_surat",
        data : {x : x},
        dataType : 'html',
        type : 'POST',
        success : function (result) {
            $('#body_tanpa_surat').append(result);

            $(".getkodebrgsurat").select2({
                allowClear: true,
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringGdSparepart/Monitoring/getKodeBarang",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                            var queryParameters = {
                                    term: params.term,
                            }
                            return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
                            })
                        };
                    }
                }
            });		

            
            $(".picGDSP").select2({
                allowClear: false,
                placeholder: "",
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringGdSparepart/Monitoring/getPIC",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.PIC, text:obj.PIC};
                            })
                        };
                    }
                }
            });

        }
    })
	
	$(document).on('click', '.tombolhapus'+x,  function() {
		$(this).parents('.tr_tanpa_surat').remove()
	});
}

function tmb_peminjam(th) {
    var x = $('.nomor:last').val();
    var x = parseInt(x)+1;
    $.ajax({
        url : baseurl + "MonitoringGdSparepart/PeminjamanBarang/tambah_peminjam",
        data : {x : x},
        dataType : 'html',
        type : 'POST',
        success : function (result) {
            $('#body_peminjam').append(result);
            $(".getpeminjam").select2({
                allowClear: true,
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringGdSparepart/PeminjamanBarang/getPeminjam",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                            var queryParameters = {
                                    term: params.term,
                            }
                            return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.noind, text:obj.noind+' - '+obj.nama};
                            })
                        };
                    }
                }
            });		

            $(".getkodebrgpeminjaman").select2({
                allowClear: true,
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringGdSparepart/Monitoring/getKodeBarang",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                            var queryParameters = {
                                    term: params.term,
                            }
                            return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
                            })
                        };
                    }
                }
            });		

            
            $(".picGDSP").select2({
                allowClear: false,
                placeholder: "",
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringGdSparepart/Monitoring/getPIC",
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj) {
                                return {id:obj.PIC, text:obj.PIC};
                            })
                        };
                    }
                }
            });

        }
    })
	
	$(document).on('click', '.tombolhapus'+x,  function() {
		$(this).parents('.tr_peminjam').remove()
	});
}

$(document).ready(function(){
    var peminjaman = document.getElementById('tbl_peminjaman');
    if (peminjaman) {
        $.ajax({
            url : baseurl + "MonitoringGdSparepart/PeminjamanBarang/tbl_peminjaman",
            dataType : 'html',
            type : 'POST',
            beforeSend: function() {
            $('#tbl_peminjaman' ).html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"></center>' );
            },
            success : function (result) {
                $('#tbl_peminjaman').html(result);
                $('#myTable').dataTable({
                    "scrollX": true,
                });
            }
        })
    }

    $(".getpeminjam").select2({
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "MonitoringGdSparepart/PeminjamanBarang/getPeminjam",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                    var queryParameters = {
                            term: params.term,
                    }
                    return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.noind, text:obj.noind+' - '+obj.nama};
                    })
                };
            }
        }
    });	
    
    $(".getkodebrgpeminjaman").select2({
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "MonitoringGdSparepart/Monitoring/getKodeBarang",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                    var queryParameters = {
                            term: params.term,
                    }
                    return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
                    })
                };
            }
        }
    });		
})

function terima_pinjaman(no) {
    var id = $('#id_peminjam'+no).val();
    $.ajax({
        url : baseurl + "MonitoringGdSparepart/PeminjamanBarang/updatePeminjaman",
        data : {id : id},
        dataType: 'html',
        type: "POST",
        success : function (result) {
            window.location.reload();
        }
    })
}

function getSeksi(no) {
    var noind = $('#nama_peminjam'+no).val();
    $.ajax({
        url : baseurl + "MonitoringGdSparepart/PeminjamanBarang/getSeksi",
        data : {noind : noind},
        dataType: 'json',
        type: "POST",
        success : function (result) {
            $('#seksi_peminjam'+no).val(result);
        }
    })
}

function getDescBarang(no) {
    var item = $('#kode_barang'+no).val();
    $.ajax({
        url : baseurl + "MonitoringGdSparepart/Monitoring/getDesc",
        data : {item : item},
        dataType: 'json',
        type: "POST",
        success : function (result) {
            $('#nama_barang'+no).val(result[0]);
            $('#uom'+no).val(result[1]);
        }
    })
}