$(document).ready(function () {
    
    var deleted_line_id = [];
    var current_item_id = [];
    var current_selector = $('.tr-update-item-GMI')

    if(current_selector.length > 0){
        $.each(current_selector, function (i, v) { 
            current_item_id.push($(this).attr('data-item'))
        });
    }

    $('#inp-item-code-GMI').select2({
        /**
         * Get option when selecting item on input form
         */
        ajax : {
            type: 'POST',
            url: baseurl + 'grouping-master-item/get-items',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var query = {
                  search: params.term
                }
            return query},
            processResults: function(data) {
                var results = $.map(data, function(item) {
                    return {
                        id: item.ITEM_ID,
                        text: item.SEGMENT1,
                        type: item.TYPE,
                        desc: item.DESCRIPTION,
                    }
                })                
                return {
                    results: results,
                    pagination:{
                        more: (data.page * 30) < results.recordsTotal
                    }
                };
            },
            cache: true,
        },
        minimumInputLength: 5
    });

    $(document)

        .on('change', '#inp-item-code-GMI', function () {
            /**
             * Fill Description input on input form
             */
            // var id = $(this).val()
            var desc = $(this).select2('data')[0].desc

            $('#inp-item-desc-GMI').val(desc)
        })

        .on('click','#btn-input-item-GMI', function () {
            /**
             * Button plus to insert item into table on input form
             */        
            var item = $('#inp-item-code-GMI').select2('data')[0]
            var action = $(this).val()

            var item_id = item.id
            var item_code = item.text
            var item_desc = item.desc
            var item_type = item.type

            if(action == 'SAVE'){
                var selector = 'tr-add-item-GMI'
                var last_tr = $(".tr-add-item-GMI:last")
                var line_state = 'input'
            } else if(action == 'UPDATE'){
                var selector = 'tr-update-item-GMI tr-new-item-GMI'
                var last_tr = $(".tr-update-item-GMI:last")
                var line_state = 'update'
            }

            if (current_item_id.includes(item_id)){
                Swal.fire({
                    type: 'warning',
                    title: 'Warning',
                    text: 'Item already exists !'
                })
            } else {
                current_item_id.push(item_id)
                var rownum = last_tr.length != 0 ? Number(last_tr.attr('data-row')) + 1 : 1
                var html = '<tr class="'+selector+'" data-row="'+rownum+'" data-id="'+item_id+'" data-source="manual">'+
                '<td style="text-align: center;">'+rownum+'</td>'+
                '<td style="text-align: center;">'+item_code+'</td>'+
                '<td style="text-align: center;">'+item_desc+'</td>'+
                '<td style="text-align: center;">'+item_type+'</td>'+
                '<td style="text-align: center;">'+
                '<button type="button" class="btn btn-danger btn-sm btn-delete-item-GMI" value="line-'+line_state+'" data-id="-1">'+
                '<i class="fa fa-times"></i>'
                '</button>'+
                '</td>'+
                '</tr>';

                $('#tr-item-null-GMI').remove()
                $('#tbody-add-item-GMI').append(html)

                $('#inp-item-code-GMI').val('')
                $('#inp-item-desc-GMI').val('')
            }
        })

        .on('click', '.btn-delete-item-GMI', function () {
            /**
             * Delete item based on the status
             */
            var status = $(this).val()
            if (status == 'line-input'){
                $(this).closest('tr').remove()
            } else if (status == 'line-update'){
                $(this).closest('tr').remove()
                deleted_line_id.push($(this).attr('data-id'))

                console.log($(this).attr('data-id'))
                console.log(deleted_line_id)

            } else if (status = 'all'){
                $('.tr-add-item-GMI').remove()
                
                var html = '<tr id="tr-item-null-GMI">'+
                        '<td colspan="5" style="text-align: center;">'+
                        'Pilih item yang ingin di group'+
                        '</td>'+
                        '</tr>'
                $('#tbody-add-item-GMI').append(html)
            }
        })

        .on('click','#btn-save-iteml-GMI',function () {
            /**
             * Save item in input form
             */
            var group_name = $('#inp-group-name-GMI').val()
            var group_desc = $('#inp-group-desc-GMI').val()

            if(group_name.length == 0 || group_desc.length == 0){
                Swal.fire({
                    type: 'warning',
                    title: 'Warning',
                    text: 'Please input group header first !'
                })
            } else {
                var header = {
                    group_name: $('#inp-group-name-GMI').val(),
                    description: $('#inp-group-desc-GMI').val()
                }
                var lines = []

                if($('#btn-save-iteml-GMI').attr('data-action') == 'UPDATE'){
                    var line_selector = '.tr-new-item-GMI'
                }else{
                    var line_selector = '.tr-add-item-GMI'
                }

                $.each($(line_selector), function (index, value) { 
                    lines.push($(this).attr('data-id'))
                });

                var rm_lines = deleted_line_id.length > 0 ? deleted_line_id : [-1]
                var lines = lines.length > 0 ? lines : [-1]

                $.ajax({
                    type: "POST",
                    url: baseurl + "grouping-master-item/save-items",
                    data: {
                        status: 'SAVE',
                        header: header,
                        lines: lines,
                        // source: source,
                        rm_lines: rm_lines,
                        action: $('#btn-save-iteml-GMI').attr('data-action'),
                        id: $('#btn-save-iteml-GMI').val()
                    },
                    dataType: "json",
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Please Wait',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            }
                        })
                    },
                    success: function (response) {
                        Swal.close()
                        if(response == '1'){
                            Swal.fire({
                                type: 'success',
                                title: 'Success',
                                text: 'Proses Successfull !'
                            })
                            window.location.replace(baseurl + 'grouping-master-item/input')
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'ERROR !',
                                text: 'Error when saving the data. Try Again !',
                            });
                        }
                    }
                });
            }
        })

        .on('click', '#btn-input-file-GMI', function () {
            /**
             * Upload Excel File
             */
            var form_data = new FormData()
            var myfile = $('#inp-input-file-GMI').prop('files')[0]
            form_data.append('file', myfile)

            $.ajax({
                type: "POST",
                url: baseurl + "grouping-master-item/input/excel",
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function () {
                      $('#loading-upl-file-GMI').fadeIn()
                },
                success: function (response) {
                    $('#tbl-input-line-GMI').remove()
                    $('#loading-upl-file-GMI').hide()
                    $('#content-lines-GMI').html(response)

                    $.each($('.tr-add-item-GMI'), function (index, value) { 
                        // console.log($(this).attr('data-id'))
                        current_item_id.push($(this).attr('data-id'))
                    });
                }
            });
        })

        .on('click','.btn-del-group-GMI', function(){
            /**
             * Save item in input form
             */
            var id = $(this).val()
            var selector = '.tr-header-'+id+'-GMI'

            Swal.fire({
                type: 'warning',
                title: 'Warning',
                text: 'Delete this data ?',
                showCancelButton: true,
                cancelButtonColor: '#d33'
            })
            .then((value) => {
                if(value.value){
                    $.ajax({
                        type: "POST",
                        url: baseurl + "grouping-master-item/save-items",
                        data: {
                            status: 'DELETE',
                            id:id
                        },
                        success: function (response) {
                            if(response == '1'){
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Data deleted !'
                                })
                                $(selector).remove()
                            }
                        }
                    });
                }
            })
        })
})