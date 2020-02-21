// $("#inputPackingPlus").on('keyup',function(e){
//     if(e.keyCode  === 13){

//     }
// });

$("#formPackingList").ready(function() {
  $.ajax({
    url: baseurl + "WarehouseSPB/Ajax/checkSPB",
    type: 'POST',
    data: {DATA:'none'},
    success:function(result){
        console.log(result);
        if(result != '"FALSE"'){
            $('input[name="nomerSPB"]').prop('readonly', true);
            $('input[name="nomerSPB"]').attr('readonly', true);
        }
        if(result == 'FALSE'){
            console.log('astagfirullah');   
        }else{
            result = result.replace('"','');
            result = result.replace('"','');
            getDataFapingList(result);
        }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
    }
  });

});


function getDataSPB() {
    event.preventDefault();
    $.ajax({
        url: baseurl + "WarehouseSPB/Ajax/getSPB",
        type: 'POST',
        data: $('#formSPB').serialize(),
        beforeSend: function() {
            $('#loadingArea').show();
            $('#tableSPBArea').empty();
        },
        success: function(result) {
            console.log(result);
            $('#tableSPBArea').html(result);
            $('#loadingArea').hide();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function getDataFapingList(nomerSPBU){
    $.ajax({
        url: baseurl + "WarehouseSPB/Ajax/PackingList",
        type: 'POST',
        data: {nomerSPB : nomerSPBU},
        beforeSend: function() {
            $('#loadingArea').show();
            $('#tablePackingListArea').empty();
        },
        success: function(result) {
            $('input[name="nomerSPB"]').val('');
            $('#tablePackingListArea').html(result);
            $('#loadingArea').hide();
            $('.select2-custom').select2({
                placeholder: "Choose Option",
                allowClear: true,
                width: 'element',
                tags: true,
                id: function(object) {
                    return object.text;
                },
                createSearchChoice: function(term, data) {
                    if ($(data).filter(function() {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                        return {
                            id: term,
                            text: term
                        };
                    }
                }
            });
            $('select#ekspedisi').select2({
                placeholder: "Choose Option",
                allowClear: true,
            });
            $('.toupper').keyup(function(){
                this.value = this.value.toUpperCase();
            });

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            console.log(textStatus);
        }
    });
}

function getDataPackingList() {
    event.preventDefault();
    $.ajax({
        url: baseurl + "WarehouseSPB/Ajax/PackingList",
        type: 'POST',
        data: $('#formPackingList').serialize(),
        beforeSend: function() {
            $('#loadingArea').show();
            $('#tablePackingListArea').empty();
        },
        success: function(result) {
           

            $('input[name="nomerSPB"]').val('');
            $('#tablePackingListArea').html(result);
            $('#loadingArea').hide();
            $('.select2-custom').select2({
                placeholder: "Choose Option",
                allowClear: true,
                width: 'element',
                tags: true,
                id: function(object) {
                    return object.text;
                },
                createSearchChoice: function(term, data) {
                    if ($(data).filter(function() {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                        return {
                            id: term,
                            text: term
                        };
                    }
                }
            });
            $('select#ekspedisi').select2({
                placeholder: "Choose Option",
                allowClear: true,
            });
            $('.toupper').keyup(function(){
                this.value = this.value.toUpperCase();
            });
            
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            console.log(textStatus);
        }
    });
}

function setDataTemp(noSPB){
    $.ajax({
        url: baseurl + "WarehouseSPB/Ajax/setSPB",
        type: 'POST',
        data: {NO_SPB: noSPB},
        success: function(result) {
            $('input[name="nomerSPB"]').val('');
            console.log(result);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            console.log(textStatus);
        }
    });
}

function delTemp(){
    $.ajax({
        url: baseurl + "WarehouseSPB/Ajax/delTemp",
        type: 'POST',
        data: {DATA:'none'},
        success:function(result){
            console.log('adexe');
            $('input[name="nomerSPB"]').attr('readonly', false);
            $('input[name="nomerSPB"]').prop('readonly', false);
            document.location.reload();

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function updatePackingQty(event, th) {
    if (event.keyCode === 13) {
        var value       = $(th).val().toUpperCase();
        var qty         = Number($('#tblSPB tbody tr[data-row="'+value+'"] input[name="packingqty[]"]').val());
        var maxPack     = Number($('#tblSPB tbody tr[data-row="'+value+'"] input[name="maxPack[]"]').val());
        var maxOnhand   = Number($('#tblSPB tbody tr[data-row="'+value+'"] input[name="maxOnhand[]"]').val());
        // var qtyNow      = qty+1;
        var kasih       = Number($('input[name="totalQtyKasih"]').val());
        // console.log(qty);



        // if (qtyNow>maxPack) {
        //     $.toaster('ERROR', 'JUMLAH ITEM TIDAK BOLEH MELEBIHI PERMINTAAN', 'danger');
        //     $('#tblSPB tbody tr[data-row="'+value+'"]').addClass('bg-success');

        // }else if (qtyNow>maxOnhand) {
        //     $.toaster('ERROR', 'JUMLAH ITEM TIDAK BISA MELEBIHI ONHAND', 'danger');
        //     $('#tblSPB tbody tr[data-row="'+value+'"]').addClass('bg-success');
        // }else if ($('#tblSPB tbody tr[data-row="'+value+'"]').length) {
        //     $('#tblSPB tbody tr[data-row="'+value+'"] input[name="packingqty[]"]').val(qtyNow);
        //     kasih+=1;
        //     $('input[name="totalQtyKasih"]').val(kasih);
        // }
        if (maxPack > 10) {
            let foo = prompt('Masukan Quantity');
            var qtyNow = 1*foo;
        }else{
            var qtyNow = qty+1;
        }

        if (qtyNow>maxPack) {
            $.toaster('ERROR', 'JUMLAH ITEM TIDAK BOLEH MELEBIHI PERMINTAAN', 'danger');
            $('#tblSPB tbody tr[data-row="'+value+'"]').addClass('bg-success');

        }else if ($('#tblSPB tbody tr[data-row="'+value+'"]').length) {
            $('#tblSPB tbody tr[data-row="'+value+'"] input[name="packingqty[]"]').val(qtyNow);
            kasih+=1;
            $('input[name="totalQtyKasih"]').val(kasih);
            if(qtyNow == maxPack){
                // console.log(qtyNow);
                $('#tblSPB tbody tr[data-row="'+value+'"]').addClass('bg-success');
            }else{
                // console.log(qtyNow, maxPack);
                $('#tblSPB tbody tr[data-row="'+value+'"]').removeClass('bg-success');
            }
        }


        $(th).val('');
        if (kasih>0 && $('#btnSubmitPacking').attr('disabled')) {
            $('#btnSubmitPacking').prop('disabled',false);
        }
    }else{
        console.log("ADEXE");
    }
}



function mdlPackingQtyCustom(th, itemcode) {
    var qty = $(th).closest('tr').find('input[name="packingqty[]"]').val();
    var onhand = $(th).closest('tr').find('input[name="maxOnhand[]"]').val();
    var required = $(th).closest('tr').find('input[name="maxPack[]"]').val();
    $('#packingqtyMdl input[name="qty"]').val(qty);
    $('#packingqtyMdl input[name="onhand"]').val(onhand);
    $('#packingqtyMdl input[name="required"]').val(required);
    $('#packingqtyMdl input[name="itemcode"]').val(itemcode);
    $('#packingqtyMdl input[name="totalItems"]').val('');
    $('#packingqtyMdl input[name="sum"]').val('');
    $('#packingqtyMdl').modal('show');
}

function getSum(th) {
    var qty = Number($(th).closest('tr').find('input[name="qty"]').val());
    var onhand = Number($(th).closest('tr').find('input[name="onhand"]').val());
    var required = Number($(th).closest('tr').find('input[name="required"]').val());
    var items = Number($(th).val());
    var sum = qty*items;

    if (sum>onhand) {
        $.toaster('ERROR', 'JUMLAH ITEM TIDAK BISA MELEBIHI ONHAND', 'danger');
    }else if (sum>required) {
        $.toaster('ERROR', 'JUMLAH ITEM TIDAK BOLEH MELEBIHI PERMINTAAN', 'danger');
    }else{
        $(th).closest('tr').find('input[name="sum"]').val(sum);
    }
}

function resetThis(th){
    $(th).closest('tr').find('input[name="packingqty[]"]').val(null);
    $(th).closest('tr').removeClass('bg-success');

    
}


function packingqtyCustom(th) {
    event.preventDefault();
    var qty         = Number($(th).closest('form').find('input[name="qty"]').val());
    var sum         = Number($(th).closest('form').find('input[name="sum"]').val());
    var itemcode    = $(th).closest('form').find('input[name="itemcode"]').val();
    var kasih       = Number($('input[name="totalQtyKasih"]').val());
    var a = sum-qty;
    kasih += a;
    $('input[name="totalQtyKasih"]').val(kasih);
    $('#tblSPB tbody tr[data-row="'+itemcode+'"] input[name="packingqty[]"]').val(sum);
    $('#packingqtyMdl').modal('hide');
}

function setPacking() {
    event.preventDefault();
    var nomerSPB = $('#spbNumber').val();
    var itemColy = $('#idItemColy').val();
    
    $('input[name="itemColy"]').val(itemColy);

    console.log(itemColy);
    console.log(nomerSPB);

    $.ajax({
        url: baseurl + "WarehouseSPB/Ajax/setPacking",
        type: 'POST',
        data: $('#formSetPacking').serialize(),
        beforeSend: function() {
            $('#loadingMdl').modal('show');
            $('#submitPacking').modal('hide');
        },
        success: function(result) {
           
            setDataTemp(nomerSPB);

            console.log(data);
            $('#btnSubmitPacking').prop('disabled',true);
            window.open(baseurl+'WarehouseSPB/Transaction/cetakPackingListPDF/'+nomerSPB);
            var data = JSON.parse(result);
            var array = $.map(data, function(value, index) {
                return [value];
            });



            for (var n = 0; n < array.length; n++) {
                var qtyBefore = $('#tblSPB tbody tr[data-id="'+array[n]['INVENTORY_ITEM_ID']+'"] input[name="maxPack[]"]').val();
                var qtyAfter = qtyBefore-(Number(array[n]['PACKING_QTY']));
                $('#tblSPB tbody tr[data-id="'+array[n]['INVENTORY_ITEM_ID']+'"] td.quantityArea').html(qtyAfter);
                $('#tblSPB tbody tr[data-id="'+array[n]['INVENTORY_ITEM_ID']+'"] input[name="maxPack[]"]').val(qtyAfter);
                $('#tblSPB tbody tr[data-id="'+array[n]['INVENTORY_ITEM_ID']+'"] input[name="packingqty[]"]').val('');
            }

            var a = Number($('#formSetPacking input[name="packingNumber"]').val());
            var b = a+1;
            $('#formSetPacking input[name="packingNumber"]').val(b);
            $('#loadingMdl').modal('hide');
            var a = Number($('#inputPackingAct').val());
            a += 1;
            $('#inputPackingAct').val(a);


            


            var kasih = Number($('input[name="totalQtyKasih"]').val());
            var minta = Number($('input[name="totalQtyMinta"]').val());
            if (minta == kasih || minta < kasih && a > 1) {
                $('#cetakPackingList').attr('disabled', false);
            }
            $('#formSetPacking input[name="weight"]').val('');


            $('input[name="nomerSPB"]').prop('readonly', true);
            $('input[name="nomerSPB"]').attr('readonly', true);

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingMdl').modal('hide');
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function enaDisItemScan() {
    var kemasan     = $('select[name="kemasan"]').val();
    var ekspedisi   = $('#ekspedisi').val();
    
    $('input[name="EkspedisiValue"]').val(ekspedisi);

    if (kemasan) {
        $('input[name="ItemCode"]').removeAttr('disabled');
        $('input[name="kemasanValue"]').val(kemasan);
    }else{
        $('input[name="ItemCode"]').attr('disabled', 'disabled');
    }
}