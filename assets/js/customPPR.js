$(document).ready( function () {
    
    $('#datePPR').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#datePPR').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
    });
  
    $('#datePPR').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('.slcItemPPR').select2({
        ajax: {
            type: "GET",
            url: baseurl + "ProgressPPPR/Progress/searchItem",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q : params.term,
                }
              },
            processResults: function (data) {
                return {
                    results : $.map(data, function(item) {
                        return {
                            id : item.ITEM_ID,
                            text : item.KODE_ITEM+' - '+item.DESKRIPSI_ITEM,
                            inv : item.ITEM_ID
                        }
                        
                    })
                };
            },
            cache:true,
        },
        minimumInputLength : 4,
        placeholder : 'Search Item',
        allowClear : true
    })

    $('.slcRequesterPPR').select2({
        ajax: {
            type: "GET",
            url: baseurl + "ProgressPPPR/Progress/searchRequester",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    r : params.term,
                }
              },
            processResults: function (data) {
                return {
                    results : $.map(data, function(item) {
                        return {
                            id : item.PERSON_ID,
                            text : item.NATIONAL_IDENTIFIER+' - '+item.FULL_NAME,
                        }
                        
                    })
                };
            },
            cache:true,
        },
        minimumInputLength : 5,
        placeholder : 'Search Requester'
    })

    $(document).on('input', '.txtNoPRPPR', function(event) {

        var value_input = $(this).val();
        // var value_split = value_input.split(".");
        var hasil = value_input.replace(/\D/g, '')

        return $(this).val(hasil);

    })

    $(document).on('click','.btnProcessPPR', function () {
        
        $('.tableReportPPR').html('');
        var requester = $('.slcRequesterPPR').val();
        var item = $('.slcItemPPR').val();
        var date = $('#datePPR').val();
        var nopr = $('.txtNoPRPPR').val();
        var nopo = $('.txtNoPOPPR').val();
        if (date) {
            $(this).attr('disabled','disabled');
            $('.loadingPPR').css('display','block');

            var date_split = date.split("-");
    
            var date1 = date_split[0];
            var date2 = date_split[1];

            $.ajax({
                type: "POST",
                url: baseurl+"ProgressPPPR/Progress/getReport",
                data: {
                    requester : requester,
                    item : item,
                    nopr : nopr,
                    nopo : nopo,
                    date1 : date1,
                    date2 : date2
                },
                success: function (response) {
                    $('.btnProcessPPR').removeAttr('disabled');
                    $('.loadingPPR').css('display','none');
                    $('.tableReportPPR').html(response);
    
                    $('#tblReportPPR').dataTable({
                        dom :  `<'row' <'col-sm-12 col-md-4'l> <'col-sm-12 col-md-4 text-center'B> <'col-sm-12 col-md-4'f> >
                            <'row' <'col-sm-12'tr> >
                            <'row' <'col-sm-12 col-md-5'i> <'col-sm-12 col-md-7'p> >`,
                        buttons: [
                            'copy', 'excel', 'print'
                        ],
                        scrollY: "500px",
                        scrollX: true,
                        scrollCollapse: true,
                    });
    
                }
            });
        }else if(nopr || nopo) {

            $(this).attr('disabled','disabled');
            $('.loadingPPR').css('display','block');

            var date1 = '';
            var date2 = '';

            $.ajax({
                type: "POST",
                url: baseurl+"ProgressPPPR/Progress/getReport",
                data: {
                    requester : requester,
                    item : item,
                    nopr : nopr,
                    nopo : nopo,
                    date1 : date1,
                    date2 : date2
                },
                success: function (response) {
                    $('.btnProcessPPR').removeAttr('disabled');
                    $('.loadingPPR').css('display','none');
                    $('.tableReportPPR').html(response);
    
                    $('#tblReportPPR').dataTable({
                        dom :  `<'row' <'col-sm-12 col-md-4'l> <'col-sm-12 col-md-4 text-center'B> <'col-sm-12 col-md-4'f> >
                            <'row' <'col-sm-12'tr> >
                            <'row' <'col-sm-12 col-md-5'i> <'col-sm-12 col-md-7'p> >`,
                        buttons: [
                            'copy', 'excel', 'print'
                        ],
                        scrollY: "500px",
                        scrollX: true,
                        scrollCollapse: true,
                    });
    
                }
            });
            
        }else{
            Swal.fire({
                type: 'warning',
                title: 'Peringatan',
                text: 'Jika tidak mengisi Nomor PR / PO, Anda harus mengisi tanggal!',
            });

            $('#datePPR').attr({
                style: 'background-color :#fbfb5966;'
            });
        }


    })
})