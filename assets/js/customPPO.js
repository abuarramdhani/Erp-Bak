$(document).ready(function() {
    //  $(document).ajaxStart(function () {
    //     $("#loading").show();
    // }).ajaxStop(function () {
    //     $("#loading").hide();
    // });

    var listItem = [];
    var SJ;
    
    // $('#in_dateRcv').datepicker({ format: 'dd/mm/yyyy hh:ii:ss' });
    // $('#in_dateRcv').datepicker('setDate', new Date());

     $('.input-group.date').datepicker({
       todayBtn: "linked",
       language: "it",
       autoclose: true,
       todayHighlight: true,
       format: 'dd/mm/yyyy'
    });
 
    $(".selectVendor").select2({
        allowClear: true,
        placeholder: "Vendor",
        ajax: {
            url: baseurl + "PenerimaanPO/C_PenerimaanAwal/getListVendor",
            dataType: 'json',
            type: 'post',
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
                            id: obj.VENDOR_NAME,
                            text: obj.VENDOR_NAME
                        };
                    })
                };
            }
        },
        minimumInputLength: 1
    });

    $(".selectItem").select2({
        allowClear: true,
        placeholder: "Nama Barang",
        ajax: {
            url: baseurl + "PenerimaanPO/C_PenerimaanAwal/getListItem",
            dataType: "json",
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
                            id: obj.SEGMENT1 + " | " + obj.DESCRIPTION,
                            text: obj.SEGMENT1 + " | " + obj.DESCRIPTION
                        };
                    })
                };
            }
        },
        minimumInputLength: 1
    });

    $("#b_procces").click(function() {
        var PO = $('#in_po').val();
        $("#loading").show();
        $.ajax({
            url: baseurl + "PenerimaanPO/awal/loadVendor/" + PO,
            success: function(data) {
                var arrayOne = $.parseJSON(data);
                var vendor = arrayOne[0].VENDOR_NAME;

                $('#sel_vendor').html('<option value="'+vendor+'">' + vendor + '</option>');
                $('#sel_vendor').val(vendor).trigger('change');

                $('#in_sj').val('');
                $('#in_dateShip').val('');
                $("#loading").hide();
            }
        })
        $.ajax({
            url: baseurl + "PenerimaanPO/awal/loadPoLine/" + PO,
            success: function(results) {
                listItem = [];
                var arrayRow = $.parseJSON(results);
                $.each(arrayRow, function(i, item) {
                    listItem.push(item);
                });
                showChange();
                $.toaster('Data loaded!', 'Load', 'success');
                $("#loading").hide();
            }
        })
         $.ajax({
            url: baseurl + "PenerimaanPO/awal/loadSubinv/" + PO,
            success: function(results) {
                var arrayOne = $.parseJSON(results);
                var subinv = arrayOne[0]['SUB_INVENTORY'];
                $('#subinv').html('<label value="'+subinv+'">' + subinv + '</label>');
                $('#subinv').val(subinv).trigger('change');
                $("#loading").hide();
            }
        })
    });

    $('#b_generate').click(function() {
        $.ajax({
            url: baseurl + "PenerimaanPO/C_PenerimaanAwal/generateSJ",
            success: function(data) {
                var arrayOne = $.parseJSON(data);
                var SJ = arrayOne[0].NEXTVAL;
                $('#in_sj').val(SJ);
            }
        })
    });

    $("#b_add").click(function() {
        var dataItem = $("#sel_item").val().split(' | ');
        var itemName = dataItem[0];
        var itemDesc = dataItem[1];
        var objItem = {
            SEGMENT1: itemName,
            ITEM_DESCRIPTION: itemDesc,
            QUANTITY: "",
            ISI: $("#in_qty").val()
        };
        listItem.unshift(objItem);
        $("#sel_item").select2("val", "");
        $("#in_qty").val("");
        showChange();
    });

    $('#b_save').click(function() {
        var actCount = 0;
        var SJ     = $('#in_sj').val();
        var Vendor = $('#sel_vendor').val();
        var tglSP  = $('#in_dateShip').val();
        var PO = $('#in_po').val()
        var whs = $('#subinv').val();
        console.log(listItem);

        if(SJ.length==0||Vendor.length==0||tglSP.length==0){
            $.toaster('Lengkapi data header!', 'Error', 'error');
        }else{
            for(i=0;i<listItem.length;i++){
                var objItem = listItem[i];
                console.log(objItem);
                var keterangan = $('#ket_qty'+i).val();
                console.log(keterangan);
                
            if($('#adexe_qty'+i).is(":checked")){
                 var keterangan = $('#ket_qty'+i).val();

                if(objItem.ISI==0){
                    ++actCount;
                }else{
                    
                    var qc = 'NON-QC';
                    if(objItem.ROUTING == 2){
                        qc = 'QC';
                    }

                    $.ajax({
                        url: baseurl + "PenerimaanPO/C_PenerimaanAwal/insertDataAwal",  
                        dataType:'json',
                        type:"POST",
                        data:{
                            po        : PO,
                            sj        : SJ,
                            vendor    : Vendor,
                            item      : objItem.SEGMENT1,
                            desc      : objItem.ITEM_DESCRIPTION,
                            qtySJ     : objItem.ISI,
                            rcptDate  : "sysdate",
                            spDate    : tglSP,
                            qtyActual : 0,
                            qtyPO     : objItem.QUANTITY,
                            qtyReceipt: objItem.QTY_RECEIPT,
                            keterangan: keterangan,
                            status:qc
                        },
                        success:function(data){
                            console.log(data);
                            if(++actCount==listItem.length){
                                $.toaster('Data Inserted!', 'Success', 'success');
                                window.open(baseurl+"PenerimaanPO/awal/cetakPDF?id="+PO+"&whs="+whs+"&sj="+SJ,'_blank');
                            }
                        },
                        error:function(error,status){
                            console.log(error);
                            console.log(status);
                        }
                    });
                }
            }else{
                console.log('cuk');
                ++actCount;
            }
        }
        }
    });

    function showChange() {
        var row = '';
        for (i = 0; i < listItem.length; i++) {
            var objItem = listItem[i];
            row = row + ' <div class="col-md-12" style="padding: 2px;border-bottom:1px solid black;"><div class="col-md-3"><div>' + objItem.SEGMENT1 + '</div><div>' + objItem.ITEM_DESCRIPTION + '</div></div><div class="col-md-1"><div style="margin-top: 10px"><center>' + objItem.QUANTITY + '</center></div></div><div class="col-md-1"><div style="margin-top: 10px"><center>' + objItem.QTY_RECEIPT + '</center></div></div><div class="col-md-2"><div style="margin-top: 10px"><center>' + objItem.BELUM_DELIVER + '</center></div></div><div class="col-md-2"><input type="text" id="ket_qty' + i + '" name="ket_qty' + i + '" > </div><div class="col-md-1"><input type="checkbox" value="fuck" class="adexe_qty'+i+'" id="adexe_qty'+i+'" name="adexe_qty'+i+'"> </div><div class="col-md-2"><input class="form-control changeQty" id="in_qty' + i + '" name="in_qty' + i + '" type="number"/></div></div>';
        }
        $("#div_root").html(row);
        $('.changeQty').change(function(e) {
            var id    = e.target.id;
            var value = e.target.value;

            var index = id.substring(6);
            var objItem = listItem[index];
            objItem.ISI = value;

            listItem.splice(index,1,objItem);           
        });
    }

    //////////////////////// PENGECEKAN
    $('#b_processSJ').click(function(){
         SJ = $('#in_sj').val();
         $.ajax({
            type:"POST",
            data: {sj:SJ},
            url: baseurl + "PenerimaanPO/cek/loadDataCek",
            success: function(results) {
                listItem = [];
                var arrayRow = $.parseJSON(results);
                $.each(arrayRow, function(i, item) {
                    listItem.push(item);
                });
                showChangePengecekan();
                $.toaster('Data loaded!', 'Load', 'success');
            }
        })
    });

    $('#b_update').click(function() {
        console.log('januck');
        var updateCount = 0
        for(i=0;i<listItem.length;i++){
            var objItem = listItem[i];
                $.ajax({
                    url: baseurl + "PenerimaanPO/C_Pengecekan/updateData",
                    type:"POST",
                    data: jQuery.param({
                        qtyActual : objItem.QTY_ACTUAL,
                        SJ        : SJ,
                        itemName  : objItem.ITEM_NAME,
                        itemDesc  : objItem.ITEM_DESCRIPTION
                    }),
                    success:function(res){
                        console.log(res);   
                      if(++updateCount==listItem.length){
                            $.toaster('Data Updated!', 'Update', 'success');
                            runAPIone(SJ);
                        }
                    }
                });
          
        }
    });


    function runAPIone(){
        $.ajax({
                url: baseurl + "PenerimaanPO/C_Pengecekan/runAPIone",
                type:"POST",
                data: jQuery.param({
                    SJ : SJ
                }),
                success:function(res){
                    console.log(res);
                    runAPItwo(res);
                }
        });
    }

    function runAPItwo(id){
        $.ajax({
                url: baseurl + "PenerimaanPO/C_Pengecekan/runAPItwo",
                type:"POST",
                data: jQuery.param({
                    GROUP_ID : id,
                    SJ : SJ
                }),
                success:function(res){
                    console.log(res);
                    deleteAll(res);
                }
        });
    }

    function deleteAll(res){
            $.ajax({
                url: baseurl + "PenerimaanPO/C_Pengecekan/deleteAll",
                type:"POST",
                data: jQuery.param({
                   IP:res 
                }),
                success:function(adexe){
                    console.log(res);   
                    res = res.replace('"','');
                    res = res.replace('"','');
                    window.open("http://produksi.quick.com/print_pdf_prod/print_letter_ai.php?id="+res,'_blank');
                    console.log(adexe);
                }
        });
    }

    function fuckedCheck(i){
        if($('#chk_qty'+i).checked){
            return true;
        }
        return false;
    }



//PO    VENDOR  TO_CHAR(RECEIPT_DATE,'DDMONYYYY')   TO_CHAR(SP_DATE,'DDMONYYYY')    ITEM_NAME   ITEM_DESCRIPTION    QTY_SJ  QTY_ACTUAL
    function showChangePengecekan() {
        var row = '';
        for (i = 0; i < listItem.length; i++) {
            var objItem = listItem[i];
            row = row + '<div class="col-md-12" style="padding: 5px"><div class="col-md-8"><div>'+objItem.ITEM_NAME+'</div><div>'+objItem.ITEM_DESCRIPTION+'</div></div><div class="col-md-2"><div style="margin-top: 10px"><center>'+objItem.QTY_SJ+'</center></div></div><div class="col-md-2"><div><input class="form-control changeQty" id="in_qty' + i + '" name="in_qty' + i + '" type="number" value="'+objItem.QTY_ACTUAL+'"/></div> </div></div>';
        }
        $("#div_root").html(row);
        $('.changeQty').change(function(e) {
            var id    = e.target.id;
            var value = e.target.value;

            var index          = id.substring(6);
            var objItem        = listItem[index];
            objItem.QTY_ACTUAL = value;

            listItem.splice(index,1,objItem);        
        });
    }
}); 