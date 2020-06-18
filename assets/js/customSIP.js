$(document).ready(function () {
    $('.slcItemSIP').select2({
        ajax: {
            url: baseurl + 'StandarisasiItemPembelian/Standarisasi/searchItem',
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
                            text: item.SEGMENT1 + ' | ' + item.DESCRIPTION,
                            title: item.DESCRIPTION,
                            uom: item.PRIMARY_UOM_CODE,
                            category: item.CATEGORY,
                            buyer: item.BUYER
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 4,
        placeholder: 'Kode / deskripsi barang',
    })

    $(document).on('change','.slcItemSIP', function () {
        var desc = $(this).select2('data')[0]['title'];
        var uom = $(this).select2('data')[0]['uom'];
        var category = $(this).select2('data')[0]['category'];
        var buyer = $(this).select2('data')[0]['buyer'];

        $('.descSIP').val(desc);
        $('.uomSIP').val(uom);
        $('.categorySIP').val(category);
        $('.buyerSIP').val(buyer);
    });
    
    var tableSIP = $('.tblListdataSIP').DataTable({
        scrollY: "50vh",
        scrollX: true,
        scrollCollapse: true,
        order: [],
        fixedColumns:   {
            leftColumns: 4,
        },
      });

    $(document).on('click','.btnUploadSIP', function () {
        var form_data  = new FormData()
        var file = $('#uploadSIP').prop('files')[0];
        form_data.append('userfile', file);
        if (file) {
            $('.loadingImportSIP').css('display','block');
            $('.listSIP').html('');

            $.ajax({
                type: 'POST',
                url: baseurl + 'StandarisasiItemPembelian/Standarisasi/UploadProcess',
                processData: false,
                contentType: false,
                data: form_data,
                // dataType: 'json',
                success: function (response) {
                    $('.loadingImportSIP').css('display','none');
                    $('.listSIP').html(response);
                    tableSIP = $('.tblListdataSIP').DataTable({
                        scrollY: "300px",
                        scrollX: true,
                        scrollCollapse: true,
                        order: [],
                        fixedColumns:   {
                            leftColumns: 4,
                        },
                    });
                    $('.btnSubmitSIP').on('click', function () {
                        tableSIP.page.len(-1).draw();
                        $('#frmSubmitSIP').submit()
                    })
                }
            });
        }else{
            Swal.fire({
                type: 'error',
                title: 'error',
                text: 'Sepertinya anda belum mengunggah file csv',
            });
        }
        
    })
    $(document).on('click','.btnListSiP', function () {
        var inv = $(this).attr('inv');

        $('#mdlEditSIP-'+inv).modal('show');
    })
    
    $(document).on('click','.btnUpdateSIP', function () {
        var inv_id = $(this).attr('inv-id');

        var spesifikasi = $('.spesifikasiEditSIP[inv-id="'+inv_id+'"]').val();
        var model = $('.modelEditSIP[inv-id="'+inv_id+'"]').val();
        var merk = $('.merkEditSIP[inv-id="'+inv_id+'"]').val();
        var origin = $('.originEditSIP[inv-id="'+inv_id+'"]').val();
        var made_in = $('.madeinEditSIP[inv-id="'+inv_id+'"]').val();
        var supplier_item = $('.suppItemEditSIP[inv-id="'+inv_id+'"]').val();
        var catatan = $('.catatanEditSIP[inv-id="'+inv_id+'"]').val();
        var cutoff = $('.cutOffEditSIP[inv-id="'+inv_id+'"]').val();
        var pembayaran = $('.pembayaranEditSIP[inv-id="'+inv_id+'"]').val();
        var kelompokBarang = $('.kelompokBarangEditSIP[inv-id="'+inv_id+'"]').val();
        var jenisKonf = $('.jenisKonfEditSIP[inv-id="'+inv_id+'"]').val();
        var katalog = $('.katalogEditSIP[inv-id="'+inv_id+'"]').val();
        var levelValiditas = $('.levelValiditasEditSIP[inv-id="'+inv_id+'"]').val();
        var importLokal = $('.importLokalEditSIP[inv-id="'+inv_id+'"]').val();

        
        $(this).attr('disabled','disabled');
        Swal.fire({
            type: 'warning',
            title: 'Tunggu',
            text: 'Tunggu Ya!!',
        });
        $.ajax({
            type: "POST",
            url: baseurl + 'StandarisasiItemPembelian/Standarisasi/UpdateItem',
            data: {
                inventory_item_id : inv_id,
                spesifikasi : spesifikasi,
                model : model,
                merk : merk,
                origin : origin,
                made_in : made_in,
                supplier_item : supplier_item,
                catatan : catatan,
                cutoff : cutoff,
                pembayaran : pembayaran,
                kelompokBarang : kelompokBarang,
                jenisKonf : jenisKonf,
                katalog : katalog,
                levelValiditas : levelValiditas,
                importLokal : importLokal,

            },
            success: function (response) {
                if (response == 1) {
                    Swal.close();
                    $('.btnUpdateSIP').removeAttr('disabled');
                    $('#mdlEditSIP-'+inv_id).modal('hide');

                    $('tr[inv="'+inv_id+'"]').find('.dsSIP').html(spesifikasi);
                    $('tr[inv="'+inv_id+'"]').find('.mdlSIP').html(model);
                    $('tr[inv="'+inv_id+'"]').find('.merSIP').html(merk);
                    $('tr[inv="'+inv_id+'"]').find('.orSIP').html(origin);
                    $('tr[inv="'+inv_id+'"]').find('.miSIP').html(made_in);
                    $('tr[inv="'+inv_id+'"]').find('.supSIP').html(supplier_item);
                    $('tr[inv="'+inv_id+'"]').find('.catSIP').html(catatan);
                    $('tr[inv="'+inv_id+'"]').find('.lastSIP').html($.datepicker.formatDate('dd-M-y', new Date()).toUpperCase());
                    $('tr[inv="'+inv_id+'"]').find('.copSIP').html(cutoff);
                    $('tr[inv="'+inv_id+'"]').find('.pembSIP').html(pembayaran);
                    $('tr[inv="'+inv_id+'"]').find('.kbSIP').html(kelompokBarang);
                    $('tr[inv="'+inv_id+'"]').find('.jkSIP').html(jenisKonf);
                    $('tr[inv="'+inv_id+'"]').find('.katSIP').html(katalog);
                    $('tr[inv="'+inv_id+'"]').find('.lvSIP').html(levelValiditas);
                    $('tr[inv="'+inv_id+'"]').find('.ilSIP').html(importLokal);
                    Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Item Berhasil Diupdate!',
                    });
                }else{
                    Swal.fire({
                        type: 'danger',
                        title: 'Gagal',
                        text: 'Item Gagal Diupdate!',
                    });
                }
            }
        });
    })

    $(document).on('click','.btnDeleteSIP',function () {
        var inv = $(this).attr('inv');
        var ini = $(this)
        Swal.fire({
            title: 'Hapus Data ini ?',
            text: "Data yang dihapus tidak dapat dikembalikan lagi!",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: baseurl + 'StandarisasiItemPembelian/Standarisasi/DeleteItem',
                    data: {
                        inv_id : inv,
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire(
                                'Deleted!',
                                'Data berhasil dihapus.',
                                'success'
                                )
                                tableSIP.rows($('tr[inv="'+inv+'"]')).remove().draw();
                        }else{
                            Swal.fire(
                                'Gagal',
                                'Data gagal dihapus.',
                                'error'
                              )
                        }
                    }
                });
            }
          })
    })

})