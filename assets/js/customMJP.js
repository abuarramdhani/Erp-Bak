$(document).ready(function () {
var master = document.getElementById("tbl_master_category");
    if(master){
      getMasterCategory(this);
    }
      
var simulasi = document.getElementById("tbl_simulasi_produksi");
    if(simulasi){
        getSimulasiProduksi(this);
    }
});

//-----------------------------------------------MONITORING---------------------------------------------------------------------------------
function schMonJob(th) {
    var  kategori   = $('#kategori').val();
    var  bulan      = $('#periode_bulan').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/search",
        data : {bulan : bulan, kategori : kategori},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_monjob_produksi' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_monjob_produksi' ).html(data);
            $('#tb_monjob').dataTable({
                "scrollX": true,
                fixedColumns:   {
                    leftColumns: 4,
                }
            });
        }
    })
}

function getSimulasiProduksi(th) {
    var item    = $('#item').val();
    var qty     = $('#qty').val();
    // console.log(item, qty)
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/Monitoring/searchSimulasi",
        data : {item : item, qty : qty},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#tbl_simulasi_produksi' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function(data) {
            $('div#tbl_simulasi_produksi' ).html(data);
            $('#tb_monsimulasi').dataTable({
                "scrollX": true,
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
                fixedColumns:   {
                    leftColumns: 4,
                }
            });
        }
    })
}

function saveSetplan(no, tgl) {
    var bulan   = $('#bulan'+no).val();
    var id_plan = $('#id_plan'+no).val();
    var item    = $('#item'+no).val();
    var plan    = $('#plan'+no+tgl).val();
    // console.log(bulan, item, plan, tgl)
    $.ajax({
        type: "POST",
        data: { bulan: bulan, item : item, plan : plan, tgl : tgl, id_plan : id_plan},
        url: baseurl + "MonitoringJobProduksi/SetPlan/saveSetPlan",
        // success: function (result) {
        //     console.log(result);
        // },
    });
}

//------------------------------------------------------ITEM LIST-----------------------------------------------------------------
function schItemList(th) {
    var  kategori   = $('#kategori').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/ItemList/search",
        data : {kategori : kategori},
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
                minimumInputLength: 0,
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
    var kategori    = $('#kategori').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/ItemList/saveitem",
        data: { item : item, kategori : kategori},
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
                data: {inv_id : inv_id, kategori : kategori},
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

function saveCategory(th) {
    var kategori = $('#kategori').val();
    $.ajax({
        url : baseurl + "MonitoringJobProduksi/MasterKategori/saveCategory",
        data: {kategori : kategori},
        type : "POST",
        dataType: "html",
        success: function(data) {
            if (data == 'oke') {
                Swal.fire({
                    title: 'Kategori Berhasil Ditambahkan!',
                    type: 'success',
                    allowOutsideClick: false
                }).then(result => {
                    if (result.value) {
                        getMasterCategory(this);
                        $('#kategori').val('');
                }}) 
            }else{
                Swal.fire({
                    title: 'Kategori Sudah Ada!',
                    type: 'error',
                    allowOutsideClick: false
                }).then(result => {
                    if (result.value) {
                        getMasterCategory(this);
                        $('#kategori').val('');
                }}) 
            }
        }
    }) 
}
