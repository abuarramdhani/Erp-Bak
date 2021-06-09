$(document).ready(function (){
    $("#input-date-lpt").datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
	})
    
    function buttondelete(){
        $(".button-delete-date-lpt").on('click', function() {
            var id = $(this).data('id')
            var date = $(this).data('date')
            Swal.fire({
                title:'STOP!',
                type:'warning',
                html:'Apakah kamu yakin menghapus tanggal tersebut ?<br><br><b>Tanggal : '+date+'</b>',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Cancel',
                showCancelButton: true
            })
            .then(function(isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url:baseurl + "menuLaporanPenjualanTraktor/inputDate/deleteDate",
                        data: {
                            id : id
                        },
                        type: "POST",
                        dataType: "html",
                        beforeSend: function () {
                            Swal.fire({
                            allowOutsideClick: false,
                            html: 'Sedang menghapus ...',
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            },
                            });
                        },
                        success: function () {
                            Swal.fire({
                                title: 'Finished!',
                                type: 'success',
                                html: 'Tanggal Berhasil Dihapus',
                                allowOutsideClick: true,
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            })
                            $.ajax({
                                url: baseurl + "menuLaporanPenjualanTraktor/inputDate/insertTable",
                                dataType: 'json',
                                success: function(data){
                                    var html = ''
                                    data.forEach(data => {
                                        html += '<tr>'+
                                        '<td width=20%><center><b>'+data.TANGGAL+'</b></center></td>'+
                                        '<td>'+data.NOTES+'</td>'+
                                        '<td><center><button class="btn btn-danger button-delete-date-lpt" data-id="'+data.DATE_ID+'" data-date="'+data.TANGGAL+'"><i class="fa fa-trash"></i></button></center></td>'
                                        '</tr>'
                                    })
                                    $("#tbody-skipdate-lpt").html(html)
                                    buttondelete()
                                }
                            })
                        }
                    })
                } else {
                    Swal.fire({
                        title:'Canceled!',
                        type:'warning',
                        html:'Tanggal tidak terhapus',
                        allowOutsideClick: true,
                        confirmButtonText: 'Ok',
                        showConfirmButton: true
                    })
                }
            });
        })
    }

    buttondelete()

    $("#button-input-skipDate").on('click', function(){
        var date = $("#input-date-lpt").val()
        var notes = $("#input-notes-lpt").val()

        if (date == '' || notes == ''){
            Swal.fire({
                title:'Aborted!',
                html:'Tangal dan Keterangan Harus diisi!',
                type:'warning',
                allowOutsideClick: true
            })
        } else {
            $.ajax({
                url: baseurl + "menuLaporanPenjualanTraktor/inputDate/insertDate",
                data: {
                    date : date,
                    notes : notes
                },
                type: "POST",
                dataType: "html",
                beforeSend: function () {
                    Swal.fire({
                    allowOutsideClick: false,
                    html: 'Sedang memproses ...',
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                    });
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Finished!',
                        type: 'success',
                        html: 'Tanggal Libur Berhasil Ditambahkan!',
                        allowOutsideClick: true,
                        confirmButtonText: 'OK',
                        showConfirmButton: true
                    })
                    $.ajax({
                        url: baseurl + "menuLaporanPenjualanTraktor/inputDate/insertTable",
                        dataType: 'json',
                        success: function(data){
                            var html = ''
                            data.forEach(data => {
                                html += '<tr>'+
                                '<td width=20%><center><b>'+data.TANGGAL+'</b></center></td>'+
                                '<td>'+data.NOTES+'</td>'+
                                '<td><center><button class="btn btn-danger button-delete-date-lpt" data-id="'+data.DATE_ID+'" data-date="'+data.TANGGAL+'"><i class="fa fa-trash"></i></button></center></td>'
                                '</tr>'
                            })
                            $("#tbody-skipdate-lpt").html(html)
                            buttondelete()
                        }
                    })
                    $("#input-date-lpt").val('')
                    $("#input-notes-lpt").val('')
                }
            })
        }
    })
})