$(document).ready(function() {

    var listItem = [];
    var SJ;
    
    $('#in_dateRcv').datepicker({ format: 'dd/mm/yyyy' });
    $('#in_dateRcv').datepicker('setDate', new Date());

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
        $.ajax({
            url: baseurl + "PenerimaanPO/awal/loadVendor/" + PO,
            success: function(data) {
                var arrayOne = $.parseJSON(data);
                var vendor = arrayOne[0].VENDOR_NAME;
                $('#sel_vendor').html('<option value="'+vendor+'">' + vendor + '</option>');
                $('#sel_vendor').val(vendor).trigger('change');

                $('#in_sj').val('');
                $('#in_dateShip').val('');
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

        if(SJ.length==0||Vendor.length==0||tglSP.length==0){
            $.toaster('Lengkapi data header!', 'Error', 'error');
        }else{
            for(i=0;i<listItem.length;i++){
            var objItem = listItem[i];

            if(objItem.ISI==0){
                ++actCount;
            }else{
                $.ajax({
                url: baseurl + "PenerimaanPO/C_PenerimaanAwal/insertDataAwal",
                type:"POST",
                data: jQuery.param({
                    po        : $('#in_po').val(),
                    sj        : SJ,
                    vendor    : Vendor,
                    item      : objItem.SEGMENT1,
                    desc      : objItem.ITEM_DESCRIPTION,
                    qtySJ     : objItem.ISI,
                    rcptDate  : "sysdate",
                    spDate    : tglSP,
                    qtyActual : 0,
                    qtyPO     : objItem.QUANTITY  
                }),
                success:function(data){
                    if(++actCount==listItem.length){
                        $.toaster('Data Inserted!', 'Success', 'success');
                        location.reload();
                    }
                }
            })
            }
        }
        }
    });

    function showChange() {
        var row = '';
        for (i = 0; i < listItem.length; i++) {
            var objItem = listItem[i];
            row = row + ' <div class="col-md-12" style="padding: 5px"><div class="col-md-8"><div>' + objItem.SEGMENT1 + '</div><div>' + objItem.ITEM_DESCRIPTION + '</div></div><div class="col-md-2"><div style="margin-top: 10px">' + objItem.QUANTITY + '</div></div><div class="col-md-2"><div><input class="form-control changeQty" id="in_qty' + i + '" name="in_qty' + i + '" type="number" value="' + objItem.ISI + '"/></div></div></div>';
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

    ////////////////////////PENGECEKAN
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
        var updateCount = 0;
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
                success:function(data){
                    if(++updateCount==listItem.length){
                        $.toaster('Data Updated!', 'Update', 'success');
                        location.reload();
                    }
                }
            })
        }
    });
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