function getDataSPB() {
    event.preventDefault();
    $.ajax({
        url: baseurl + "Warehouse/Ajax/getSPB",
        type: 'POST',
        data: $('#formSPB').serialize(),
        beforeSend: function() {
            $('#loadingArea').show();
            $('#tableSPBArea').empty();
        },
        success: function(result) {
            $('#tableSPBArea').html(result);
            $('#loadingArea').hide();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function getDataPackingList() {
    event.preventDefault();
    $.ajax({
        url: baseurl + "Warehouse/Ajax/PackingList",
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
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function updatePackingQty(e, th) {
    if (e.keyCode === 13) {
        var value = $(th).val();
        var qty = Number($('#tblSPB tbody tr[data-row="'+value+'"] input[name="packingqty[]"]').val());
        var maxPack = Number($('#tblSPB tbody tr[data-row="'+value+'"] input[name="maxPack[]"]').val());
        var maxOnhand = Number($('#tblSPB tbody tr[data-row="'+value+'"] input[name="maxOnhand[]"]').val());
        var qtyNow = qty+1;

        if (qtyNow>maxPack) {
            $.toaster('ERROR', 'JUMLAH ITEM TIDAK BOLEH MELEBIHI PERMINTAAN', 'danger');
        }else if (qtyNow>maxOnhand) {
            $.toaster('ERROR', 'JUMLAH ITEM TIDAK BISA MELEBIHI ONHAND', 'danger');
        }else{
            $('#tblSPB tbody tr[data-row="'+value+'"] input[name="packingqty[]"]').val(qtyNow);
        }

        $(th).val('');
        $('#btnSubmitPacking').attr('disabled', false);
        if (true) {
            $('#cetakPackingList').attr('disabled', false);
        }
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

function packingqtyCustom(th) {
    event.preventDefault();
    var sum = $(th).closest('form').find('input[name="sum"]').val();
    var itemcode = $(th).closest('form').find('input[name="itemcode"]').val();
    $('#tblSPB tbody tr[data-row="'+itemcode+'"] input[name="packingqty[]"]').val(sum);
    $('#packingqtyMdl').modal('hide');
}

function setPacking() {
    event.preventDefault();
    $.ajax({
        url: baseurl + "Warehouse/Ajax/setPacking",
        type: 'POST',
        data: $('#formSetPacking').serialize(),
        beforeSend: function() {
            $('#loadingMdl').modal('show');
            $('#submitPacking').modal('hide');
        },
        success: function(result) {
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
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingMdl').modal('hide');
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}