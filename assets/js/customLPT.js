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

    $(".button-input-lpt").on("click", function(){
        var mks = $(".input-target-lpt-mks").val()
        var gjk = $(".input-target-lpt-gjk").val()
        var ygy = $(".input-target-lpt-ygy").val()
        var jkt = $(".input-target-lpt-jkt").val()
        var tjk = $(".input-target-lpt-tjk").val()
        var mdn = $(".input-target-lpt-mdn").val()
        var plu = $(".input-target-lpt-plu").val()
        var pku = $(".input-target-lpt-pku").val()
        var pnk = $(".input-target-lpt-pnk").val()
        var bjm = $(".input-target-lpt-bjm").val()
        var ekspor = $(".input-target-lpt-ekspor").val()

        if (mks == "" || gjk == "" || ygy == "" || jkt == "" || tjk == "" || mdn == "" || plu == "" || pku == "" || pnk == "" || bjm == "" || ekspor ==""){
            Swal.fire({
                type:'warning',
                title:'Mohon Target diisi!!!'
            })
        }else {
            Swal.fire({
                type:'warning',
                title:'Input Target?',
                confirmButtonText: 'Input',
                cancelButtonText: 'Cancel',
                showCancelButton: true
            })
            .then(function(isConfirm) {
                if (isConfirm.value) {
                    dataarray = []
                    result = {'CABANG':'MKS','TARGET':mks}
                    dataarray.push(result)
                    result = {'CABANG':'GJK','TARGET':gjk}
                    dataarray.push(result)
                    result = {'CABANG':'YGY','TARGET':ygy}
                    dataarray.push(result)
                    result = {'CABANG':'JKT','TARGET':jkt}
                    dataarray.push(result)
                    result = {'CABANG':'TJK','TARGET':tjk}
                    dataarray.push(result)
                    result = {'CABANG':'MDN','TARGET':mdn}
                    dataarray.push(result)
                    result = {'CABANG':'PLU','TARGET':plu}
                    dataarray.push(result)
                    result = {'CABANG':'PKU','TARGET':pku}
                    dataarray.push(result)
                    result = {'CABANG':'PNK','TARGET':pnk}
                    dataarray.push(result)
                    result = {'CABANG':'BJM','TARGET':bjm}
                    dataarray.push(result)
                    result = {'CABANG':'EKSPOR','TARGET':ekspor}
                    dataarray.push(result)

                    $.ajax({
                        url:baseurl +"laporanPenjualanTR2/Pusat/inputTargetToDB",
                        type: "POST",
                        data:{
                            array: dataarray
                        },
                        beforeSend: function () {
                            Swal.fire({
                                allowOutsideClick: false,
                                html: 'Input Target Cabang  ...',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                        },
                        success: function(){
                            Swal.fire({
                                title: 'Finished!',
                                type: 'success',
                                html: 'Behasil Input Target',
                                allowOutsideClick: true,
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            })
                            .then(function(isConfirm) {
                                if (isConfirm.value) {
                                    window.location.reload();
                                }else {
                                    window.location.reload();
                                }
                            })
                        }
                    })
                } else {

                }
            })
        }
    })

    $(".close-info-input-target").on("click", function (){
        $(".box-info-input-target-lpt").hide('slide',900, function(){ $(".box-info-input-target-lpt").remove()})
    })

    $(".input-attachment-market-info-lpt").on('change', function(){
        var path = $(this).val()
        var row = $(this).data('input')
        var pathfinal = path.replace(/^C:\\fakepath\\/, "")

        $('.ial-'+row+' .output-attachment-market-info-lpt').attr('placeholder',pathfinal)
    })

    $(".button-edit-target-lpt-pusat").on('click',function() {
        var id = $(this).data('id')

        $(".edit-input-target-lpt-pusat-"+id).removeAttr('disabled')
        $(".button-save-target-lpt-pusat-"+id).removeAttr('style')
    })

    $(".button-save-target-lpt-pusat").on('click', function(){
        var id = $(this).data('id')
        var target = $(".edit-input-target-lpt-pusat-"+id).val()

        Swal.fire({
            type: 'warning',
            title: 'Yakin ?',
            confirmButtonText: 'Edit',
            cancelButtonText: 'Cancel',
            showCancelButton: true
        })
        .then(function(isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    url: baseurl + "laporanPenjualanTR2/Pusat/inputTarget/editTarget",
                    type: 'POST',
                    data: {
                        reportId: id,
                        target: target
                    },
                    beforeSend: function () {
                        Swal.fire({
                            allowOutsideClick: false,
                            html: 'Edit Target Cabang  ...',
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                    },
                    success: function(){
                        Swal.fire({
                            title: 'Finished!',
                            type: 'success',
                            html: 'Behasil Edit Target',
                            allowOutsideClick: true,
                            confirmButtonText: 'OK',
                            showConfirmButton: true
                        })
                        .then(function(isConfirm) {
                            if (isConfirm.value) {
                                window.location.reload();
                            }else {
                                window.location.reload();
                            }
                        })
                    }
                })
            } else {

            }
        })
    })

    $(".input-analytics-duedate-lpt-cabang").datepicker({
        format: "dd-mm-yyyy",
		autoclose: true,
    })

    $("#button-input-analytics-lpt-cabang").on('click', function(){
        var problem = $(".input-analytics-problem-lpt-cabang").val()
        var rootcause = $(".input-analytics-rootcause-lpt-cabang").val()
        var action = $(".input-analytics-action-lpt-cabang").val()
        var duedate = $(".input-analytics-duedate-lpt-cabang").val()
        var id = $(".input-analytics-problem-lpt-cabang").data('id')

        if(problem == '' || rootcause == '' || action == '' || duedate == ''){
            if(problem == '') {
                $(".input-analytics-problem-lpt-cabang").attr('style', 'height:80px;border-color:red')
            }else {
                $(".input-analytics-problem-lpt-cabang").attr('style', 'height:80px')
            }
            if(rootcause == '') {
                $(".input-analytics-rootcause-lpt-cabang").attr('style', 'height:80px;border-color:red')
            }else {
                $(".input-analytics-rootcause-lpt-cabang").attr('style', 'height:80px')
            }
            if(action == '') {
                $(".input-analytics-action-lpt-cabang").attr('style', 'height:80px;border-color:red')
            }else {
                $(".input-analytics-action-lpt-cabang").attr('style', 'height:80px')
            }
            if(duedate == '') {
                $(".input-analytics-duedate-lpt-cabang").attr('style', 'border-color:red')
            }else {
                $(".input-analytics-duedate-lpt-cabang").attr('style', 'height:80px')
            }
            const toastMTA_ = (type, message) => {
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                }).fire({
                    customClass: 'swal-font-small',
                    type: type,
                    title: message
                })
            }
            toastMTA_('warning', 'Mohon kolom yang kosong diisi!')
        } else {
            $(".input-analytics-problem-lpt-cabang").attr('style', 'height:80px')
            $(".input-analytics-rootcause-lpt-cabang").attr('style', 'height:80px')
            $(".input-analytics-action-lpt-cabang").attr('style', 'height:80px')
            $(".input-analytics-duedate-lpt-cabang").attr('style', 'margin-bottom:10px;')
            Swal.fire({
                type: 'warning',
                title: 'Yakin ?',
                html: 'Pastikan data yang diinputkan sesuai',
                confirmButtonText: 'Input',
                cancelButtonText: 'Cancel',
                showCancelButton: true
            })
            .then(function(isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url:baseurl + "laporanPenjualanTR2/inputAnalisa",
                        type: 'POST',
                        data: {
                            problem:problem,
                            rootcause:rootcause,
                            action:action,
                            duedate:duedate,
                            id:id
                        },
                        beforeSend: function () {
                            Swal.fire({
                                allowOutsideClick: false,
                                html: 'Input Analisa  ...',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                        },
                        success: function(){
                            Swal.fire({
                                title: 'Finished!',
                                type: 'success',
                                html: 'Behasil Input',
                                allowOutsideClick: true,
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            })
                            .then(function(isConfirm) {
                                if (isConfirm.value) {
                                    window.location.reload()
                                }else {
                                    window.location.reload()
                                }
                            })
                        }
                    })
                }else {

                }
            })
        }
    })

    $("#button-edit-input-analytics-lpt-cabang").on('click',function(){
        Swal.fire({
            type: 'warning',
            title: 'Edit ?',
            confirmButtonText: 'Edit',
            cancelButtonText: 'Cancel',
            showCancelButton: true
        })
        .then(function(isConfirm) {
            if (isConfirm.value) {
                $(".input-analytics-problem-lpt-cabang").removeAttr('disabled')
                $(".input-analytics-rootcause-lpt-cabang").removeAttr('disabled')
                $(".input-analytics-action-lpt-cabang").removeAttr('disabled')
                $(".input-analytics-duedate-lpt-cabang").removeAttr('disabled')
                $(".input-analytics-duedate-lpt-cabang").attr('style', 'margin-bottom:10px;')

                $("#button-save-edit-analytics-lpt-cabang").attr('style', 'margin-left:10px;')
            }
        })
    })

    $("#button-save-edit-analytics-lpt-cabang").on('click', function(){
        var problem = $(".input-analytics-problem-lpt-cabang").val()
        var rootcause = $(".input-analytics-rootcause-lpt-cabang").val()
        var action = $(".input-analytics-action-lpt-cabang").val()
        var duedate = $(".input-analytics-duedate-lpt-cabang").val()
        var id = $(".input-analytics-problem-lpt-cabang").data('id')

        if(problem == '' || rootcause == '' || action == '' || duedate == ''){
            if(problem == '') {
                $(".input-analytics-problem-lpt-cabang").attr('style', 'height:80px;border-color:red')
            }else {
                $(".input-analytics-problem-lpt-cabang").attr('style', 'height:80px')
            }
            if(rootcause == '') {
                $(".input-analytics-rootcause-lpt-cabang").attr('style', 'height:80px;border-color:red')
            }else {
                $(".input-analytics-rootcause-lpt-cabang").attr('style', 'height:80px')
            }
            if(action == '') {
                $(".input-analytics-action-lpt-cabang").attr('style', 'height:80px;border-color:red')
            }else {
                $(".input-analytics-action-lpt-cabang").attr('style', 'height:80px')
            }
            if(duedate == '') {
                $(".input-analytics-duedate-lpt-cabang").attr('style', 'border-color:red')
            }else {
                $(".input-analytics-duedate-lpt-cabang").attr('style', 'margin-bottom:10px;')
            }
            const toastMTA_ = (type, message) => {
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                }).fire({
                    customClass: 'swal-font-small',
                    type: type,
                    title: message
                })
            }
            toastMTA_('warning', 'Mohon kolom yang kosong diisi!')
        } else {
            $(".input-analytics-problem-lpt-cabang").attr('style', 'height:80px')
            $(".input-analytics-rootcause-lpt-cabang").attr('style', 'height:80px')
            $(".input-analytics-action-lpt-cabang").attr('style', 'height:80px')
            $(".input-analytics-duedate-lpt-cabang").attr('style', 'margin-bottom:10px;')
            Swal.fire({
                type: 'warning',
                title: 'Yakin ?',
                html: 'Pastikan data yang diinputkan sesuai',
                confirmButtonText: 'Edit',
                cancelButtonText: 'Cancel',
                showCancelButton: true
            })
            .then(function(isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url:baseurl + "laporanPenjualanTR2/inputAnalisa",
                        type: 'POST',
                        data: {
                            problem:problem,
                            rootcause:rootcause,
                            action:action,
                            duedate:duedate,
                            id:id
                        },
                        beforeSend: function () {
                            Swal.fire({
                                allowOutsideClick: false,
                                html: 'Edit Analisa  ...',
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                        },
                        success: function(){
                            Swal.fire({
                                title: 'Finished!',
                                type: 'success',
                                html: 'Behasil Edit Analisa',
                                allowOutsideClick: true,
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            })
                            .then(function(isConfirm) {
                                if (isConfirm.value) {
                                    window.location.reload()
                                }else {
                                    window.location.reload()
                                }
                            })
                        }
                    })
                } else {

                }
            })
        }
    })

    $(".input-attachment-lpt").on('change', function(){
        var id = parseInt($(this).data('id'))
        id++
        if(id != 5){
            $(".ial-"+id).attr('style', 'margin:10px 0')
        }
    })

    $(".button-edit-info-pasar-lpt").on("click", function(){
        Swal.fire({
            type: 'warning',
            title: 'Edit ?',
            confirmButtonText: 'Edit',
            cancelButtonText: 'Cancel',
            showCancelButton: true
        })
        .then(function(isConfirm) {
            if (isConfirm.value) {
                $(".value-info-pasar-lpt").removeAttr('disabled')
                $(".button-save-edit-info-pasar-lpt").attr('style', 'margin-left:10px;')
            }
        })
    })

    $(".button-edit-attachment-info-pasar-lpt").on("click", function(){
        Swal.fire({
            type: 'warning',
            title: 'Edit ?',
            html: 'semua file akan dihapus, upload ulang semua file',
            confirmButtonText: 'Edit',
            cancelButtonText: 'Cancel',
            showCancelButton: true
        })
        .then(function(isConfirm) {
            if (isConfirm.value) {
                $(".file-attachment-info-pasar-lpt").remove()
                $("#input-edit-file-attachment-info-pasar-lpt").removeAttr('style')
                $(".button-save-edit-attachment-info-pasar-lpt").attr('style', 'margin-left:10px')
            }
        })
    })
})