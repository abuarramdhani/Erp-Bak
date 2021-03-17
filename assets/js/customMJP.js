$(document).ready(function () {
var master = document.getElementById("tbl_master_category");
    if(master){
      getMasterCategory(this);
    }
      
var simulasi = document.getElementById("tbl_simulasi_produksi");
    if(simulasi){
        getSimulasiProduksi('');
    }

var user = document.getElementById("tbl_usermng");
    if(user){
        getUserMngProduksi(this);
    }

    $(".getusermjp").select2({
        allowClear: true,
        placeholder: "pilih User",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "MonitoringJobProduksi/UserManagement/getuserMJP",
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
});

//-----------------------------------------------MONITORING---------------------------------------------------------------------------------
function schMonJob(ket) {
    var  kategori   = $('#kategori').val();
    var  bulan      = $('#periode_bulan').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/search",
        data : {bulan : bulan, kategori : kategori, ket : ket},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_monjob_produksi' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_monjob_produksi' ).html(data);
            $('#tb_monjob').dataTable({
                "scrollX": true,
                paging : false,
                scrollY : 500,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 3,
                }
            });
            $('#tb_monjob2').dataTable({
                "scrollX": true,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 3,
                }
            });

            var nomor = $('.nomorr:last').val();
            // console.log(nomor);
            if (nomor != undefined) {
                getWipMonitoring(1, nomor);
                getGdMonitoring(1, nomor);
                // getPickMonitoring(1, nomor);
                $('.loadingwip').html('<center><img style="width:30px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"></center>' );
                $('.loadingpick').html('<center><img style="width:30px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"></center>' );
                $('.loadinggd').html('<center><img style="width:30px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"></center>' );
            }
        }
    })
}

function getWipMonitoring(no, batas) {
    if (no <= batas) {
        var item = $('#item'+no).val();
        $.ajax ({
            url : baseurl + "MonitoringJobProduksi/Monitoring/searchwipmonitoring",
            data : {item : item},
            dataType : 'json',
            type : 'POST',
            success : function (result) {
                // console.log(result,no)
                $('[name = "ini_wip'+no+'"]').html('<b>WIP :</b> '+result+'')
                $('[name ="wip'+no+'"]').val(result);
                getWipMonitoring((no+1), batas);
            }
        })
    }else{
        getPickMonitoring(1, batas);
    }
}

function getPickMonitoring(no, batas) {
    if (no <= batas) {
        var item = $('#item'+no).val();
        $.ajax ({
            url : baseurl + "MonitoringJobProduksi/Monitoring/searchpickmonitoring",
            data : {item : item},
            dataType : 'json',
            type : 'POST',
            success : function (result) {
                // console.log(result,no)
                $('[name = "ini_pick'+no+'"]').html('<b>Picklist :</b> '+result+'')
                $('[name ="picklist'+no+'"]').val(result);
                getPickMonitoring((no+1), batas);
            }
        })
    }
}

function getGdMonitoring(no, batas) {
    if (no <= batas) {
        var item = $('#item'+no).val();
        $.ajax ({
            url : baseurl + "MonitoringJobProduksi/Monitoring/searchgdmonitoring",
            data : {item : item},
            dataType : 'json',
            type : 'POST',
            success : function (result) {
                // console.log(result,no)
                $('[name = "ini_gd'+no+'"]').html('<b>FG-TKS :</b> '+result[0]+'<br><b>MLATI-DM :</b> '+result[1]+'')
                $('[name ="fg_tks'+no+'"]').val(result[0]);
                $('[name ="mlati'+no+'"]').val(result[1]);
                getGdMonitoring((no+1), batas);
            }
        })
    }
}

function commentmin(no, tgl, ket) {
    var item    = $('#item'+no).val();
    var desc    = $('#desc'+no).val();
    var inv     = $('#inv'+no).val();
    var bulan   = $('#bulan').val();
    var bulan2   = $('#bulan2').val();
    var kategori = $('#kategori2').val();

    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/commentmin",
        data : {item : item, desc : desc, inv : inv, bulan : bulan, bulan2 : bulan2,
                kategori : kategori, tgl : tgl, ket : ket},
        dataType : 'html',
        type : 'POST',
        success : function (data) {
            $('#mdlcommentmin').modal('show');
            $('#datacommentmin').html(data);
        }
    })
}

function editcomment(){
    // console.log('woy')
    $('#savecommentmin').css('display','');
    $('#editcommentmin').css('display','none');
    $('#comment').removeAttr('disabled');
}

function saveCommentmin(ket) {
    var kategori = $('#kategori').val();
    var inv     = $('#inv').val();
    var bulan   = $('#bulanmin').val();
    var tgl     = $('#tgl').val();
    var comment = $('#comment').val();
    if (ket == 1) {
        tujuan = 'saveComment';
    }else if (ket == 2) {
        tujuan = 'saveCommentPL';
    }else{
        tujuan = 'saveCommentC';
    }
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/"+tujuan+"",
        data : {inv : inv, bulan : bulan, comment : comment,
                kategori : kategori, tgl : tgl},
        dataType : 'html',
        type : 'POST',
        success : function (data) {
            $('#mdlcommentmin').modal('hide');
        }
    })
}

function getSimulasiProduksi(ket) {
    var item    = $('#item').val();
    var qty     = $('#qty').val();
    document.getElementById('btn_tmb_level').setAttribute('onclick','gettambahlevel(1)')
    $('#btn_simulasi_all').val('');
    // console.log(item, qty)
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/searchSimulasi",
        data : {item : item, qty : qty, level: 1, ket : ket},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_simulasi_produksi' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_simulasi_produksi' ).html(data);
            // $('#tb_monsimulasi').dataTable({
            //     "scrollX": true,
            // });
        }
    })
}

function gettambahlevel(level) {
    // console.log(level)
    if (level == 'All') {
        //langsung semua
        $('.button1').click();
        $('#btn_simulasi_all').val('all');
        document.getElementById('btn_tmb_level').setAttribute('onclick','gettambahlevel(1)')
    }else{
        //satu-satu
        $('#btn_simulasi_all').val('');
        var batas = $('#btn_level_'+level).val();
        if (batas) {
            $('.button'+level).click();
            document.getElementById('btn_tmb_level').setAttribute('onclick','gettambahlevel('+(level+1)+')');
        }else{
            Swal.fire({
                type: 'error',
                title: 'Level Sudah Mencapai Batas...',
                text: '',
                showConfirmButton: false,
                showCloseButton: true,
            })
        }
    }
}

function tambahsimulasi(level, no, num) {
    // $('#tr_simulasi'+level+no).slideToggle('slow');   
    var num = num == undefined ? '' : num;
    var nomor = level+''+no+''+''+num+'';
    // console.log(nomor,level,no)
    var penanda = $('#penanda'+nomor).val();
    if (penanda == 'off') {
        $('#tr_simulasi'+nomor).css('display','');   
        $('#penanda'+nomor).val('on');
        var item = $('#komp'+nomor).val();
        // var item = 'AAC1000AA1AZ-F';
        var qty = $('#qty'+nomor).val();
        $.ajax({
            url : baseurl + "MonitoringJobProduksi/Monitoring/searchSimulasi",
            data : {item : item, qty : qty, level : (level+1), nomor : nomor},
            dataType : 'html',
            type : 'POST',
            beforeSend: function() {
            $('#tr_simulasi'+nomor).html('<center><img style="width:50px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"></center>' );
            },
            success : function(data) {
                // console.log(level);
                $('#tr_simulasi'+nomor).html(data);
                var all = $('#btn_simulasi_all').val();
                if (data != '<center><b>Data Kosong</b></center>' && all == 'all') {
                    $('.button'+nomor).click();
                }
            }
        })
    }else{
        document.getElementById('btn_tmb_level').setAttribute('onclick','gettambahlevel(1)')
        $('#tr_simulasi'+nomor).css('display','none');   
        $('#tr_simulasi'+nomor).html('<p>tutup</p>');
        $('#penanda'+nomor).val('off');
    }
}

function mdlGudangSimulasi(no) {
    var item        = $('#komp'+no).val();
    var desc        = $('#desc'+no).val();
    var dfg         = $('#dfg'+no).val();
    var dmc         = $('#dmc'+no).val();
    var fg_tks      = $('#fg_tks'+no).val();
    var int_paint   = $('#int_paint'+no).val();
    var int_weld    = $('#int_weld'+no).val();
    var int_sub     = $('#int_sub'+no).val();
    var pnl_tks     = $('#pnl_tks'+no).val();
    var sm_tks      = $('#sm_tks'+no).val();
    var int_assygt      = $('#int_assygt'+no).val();
    var int_assy      = $('#int_assy'+no).val();
    var int_macha      = $('#int_macha'+no).val();
    var int_machb      = $('#int_machb'+no).val();
    var int_machc      = $('#int_machc'+no).val();
    var int_machd      = $('#int_machd'+no).val();
    var jumlah      = $('#jml_gudang'+no).val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/detailGudang",
        data : {item : item, desc: desc, dfg : dfg, dmc : dmc, fg_tks : fg_tks, int_paint : int_paint, 
                int_weld : int_weld, int_sub : int_sub, pnl_tks : pnl_tks, sm_tks : sm_tks, jumlah : jumlah,
                int_assygt : int_assygt, int_assy : int_assy, int_macha : int_macha, int_machb : int_machb, 
                int_machc : int_machc, int_machd : int_machd },
        dataType : 'html',
        type : 'POST',
        success : function (result) {
            $('#mdlGDSimulasi').modal('show');
            $('#datamdlsimulasi').html(result);
            // $('#tbl_modal_simulasi').dataTable({
            //     scrollX : true,
            // });
        }
    })
}

function mdlWIPSimulasi(no) {
    var item        = $('#komp'+no).val();
    var desc        = $('#desc'+no).val();
    var wip         = $('#wip'+no).val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/detailWIP",
        data : {item : item, desc: desc, wip : wip },
        dataType : 'html',
        type : 'POST',
        success : function (result) {
            $('#mdlGDSimulasi').modal('show');
            $('#datamdlsimulasi').html(result);
            $('#tbl_modal_simulasi').dataTable();
        }
    })
}

function schMonJob2(th) {
    var kategori = $('#kategori_range').map(function(){return $(this).val();}).get();
    var tglawal = $('#tgl_awal').val();
    var tglakhir = $('#tgl_akhir').val();
    var bulan = $('#periode_bulan_range').val();
// console.log(kategori);
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/searchReport",
        data : {kategori : kategori, tglawal : tglawal, tglakhir : tglakhir, bulan : bulan},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_monjob_produksi2' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_monjob_produksi2' ).html(data);
            $('.tb_monjob').dataTable({
                "scrollX": true,
                paging : false,
                scrollY : 500,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 3,
                }
            });
            $('.tb_monjob2').dataTable({
                "scrollX": true,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 3,
                }
            });
        }
    })
}

//----------------------------------------------------SET PLAN PRODUKSI------------------------------------------------
function schSetPlan(th) {
    var  kategori   = $('#kategori').val();
    var  bulan      = $('#periode_bulan').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/SetPlan/search",
        data : {bulan : bulan, kategori : kategori},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_setplan' ).html('<center><img style="width:90px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_setplan' ).html(data);
            $('#tb_setplan').dataTable({
                "scrollX": true,
                paging : false,
                scrollY : 500,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 4,
                }
            });
            $('#tb_setplan2').dataTable({
                "scrollX": true,
                fixedColumns:   {
                    leftColumns: 4,
                }
            });
        }
    })
}

function sumSetplan(no, tgl) {
    // var bulan   = $('#bulan'+no).val();
    // var id_plan = $('#id_plan'+no).val();
    // var item    = $('#item'+no).val();
    // var plan    = $('#plan'+no+tgl).val();
    var planall = $('.plan'+no).map(function(){return $(this).val();}).get();
    
    var sumplan = planall.map( function(elt){ // assure the value can be converted into a number
      return /^\d+$/.test(elt) ? parseInt(elt) : 0; 
    }).reduce( function(a,b){ // sum all resulting numbers
      return a+b
    })
    $('#jml'+no).html(sumplan);

    // console.log(sumplan)
    // $.ajax({
    //     type: "POST",
    //     data: { bulan: bulan, item : item, plan : plan, tgl : tgl, id_plan : id_plan},
    //     url: baseurl + "MonitoringJobProduksi/SetPlan/saveSetPlan",
    //     // success: function (result) {
    //     //     console.log(result);
    //     // },
    // });
}

//------------------------------------------------------ITEM LIST-----------------------------------------------------------------

$(document).on("change", "#kategori", function(){
    var kategori = $('#kategori').val();
    if (kategori) {
        $.ajax({
            data: { kategori : kategori},
            url: baseurl + "MonitoringJobProduksi/ItemList/cekSubCategory",
            dataType : 'html',
            type: "POST",
            success: function (result) {
                if (result != '<option></option>') {
                    $('#sub_kategori').select2('val','');
                    $('#sub_kategori').html(result);
                    $('#subcategory').css('display','');
                }else{
                    $('#sub_kategori').select2('val','');
                    $('#sub_kategori').html(result);
                    $('#subcategory').css('display','none');
                }
            },
        });
    }
})

function schItemList(th) {
    var  kategori   = $('#kategori').val();
    var  subkategori   = $('#sub_kategori').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/ItemList/search",
        data : {kategori : kategori, subkategori : subkategori},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_item_produksi' ).html('<center><img style="width:90px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_item_produksi' ).html(data);
            $('#tb_itemlist').dataTable({
                "scrollX": true,
            });
            
            $(".kodeitem").select2({
                allowClear: true,
                placeholder: "pilih Item",
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringJobProduksi/ItemList/kodeitem",
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
                                return {id:obj.INVENTORY_ITEM_ID, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
                            })
                        };
                    }
                }
            });		
        }
    })
}

function tambahItemList(th) {
    var item        = $('#kode_item').val();
    var kategori    = $('#kategori_item').val();
    var subkategori    = $('#sub_kategori_item').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/ItemList/saveitem",
        data: { item : item, kategori : kategori, subkategori : subkategori},
        type : "POST",
        dataType: "html",
        success: function(data) {
            if (data == 'oke') {
                Swal.fire({
                    title: 'Item Berhasil Ditambahkan!',
                    type: 'success',
                    allowOutsideClick: false
                }).then(result => {
                    if (result.value) {
                        schItemList(this);
                }})  
            }else {
                Swal.fire({
                    title: 'Item Sudah Ada!',
                    type: 'error',
                    allowOutsideClick: false
                }).then(result => {
                    if (result.value) {
                        schItemList(this);
                }})  
            }
        }
    }) 
}

function deleteitemList(no) {
    var item        = $('#item'+no).val();
    var inv_id      = $('#inv_id'+no).val();
    var kategori    = $('#kategori'+no).val();
    var subkategori    = $('#subkategori'+no).val();
    // console.log(item)
    Swal.fire({
        title: 'Apakah Anda Yakin ?',
        // html: '<b>Apakah Anda Yakin Akan Menghapus <span style="color:red">'+item+'</span> ?<b>',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $.ajax({
                url : baseurl + "MonitoringJobProduksi/ItemList/deleteitem",
                data: {inv_id : inv_id, kategori : kategori, subkategori : subkategori},
                type : "POST",
                dataType: "html",
                success: function(data) {
                    Swal.fire({
                        title: 'Data Berhasil di Hapus!',
                        type: 'success',
                        allowOutsideClick: false
                    }).then(result => {
                        if (result.value) {
                            schItemList(this);
                    }})  
                }
            })
    }})  
}

function updateflag(no) {
    var inv_id      = $('#inv_id'+no).val();
    var kategori    = $('#kategori'+no).val();
    var subkategori = $('#subkategori'+no).val();
    var flag        = $('#flag'+no).val();
    if (flag == 'Y') {
        $('#btn_check'+no).removeClass('fa-check-square-o').addClass('fa-square-o');
        $('#flag'+no).val('');
    }else{
        $('#btn_check'+no).removeClass('fa-square-o').addClass('fa-check-square-o');
        $('#flag'+no).val('Y');
    }
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/ItemList/updateflag",
        data: {inv_id : inv_id, kategori : kategori, subkategori : subkategori, flag : flag},
        type : "POST",
        dataType: "html"
    })
}

//-------------------------------------------------------MASTER KATEGORI--------------------------------------------------------------
function getMasterCategory(th) {
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/MasterKategori/search",
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_master_category' ).html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading12.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_master_category' ).html(data);
            $('#tb_master_ctgr').dataTable({
                "scrollX": true,
            });
        }
    })
}

function deletecategory(no) {
    var id          = $('#id_kategori'+no).val();
    var kategori    = $('#kategori'+no).val();
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {  
            $.ajax({
                url : baseurl + "MonitoringJobProduksi/MasterKategori/deleteCategory",
                data: {id : id, kategori : kategori},
                type : "POST",
                dataType: "html",
                success: function(data) {
                    Swal.fire({
                        title: 'Data Berhasil di Hapus!',
                        type: 'success',
                        allowOutsideClick: false
                    }).then(result => {
                        if (result.value) {
                            getMasterCategory(this);
                    }})  
                }
            })
    }})  
}

function editcategory(no) {
    var id          = $('#id_kategori'+no).val();
    var kategori    = $('#kategori'+no).val();
    
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/MasterKategori/editCategory",
        data: {id : id, kategori : kategori},
        type : "POST",
        dataType: "html",
        success: function(data) {
            $('#mdl_masterctgr').modal('show');
            $('#data_masterctgr').html(data);
        }
    })
    // Swal.fire({
	// 	title: 'Edit Category',
	// 	html : '<p style="text-align:left"><b>Category Name : </b>'+kategori+'</p>',
	// 	// type: 'success',
	// 	input: 'text',
	// 	inputAttributes: {
	// 		autocapitalize: 'off'
	// 	},
	// 	showCancelButton: true,
	// 	confirmButtonText: 'OK',
	// 	showLoaderOnConfirm: true,
	// }).then(result => {
	// 	if (result.value) {
    //         var val = result.value;
    //         $.ajax({
    //             url : baseurl + "MonitoringJobProduksi/MasterKategori/editCategory",
    //             data: {id : id, kategori : kategori, val : val},
    //             type : "POST",
    //             dataType: "html",
    //             success: function(data) {
    //                 if (data == 'not oke') {
    //                     Swal.fire({
    //                         title: 'Kategori Sudah Ada!',
    //                         type: 'error',
    //                         allowOutsideClick: false
    //                     }).then(result => {
    //                         if (result.value) {
    //                             getMasterCategory(this);
    //                     }}) 
    //                 }else{
    //                     getMasterCategory(this);
    //                 }
    //             }
    //         })
    // }})
}

function saveCategory(th) {
    var kategori = $('#kategori').val();
    var sub_kategori = $('[name="sub_kategori[]"]').map(function(){return $(this).val();}).get();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/MasterKategori/saveCategory",
        data: {kategori : kategori, sub_kategori : sub_kategori},
        type : "POST",
        dataType: "html",
        success: function(data) {
            window.location.reload();
            // $('#kategori').val('');
            // if (data == 'oke') {
            //     Swal.fire({
            //         title: 'Kategori Berhasil Ditambahkan!',
            //         type: 'success',
            //         allowOutsideClick: false
            //     }).then(result => {
            //         if (result.value) {
            //             getMasterCategory(this);
            //     }}) 
            // }else{
            //     Swal.fire({
            //         title: 'Kategori Sudah Ada!',
            //         type: 'error',
            //         allowOutsideClick: false
            //     }).then(result => {
            //         if (result.value) {
            //             getMasterCategory(this);
            //     }}) 
            // }
        }
    }) 
}

function updateCategory() {
    var id          = $('#id_kategori').val();
    var kategori    = $('#kategori').val();
    var sub_kategori = $('[name="sub_kategori2[]"]').map(function(){return $(this).val();}).get();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/MasterKategori/updateCategory",
        data: {id : id,kategori : kategori, sub_kategori : sub_kategori},
        type : "POST",
        dataType: "html",
        success: function(data) {
            $('#mdl_masterctgr').modal('hide');
        }
    })
}

var i = 2;
function tmb_subkategori() {
    $('#tambah_subkategori').append('<div class="tambah_subkategori"><br><br><div class="col-md-4 text-right"></div><div class="col-md-4"><input id="sub_kategori'+i+'" name="sub_kategori[]" class="form-control" style="text-transform:uppercase" placeholder="Masukkan SubKategori"></div><div class="col-md-1"><button type="button" class="btn bg-default tombolhapus'+i+'" style="margin-left:15px"><i class="fa fa-minus"></i></button></div></div>');

    $(document).on('click', '.tombolhapus'+i,  function() {
		$(this).parents('.tambah_subkategori').remove()
	});
}

var j = 2;
function tmb_subkategori2() {
    $('#tambah_subkategori2').append('<div class="tambah_subkategori2"><div class="col-md-3 text-right"></div><div class="col-md-6"><input name="sub_kategori2[]" class="form-control" style="text-transform:uppercase" placeholder="Masukkan SubKategori"></div><div class="col-md-1"><button type="button" class="btn bg-default tombolhapus'+j+'" style="margin-left:15px"><i class="fa fa-minus"></i></button></div><br><br></div>');

    $(document).on('click', '.tombolhapus'+i,  function() {
		$(this).parents('.tambah_subkategori2').remove()
	});
}

//------------------------------------------------- USER MANAGEMENT ------------------------------------------------------------------

function getUserMngProduksi(th) {
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/UserManagement/getdata",
        beforeSend: function() {
        $('div#tbl_usermng' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_usermng' ).html(data);
            $('#tb_user_mng').dataTable({
                "scrollX": true,
            });
        }
    })
}

function saveUserMng(th) {
    var jenis = $('#kategori').val();
    var user = $('#user').val();

    $.ajax({
        url : baseurl + "MonitoringJobProduksi/UserManagement/saveUser",
        data : { jenis : jenis, user : user},
        dataType : 'html',
        type : 'POST',
        success : function (data) {
            if (data == 'oke') {
                Swal.fire({
                    title: 'User Berhasil Ditambahkan!',
                    type: 'success',
                    allowOutsideClick: true
                }).then(result => {
                    if (result.value) {
                        getUserMngProduksi(this);
                }}) 
            }else{
                swal.fire("User Sudah Ada", "", "error");
            }
            $('#kategori').select2('val','');
            $('#user').select2('val','');
            
            $(".getusermjp").select2({
                allowClear: true,
                placeholder: "pilih User",
                minimumInputLength: 3,
                ajax: {
                    url: baseurl + "MonitoringJobProduksi/UserManagement/getuserMJP",
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
        }
    })    
}

function editUser(no) {
    var noind = $('#noind'+no).val();
    var nama = $('#nama'+no).val();
    var jenis = $('#jenis'+no).val();

    $.ajax({
        url : baseurl + "MonitoringJobProduksi/UserManagement/editUser",
        data : {noind : noind, nama : nama, jenis : jenis},
        dataType : 'html',
        type : 'POST',
        success : function (result) {
            $('#mdleditUser').modal('show');
            $('#dataedituser').html(result);
            
            $("#jenis").select2({
                allowClear: true,
            });		
        }
    })
}

function deleteUser(no) {
    var noind = $('#noind'+no).val();
    var jenis = $('#jenis'+no).val();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url : baseurl + "MonitoringJobProduksi/UserManagement/deleteUser",
                data : {noind : noind, jenis : jenis},
                dataType : 'html',
                type : 'POST',
                success : function (result) {
                    swal.fire("User Berhasil Dihapus!", "", "success");
                    getUserMngProduksi(this);
                }
            })
    }}) 
}

//----------------------------------------------------LAPORAN PRODUKSI------------------------------------------------

$(document).on("change", "#asal", function(){
    var asal = $('#asal').val();
    if (asal == 'TRANSAKSI') {
        $('.asal_transaksi').css('display', '');
        
        $(".getsubinv").select2({
            allowClear: true,
            placeholder: "pilih Subinv",
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "MonitoringJobProduksi/LaporanProduksi/getSubinv",
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
                            return {id:obj.SECONDARY_INVENTORY_NAME, text:obj.SECONDARY_INVENTORY_NAME};
                        })
                    };
                }
            }
        });	
    }else{
        $('.asal_transaksi').css('display', 'none');
        $(".getsubinv").select2('val', '');
    }
})

function schLaporanProd(th) {
    var  kategori   = $('#kategori').val();
    var  bulan      = $('#periode_bulan').val();
    var  asal      = $('#asal').val();
    var  subinv_from      = $('#subinv_from').val();
    var  subinv_to      = $('#subinv_to').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/LaporanProduksi/search",
        data : {bulan : bulan, kategori : kategori, asal : asal, subinv_from : subinv_from, subinv_to : subinv_to},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_laporan' ).html('<center><img style="width:90px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_laporan' ).html(data);
            $('#tb_laporan').dataTable({
                scrollX: true,
                paging : false,
                scrollY : 500,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 2,
                }
            });
            $('#tb_laporan2').dataTable({
                scrollX: true,
                ordering : false,
                fixedColumns:   {
                    leftColumns: 2,
                }
            });
        }
    })
}
