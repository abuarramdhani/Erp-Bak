$(document).ready(function () {

    $(document).on('click','.tambahAdditionalInfoPBI', function () {
        $('.btndeleteAddCostTambahanPBI:first').removeAttr('disabled');
        var row_id = Number($('.trAdditionalInfoAddPBI:last').attr('data-row'));

        var html = '<tr class="trAdditionalInfoAddPBI" data-row="'+(row_id+1)+'">'+
                        '<td>'+(row_id+1)+'</td>'+
                        '<td><input type="text" class="form-control" name="additionalAdd[]"></td>'+
                        '<td></td>'+
                        '<td><input type="text" class="form-control additionalAddPricePBI hrgLainAdditionalCostPBI" name="additionalAddPrice[]" style="text-align:right"></td>'+
                        '<td><button type="button" class="btn btn-danger btndeleteAddCostTambahanPBI"><i class="fa fa-trash"></i></button>'+
                    '</tr>';
        $('.trAdditionalInfoAddPBI').parent().append(html);
    })

    $(document).on('click','.btndeleteAddCostTambahanPBI', function() {
        var count = $('.trAdditionalInfoAddPBI').length;

        $(this).parentsUntil('tbody').remove();

        if (count == 2) {
            $('.btndeleteAddCostTambahanPBI').attr('disabled','disabled');
        }
    })

    $('#tblHistoryPBI').DataTable({
        order: [[0, 'asc']],
    });
    //ready
        var totalAdditionalAtasCost = 0;

        $('.pembagianBiayaPBI').each(function () {
            var nilaiBarang = $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html();
            var totalNilaiBarang = $('.totalNilaiBarangPBI').html();
            var pembagianBiaya = Number(purify(nilaiBarang)) / Number(purify(totalNilaiBarang)) * 100;

            var bulat = Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100;
            // beamasuk
            var totalBeaMasuk = $('.totalBeaMasukPBI').html();

            var rincianBeaMasuk = pembagianBiaya * Number(purify(totalBeaMasuk)) / 100;
            $(this).parentsUntil('tbody').find('.beaMasukPBI').html(formatMoney(Math.round((rincianBeaMasuk + Number.EPSILON) * 100) / 100));
            //end

            //additionalcost
            var additionalCost = $('.totalAdditionalCostPBI').html();
            var rincianAdditionalCost = pembagianBiaya * Number(purify(additionalCost)) / 100;
            var rincianAdd = Math.round((rincianAdditionalCost + Number.EPSILON) * 100) / 100;
            $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html(formatMoney(rincianAdd));
            totalAdditionalAtasCost += Number(rincianAdditionalCost);

            // console.log(rincianAdditionalCost)
            //end
            
            $(this).html(Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100+'%');
        })
        $('.totalAdditionalAtasCostPBI').html(formatMoney(Math.round((totalAdditionalAtasCost))));

        $('.hargaPOPBI').each(function () {
            var harga = $(this).parentsUntil('tbody').find('.hargaPBI').html();
            var rate = $(this).parentsUntil('tbody').find('.txtRatePBI').val();

            var hargaPO = Number(purify(harga)) * Number(purify(rate));

            $(this).html(formatMoney(Math.round((hargaPO + Number.EPSILON) * 100) / 100));
        })

        var ttotalbiaya = 0;
            $('.totalBiayaRPPBI').each(function () {
                var beamasuk = $(this).parentsUntil('tbody').find('.beaMasukPBI').html();
                var nilai = $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html();
                var totalbiaya = Number(purify(beamasuk)) + Number(purify(nilai));
                ttotalbiaya += Number(totalbiaya);
                $(this).html(formatMoney(Math.round((totalbiaya + Number.EPSILON) * 100) / 100));
                // console.log(totalbiaya)

                var qtyKirim = Number(purify($(this).parentsUntil('tbody').find('.qtyKirimPBI').val())); 
                var tamb = totalbiaya / qtyKirim;
                $(this).parentsUntil('tbody').find('.tambPBI').html(formatMoney(Math.round((tamb + Number.EPSILON) * 100) / 100));
                var po = Number(purify($(this).parentsUntil('tbody').find('.hargaPOPBI').html()));
                var hrgtot = po + tamb;
                $(this).parentsUntil('tbody').find('.hrgTotPBI').html(formatMoney(Math.round((hrgtot + Number.EPSILON) * 100) / 100));
                
                var percent = tamb / po *100;
                $(this).parentsUntil('tbody').find('.percentPBI').html(Math.round((percent + Number.EPSILON) * 100) / 100+'%');
                
            })
        $('.totalbiayaPBI').html(formatMoney(Math.round(ttotalbiaya)))
    //end
    var tablePBI = $('.tblPerhitunganPBI').DataTable({
        scrollY: "60vh",
        scrollX: true,
        paging: false,
        ordering: false,
        scrollCollapse: true,
        // fixedColumns:   {
        //     leftColumns: 4,
        // },
    });

    $('.slcCurrencyPBI').select2({
        placeholder: 'Select Currency',
    })

    $('.slcHistoryPBI').select2({
        placeholder:'Pilih Request Id'
    });

    $(document).on('change','.slcCurrencyPBI',function () {
       var curr = $(this).val();

       $('.currPBI').html(curr);
    })

    $(document).on('click','.btnRateBatchPBI',function () {
        var rateBatch = $('.rateBatchPBI').val();
        // var localtrans = $('.txtLocalTransPBI').val();

        if (!rateBatch) {
            Swal.fire({
                type: 'error',
                title: 'Masih kosong',
                text: 'Anda belum mengisi rate',
            });
        }else{
            $('.txtRatePBI').val(formatMoney(rateBatch));

            var totalNilaiBarang = 0;
            $('.nilaiBarangPBI').each(function () {
                var rate = $(this).parentsUntil('tbody').find('.txtRatePBI').val();
                var totalUSD = Number(purify($(this).parentsUntil('tbody').find('.totalUSDPBI').html()));

                var nilaiBarang = Number(purify(rate)) * totalUSD;
                $(this).html(formatMoney(nilaiBarang));
                totalNilaiBarang += nilaiBarang;
            })
            $('.totalNilaiBarangPBI').html(formatMoney(totalNilaiBarang));
            var totalAdditionalAtasCost = 0;
            $('.pembagianBiayaPBI').each(function () {
                var nilaiBarang = $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html();
                var totalNilaiBarang = $('.totalNilaiBarangPBI').html();
                var pembagianBiaya = Number(purify(nilaiBarang)) / Number(purify(totalNilaiBarang)) * 100;

                var bulat = Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100;
                // beamasuk
                var totalBeaMasuk = $('.totalBeaMasukPBI').html();

                var rincianBeaMasuk = pembagianBiaya * Number(purify(totalBeaMasuk)) / 100;
                $(this).parentsUntil('tbody').find('.beaMasukPBI').html(formatMoney(Math.round((rincianBeaMasuk + Number.EPSILON) * 100) / 100));
                //end

                //additionalcost
                var additionalCost = $('.totalAdditionalCostPBI').html();
                var rincianAdditionalCost = pembagianBiaya * Number(purify(additionalCost)) / 100;
                var rincianAdd = Math.round((rincianAdditionalCost + Number.EPSILON) * 100) / 100;
                $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html(formatMoney(rincianAdd));
                totalAdditionalAtasCost += Number(rincianAdditionalCost);

                // console.log(rincianAdditionalCost)
                //end
                
                $(this).html(Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100+'%');
            })
            $('.totalAdditionalAtasCostPBI').html(formatMoney(Math.round((totalAdditionalAtasCost))));

            $('.hargaPOPBI').each(function () {
                var harga = $(this).parentsUntil('tbody').find('.hargaPBI').html();
                var rate = $(this).parentsUntil('tbody').find('.txtRatePBI').val();

                var hargaPO = Number(purify(harga)) * Number(purify(rate));

                $(this).html(formatMoney(Math.round((hargaPO + Number.EPSILON) * 100) / 100));
            })

            var ttotalbiaya = 0;
            $('.totalBiayaRPPBI').each(function () {
                var beamasuk = $(this).parentsUntil('tbody').find('.beaMasukPBI').html();
                var nilai = $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html();
                var totalbiaya = Number(purify(beamasuk)) + Number(purify(nilai));
                ttotalbiaya += Number(totalbiaya);
                $(this).html(formatMoney(Math.round((totalbiaya + Number.EPSILON) * 100) / 100));
                console.log(totalbiaya)

                var qtyKirim = Number(purify($(this).parentsUntil('tbody').find('.qtyKirimPBI').val())); 
                var tamb = totalbiaya / qtyKirim;
                $(this).parentsUntil('tbody').find('.tambPBI').html(formatMoney(Math.round((tamb + Number.EPSILON) * 100) / 100));
                var po = Number(purify($(this).parentsUntil('tbody').find('.hargaPOPBI').html()));
                var hrgtot = po + tamb;
                $(this).parentsUntil('tbody').find('.hrgTotPBI').html(formatMoney(Math.round((hrgtot + Number.EPSILON) * 100) / 100));
                
                var percent = tamb / po *100;
                $(this).parentsUntil('tbody').find('.percentPBI').html(Math.round((percent + Number.EPSILON) * 100) / 100+'%');
                
            })
            $('.totalbiayaPBI').html(formatMoney(Math.round(ttotalbiaya)))
        }
    })

    $(document).on('change','.txtLocalTransPBI',function () {
        var localTrans = $(this).val();
        var totallain = 0;
        $('.hrgLainAdditionalCostPBI').each(function () {
            totallain += parseInt($(this).val());
        })
        var totalHargaAdditionalCost = Number(totallain) + Number(localTrans);
        $('.totalAdditionalCostPBI').html(totalHargaAdditionalCost);
    })

    $(document).on('change','.txtLocalTransPBICurrency',function () {
        var rate = $('.rateBatchPBI').val();
        var localTransCurr = $(this).val();

        var idrLocalTrans = Number(localTransCurr) * Number(rate);

        $('.txtLocalTransPBI').val(formatMoney(idrLocalTrans));

        var totallain = 0;
        $('.hrgLainAdditionalCostPBI').each(function () {
            totallain += Number(purify($(this).val()));
        })
        var totalHargaAdditionalCost = Number(totallain) + Number(idrLocalTrans);
        $('.totalAdditionalCostPBI').html(formatMoney(totalHargaAdditionalCost));

        var totalAdditionalAtasCost = 0;
        
        $('.nilaiAdditionalCostPBI').each( function () {
            var nilaiBarang = $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html();
            var totalNilaiBarang = $('.totalNilaiBarangPBI').html();
            var pembagianBiaya = Number(purify(nilaiBarang)) / Number(purify(totalNilaiBarang)) * 100;
            // var additionalCost = $('.totalAdditionalCostPBI').html();
            var rincianAdditionalCost = pembagianBiaya * totalHargaAdditionalCost / 100;
            var rincianAdd = Math.round((rincianAdditionalCost + Number.EPSILON) * 100) / 100;
            $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html(formatMoney(rincianAdd));
            totalAdditionalAtasCost += Number(rincianAdditionalCost);
        })
        $('.totalAdditionalAtasCostPBI').html(formatMoney(Math.round((totalAdditionalAtasCost))));
        
        var ttotalbiaya = 0;
        $('.totalBiayaRPPBI').each(function () {
            var beamasuk = $(this).parentsUntil('tbody').find('.beaMasukPBI').html();
            var nilai = $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html();
            var totalbiaya = Number(purify(beamasuk)) + Number(purify(nilai));
            ttotalbiaya += Number(totalbiaya);
            $(this).html(formatMoney(Math.round((totalbiaya + Number.EPSILON) * 100) / 100));
            console.log(totalbiaya)

            var qtyKirim = Number(purify($(this).parentsUntil('tbody').find('.qtyKirimPBI').val())); 
            var tamb = totalbiaya / qtyKirim;
            $(this).parentsUntil('tbody').find('.tambPBI').html(formatMoney(Math.round((tamb + Number.EPSILON) * 100) / 100));
            var po = Number(purify($(this).parentsUntil('tbody').find('.hargaPOPBI').html()));
            var hrgtot = po + tamb;
            $(this).parentsUntil('tbody').find('.hrgTotPBI').html(formatMoney(Math.round((hrgtot + Number.EPSILON) * 100) / 100));
                
            var percent = tamb / po *100;
            $(this).parentsUntil('tbody').find('.percentPBI').html(Math.round((percent + Number.EPSILON) * 100) / 100+'%');
                
        })
        $('.totalbiayaPBI').html(formatMoney(Math.round(ttotalbiaya)))
    })

    $(document).on('change','.txtBiayaSurveyPBI',function () {
        var biayaSurvey = $(this).val();
        var idrLocalTrans = $('.txtLocalTransPBI').val();

        $('.txtBiayaSurveyPBI').val(formatMoney(biayaSurvey));

        var totallain = 0;
        $('.hrgLainAdditionalCostPBI').each(function () {
            totallain += Number(purify($(this).val()));
        })
        var totalHargaAdditionalCost = Number(totallain) + Number(purify(idrLocalTrans)) + Number(biayaSurvey);
        $('.totalAdditionalCostPBI').html(formatMoney(totalHargaAdditionalCost));

        var totalAdditionalAtasCost = 0;
        
        $('.nilaiAdditionalCostPBI').each( function () {
            var nilaiBarang = $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html();
            var totalNilaiBarang = $('.totalNilaiBarangPBI').html();
            var pembagianBiaya = Number(purify(nilaiBarang)) / Number(purify(totalNilaiBarang)) * 100;
            // var additionalCost = $('.totalAdditionalCostPBI').html();
            var rincianAdditionalCost = pembagianBiaya * totalHargaAdditionalCost / 100;
            var rincianAdd = Math.round((rincianAdditionalCost + Number.EPSILON) * 100) / 100;
            $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html(formatMoney(rincianAdd));
            totalAdditionalAtasCost += Number(rincianAdditionalCost);
        })
        $('.totalAdditionalAtasCostPBI').html(formatMoney(Math.round((totalAdditionalAtasCost))));
        
        var ttotalbiaya = 0;
        $('.totalBiayaRPPBI').each(function () {
            var beamasuk = $(this).parentsUntil('tbody').find('.beaMasukPBI').html();
            var nilai = $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html();
            var totalbiaya = Number(purify(beamasuk)) + Number(purify(nilai));
            ttotalbiaya += Number(totalbiaya);
            $(this).html(formatMoney(Math.round((totalbiaya + Number.EPSILON) * 100) / 100));
            console.log(totalbiaya)

            var qtyKirim = Number(purify($(this).parentsUntil('tbody').find('.qtyKirimPBI').val())); 
            var tamb = totalbiaya / qtyKirim;
            $(this).parentsUntil('tbody').find('.tambPBI').html(formatMoney(Math.round((tamb + Number.EPSILON) * 100) / 100));
            var po = Number(purify($(this).parentsUntil('tbody').find('.hargaPOPBI').html()));
            var hrgtot = po + tamb;
            $(this).parentsUntil('tbody').find('.hrgTotPBI').html(formatMoney(Math.round((hrgtot + Number.EPSILON) * 100) / 100));
                
            var percent = tamb / po *100;
            $(this).parentsUntil('tbody').find('.percentPBI').html(Math.round((percent + Number.EPSILON) * 100) / 100+'%');
                
        })
        $('.totalbiayaPBI').html(formatMoney(Math.round(ttotalbiaya)))
    })


    var totalNilaiBarang = 0;

    $(document).on('change','.txtRatePBI',function () {
        totalNilaiBarang = 0;
        var row_id = $(this).closest('tr').attr('data-row');
        var rate = Number($(this).val());
        var totalUSD = Number(purify($(this).parentsUntil('tbody').find('.totalUSDPBI').html()));

        var nilaiBarang = rate * totalUSD;

        // totalNilaiBarang = Number(totalNilaiBarang) + nilaiBarang;
        // console.log(totalNilaiBarang)
        
        $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html(nilaiBarang);
        
        //total nilai barang
        $('.nilaiBarangPBI').each(function () {
            var nilaiBarangs = $(this).html();
            // alert(nilaiBarangs)
            totalNilaiBarang += parseInt(nilaiBarangs);
        })
        
        $('.totalNilaiBarangPBI').html('<b>'+totalNilaiBarang+'</b>')
        //pembagian biaya
        var pembagianBiaya = nilaiBarang / totalNilaiBarang *100;
        $(this).parentsUntil('tbody').find('.pembagianBiayaPBI').html(Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100+'%');
        //bea masuk
        var totalBeaMasuk = $('.totalBeaMasukPBI').html();
        var rincianBeaMasuk = pembagianBiaya * Number(totalBeaMasuk) / 100;
        $(this).parentsUntil('tbody').find('.beaMasukPBI').html(Math.round((rincianBeaMasuk + Number.EPSILON) * 100) / 100);
    });

    // $(document).on('change','.nilaiBarangPBI',function () {
    //     var nilaiBarangPerLine = $(this).html();

    // })

    // $('.nilaiBarangPBI').each(function () {
    // })

    $(document).on('click','.btndeleteAddCostPBI',function () {
        var tombolPBI = $(this)
        var value = $(this).val();
        value = value.split("-");
        var request_id = value[0];
        var deskripsi = value[1];
        Swal.fire({
                title: 'Apakah anda yakin ingin menghapus data ini ?',
                // text: "Data yang dihapus tidak dapat dikembalikan(perlu request ulang)",
                // icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: baseurl+"PerhitunganBiayaImpor/Laporan/HapusAdditionalCost",
                        data: {
                            request_id : request_id,
                            deskripsi : deskripsi,
                        },
                        success: function (response) {
                            if (response == 1) {
                                tombolPBI.closest('tr').remove();
                                refreshNilaiAdditionalCostAtasLengkap();
                                Swal.fire(
                                  'Deleted!',
                                  'Data berhasil dihapus',
                                  'success'
                                )
                            }
                        }
                    });
                }
              })
    })

    $(document).on('click','.btnDeleteLinePBI', function () {
        var tombolPBI = $(this)
        var value = $(this).val();
        value = value.split("+");

        var kode_barang = value[0];
        var no_po = value[1];
        var qty_po = value[2];
        var io = value[3];
        var request_id = value[4];

        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus data ini ?',
            // text: "Data yang dihapus tidak dapat dikembalikan(perlu request ulang)",
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: baseurl+"PerhitunganBiayaImpor/Laporan/HapusLine",
                    data: {
                        kode_barang : kode_barang,
                        no_po : no_po,
                        qty_po : qty_po,
                        io : io,
                        request_id : request_id,
                    },
                    success: function (response) {
                        if (response == 1) {
                            // tablePBI.rows(tombolPBI.closest('tr')).remove().draw();
                            tablePBI.rows(tombolPBI.parentsUntil('tbody')).remove().draw();
                            refreshNilaiLineLengkap();
                            Swal.fire(
                                'Deleted!',
                                'Data berhasil dihapus',
                                'success'
                                )
                        }
                    }
                });
            }
          })
    })

    $(document).on('change','.hrgLainAdditionalCostPBI', function () {
        refreshNilaiAdditionalCostAtasLengkap();
        refreshNilaiLineLengkap();
    });

    $(document).on('change','.additionalAddPricePBI', function () {
        var nilai = $(this).val();
        $(this).val(formatMoney(nilai));
        refreshNilaiAdditionalCostAtasLengkap();
    })

    $(document).on('change','.qtyKirimPBI', function () {
        // alert('hello')
        refreshNilaiLineLengkap();
    })

    $(document).on('click','.editAdditionalCostPBI', function () {
        var rid = $(this).attr('rid');
        $('.hrgLainAdditionalCostPBI[rid="'+rid+'"]').removeAttr('readonly');
        $('.prosesEditAddCostPBI[rid="'+rid+'"]').css('display','block');
        $(this).css('display','none');
    })
    
    $(document).on('click','.prosesEditAddCostPBI', function () {
        var rid = $(this).attr('rid');
        var value = $(this).val();
        value = value.split("-");
        var request_id = value[0];
        var deskripsi = value[1];
        var price = purify($('.hrgLainAdditionalCostPBI[rid="'+rid+'"]').val());

        $(this).css('display','none');
        $('.loadingEditAddCostPBI[rid="'+rid+'"]').css('display','block');
        $('.hrgLainAdditionalCostPBI[rid="'+rid+'"]').attr('readonly','readonly');

        $.ajax({
            type: "POST",
            url: baseurl+"PerhitunganBiayaImpor/Laporan/EditAdditionalCost",
            data: {
                    request_id : request_id,
                    deskripsi : deskripsi,
                    price : price
                    },
            success: function (response) {
                if (response == 1) {
                    Swal.fire(
                        'Updated!',
                        'Data berhasil diperbarui',
                        'success'
                    )
                    $('.loadingEditAddCostPBI[rid="'+rid+'"]').css('display','none');
                    $('.editAdditionalCostPBI[rid="'+rid+'"]').css('display','block');
                }
            }
        });
    })

})

function refreshNilaiLineLengkap() {
    // alert($('.totalUSDPBI').length)
    $('.qtyKirimPBI').each(function () {
        var qtyKirim = Number(purify($(this).val()));
        var harga = Number(purify($('.hargaPBI').html()));
        var totalharga = qtyKirim * harga;
        $(this).parentsUntil('tbody').find('.totalUSDPBI').html(formatMoney(totalharga));
    })
    var rateBatch = $('.rateBatchPBI').val();
    var ttotalUSD = 0;
    $('.totalUSDPBI').each(function () {
        var totalUSD = $(this).html();

        ttotalUSD += Number(purify(totalUSD));
    })
    $('.ttotalUSDPBI').html(ttotalUSD);

    var totalNilaiBarang = 0;
    $('.nilaiBarangPBI').each(function () {
        var rate = $(this).parentsUntil('tbody').find('.txtRatePBI').val();
        var totalUSD = Number(purify($(this).parentsUntil('tbody').find('.totalUSDPBI').html()));

        var nilaiBarang = Number(purify(rate)) * totalUSD;
        $(this).html(formatMoney(nilaiBarang));
        totalNilaiBarang += nilaiBarang;
    })
    $('.totalNilaiBarangPBI').html(formatMoney(totalNilaiBarang));
    var totalAdditionalAtasCost = 0;
    $('.pembagianBiayaPBI').each(function () {
        var nilaiBarang = $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html();
        var totalNilaiBarang = $('.totalNilaiBarangPBI').html();
        var pembagianBiaya = Number(purify(nilaiBarang)) / Number(purify(totalNilaiBarang)) * 100;

        var bulat = Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100;
        // beamasuk
        var totalBeaMasuk = $('.totalBeaMasukPBI').html();

        var rincianBeaMasuk = pembagianBiaya * Number(purify(totalBeaMasuk)) / 100;
        $(this).parentsUntil('tbody').find('.beaMasukPBI').html(formatMoney(Math.round((rincianBeaMasuk + Number.EPSILON) * 100) / 100));
        //end

        //additionalcost
        var additionalCost = $('.totalAdditionalCostPBI').html();
        var rincianAdditionalCost = pembagianBiaya * Number(purify(additionalCost)) / 100;
        var rincianAdd = Math.round((rincianAdditionalCost + Number.EPSILON) * 100) / 100;
        $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html(formatMoney(rincianAdd));
        totalAdditionalAtasCost += Number(rincianAdditionalCost);

        // console.log(rincianAdditionalCost)
        //end
                
        $(this).html(Math.round((pembagianBiaya + Number.EPSILON) * 100) / 100+'%');
    })
    $('.totalAdditionalAtasCostPBI').html(formatMoney(Math.round((totalAdditionalAtasCost))));

    $('.hargaPOPBI').each(function () {
        var harga = $(this).parentsUntil('tbody').find('.hargaPBI').html();
        var rate = $(this).parentsUntil('tbody').find('.txtRatePBI').val();

        var hargaPO = Number(purify(harga)) * Number(purify(rate));

        $(this).html(formatMoney(Math.round((hargaPO + Number.EPSILON) * 100) / 100));
    })

    var ttotalbiaya = 0;
    $('.totalBiayaRPPBI').each(function () {
        var beamasuk = $(this).parentsUntil('tbody').find('.beaMasukPBI').html();
        var nilai = $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html();
        var totalbiaya = Number(purify(beamasuk)) + Number(purify(nilai));

        ttotalbiaya += Number(totalbiaya);
        $(this).html(formatMoney(Math.round((totalbiaya + Number.EPSILON) * 100) / 100));
        // console.log(totalbiaya)

        var qtyKirim = Number(purify($(this).parentsUntil('tbody').find('.qtyKirimPBI').val())); 
        var tamb = totalbiaya / qtyKirim;
        $(this).parentsUntil('tbody').find('.tambPBI').html(formatMoney(Math.round((tamb + Number.EPSILON) * 100) / 100));
        var po = Number(purify($(this).parentsUntil('tbody').find('.hargaPOPBI').html()));
        var hrgtot = po + tamb;
        $(this).parentsUntil('tbody').find('.hrgTotPBI').html(formatMoney(Math.round((hrgtot + Number.EPSILON) * 100) / 100));
                
        var percent = tamb / po *100;
        $(this).parentsUntil('tbody').find('.percentPBI').html(Math.round((percent + Number.EPSILON) * 100) / 100+'%');
                
    })
    $('.totalbiayaPBI').html(formatMoney(Math.round(ttotalbiaya)))
}
function refreshNilaiAdditionalCostAtasLengkap() { 
    // alert($('.hrgLainAdditionalCostPBI').length)
    var totallain = 0;
    $('.hrgLainAdditionalCostPBI').each(function () {
        totallain += Number(purify($(this).val()));
        // alert(totallain)
    })
    var totalHargaAdditionalCost = Number(totallain);
    // console.log(idrLocalTrans)
    $('.totalAdditionalCostPBI').html(formatMoney(totalHargaAdditionalCost));

    var totalAdditionalAtasCost = 0;
        
    $('.nilaiAdditionalCostPBI').each( function () {
        var nilaiBarang = $(this).parentsUntil('tbody').find('.nilaiBarangPBI').html();
        var totalNilaiBarang = $('.totalNilaiBarangPBI').html();
        var pembagianBiaya = Number(purify(nilaiBarang)) / Number(purify(totalNilaiBarang)) * 100;
        // var additionalCost = $('.totalAdditionalCostPBI').html();
        var rincianAdditionalCost = pembagianBiaya * totalHargaAdditionalCost / 100;
        var rincianAdd = Math.round((rincianAdditionalCost + Number.EPSILON) * 100) / 100;
        $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html(formatMoney(rincianAdd));
        totalAdditionalAtasCost += Number(rincianAdditionalCost);
    })
    $('.totalAdditionalAtasCostPBI').html(formatMoney(Math.round((totalAdditionalAtasCost))));
        
    var ttotalbiaya = 0;
    $('.totalBiayaRPPBI').each(function () {
        var beamasuk = $(this).parentsUntil('tbody').find('.beaMasukPBI').html();
        var nilai = $(this).parentsUntil('tbody').find('.nilaiAdditionalCostPBI').html();
        var totalbiaya = Number(purify(beamasuk)) + Number(purify(nilai));
        ttotalbiaya += Number(totalbiaya);
        $(this).html(formatMoney(Math.round((totalbiaya + Number.EPSILON) * 100) / 100));
        // console.log(totalbiaya)

        var qtyKirim = Number(purify($(this).parentsUntil('tbody').find('.qtyKirimPBI').val())); 
        var tamb = totalbiaya / qtyKirim;
        $(this).parentsUntil('tbody').find('.tambPBI').html(formatMoney(Math.round((tamb + Number.EPSILON) * 100) / 100));
        var po = Number(purify($(this).parentsUntil('tbody').find('.hargaPOPBI').html()));
        var hrgtot = po + tamb;
        $(this).parentsUntil('tbody').find('.hrgTotPBI').html(formatMoney(Math.round((hrgtot + Number.EPSILON) * 100) / 100));
                
        var percent = tamb / po *100;
        $(this).parentsUntil('tbody').find('.percentPBI').html(Math.round((percent + Number.EPSILON) * 100) / 100+'%');
                
    })
    $('.totalbiayaPBI').html(formatMoney(Math.round(ttotalbiaya)))
}

function formatMoney(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function purify(val){
    var newval = val.split(',').join('');
    return Number(newval);
}