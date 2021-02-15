$(document).on('mainDashboardMenuOpened', () => {
    // Outstanding order Approver
    const approverResponsibilityName = '(Approver)Order Kebutuhan Barang dan Jasa';
    const $approverResponsibilityBoxContent = $(`.info-box .info-box-content:contains(${approverResponsibilityName})`);
    const hasApproverResponsibility = $approverResponsibilityBoxContent.length > 0;

    if (hasApproverResponsibility) {
        $(document).trigger('hasOkebajaResponsibility', [{
            responsibilityName: 'Approver',
            $responsibilityBoxContent: $approverResponsibilityBoxContent,
        }]);
    }

    // Outstanding order Pengelola
    const pengelolaResponsibilityName = '(Pengelola)Order Kebutuhan Barang dan Jasa';
    const $pengelolaResponsibilityBoxContent = $(`.info-box .info-box-content:contains(${pengelolaResponsibilityName})`);
    const hasPengelolaResponsibility = $pengelolaResponsibilityBoxContent.length > 0;

    if (hasPengelolaResponsibility) {
        $(document).trigger('hasOkebajaResponsibility', [{
            responsibilityName: 'Pengelola',
            $responsibilityBoxContent: $pengelolaResponsibilityBoxContent,
        }]);
    }

    // Outstanding order Puller
    const pullerResponsibilityName = '(Puller)Order Kebutuhan Barang dan Jasa';
    const $pullerResponsibilityBoxContent = $(`.info-box .info-box-content:contains(${pullerResponsibilityName})`);
    const hasPullerResponsibility = $pullerResponsibilityBoxContent.length > 0;

    if (hasPullerResponsibility) {
        $(document).trigger('hasOkebajaResponsibility', [{
            responsibilityName: 'Puller',
            $responsibilityBoxContent: $pullerResponsibilityBoxContent,
        }]);
    }

    // Outstanding order Purchasing
    const purchasingResponsibilityName = '(Purchasing)Order Kebutuhan Barang dan Jasa';
    const $purchasingResponsibilityBoxContent = $(`.info-box .info-box-content:contains(${purchasingResponsibilityName})`);
    const hasPurchasingResponsibility = $purchasingResponsibilityBoxContent.length > 0;

    if (hasPurchasingResponsibility) {
        $(document).trigger('hasOkebajaResponsibility', [{
            responsibilityName: 'Purchasing',
            $responsibilityBoxContent: $purchasingResponsibilityBoxContent,
        }]);
    }
});

$(document).on('hasOkebajaResponsibility', (e, { responsibilityName, $responsibilityBoxContent }) => {
    const $badge = $(/* html */`
        <span class="label"></span>
    `);

    $badge.addClass('bg-aqua').html(/* html */`
        <i class="fa fa-spinner fa-spin"></i> Sedang Menghitung Total Order Anda
    `);

    $responsibilityBoxContent.append($badge);

    $.get(`${baseurl}OrderKebutuhanBarangDanJasa/${responsibilityName}/getUnapprovedOrderCount`)
        .done((orderCount) => {
            if (orderCount > 0) {
                $badge.removeClass('bg-aqua').addClass('bg-red').html(/* html */`
                    <i class="fa fa-clock-o"></i> Terdapat ${orderCount} Order yang Belum Anda Approve
                `);
            } else {
                $badge.html(/* html */`
                    <i class="fa fa-check"></i> Terdapat ${orderCount} Order yang Belum Anda Approve
                `);
            }
        }).fail(() => {
            $badge.html(/* html */`
                <i class="fa fa-times"></i> Gagal Menghitung Total Order Anda
            `);
        });
});

(() => {
    if (window.location.href === baseurl) $(document).trigger('mainDashboardMenuOpened');
})();

$(document).ready(function () {
    $.fn.dataTable.moment('DD-MMM-YY');

    //modal status order
    $('.mdlOKBStatusOrder').modal('show');

    $('.btnOKBChangeStatusOrder').on('click', function () {
        $('.mdlOKBStatusOrder').modal('show');
    })

    $('.btnOKBStatusOrderNormal').on('click', function () {
        $('#txtOKBStatusOrder').val('REGULER');
        $('.txaOKBNewOrderListUrgentReason').removeAttr('required');
        $('.slcAlasanUrgensiOKB').removeAttr('required');
        $('.slcAlasanUrgensiOKB').attr('disabled','disabled');
        $('.slcAlasanUrgensiOKB+.select2-container>.selection>.select2-selection').attr({
            style: 'background: #eeeeee; text-align: left;',
        });

        $('.slcAlasanUrgensiOKB').val('').trigger('change.select2');
        $('.txaOKBNewOrderListUrgentReason').val('');
        $('.txaOKBNewOrderListUrgentReason').css('display','none');
        // $('.txaOKBNewOrderListUrgentReason').attr({
        //     style: 'height: 34px; width:360px;'
        // });
        $('.nbdOKB').each(function () {
            // var nbd = $(this).val();
            var prn = $(this).parentsUntil('.tblOKBOrderNew');
            var estArrival = prn.find('.hdnEstArrivalOKB').html();
            var urgentReasontxa = prn.find('.txaOKBNewOrderListUrgentReason');
            var urgentReason = prn.find('.slcAlasanUrgensiOKB+.select2-container>.selection>.select2-selection');
            var urgentReason1 = prn.find('.slcAlasanUrgensiOKB');

            var urgentFlag = prn.find('.hdUrgentFlagOKB');

            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            if($(this).val() != ''){

                // var tanggal = date + '-' + monthNames[month] + '-' + year
                var nbd = $(this).val();
                
                estArrival = estArrival.split('-');

                var year = estArrival[2];
                var month = monthNames.indexOf(estArrival[1]);
                var date = estArrival[0];
    
                nbd = nbd.split('-');
                
                    
                    if (year < nbd[2]) {
                        var tahunBaru = 1;
                    } else if (year == nbd[2]) {
                        var tahunBaru = 0.5;
                    } else {
                        var tahunBaru = 0;
                    }
                    if (month < monthNames.indexOf(nbd[1])) {
                        var bulanBaru = 1;
                    } else if (month == monthNames.indexOf(nbd[1])) {
                        var bulanBaru = 0.5;
                    } else {
                        var bulanBaru = 0;
                    }
                    if (date < nbd[0]) {
                        var tanggalBaru = 1;
                    } else if (date == nbd[0]) {
                        var tanggalBaru = 0.5;
                    } else {
                        var tanggalBaru = 0;
                    }
        
                    if (tahunBaru == 1 || (tahunBaru == 0.5 && bulanBaru == 1) || (tahunBaru == 0.5 && bulanBaru == 0.5 && tanggalBaru == 1) || (tahunBaru == 0.5 && bulanBaru == 0.5 && tanggalBaru == 0.5)) {
                        $(this).attr('style', 'background-color : #00bf024d; width:250px;');
                        urgentReasontxa.removeAttr('required');
                        // urgentReasontxa.attr('readonly','readonly');
                        urgentReasontxa.css('display','none');
                        urgentReasontxa.val('');
                        urgentReason.attr({
                            style: 'background: #eeeeee; text-align: left;',
                        });
                        urgentReason1.attr('disabled','disabled');
                        urgentReason1.val('').trigger('change.select2');
                        urgentFlag.val('N');
                    }else{
                        $(this).attr('style', 'background-color : #ff00004d; width:250px;');
                        urgentReasontxa.attr('required');
                        urgentReasontxa.removeAttr('readonly');
                        // urgentReasontxa.css('display','block');
                        urgentReason1.removeAttr('disabled');
                        urgentReason.attr({
                            style: 'background: #fbfb5966; text-align: left;',
                        });
                        urgentFlag.val('Y');
                    }
                
            }
        })
        $('#txtOKBHdnStatusOrder').val('N');
        $('.bright-warning').children().attr('class', 'fa fa-fw fa-check');
        $('.bright-warning').attr('class', 'input-group-addon bright-success');
    });
    
    $('.btnOKBStatusOrderFollowUp').on('click', function () {
        Swal.fire({
            type: 'warning',
            title: 'Peringatan',
            text: 'Alasan Urgensi wajib diisi!',
        });
        $('#txtOKBStatusOrder').val('EMERGENCY (SUSULAN)');
        $('.nbdOKB').attr('style', 'background-color : #fbfb5966; width:150px;');
        $('.slcAlasanUrgensiOKB').removeAttr('disabled');
        $('.slcAlasanUrgensiOKB').attr('required','required');
        $('.txaOKBNewOrderListUrgentReason').attr('required','required');
        
        $('.slcAlasanUrgensiOKB+.select2-container>.selection>.select2-selection').attr({
            style: 'background: #fbfb5966; text-align: left;'
        });
        
        $('#txtOKBHdnStatusOrder').val('Y');
        $('.bright-success').children().attr('class', 'fa fa-warning');
        $('.bright-success').attr('class', 'input-group-addon bright-warning');
    });
    //end status order

    // place order
    $('.slcOKBNewOrderList').select2({
        ajax: {
            url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchItem',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.INVENTORY_ITEM_ID,
                            text: item.SEGMENT1,
                            title: item.DESCRIPTION,
                            uom1: item.PRIMARY_UOM,
                            uom2: item.SECONDARY_UOM,
                            kategori_item : item.KATEGORI_ITEM,
                            leadtime : item.TOTAL_LEAD_TIME,
                            nbd: item.DEFAULT_NBD,
                            allow_desc : item.ALLOW_DESC,
                            cut_off : item.CUTOFF_TERDEKAT,
                            txt : item.SEGMENT1,
                            setup_item : item.SETUP_ITEM,
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
        placeholder: 'Kode Barang',
        // dropdownParent : $('#parentsItemOKB')
        
    })

    $('.slcOKBNewOrderListNamaBarang').select2({
        ajax: {
            url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchItem',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.INVENTORY_ITEM_ID,
                            text: item.DESCRIPTION,
                            title: item.DESCRIPTION,
                            uom1: item.PRIMARY_UOM,
                            uom2: item.SECONDARY_UOM,
                            kategori_item : item.KATEGORI_ITEM,
                            leadtime : item.TOTAL_LEAD_TIME,
                            nbd: item.DEFAULT_NBD,
                            allow_desc : item.ALLOW_DESC,
                            cut_off : item.CUTOFF_TERDEKAT,
                            txt : item.SEGMENT1,
                            setup_item : item.SETUP_ITEM,
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
        placeholder: 'Nama Barang',
        // dropdownParent : $('#parentsItemOKB')
        
    })


    $('.slcOKBNewUomList').select2({
        dropdownParent : $('#parentsItemOKB')
    });

    $('.slcOKBOrder').on('select2:open', function (e) {
        const evt = "scroll.select2";
        $(e.target).parents().off(evt);
        $(window).off(evt);
    });

    $(document).on('change','.slcOKBNewOrderList',function () {
            $('.tblOKBOrderNew').focus();
            let ItemName = $(this).select2('data')[0]['title'];
            itemkode = $(this).select2('data')[0]['txt'];
            leadtime = $(this).select2('data')[0]['leadtime'];
            nbd = $(this).select2('data')[0]['nbd'];
            allow_desc = $(this).select2('data')[0]['allow_desc'];
            kategoriItem = $(this).select2('data')[0]['kategori_item'];
            primary_uom = $(this).select2('data')[0]['uom1'];
            secondary_uom = $(this).select2('data')[0]['uom2'];
            cutoff_terdekat = $(this).select2('data')[0]['cut_off'];
            inv_item_id = $(this).val();
            setup_item = $(this).select2('data')[0]['setup_item'];

            var prn = $(this).parentsUntil('.tblOKBOrderNew');
            if (setup_item != 'BELUM DI SET') {
                // console.log(prn)

                prn.find('.slcOKBNewOrderListNamaBarang').val(ItemName);
                prn.find('.slcOKBNewOrderListNamaBarang').empty();
                var html = '<option value="'+inv_item_id+'">'+ItemName+'</option>';

                prn.find('.slcOKBNewOrderListNamaBarang').append(html);
                prn.find('.slcOKBNewOrderListNamaBarang').val(inv_item_id).trigger('change.select2');

                prn.find('.leadtimeOKB').val(leadtime);
                prn.find('.kategoriItemOKB').val(kategoriItem);

                prn.find('.btnOKBStokNew').val(itemkode);
                prn.find('.btnOKBStokNew').removeAttr('style');

                var desc = prn.find('.txaOKBNewOrderDescription');
                if (allow_desc == 'Y') {
                    desc.removeAttr('readonly');
                    desc.attr('required','required');
                    desc.attr({
                        style: 'height: 34px; width:360px; background-color :#fbfb5966;'
                    });
                }else{
                    desc.val(ItemName);
                    desc.attr('readonly','readonly');
                    desc.attr({
                        style: 'height: 34px; width:360px;'
                    });
                }

                //uom
                var html = '<option value="'+primary_uom+'" selected>'+primary_uom+'</option>';
                if (secondary_uom != null && secondary_uom!='') {
                    html += '<option value="'+secondary_uom+'">'+secondary_uom+'</option>';
                }

                prn.find('.slcOKBNewUomList').html(html);
                prn.find('.slcOKBNewUomList').val(primary_uom).trigger('change.select2');
                // end uom

                prn.find('.hdnItemCodeOKB').val(itemkode+' - '+ItemName);

                //nbd
                // prn.find('.nbdOKB').val(nbd);
                prn.find('.hdnEstArrivalOKB').html(nbd);
                var html = '<input type="hidden" class="form-control" name="cutoff[]" id="" value="'+cutoff_terdekat+'"></input>';
                prn.find('.hdnECutOffOKB').html(cutoff_terdekat+html);
                prn.find('.hdnTemporaryNbd').val(nbd);
                // prn.find('.nbdOKB').attr('style', 'background-color : #00bf024d; width:150px;');
                
                $('.nbdOKB').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd-M-yyyy'
                });
                //end nbd

                destinationLine(prn);
            }else{
                swal.fire({
                    type: 'error',
                    title: 'Item ini belum di setting, Silahkan hubungi Pembelian!'
                })
                $(this).val('').trigger('change.select2');
                prn.find('.slcOKBNewOrderListNamaBarang').val('').trigger('change.select2');
            }

            
    });

    $(document).on('change','.slcOKBNewOrderListNamaBarang', function () {
        ItemName = $(this).select2('data')[0]['title'];
        itemkode = $(this).select2('data')[0]['txt'];
        leadtime = $(this).select2('data')[0]['leadtime'];
        nbd = $(this).select2('data')[0]['nbd'];
        allow_desc = $(this).select2('data')[0]['allow_desc'];
        kategoriItem = $(this).select2('data')[0]['kategori_item'];
        primary_uom = $(this).select2('data')[0]['uom1'];
        secondary_uom = $(this).select2('data')[0]['uom2'];
        cutoff_terdekat = $(this).select2('data')[0]['cut_off'];
        inv_item_id = $(this).val();
        setup_item = $(this).select2('data')[0]['setup_item'];

        var prn = $(this).parentsUntil('.tblOKBOrderNew');

        if (setup_item != 'BELUM DI SET') {
            prn.find('.btnOKBStokNew').val(itemkode);
            prn.find('.btnOKBStokNew').removeAttr('style');

            prn.find('.slcOKBNewOrderList').empty();
            var html = '<option value="'+inv_item_id+'">'+itemkode+'</option>';

            prn.find('.slcOKBNewOrderList').append(html);
            prn.find('.slcOKBNewOrderList').val(inv_item_id).trigger('change.select2');

            prn.find('.leadtimeOKB').val(leadtime);
            prn.find('.kategoriItemOKB').val(kategoriItem);

            var desc = prn.find('.txaOKBNewOrderDescription');
            if (allow_desc == 'Y') {
                desc.removeAttr('readonly');
                desc.attr('required','required');
                desc.attr({
                    style: 'height: 34px; width:360px; background-color :#fbfb5966;'
                });
            }else{
                desc.val(ItemName);
                desc.attr('readonly','readonly');
                desc.attr({
                    style: 'height: 34px; width:360px;'
                });
            }

            //uom
            var html = '<option value="'+primary_uom+'" selected>'+primary_uom+'</option>';
            if (secondary_uom != null && secondary_uom!='') {
                html += '<option value="'+secondary_uom+'">'+secondary_uom+'</option>';
            }

            prn.find('.slcOKBNewUomList').html(html);
            prn.find('.slcOKBNewUomList').val(primary_uom).trigger('change.select2');
            // end uom

            prn.find('.hdnItemCodeOKB').val(itemkode+' - '+ItemName);

            //nbd
            // prn.find('.nbdOKB').val(nbd);
            prn.find('.hdnEstArrivalOKB').html(nbd);
            prn.find('.hdnECutOffOKB').html(cutoff_terdekat);
            prn.find('.hdnTemporaryNbd').val(nbd);
            // prn.find('.nbdOKB').attr('style', 'background-color : #00bf024d; width:150px;');
                
            $('.nbdOKB').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd-M-yyyy'
            });
                //end nbd

            destinationLine(prn);
        }else{
            swal.fire({
                type: 'error',
                title: 'Item ini belum di setting, Silahkan hubungi Pembelian!'
            })
            $(this).val('').trigger('change.select2');
            prn.find('.slcOKBNewOrderList').val('').trigger('change.select2');
        }

        
    });

    $(document).on('input','.txtOKBNewOrderListQty', function(event) {
        var value_input = $(this).val();
        var value_split = value_input.split(".");
        var hasil = value_split[0].replace(/\D/g, '').toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")

        if (value_split.length > 1) {
            return $(this).val(hasil + '.' + value_split[1].slice(0, 1));
        } else if (value_split.length <= 1) {
            return $(this).val(hasil);
        }

    })

     //change nbd
     $(document).on('change','.nbdOKB', function () {
        // var estArrival = new Date();
        var susulan = $('#txtOKBHdnStatusOrder').val();
        var estArrival = $(this).parentsUntil('.tblOKBOrderNew').find('.hdnEstArrivalOKB').html();
        // alert(estArrival);
        var leadtime = $(this).parentsUntil('.tblOKBOrderNew').find('.leadtimeOKB').val();
        var urgentReasontxa = $(this).parentsUntil('.tblOKBOrderNew').find('.txaOKBNewOrderListUrgentReason');
        var urgentReason = $(this).parentsUntil('.tblOKBOrderNew').find('.slcAlasanUrgensiOKB+.select2-container>.selection>.select2-selection');
        var urgentReason1 = $(this).parentsUntil('.tblOKBOrderNew').find('.slcAlasanUrgensiOKB');
        var urgentFlag = $(this).parentsUntil('.tblOKBOrderNew').find('.hdUrgentFlagOKB');

        

        // estArrival.setDate(estArrival.getDate() + Number(leadtime));

        // var year = estArrival.getFullYear();
        // var month = estArrival.getMonth();
        // var date = estArrival.getDate();

        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        
        // date = ("00" + date).slice(-2);

        if($(this).val() != ''){

            // var tanggal = date + '-' + monthNames[month] + '-' + year
            var nbd = $(this).val();
            
            estArrival = estArrival.split('-');

            var year = estArrival[2];
            var month = monthNames.indexOf(estArrival[1]);
            var date = estArrival[0];

            nbd = nbd.split('-');
            
            if (susulan != 'Y') {
                
                if (year < nbd[2]) {
                    var tahunBaru = 1;
                } else if (year == nbd[2]) {
                    var tahunBaru = 0.5;
                } else {
                    var tahunBaru = 0;
                }
                if (month < monthNames.indexOf(nbd[1])) {
                    var bulanBaru = 1;
                } else if (month == monthNames.indexOf(nbd[1])) {
                    var bulanBaru = 0.5;
                } else {
                    var bulanBaru = 0;
                }
                if (date < nbd[0]) {
                    var tanggalBaru = 1;
                } else if (date == nbd[0]) {
                    var tanggalBaru = 0.5;
                } else {
                    var tanggalBaru = 0;
                }
    
                if (tahunBaru == 1 || (tahunBaru == 0.5 && bulanBaru == 1) || (tahunBaru == 0.5 && bulanBaru == 0.5 && tanggalBaru == 1) || (tahunBaru == 0.5 && bulanBaru == 0.5 && tanggalBaru == 0.5)) {
                    $(this).attr('style', 'background-color : #00bf024d; width:250px;');
                    urgentReasontxa.removeAttr('required');
                    // urgentReasontxa.attr('readonly','readonly');
                    urgentReasontxa.css('display','none');
                    urgentReasontxa.val('');
                    urgentReason.attr({
                        style: 'background: #eeeeee; text-align: left;',
                    });
                    urgentReason1.attr('disabled','disabled');
                    urgentReason1.val('').trigger('change.select2');
                    urgentFlag.val('N');
                    
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Peringatan',
                        text: 'Order ini berstatus urgent, Silahkan mengisi alasan urgensi !',
                    });
                    $(this).attr('style', 'background-color : #ff00004d; width:250px;');
                    urgentReasontxa.attr('required');
                    urgentReasontxa.removeAttr('readonly');
                    // urgentReasontxa.css('display','block');
                    urgentReason1.removeAttr('disabled');
                    urgentReason.attr({
                        style: 'background: #fbfb5966; text-align: left;',
                    });
                    urgentFlag.val('Y');
                }
            }
        }

    })
    //end change nbd

    //set select2
    $('.slcOKBNewUomList').select2();

    $('.slcApproverUnitOKB').select2();

    $('.organizationOKB').select2();
    $('.locationOKB').select2();
    $('.subinventoryOKB').select2();

    $('.checkBoxConfirmOrderOkebaja').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('.checkBoxConfirmOrderOkebaja').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $('.btnBuatOrderOkebaja').removeAttr('disabled');
        } else {
            $('.btnBuatOrderOkebaja').attr('disabled','disabled');
        }
    });

    $('.checkAllApproveOKB').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('.checkApproveOKB').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_flat-blue'
    });
    //end set

    //add order
    $('.btnOKBNewOrderList').click(function(){
        var susulan = $('#txtOKBHdnStatusOrder').val();
        // alert(susulan)
        if (susulan == 'Y') {
            var requi = 'required';
            // var colorr = 'background-color: #fbfb5966;';
            
            var disab = '';
        }else{
            var requi = '';
            var colorr = '';
            var disab = 'disabled';
        }

        $('.btnOKBNewOrderListDelete:first').removeAttr('disabled');

        var LastDataRow = Number($('.formOKB:last').attr('id-form'));

        var html = '<div class="col-md-12 formOKB" id-form="' + (LastDataRow + 1) + '">' +
            '<div class="box box-primary">' +
            '<div class="box-header">' +
            '<div class="box-title with-border">' +
            'Order No : ' + (LastDataRow + 1) +
            ' <button type="button" class="btn btn-success btnOKBNewOrderListCancel" title="clear line" data-row="' + (LastDataRow + 1) + '"><i class="fa fa-refresh"></i></button>&nbsp;' +
            '<button type="button" class="btn btn-danger btnOKBNewOrderListDelete" disabled><i class="fa fa-trash"></i></button>&nbsp;' +
            '<span class="OKBOrderNameMinimize"></span>' +
            '</div>' +
            '<div class="pull-right">' +
            '<button type="button" class="btn btn-box-tool OKBMinimize" data-widget="collapse"><i class="fa fa-minus"></i></button>' +
            '</div>' +
            '</div>' +
            '<div class="box-body" id="parentsItemOKB">' +
            '<table class="table tblOKBOrderNew"' +
            '<tr>' +
            '<th>Kode Barang</th>' +
            '<th>:</th>' +
            '<td><select class="select2 slcOKBNewOrderList slcOKBOrder" name="slcOKBinputCode[]" required style="width:360px"></select> <button type="button" class="btn btn-default btnOKBStokNew" style="display:none">INFO</button></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Nama Barang</th>' +
            '<th>:</th>' +
            '<td><select class="select2 slcOKBNewOrderListNamaBarang slcOKBOrder" name="" required style="width:360px"></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Deskripsi</th>' +
            '<th>:</th>' +
            '<td><textarea style="height: 34px; width:360px;" class="form-control txaOKBNewOrderDescription" name="txtOKBinputDescription[]" readonly></textarea></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Quantity</th>' +
            '<th>:</th>' +
            '<td><input type="text" class="form-control txtOKBNewOrderListQty" name="txtOKBinputQty[]" required style="background-color: #fbfb5966; width:250px;"></td>' +
            '</tr>' +
            '<tr>' +
            '<th>UOM</th>' +
            '<th>:</th>' +
            '<td><select class="form-control select2 slcOKBNewUomList slcOKBOrder" name="slcOKBuom[]" required style="width:250px"></select></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Kategori Item</th>' +
            '<th>:</th>' +
            '<td><input type="text" class="form-control kategoriItemOKB" name="" id="" style="width:360px" readonly></td>' +
            '</tr>' +

            '<tr>' +
            '<th>Estimasi Kedatangan Barang</th>' +
            '<th>:</th>' +
            '<td class="hdnEstArrivalOKB"></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Cut Off Terdekat</th>' +
            '<th>:</th>' +
            '<td class="hdnECutOffOKB"></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Tanggal Kebutuhan (Need By Date/NBD)</th>' +
            '<th>:</th>' +
            '<td><input type="text" class="form-control nbdOKB" name="txtOKBnbd[]" id="" required style="background-color: #fbfb5966; width:250px;" autocomplete="off"></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Destination Type</th>' +
            '<th>:</th>' +
            '<td>' +
            '<div class="loadingDestinationOKB" style="display:none; width:100%;margin-top: 0px;margin-bottom: 20px" data-row="1">' +
            '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>' +
            '</div>' +
            '<div class="dest_typeOKB" style="display: block;">' +
            '<input type="text" class="form-control text-center destinationOKB" id="txtModalDestination" style="width: 250px;" name="hdnDestinationOKB[]" title="Destination Type" readonly>' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Organization</th>' +
            '<th>:</th>' +
            '<td>' +
            '<div class="loadingOrganizationOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">' +
            '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>' +
            '</div>' +
            '<div class="viewOrganizationOKB" style="display: block;">' +
            '<select class="select2 organizationOKB slcModalOrganization" id="slcModalOrganization" style="width: 250px; text-align:center" name="organizationOKB[]" required title="Organization">' +
            '<option></option>' +
            '</select>' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Location</th>' +
            '<th>:</th>' +
            '<td>' +
            '<div class="loadingLocationOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">' +
            '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>' +
            '</div>' +
            '<div class="viewLocationOKB">' +
            '<select class="select2 locationOKB slcLocation" id="slcLocation" style="width: 250px; text-align:center" name="locationOKB[]" required title="Location>' +
            '<option></option>' +
            '</select>' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Subinventory</th>' +
            '<th>:</th>' +
            '<td>' +
            '<div class="loadingSubinventoryOKB" style="display: none; width:100%;margin-top: 0px;margin-bottom: 20px">' +
            '<img style="width:50px" src="' + baseurl + 'assets/img/gif/loading5.gif"/>' +
            '</div>' +
            '<div class="viewSubinventoryOKB">' +
            '<select class="select2 subinventoryOKB" id="slcSubinventory" style="width: 250px; text-align:center">' +
            '<option></option>' +
            '</select>' +
            '<input type="hidden" class="hdnSubinvOKB" name="subinventoyOKB[]">' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Alasan Order</th>' +
            '<th>:</th>' +
            '<td><textarea style="height: 34px; width:360px; background-color: #fbfb5966;" class="form-control txaOKBNewOrderListReason" name="txtOKBinputReason[]" required></textarea></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Alasan Urgensi</th>' +
            '<th>:</th>' +
            '<td>' +
            '<select class="select2 slcAlasanUrgensiOKB" style="width: 250px;"' + disab + '>' +
            '<option></option>' +
            '<option value="Perubahan Rencana Penjualan">Perubahan Rencana Penjualan</option>' +
            '<option value="Kesalahan Perencanaan Seksi">Kesalahan Perencanaan Seksi</option>' +
            '<option value="Manajemen Stok Gudang">Manajemen Stok Gudang</option>' +
            '<option value="Kebutuhan Proses Beli">Kebutuhan Proses Beli</option>' +
            '<option value="Barang Reject / Proses Produksi Reject">Barang Reject / Proses Produksi Reject</option>' +
            '<option value="0">Lain-Lain</option>' +
            '</select><br><br>' +
            '<textarea style="height: 34px; width:360px; display:none;" class="form-control txaOKBNewOrderListUrgentReason" name="txtOKBinputUrgentReason[]"></textarea>' +
            '</tr>' +
            '<tr>' +
            '<th>Note to Pengelola</th>' +
            '<th>:</th>' +
            '<td><textarea style="height: 34px; width:360px; " class="form-control txaOKBNewOrderListNote" name="txtOKBinputNote[]"></textarea></td>' +
            '</tr>' +
            '<tr>' +
            '<th>Attachment</th>' +
            '<th>:</th>' +
            '<td class="tdOKBInputFileAttachment">' +
            '<small>*Tipe file selain jpg, jpeg, png, pdf juga dapat diupload, tetapi tidak dapat dipreview (Bisa didownload).</small>' +
            '<li style="list-style: none; width: 100%;">' +
            '<input type="file" name="fileOKBAttachment' + (LastDataRow + 1) + '[]" style="display: inline-block;">' +
            '<button type="button" class="btn btn-primary ml-3 btnOKBAddInputAttachment" data-row="' + (LastDataRow + 1) + '" style="display: inline-block;"><i class="fa fa-plus"></i></button>' +
            '</li>' +
            '</td>' +
            '</tr>' +
            '<tr style="display:none">' +
            '<th><input type="hidden" class="hdUrgentFlagOKB" name="hdnUrgentFlagOKB[]"></th>' +
            '<th><input type="hidden" class="hdnItemCodeOKB" name="hdnItemCodeOKB[]"></th>' +
            '</tr>' +
            '<div class="modal fade mdlOKBListOrderStock" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">' +
            '<div class="modal-dialog" style="width:750px;">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '<h4><i style="vertical-align: middle;" class="fa fa-check-circle-o"> </i> Stock <b>Item</b></h4>' +
            '</div>' +
            '<div class="modal-body" style="height: 300px;">' +
            '<center>' +
            ' <div class="row text-primary divOKBListOrderStockLoading" style="width: 400px; margin-top: 25px; display: none;">' +
            '<label class="control-label"+ <h4> <img style="width:30px" src="' + baseurl + 'assets/img/gif/loading5.gif"> <b>Sedang Mengambil Data ...</b></h4> </label>' +
            '</div>' +
            '</center>' +
            '<div class="row divStockOKB"></div>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</table>' +
            '</div>' +
            '</div>' +
            '</div>';

        $('.formOKB').parent().append(html);
        $('.btnOKBNewOrderListDelete:last').removeAttr('disabled');

        $('.slcOKBNewOrderList').select2({
            ajax: {
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchItem',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.INVENTORY_ITEM_ID,
                                text: item.SEGMENT1,
                                title: item.DESCRIPTION,
                                uom1: item.PRIMARY_UOM,
                                uom2: item.SECONDARY_UOM,
                                kategori_item : item.KATEGORI_ITEM,
                                leadtime : item.TOTAL_LEAD_TIME,
                                nbd: item.DEFAULT_NBD,
                                allow_desc : item.ALLOW_DESC,
                                cut_off : item.CUTOFF_TERDEKAT,
                                txt : item.SEGMENT1,
                                setup_item : item.SETUP_ITEM,
                            }
                        })
                    };
                },
                cache: true,
            },
            minimumInputLength: 4,
            placeholder: 'Kode Barang',
        });

        $('.slcOKBNewOrderListNamaBarang').select2({
            ajax: {
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchItem',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.INVENTORY_ITEM_ID,
                                text: item.DESCRIPTION,
                                title: item.DESCRIPTION,
                                uom1: item.PRIMARY_UOM,
                                uom2: item.SECONDARY_UOM,
                                kategori_item : item.KATEGORI_ITEM,
                                leadtime : item.TOTAL_LEAD_TIME,
                                nbd: item.DEFAULT_NBD,
                                allow_desc : item.ALLOW_DESC,
                                cut_off : item.CUTOFF_TERDEKAT,
                                txt : item.SEGMENT1,
                                setup_item : item.SETUP_ITEM,
                            }
                        })
                    };
                },
                cache: true,
            },
            minimumInputLength: 4,
            placeholder: 'Nama Barang',
            // dropdownParent : $('#parentsItemOKB')
            
        });

        $('.slcOKBOrder').on('select2:open', function (e) {
            const evt = "scroll.select2";
            $(e.target).parents().off(evt);
            $(window).off(evt);
        });

        $('.slcAlasanUrgensiOKB').select2({
            placeholder : 'Pilih Alasan Urgensi',
        });

        if (susulan == 'Y') {

            $('.slcAlasanUrgensiOKB+.select2-container>.selection>.select2-selection').attr({
                style: 'background: #fbfb5966; text-align: left;'
            });
        }

        // $('.slcOKBNewUomList').select2({
        //     dropdownParent : $('#parentsItemOKB')
        // });

        $('.slcOKBNewUomList').select2();
        $('.organizationOKB').select2();
        $('.locationOKB').select2();
        $('.subinventoryOKB').select2();
    })
    //end add

    //delete form order
    //remove
    $(document).on('click', '.btnOKBNewOrderListDelete', function(){
        var count = $('.formOKB').length;
        // alert(count);
        $(this).parentsUntil('.bodyformOKB').remove();

        if (count == 2) {
            $('.btnOKBNewOrderListDelete').attr('disabled','disabled')
        }
    });
    //clear
    $(document).on('click', '.btnOKBNewOrderListCancel', function(){
        var row_id = $(this).attr('data-row');
        $('.destinationOKB[data-row="'+row_id+'"]').val('');
        $('.organizationOKB[data-row="'+row_id+'"]').val('').trigger('change.select2');
        $('.locationOKB[data-row="'+row_id+'"]').val('').trigger('change.select2');
        $(this).parentsUntil('.bodyformOKB').find('input, textarea').val('');
        $(this).parentsUntil('.bodyformOKB').find('.OKBOrderNameMinimize').html('');
        $(this).parentsUntil('.bodyformOKB').find('select').val('').trigger('change.select2');
    });
    //end delete form order

    // end place order

    //start approve order
    var tableOKB = $('.tblOKBOrderList').DataTable({
        scrollY: "370px",
        // fixedColumns:   {
        //     leftColumns: 5
        // },
        scrollX: true,
        scrollCollapse: true,
        columnDefs: [ {
            "targets": 0,
            "orderable": false
        } ],
        order: [[1, 'asc']],
    });

    $('.checkAllApproveOKB').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $('.checkApproveOKB').iCheck('check');
            // alert('benith my skins');
        } else {
            $('.checkApproveOKB').iCheck('uncheck');
        }
                                                    
        $('.checkApproveOKB').on('ifChanged', function(event) {
            if ($('.checkApproveOKB').filter(':checked').length == $('.checkApproveOKB').length) {
                // alert('benith my skins');
                $('.checkAllApproveOKB').prop('checked', 'checked');
            } else {
                $('.checkAllApproveOKB').prop('checked', false);
            }
                $('.checkAllApproveOKB').iCheck('update');
            });
    });

    $(document).on('click', '.btnOKBListOrderHistory', function () {
        let orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html()        
        $('.mdlOKBListOrderHistory-'+orderid).modal('show');
        if ( $('.divOKBListOrderHistory-'+orderid).find('span:first').html() == '' ) {
            $('.divOKBListOrderHistoryLoading-'+orderid).fadeIn();
            $.ajax({
                type: "post",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getHistoryOrder",
                data: {orderid: orderid},
                dataType: "json",
                success: function (resp) {
                    $('.divOKBListOrderHistoryLoading-'+orderid).hide();
                    $('.divOKBListOrderHistory-'+orderid).fadeIn();
                    $(resp).each( function ( index, value ) {
                        console.log(value)
                        if ( value.JUDGEMENT == 'A' ) {
                            var order_class = 'approved',
                                status      = 'Order Approved',
                                icon_class  = 'fa fa-check',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';                                
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Approved pada order ini ';
                                    if (value.ITEM_DESCRIPTION_BEFORE && value.ITEM_DESCRIPTION_AFTER) {
                                        explain += 'dan telah mengubah deskripsi item dari <b>'+value.ITEM_DESCRIPTION_BEFORE+'</b> menjadi <b>'+value.ITEM_DESCRIPTION_AFTER+'</b> ';

                                        if (value.QUANTITY_BEFORE && value.QUANTITY_AFTER) {
                                            explain += 'kemudian mengubah quantity item dari <b>'+value.QUANTITY_BEFORE+' '+value.UOM+'</b> menjadi <b>'+value.QUANTITY_AFTER+' '+value.UOM+'</b> ';

                                            if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                                explain += 'dan mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b>';
                                            }
                                        }else if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                            explain += 'kemudian mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b>';
                                        }

                                    }else if (value.QUANTITY_BEFORE && value.QUANTITY_AFTER) {
                                        explain += 'dan telah mengubah quantity item dari <b>'+value.QUANTITY_BEFORE+' '+value.UOM+'</b> menjadi <b>'+value.QUANTITY_AFTER+' '+value.UOM+'</b> ';

                                        if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                            explain += 'kemudian mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b> ';
                                        }
                                    }else if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                        explain += 'dan telah mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b>';
                                    }
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Approved pada order ini ';
                                    if (value.ITEM_DESCRIPTION_BEFORE && value.ITEM_DESCRIPTION_AFTER) {
                                        explain += 'dan telah mengubah deskripsi item dari <b>'+value.ITEM_DESCRIPTION_BEFORE+'</b> menjadi <b>'+value.ITEM_DESCRIPTION_AFTER+'</b> ';

                                        if (value.QUANTITY_BEFORE && value.QUANTITY_AFTER) {
                                            explain += 'kemudian mengubah quantity item dari <b>'+value.QUANTITY_BEFORE+' '+value.UOM+'</b> menjadi <b>'+value.QUANTITY_AFTER+' '+value.UOM+'</b> ';

                                            if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                                explain += 'dan mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b>';
                                            }
                                        }else if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                            explain += 'kemudian mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b>';
                                        }

                                    }else if (value.QUANTITY_BEFORE && value.QUANTITY_AFTER) {
                                        explain += 'dan telah mengubah quantity item dari <b>'+value.QUANTITY_BEFORE+' '+value.UOM+'</b> menjadi <b>'+value.QUANTITY_AFTER+' '+value.UOM+'</b> ';

                                        if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                            explain += 'kemudian mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b> ';
                                        }
                                    }else if (value.ORDER_PURPOSE_BEFORE && value.ORDER_PURPOSE_AFTER) {
                                        explain += 'dan telah mengubah alasan order dari <b>'+value.ORDER_PURPOSE_BEFORE+'</b> menjadi <b>'+value.ORDER_PURPOSE_AFTER+'</b>';
                                    }
                                }
                        } else if ( value.JUDGEMENT == 'R' ) {
                            var order_class = 'rejected',
                                status      = 'Order Rejected',
                                icon_class  = 'fa fa-times-circle-o',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                }                                
                        } else {
                            var order_class = 'waiting',
                                status      = 'Sedang Menunggu Keputusan',
                                icon_class  = 'fa fa-clock-o',
                                date        = '';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Approval order ini menunggu keputusan anda.';
                                } else {
                                    var explain = 'Approval order ini sedang diproses oleh '+value.FULL_NAME+'.';
                                }
                        }
                        if ( index == 0 ) {
                            $('.divOKBListOrderHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        } else if ( index > 0 && resp[index-1].JUDGEMENT != null && resp[index-1].JUDGEMENT != 'R' ) {
                            $('.divOKBListOrderHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        }
                    })
                }
            });
        }   
    });

    $(document).on('click', '.btnOKBListRequisitionHistory', function () {
        let orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html()        
        // alert(orderid)
        $('.mdlOKBListRequisitionHistory-'+orderid).modal('show');
        if ( $('.divOKBListRequisitionHistory-'+orderid).find('span:first').html() == '' ) {
            $('.divOKBListRequisitionHistoryLoading-'+orderid).fadeIn();
            $.ajax({
                type: "post",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Pengelola/getHistoryRequisition",
                data: {pre_req_id: orderid},
                dataType: "json",
                success: function (resp) {
                    $('.divOKBListRequisitionHistoryLoading-'+orderid).hide();
                    $('.divOKBListRequisitionHistory-'+orderid).fadeIn();
                    $(resp).each( function ( index, value ) {
                        console.log(value)
                        if ( value.JUDGEMENT == 'A' ) {
                            var order_class = 'approved',
                                status      = 'Order Approved',
                                icon_class  = 'fa fa-check',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';                                
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Approved pada order ini.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Approved pada order ini.';
                                }
                        } else if ( value.JUDGEMENT == 'R' ) {
                            var order_class = 'rejected',
                                status      = 'Order Rejected',
                                icon_class  = 'fa fa-times-circle-o',
                                date        = '['+value.JUDGEMENT_DATE+'] - ';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Anda telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                } else {
                                    var explain = value.FULL_NAME+' telah memberi keputusan Rejected pada order ini dengan alasan '+value.NOTE+'.';
                                }                                
                        } else {
                            var order_class = 'waiting',
                                status      = 'Sedang Menunggu Keputusan',
                                icon_class  = 'fa fa-clock-o',
                                date        = '';
                                if ( value.NATIONAL_IDENTIFIER == $('#txtOKBOrderRequestorId').val() ) {
                                    var explain = 'Approval order ini menunggu keputusan anda.';
                                } else {
                                    var explain = 'Approval order ini sedang diproses oleh '+value.FULL_NAME+'.';
                                }
                        }
                        if ( index == 0 ) {
                            $('.divOKBListRequisitionHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        } else if ( index > 0 && resp[index-1].JUDGEMENT != null && resp[index-1].JUDGEMENT != 'R' ) {
                            $('.divOKBListRequisitionHistory-'+orderid).find('span:first').append(
                                '<p>\
                                    <b>'+date+'</b>\
                                    <span class="'+order_class+'"><label class="control-label"><i class="'+icon_class+'"></i><b> '+status+' </b></label> - '+explain+' </span>\
                                </p>'
                            );
                        }
                    })
                }
            });
        }   
    });

    $('.slcTindakanOKB').select2({
        placeholder: '--tindakan untuk semua yang ditandai--'
    });

    $(document).on('click','.btnOKBApproverAct', function () {
        var checkbox = $('.checkApproveOKB').filter(':checked');
        var judgement = $('.slcOKBTindakanApprover').val();
        var person_id = $('.txtOKBPerson_id').val();

        if (judgement =='') {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih tindakan !',
            });
        } else if (checkbox.length == 0) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih order !',
            });
        } else if (judgement == 'R') {

            ( async function () {
                    let { value: reason, dismiss } = await Swal.fire({
                        text: 'Silahkan berikan alasan anda .',
                        input: 'textarea',
                        inputPlaceholder: 'Alasan anda...',
                        inputAttributes: {
                            'aria-label': 'Alasan anda...'
                        },
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok',
                        showCloseButton: true
                    });
                    
                    if ( dismiss != 'close' ) {
                        if ( reason == null || reason == '' ) {
                            Swal.fire({
                                customClass: 'swal-font-large',
                                type: 'error',
                                title: 'Gagal',
                                text: 'Alasan tidak boleh kosong!',
                            });
                        } else {
                            $('.btnOKBApproverAct').attr('disabled','disabled');
                            $('.imgOKBLoading').fadeIn();
                            var orderid = new Array();
                            if (checkbox) {
                                $(checkbox).each(function () {
                                    var order_id = $(this).val();
                                    orderid.push(order_id);
                                })
                            };
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrder',
                                data: {
                                        orderid : orderid,
                                        judgment : judgement,
                                        person_id : person_id,
                                        note : reason
                                    },
                                success: function (response) {
                                    if (response == 1) {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Berhasil',
                                            text: 'Order berhasil di reject',
                                        })
                                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                                        // checkbox.parentsUntil('tbody').remove();
                                        $('#modalReasonRejectOrderOKB').modal('hide');
                                        $('.slcOKBTindakanApprover').val('').trigger('change.select2');
                                    } else {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Gagal',
                                            text: 'Order gagal di reject',
                                        })
                                    };                
                                    $('.imgOKBLoading').fadeOut();            
                                    $('.btnOKBApproverAct').removeAttr('disabled');
                                    // $('.tblOKBOrderList').DataTable().draw();
                                }
                            });
                        };
                    };
                }) ();
        } else {
            $('.btnOKBApproverAct').attr('disabled','disabled');
            $('.imgOKBLoading').fadeIn();
            var orderid = new Array();
            if (checkbox) {
                $(checkbox).each(function () {
                    var order_id = $(this).val();
                    orderid.push(order_id);
                  })
            };
            $.ajax({
                type: "POST",
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrder',
                data: {
                        orderid : orderid,
                        judgment : judgement,
                        person_id : person_id
                    },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Order berhasil di approve',
                        });
                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                        $('.slcOKBTindakanApprover').val('').trigger('change.select2');
                        // checkbox.parentsUntil('tbody').remove();
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Order gagal di approve',
                        });
                    };
                    $('.imgOKBLoading').fadeOut();
                    $('.btnOKBApproverAct').removeAttr('disabled');
                }
            });
        }
    })

    $('.tblOKBOrderListApprover').DataTable({
        scrollY: "370px",
        // fixedColumns:   {
        //     leftColumns: 5
        // },
        scrollX: true,
        scrollCollapse: true,
        // columnDefs: [ {
        //     "targets": 0,
        //     "orderable": false
        // } ],
        order: [[0, 'asc']],
    });
    //end approve order

    //pengelola
    $(document).on('click','.btnOKBPengelolaAct', function () {

        var pengelola = $('.txtOKBPerson_id').val();
        var checkbox = $('.checkApproveOKB').filter(':checked');
        var orderClass = $('.slcOKBTindakanPengelola').val();

        if (orderClass =='') {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih tindakan !',
            });
        } else if (checkbox.length == 0) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih order !',
            });
        } else if (orderClass == 'R') {
            ( async function () {
                let { value: reason, dismiss } = await Swal.fire({
                    text: 'Silahkan berikan alasan anda .',
                    input: 'textarea',
                    inputPlaceholder: 'Alasan anda...',
                    inputAttributes: {
                        'aria-label': 'Alasan anda...'
                    },
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok',
                    showCloseButton: true
                });
                
                if ( dismiss != 'close' ) {
                    if ( reason == null || reason == '' ) {
                        Swal.fire({
                            customClass: 'swal-font-large',
                            type: 'error',
                            title: 'Gagal',
                            text: 'Alasan tidak boleh kosong!',
                        });
                    } else {
                        $('.btnOKBPengelolaAct').attr('disabled','disabled');
                        $('.imgOKBLoading').fadeIn();
                        var orderid = new Array();
                        if (checkbox) {
                            $(checkbox).each(function () {
                                var order_id = $(this).val();
                                orderid.push(order_id);
                            })
                        };
                        
                        $.ajax({
                            type: "POST",
                            url: baseurl + 'OrderKebutuhanBarangDanJasa/Approver/ApproveOrder',
                            data: {
                                    orderid : orderid,
                                    judgment : orderClass,
                                    person_id : pengelola,
                                    note : reason
                                },
                            success: function (response) {
                                if (response == 1) {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Berhasil',
                                        text: 'Order berhasil di reject',
                                    })
                                    tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                                    $('.slcOKBTindakanPengelola').val('').trigger('change.select2')
                                    // checkbox.parentsUntil('tbody').remove();
                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Gagal',
                                        text: 'Order gagal di reject',
                                    })
                                };
                                $('.imgOKBLoading').fadeOut();            
                                $('.btnOKBPengelolaAct').removeAttr('disabled');
                                $('.btnOKBApproverAct').removeAttr('disabled');
                            }
                        });
                    };
                };
            }) (); 
        } else if (orderClass == '1') {
            // ( async function () {
            //     let { value: note, dismiss } = await Swal.fire({
            //         text: 'Silahkan berikan note to buyer .',
            //         input: 'textarea',
            //         inputPlaceholder: 'Catatan anda...',
            //         inputAttributes: {
            //             'aria-label': 'Catatan anda...'
            //         },
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Ok',
            //         showCloseButton: true
            //     });
                
                // if ( dismiss != 'close' ) {
                    // if ( note == null || note == '' ) {
                    //     Swal.fire({
                    //         customClass: 'swal-font-large',
                    //         type: 'error',
                    //         title: 'Gagal',
                    //         text: 'Catatan tidak boleh kosong!',
                    //     });
                    // } else {
                        $('.btnOKBPengelolaAct').attr('disabled','disabled');
                        $('.imgOKBLoading').fadeIn();
                        var orderid = new Array();
                        if (checkbox) {
                            $(checkbox).each(function () {
                                var order_id = $(this).val();
                                var notes = $(this).parentsUntil('tbody').find('.noteBuyerOKB').val();
                                var orderDanNote = order_id + '-' + notes;
                                orderid.push(orderDanNote);
                            })
                        };
                        console.log(orderid)
                        $.ajax({
                            type: "POST",
                            url: baseurl + 'OrderKebutuhanBarangDanJasa/Pengelola/TindakanPengelola2',
                            data: {
                                    orderid : orderid,
                                    orderClass : orderClass,
                                    person_id : pengelola,
                                    // note : note
                                },
                            success: function (response) {
                                if (response == 1) {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Berhasil',
                                        text: 'Order berhasil di approve',
                                    })
                                    tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                                    // checkbox.parentsUntil('tbody').remove();
                                    $('.slcOKBTindakanPengelola').val('').trigger('change.select2')
                                    // $('#modalReasonRejectOrderOKB').modal('hide');
                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Gagal',
                                        text: 'Order gagal di approve',
                                    })
                                }                 
                                $('.imgOKBLoading').fadeOut();
                                $('.btnOKBPengelolaAct').removeAttr('disabled');

                            }
                        });
                    // };
                // };
            // }) (); 
        } else {
            var orderid = new Array();
            if (checkbox) {
                $(checkbox).each(function () {
                    var order_id = $(this).val();
                    orderid.push(order_id);
                  })
            };
            // console.log(orderid);
            $('.btnOKBPengelolaAct').attr('disabled','disabled');
            $('.imgOKBLoading').fadeIn();
            $.ajax({
                type: "POST",
                url: baseurl +'OrderKebutuhanBarangDanJasa/Pengelola/TindakanPengelola',
                data: {
                    orderid : orderid,
                    orderClass: orderClass,
                    person_id : pengelola
                },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Order berhasil di approve',
                        })
                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                        checkbox.parentsUntil('tbody').remove();
                        $('#modalReasonRejectOrderOKB').modal('hide');
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Order gagal di approve',
                        })
                    }                
                    $('.imgOKBLoading').fadeOut();            
                    $('.btnOKBPengelolaAct').removeAttr('disabled');
                }
            });
        };
    })
    // end pengelola

    //puller
    $('.tblOKBReleasedOrderList').DataTable({
        scrollX: true,
        scrollCollapse: true,
    });

    $(document).on('click','.btnOKBReleaseOrderPulling', function () {
        var checkbox = $('.checkApproveOKB').filter(':checked');
        
        if (checkbox.length == 0) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih order !',
            });
        }else{
            $(this).attr('disabled','disabled');
            $('.imgOKBLoading').fadeIn();
            var orderid = new Array();
            if (checkbox) {
                $(checkbox).each(function () {
                    var order_id = $(this).val();
                        orderid.push(order_id);
                })
            }; 

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Puller/ReleaseOrder",
                data: {
                    order_id : orderid
                },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Order berhasil direlease !',
                        });
                        // checkbox.parentsUntil('tbody').remove();
                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Order gagal direlease !',
                        });
                    }
                    $('.btnOKBReleaseOrderPulling').removeAttr('disabled');
                    $('.imgOKBLoading').hide();
                }
            });
        }
    })

    $(document).on('click','.btnOKBReleaseOrderPullingBatch', function () {
        var checkbox = $('.checkApproveOKB').filter(':checked');
        
        if (checkbox.length == 0) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih order !',
            });
        }else{
            $(this).attr('disabled','disabled');
            $('.imgOKBLoading').fadeIn();
            var itemcode = new Array();
            if (checkbox) {
                $(checkbox).each(function () {
                    var item_code = $(this).val();
                        itemcode.push(item_code);
                })
            }; 

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Puller/ReleaseOrderBatch",
                data: {
                    item_code : itemcode
                },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Order berhasil direlease !',
                        });
                        // checkbox.parentsUntil('tbody').remove();
                        tableOKB.rows(checkbox.parentsUntil('tbody')).remove().draw();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Order gagal direlease !',
                        });
                    }
                    $('.btnOKBReleaseOrderPullingBatch').removeAttr('disabled');
                    $('.imgOKBLoading').hide();
                }
            });
        }
    })

    $(document).on('click','.btnOKBDetailReleasedOrder', function () {
        var orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();
        $('.modalDetailReleasedOrderOKB-'+orderid).modal('show');
        
        $.ajax({
            type: "POST",
            url: baseurl+"OrderKebutuhanBarangDanJasa/Puller/ShowDetailReleasedOrder",
            data: {
                pre_req_id : orderid
            },
            success: function (response) {
                $('.newtableDetailOKB-'+orderid).html(response);
            }
        });

        $(document).on('click','.clsOKBModalAttachment',function () {
            $('.mdlOKBattach').modal('hide');
        })
    })
    // end puller

    //purchasing
    $('.tblDetailApprovedPurchasingOKB').DataTable();
    $(document).on('click','.btnOKBPurchasingAct', function () {
        var checkbox = $('.checkApproveOKB').filter(':checked');
        var judgement = $('.slcOKBTindakanPurchasing').val();
        var person_id = $('.txtOKBPerson_id').val();

        // alert(judgement);

        if (judgement =='') {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih tindakan !',
            });
        } else if (checkbox.length == 0) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda belum memilih order !',
            });
        } else if (judgement == 'N') {
            ( async function () {
                let { value: reason, dismiss } = await Swal.fire({
                    text: 'Silahkan berikan alasan anda .',
                    input: 'textarea',
                    inputPlaceholder: 'Alasan anda...',
                    inputAttributes: {
                        'aria-label': 'Alasan anda...'
                    },
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok',
                    showCloseButton: true
                });
                if ( dismiss != 'close' ) {
                    if ( reason == null || reason == '' ) {
                        Swal.fire({
                            customClass: 'swal-font-large',
                            type: 'error',
                            title: 'Gagal',
                            text: 'Alasan tidak boleh kosong!',
                        });
                    } else {
                        var orderid = new Array();
                        $('.btnOKBPurchasingAct').attr('disabled','disabled');
                        $('.imgOKBLoading').fadeIn();
                        var orderid = new Array();
                        if (checkbox) {
                            $(checkbox).each(function () {
                                var order_id = $(this).val();
                                orderid.push(order_id);
                            })
                        };

                        $.ajax({
                            type: "POST",
                            url: baseurl + 'OrderKebutuhanBarangDanJasa/Purchasing/ApproveOrder',
                            data: {
                                    pre_req_id : orderid,
                                    judgement : judgement,
                                    person_id : person_id,
                                    note: reason
                                },
                            success: function (response) {
                                if (response == 1) {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Berhasil',
                                        text: 'Order berhasil di reject',
                                    });
                                    checkbox.parentsUntil('tbody').remove();
                                    $('.slcOKBTindakanPurchasing').val('').trigger('change.select2');
                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Gagal',
                                        text: 'Order gagal di reject',
                                    });
                                };
                                $('.imgOKBLoading').fadeOut();
                                $('.btnOKBPurchasingAct').removeAttr('disabled');
                            }
                        });
                    }
                }
            }) ();
        }else{
            $('.btnOKBPurchasingAct').attr('disabled','disabled');
            $('.imgOKBLoading').fadeIn();
            var orderid = new Array();
            if (checkbox) {
                $(checkbox).each(function () {
                    var order_id = $(this).val();
                    orderid.push(order_id);
                })
            };
            $.ajax({
                type: "POST",
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Purchasing/ApproveOrder',
                data: {
                        pre_req_id : orderid,
                        judgement : judgement,
                        person_id : person_id
                    },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Order berhasil di approve',
                        });
                        checkbox.parentsUntil('tbody').remove();
                        $('.slcOKBTindakanPurchasing').val('').trigger('change.select2');
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Gagal',
                            text: 'Order gagal di approve',
                        });
                    };
                    $('.imgOKBLoading').fadeOut();
                    $('.btnOKBPurchasingAct').removeAttr('disabled');
                }
            });
        }
    })

    $(document).on('click','.btnOKBDetailApprovedOrderPurchasing', function () {
        var order_id = $(this).html();

        $('#mdlOKBDetailApprovedPurchasing-'+order_id).modal('show');

        $.ajax({
            type: "POST",
            url: baseurl+"OrderKebutuhanBarangDanJasa/Purchasing/ShowDetailOrderApproved",
            data: {order_id : order_id},
            success: function (response) {
                $('.newtableDetailApprovedOKB-'+order_id).html(response);
            }
        });
    })
    // end purchasing

    //list
    $(document).on('click','.checkStokOKB', function () {
        var orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();
        var itemDesc = $(this).html();
        var item = itemDesc.split("-");

        $('.mdlOKBListOrderStock-'+orderid).modal('show');
        console.log($('.divStockOKB-'+orderid).html())
        if ($('.divStockOKB-'+orderid).html() == '') {
            $('.divOKBListOrderStockLoading-'+orderid).fadeIn();
            
            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/getStock",
                data: {
                    itemkode : item[0]
                },
                // dataType: "json",
                success: function (response) {
                    $('.divOKBListOrderStockLoading-'+orderid).hide();
                    if (response == null || response =='') {
                        html = '<center><span><i class="fa fa-warning">No Data Found</i></span></center>';
                    }else{
                        html = response;
                    }
                    $('.divStockOKB-'+orderid).html(html);
                }
            });
        }
        
    })

    var tableOKBPengorder = $('.tblOKBOrderListPengorder').DataTable({
        scrollY: "370px",
        scrollX: true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 5
        },
        columnDefs: [
            { width: 196, targets: 8 },
            { width: 150, targets: 10 }
        ]
    });

    $(document).on('click','.btnAttachmentOKB', function () {
        var orderid = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();

        $('.mdlOKBListOrderAttachment-'+orderid).modal('show');

        if ($('.divAttachmentOKB-'+orderid).html() == '') {
            $('.divOKBListOrderAttachmentLoading-'+orderid).fadeIn();

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/getAttachment",
                data: {
                    order_id : orderid
                },
                dataType: 'JSON',
                success: function (response) {
                    $('.divOKBListOrderAttachmentLoading-'+orderid).hide();
                    console.log(response);
                    var html = '';
                    html += '<center>';
                    for (let i = 0; i < response.length; i++) {
                        const elm = response[i];
                        if (elm['FILE_NAME'] == null) {
                            html += '<span><i class="fa fa-warning"></i>Tidak ada attachment</span><br>';
                        } else {
                            let ext = elm['FILE_NAME'].split('.')[1].toLowerCase();
                            if (ext == 'pdf') {
                                html += '<div style="width: 100%; margin: 10px; padding: 10px;">';
                                html += '<a href="' + baseurl + elm['ADDRESS'] + elm['FILE_NAME'] + '" target="_blank" data-toggle="tooltip" title="Tipe File ini adalah PDF. Klik untuk melihat isinya." style="font-size: 18px;">' + elm['FILE_NAME'] + '</a>';
                                html += '</div>';
                            } else if (ext == 'png' || ext == 'jpg' || ext == 'jpeg') {
                                if (response.length == 1) {
                                    html += '<a href="' + baseurl + elm['ADDRESS'] + elm['FILE_NAME'] + '" target="_blank" rel="noopener noreferrer"><img style="max-width:500px; max-height:500px;" src="' + baseurl + elm['ADDRESS'] + elm['FILE_NAME'] + '" alt="' + elm['FILE_NAME'] + '"></a><br>';
                                } else {
                                    html += '<a href="' + baseurl + elm['ADDRESS'] + elm['FILE_NAME'] + '" target="_blank" rel="noopener noreferrer"><img style="max-width:200px; max-height:200px;" src="' + baseurl + elm['ADDRESS'] + elm['FILE_NAME'] + '" alt="' + elm['FILE_NAME'] + '"></a><br>';
                                }
                            } else {
                                html += '<div style="width: 100%; margin: 10px; padding: 10px;">';
                                html += '<a href="' + baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/downloadAttachment?id-attachment=' + elm['ATTACHMENT_ID'] + '" target="_blank" title="Mohon maaf file ini tidak bisa dibuka karena bukan file gambar atau pdf. Klik untuk download" data-toggle="tooltip" filename="' + elm['FILE_NAME'] + '" style="font-size: 18px;">' + elm['FILE_NAME'] + '</a>'
                                html += '</div>';
                            }
                        }

                    }
                    html += '</center>';


                    $('.divAttachmentOKB-'+orderid).html(html);
                }
            });

            $('body').on('click', '.clsOKBModalAttachment', function () {
                $('.mdlOKBattach').modal('hide');
            })
        }

    })

    $(document).on('click','.btnOKBInfoPR', function () {
        var order_id = $(this).parentsUntil('tbody').find('.tdOKBListOrderId').html();

        $('.mdlOKBOrderPR-'+order_id).modal();
        if ($('.divOKBOrderPR-'+order_id).html() == '') {
            
            $('.divOKBOrderPRLoading-'+order_id).fadeIn();

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/InfoOrderPR",
                data: {
                    order_id : order_id
                },
                success: function (response) {
                    $('.divOKBOrderPR-'+order_id).fadeIn();
                    $('.divOKBOrderPR-'+order_id).html(response);
                    $('.divOKBOrderPRLoading-'+order_id).hide();
                }
            });
        }
    })
    //end list

    //icon approver
    $(document).on('click','.btnNormalOrderOKB', function () {
        window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveNormal";
    })

    $(document).on('click','.btnSusulanOrderOKB', function () {
        window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveSusulan";
    })

    $(document).on('click','.btnUrgentOrderOKB', function () {
        window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveUrgent";
    })

    $(document).on('click','.btnNormalOrderOKBPengelola', function () {
        window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderNormal";
    })

    $(document).on('click','.btnSusulanOrderOKBPengelola', function () {
        window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderSusulan";
    })

    $(document).on('click','.btnUrgentOrderOKBPengelola', function () {
        window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderUrgent";
    })
    // end

    //minimizeOrder
    $(document).on('click','.OKBMinimize', function () {
        var prn = $(this).parentsUntil('.bodyformOKB');
        var kodeitem = prn.find('.slcOKBNewOrderList').select2('data')[0]['text'];
        var itemName = prn.find('.slcOKBNewOrderList').select2('data')[0]['title'];
        var qty = prn.find('.txtOKBNewOrderListQty').val();
        var uom = prn.find('.slcOKBNewUomList').val();
        var nbd = prn.find('.nbdOKB').val();
        
        var minimizeOrder = kodeitem+'-'+itemName+' '+qty+' '+uom+' '+nbd;
        var mnm = prn.find('.OKBOrderNameMinimize').html();

        if (!mnm) {
            prn.find('.OKBOrderNameMinimize').html(minimizeOrder);
        }else{
            prn.find('.OKBOrderNameMinimize').html('');
        }
    })
    //end

    //getStokOrderNew
    $(document).on('click','.btnOKBStokNew', function () {
        var prn = $(this).parentsUntil('.bodyformOKB');

        var itemcode = $(this).val();

        prn.find('.mdlOKBListOrderStock').modal('show');

        if (prn.find('.divStockOKB').html() =='') {
            prn.find('.divOKBListOrderStockLoading').fadeIn();

            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/getStock",
                data: {
                    itemkode : itemcode
                },
                // dataType: "json",
                success: function (response) {
                    prn.find('.divOKBListOrderStockLoading').hide();
                    if (response == null || response =='') {
                        html = '<center><span><i class="fa fa-warning">No Data Found</i></span></center>';
                    }else{
                        html = response;
                    }
                    prn.find('.divStockOKB').html(html);
                }
            });
        }
    })
    //end

    function destinationLine(prn) {
        
        //destination type
        prn.find('.loadingDestinationOKB').css('display','block');
        prn.find('.dest_typeOKB').css('display','none');
        $.ajax({
            type: "POST",
            url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getDestination",
            data: {
                itemkode : inv_item_id
            },
            dataType: "JSON",
            success: function (response) {
                // console.log(response);
                prn.find('.loadingDestinationOKB').css('display','none');
                prn.find('.dest_typeOKB').css('display','block');
                prn.find('.destinationOKB').val(response[0]['DESTINATION_TYPE_CODE']);
                if(response[0]['SUBINV'] == 'N'){
                    prn.find('.subinventoryOKB').attr('disabled','diabled');
                }else if (response[0]['SUBINV'] == 'Y'){
                    prn.find('.subinventoryOKB').removeAttr('disabled');
                }
                // alert(response[0]['DESTINATION_TYPE_CODE']);
            }
        });

        //organization
        prn.find('.loadingOrganizationOKB').css('display','block');
        prn.find('.viewOrganizationOKB').css('display','none');

        $.ajax({
            type: "POST",
            url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getOrganization",
            data: {
                itemkode : inv_item_id
            },
            dataType: "JSON",
            success: function (response) {
                prn.find('.organizationOKB').empty();
                var html = '';
                for (var i = 0; i < response.length; i++) {
                    if (i == 0) {
                        html += '<option value="'+response[i]['ORGANIZATION_ID']+'" title="'+response[i]['ORGANIZATION_NAME']+'">'+response[i]['IO']+'</option>';
                    }else{
                        html += '<option value="'+response[i]['ORGANIZATION_ID']+'" title="'+response[i]['ORGANIZATION_NAME']+'">'+response[i]['IO']+'</option>';
                    }
                }

                prn.find('.organizationOKB').append(html);
                prn.find('.organizationOKB').val('').trigger('change.select2');
                prn.find('.loadingOrganizationOKB').css('display','none');
                prn.find('.viewOrganizationOKB').css('display','block');
                // console.log(response);
            }
        });

        //location
        $.ajax({
            type: "POST",
            url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getLocation",
            data: {},
            dataType: "JSON",
            success: function (response) {
                // console.log(response);
                prn.find('.locationOKB').empty();
                var html = '';
                for (var i = 0; i < response.length; i++) {
                    if (i == 0) {
                        html += '<option value="'+response[i]['LOCATION_ID']+'">'+response[i]['LOC']+'</option>';
                    }else{
                        html += '<option value="'+response[i]['LOCATION_ID']+'">'+response[i]['LOC']+'</option>';
                    }
                }

                prn.find('.locationOKB').append(html);
                prn.find('.locationOKB').val('').trigger('change.select2');
                prn.find('.loadingLocationOKB').css('display', 'none');
                prn.find('.viewLocationOKB').css('display', 'block');
            }
        });

        //subinventory
        prn.find('.organizationOKB').on('change', function () {
            var organization = $(this).val();
            prn.find('.loadingSubinventoryOKB').css('display', 'block');
            prn.find('.viewSubinventoryOKB').css('display', 'none');
            $.ajax({
                type: "POST",
                url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/getSubinventory",
                data: {
                    organization: organization
                },
                dataType: "JSON",
                success: function (response) {
                    console.log(response)
                    prn.find('.subinventoryOKB').empty();
                    var html = '';
                    for (let i = 0; i < response.length; i++) {
                        if (i == 0) {
                            html += '<option value="'+response[i]['SUBINV']+'" title="'+response[i]['DESCRIPTION']+'">'+response[i]['SUBINV']+'</option>';
                        }else{
                            html += '<option value="'+response[i]['SUBINV']+'" title="'+response[i]['DESCRIPTION']+'">'+response[i]['SUBINV']+'</option>';
                        }
                    }
    
                    prn.find('.subinventoryOKB').append(html);
                    prn.find('.subinventoryOKB').val('').trigger('change.select2');
                    prn.find('.loadingSubinventoryOKB').css('display', 'none');
                    prn.find('.viewSubinventoryOKB').css('display', 'block');
                }
            });
        })
        
        prn.find('.subinventoryOKB').on('change', function () {
            // alert(row_id)
            var subinventory = $(this).val();
            prn.find('.hdnSubinvOKB').val(subinventory);
        })
    }

    //upload to import order via excel
    $(document).on('click','.btnUploadOKB', function () {
        // alert('hello')
        var form_data  = new FormData();
        var file = $('#uploadOKB').prop('files')[0];
        form_data.append('userfile', file);

        if (file) {
            $('.loadingImportOKB').css('display','block');
            $('.listOKB').html('');

            $.ajax({
                type: 'POST',
                url: baseurl + 'OrderKebutuhanBarangDanJasa/Import/UploadProcess',
                processData: false,
                contentType: false,
                data: form_data,
                // dataType: 'json',
                success: function (response) {
                    $('.loadingImportOKB').css('display','none');
                    $('.listOKB').html(response);
                    
                }
            });
        }else{
            swal.fire({
                type: 'error',
                title: 'error',
                text: 'Sepertinya anda belum mengunggah file Excel',
            });
        }
    })
    //end

    //edit approver
    $(document).on('click','.btnUbahDescOKB', function () {
        var prn = $(this).parentsUntil('tbody');
        var desc = prn.find('.okbDesc').html();

        var person_id = $('.txtOKBPerson_id').val();
        var order_id = prn.find('.checkApproveOKB').val();

        $('.mdlUbahDeskripsiApproverOKB').modal('show');
        $('.txtEditDescBeforeOKB').val(desc);
        $('.txtEditDescOKB').val(desc);

        $(document).on('click','.btnActUbahDescOKB',function () {
            var desc2 = $('.txtEditDescOKB').val();

            if (desc2 != desc) {
                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/UbahDeskripsiOrder",
                    data: {
                        person_id : person_id,
                        order_id : order_id,
                        desc_baru : desc2,
                        desc_lama : desc
                    },
                    success: function (response) {
                        if (response == 1) {
                            swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Deskripsi berhasil diubah!',
                            });
                            prn.find('.okbDesc').html(desc2);
                            $('.mdlUbahDeskripsiApproverOKB').modal('hide');
                        }
                    }
                });
            }else{
                $('.mdlUbahDeskripsiApproverOKB').modal('hide');
            }
        })
    })

    $(document).on('click','.btnUbahOrderPurpOKB', function () {
        var prn = $(this).parentsUntil('tbody');
        var order_purpose = prn.find('.okbOrderPurp').html();

        var person_id = $('.txtOKBPerson_id').val();
        var order_id = prn.find('.checkApproveOKB').val();

        $('.mdlUbahAlasanOrderApproverOKB').modal('show');
        $('.txtEditOrderPurpBeforeOKB').val(order_purpose);
        $('.txtEditOrderPurpOKB').val(order_purpose);

        $(document).on('click','.btnActUbahOrderPurpOKB', function () {
            var order_purpose2 = $('.txtEditOrderPurpOKB').val();

            if (order_purpose2 != order_purpose) {

                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/UbahAlasanOrder",
                    data: {
                        person_id : person_id,
                        order_id : order_id,
                        order_purp_baru : order_purpose2,
                        order_purp_lama : order_purpose
                    },
                    success: function (response) {
                        if (response == 1) {
                            swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Alasan Order berhasil diubah!',
                            });
                            prn.find('.okbOrderPurp').html(order_purpose2);
                            $('.mdlUbahAlasanOrderApproverOKB').modal('hide');
                        }
                    }
                });
                
            }else{
                $('.mdlUbahAlasanOrderApproverOKB').modal('hide');
            }
        })
    })

    $(document).on('click','.btnUbahQtyOKB', function () {
        var prn = $(this).parentsUntil('tbody');
        var qtyuom = prn.find('.okbQty').html();

        var person_id = $('.txtOKBPerson_id').val();
        var order_id = prn.find('.checkApproveOKB').val();

        var splt = qtyuom.split(" ");

        var qty = splt[0];
        var uom = splt[1];

        $('.mdlUbahQtyOrderApproverOKB').modal('show');
        $('.txtEditQtyOrderBeforeOKB').val(qty);
        $('.txtEditQtyOrderOKB').val(qty);
        $('.OKBafterUOM').html(uom);

        $(document).on('click','.btnActUbahQtyOrderOKB', function () {
            var qty2 = $('.txtEditQtyOrderOKB').val();

            if (qty2 != qty) {
                $.ajax({
                    type: "POST",
                    url: baseurl+"OrderKebutuhanBarangDanJasa/Approver/UbahQtyOrder",
                    data: {
                        person_id : person_id,
                        order_id : order_id,
                        qty_baru : qty2,
                        qty_lama : qty
                    },
                    success: function (response) {
                        if (response == 1) {
                            swal.fire({
                                type: 'success',
                                title: 'Berhasil',
                                text: 'Quantity Order berhasil diubah!',
                            });
                            prn.find('.okbQty').html(qty2+' '+uom);
                            $('.mdlUbahQtyOrderApproverOKB').modal('hide');
                        }
                    }
                });
                
            }
        })

    })
    //end

    //alasan urgensi
    $('.slcAlasanUrgensiOKB').select2({
        placeholder : 'Pilih Alasan Urgensi',
    });

    $(document).on('change','.slcAlasanUrgensiOKB', function () {
        var alasan = $(this).val();

        var prn = $(this).parentsUntil('tbody');

        if (alasan != 0) {
            prn.find('.txaOKBNewOrderListUrgentReason').val(alasan);
            prn.find('.txaOKBNewOrderListUrgentReason').css('display','none');
        }else if (alasan == 0) {
            prn.find('.txaOKBNewOrderListUrgentReason').val('');
            prn.find('.txaOKBNewOrderListUrgentReason').attr({
                style: 'height: 34px; background-color :#fbfb5966; width:360px;',
                required : 'required'
            });
        }
        
        
    })
    //end

    $(document).on('click','.btnSetRequestorOKB', function () {
        $('.imgOKBLoading').fadeIn();
        $(this).attr('disabled','disabled');
        var requestor = $('.slcRequestorOKB').val();
        var person = $('.hdnPersonIdOKB').val();
        
        var namaRequestor = $('.slcRequestorOKB').select2('data')[0]['title'];

        $.ajax({
            type: "POST",
            url: baseurl+"OrderKebutuhanBarangDanJasa/Requisition/SetRequestor",
            data: {
                person_id : person,
                requestor : requestor
            },
            success: function (response) {
                if(response == 1){
                    Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil diupdate!',
                    })
                    $('.imgOKBLoading').fadeOut();
                    $('.btnSetRequestorOKB').removeAttr('disabled');
                    $('.txtRequestoractOKB').val(namaRequestor);
                }else{
                    Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: 'Data gagal diupdate!',
                    })
                    $('.imgOKBLoading').fadeOut();
                    $('.btnSetRequestorOKB').removeAttr('disabled');
                }
            }
        });

    })

    $('.slcAtasanOKB').select2({
        ajax: {
            url: baseurl + 'OrderKebutuhanBarangDanJasa/Requisition/searchAtasan',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.PERSON_ID,
                            text: item.FULL_NAME+'('+item.NATIONAL_IDENTIFIER+')',
                            title: item.FULL_NAME
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
        placeholder: 'Search Name',
    })

    $(document).on('click', '.btnOKBAddInputAttachment', function () {
        let dataRow = $(this).attr('data-row');
        let $currentField = $(this).parents('.tdOKBInputFileAttachment')
        let max = 3;
        let current = $currentField.find('input[type="file"]').length;
        if (current < max) {
            let html = /* html */
                `
                        <li style="list-style: none; width: 100%; margin-top: 10px">
                            <input type="file" name="fileOKBAttachment${dataRow}[]" style="display: inline-block;">
                            <button type="button" class="btn btn-primary ml-3 btnOKBRemoveInputAttachment" style="display: inline-block;"><i class="fa fa-minus"></i></button>
                        </li>
                        `;
            $currentField.append(html);
        }
        if (current + 1 == max) {
            $(this).prop('disabled', true);
        }
    });

    $(document).on('click', '.btnOKBRemoveInputAttachment', function () {
        let $currentField = $(this).parents('.tdOKBInputFileAttachment');
        $(this).parent('li').remove();
        $currentField.find('.btnOKBAddInputAttachment').prop('disabled', false);
    });

    $('[data-toggle="tooltip"]').tooltip();

})