<style>
    .center {
        text-align: center;
    }
    
    tbody>tr>td {
        text-align: center;
    }
    
    thead>tr {
        font-weight: bold;
    }
    
    thead>tr>td:first-child {
        width: 5%;
    }
    
    thead>tr>td:first-child+td {
        width: 10%;
    }
    
    .modal-content {
        top: 7em !important;
        border-radius: 10px !important;
        z-index: 1;
    }
    
    #modalForm {
        margin: 0 2em 0 2em !important;
    }
    
    .modal-footer {
        margin: 0 2em 0 2em !important;
    }
    /* .bg-red{
		background-color: red;
	} */
    
    .font-red {
        color: red;
    }
    
    .font-green {
        color: green;
    }
    
    .font-orange {
        color: #eb9e34;
    }
    
    .font-blue {
        color: #1249af;
    }
    
    .borderHistory {
        border-radius: 5px;
        border: 1px solid grey;
        padding: 10px;
        background-color: #f5f7fa;
    }
    
    .modal-lg {
        width: 1200px;
    }
    
    .modal-detail {}
    
    .modalHistoryDiv {}
    
    .table-info-data>thead>tr>th {
        text-align: center;
    }
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b>Input Data</b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="#">
                                    <i class="icon-wrench icon-2x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 style="float: left;">Seksi
                                    <?=$seksi?>
                                </h3>
                                <a href="#" id="modalAdd" class="btn btn-default icon-plus icon-2x" data-toggle="modal" data-target="#modalInput" data-backdrop="static" data-keyboard="false" alt='Add New' title="Add New" style="float: right;"></a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left table-input-dokumen" style="font-size: 12px;">
                                        <thead class="bg-primary center">
                                            <tr>
                                                <td>No</td>
                                                <td>No Induk</td>
                                                <td>Nama</td>
                                                <td>Keterangan</td>
                                                <td>Tanggal Input</td>
                                                <td>Tanggal</td>
                                                <td>Status</td>
                                                <td>Alasan</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= $table?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add/Edit Data  -->
<div class="modal fade modal-xl" id="modalInput" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title center"></h3>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <form id="modalForm">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="modalNoInduk">No Ind</label>
                                <div class="col-sm-3">
                                    <select class="form-control multiselect" placeholder="noind" id="modalNoInduk">
                                    <!-- this is select 2 -->
                                </select>
                                </div>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text" id="modalNameWorker" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="modalSeksi">Seksi</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="modalSeksi" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="modalInformation">Keterangan</label>
                                <div class="col-sm-10">
                                    <select class="form-control" placeholder="jenis keterangan" id="modalInputInformation">
                                    <!-- ajax -->
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="modalDate">Tanggal</label>
                                <div class="col-sm-10">
                                    <input class="form-control" data-date-format="yyyy-mm-dd" type="text" placeholder="" id="modalDate">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 border-left">
                        <table class="table table-responsive table-info-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Induk</th>
                                    <th>Nama</th>
                                    <th colspan="2">Seksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- js is powerfull -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-lg-6 text-center">
                    <button type="button" id="addData" class="btn btn-success">Add <i class="fa fa-plus"></i></button>
                </div>
                <div class="col-lg-6">
                    <button type="button" id="modalAction" class="btn btn-primary">Save Changes</button>
                    <button type="button" id="modalCancel" class="btn btn-warning pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Info  -->
<div class="modal fade" id="modalInfo" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-detail">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title center"><b>Info</b></h3>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="modalDetail">Detail</label>
                        <input class="form-control" id="modalDetail" disabled>
                    </div>
                    <div class="form-group">
                        <label for="modalApp1">Approve 1</label>
                        <input class="form-control" id="modalApp1" disabled>
                    </div>
                    <div class="form-group">
                        <label for="modalApp2">Approve 2</label>
                        <input class="form-control" id="modalApp2" disabled>
                    </div>
                    <div class="form-group modalHistoryDiv borderHistory">
                        <!-- on js -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- only noob write js on -->
<script>
    baseurl = '<?= base_url() ?>'
    $(document).ready(function() {
        $('modalNoInduk').on('change', function(e) {
            let noind = $(this).val()
            $.ajax({
                type: 'GET',
                url: baseurl + 'PengirimanDokumen/ajax/noind',
                dataType: 'json',
                data: {
                    params: noind
                },
                success: res => {
                    res.forEach(res => {
                        $('#modalNameWorker').val(res.nama)
                        $('#modalSeksi').val(res.seksi)
                    })
                }
            })
        });

        //show modal
        $('#modalAdd').click(() => {
            $("#modalForm")[0].reset()
            $("#modalNoInduk").select2('val', '')
            $("#modalInputInformation").select2('val', '')

            title = "<b>Add Data</b>"
            action = "Add"
            $('.modal-title').html(title)
            $('.modal-footer #action').html(action)
        })

        //Listener add Data
        $('#addData').click(() => {
            let noind = $('#modalNoInduk').val(),
                name = $('#modalNameWorker').val().toLowerCase().split(' ').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
            seksi = $('#modalSeksi').val().toLowerCase().split(' ').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');

            if (noind == null) {
                alert("No induk kosong")
                return
            }

            let listNoind = []
            $('.table-info-data tbody tr').each(function() {
                let noind = $(this).find('.noind').text()
                listNoind.push(noind)
            })

            if (listNoind.includes(noind)) {
                alert("No induk sudah ditambahkan")
                return
            }
            //count row 
            let lastNum = $('.table-info-data tbody tr').length

            //append to table
            let row = `<tr>
                            <td>${lastNum+1}</td>
                            <td class="noind">${noind}</td>
                            <td>${name}</td>
                            <td>${seksi}</td>
                            <td><button class="btn btn-xs btn-danger delete-row"><i class="fa fa-close"></i></button></td>
                        </tr>`

            $('.table-info-data > tbody').append(row)

            $('.delete-row').click(function() {
                $(this).closest('tr').remove()

                let last = $('.table-info-data > tbody tr').length

                let i = 1
                $('.table-info-data > tbody tr').each(function() {
                    $(this).find('td').first().text(i)
                    i++
                })
            })

        })

        //listener save Changes
        $('#modalAction').click(() => {
            let allNoind = []

            $('.table-info-data tbody tr').each(function() {
                let noind = $(this).find('.noind').text()
                allNoind.push(noind)
            })

            let jsonNoind = allNoind.join(',')

            console.log(jsonNoind);


            let ket = $('#modalInputInformation').val(),
                date = $('#modalDate').val()

            if (allNoind.length == 0 || ket == null || date == '') {
                showSweetAlert('Isi data dengan lengkap !')
                return
            }

            let data = {
                noind: jsonNoind,
                ket: ket,
                date: date
            }

            $.ajax({
                method: 'POST',
                url: baseurl + 'PengirimanDokumen/ajax/addData',
                data: data,
                success: res => {
                    showSuccessAlert()
                    $('#modalInput').modal('toggle')
                    showTableInput()
                }
            })

        })

        //modal cancel for reset table
        $('#modalCancel').click(function() {
            $('.table-info-data > tbody').html('')
        })

        //load list keterangan
        $.ajax({
            url: baseurl + 'PengirimanDokumen/ajax/listMaster',
            dataType: 'json',
            success: res => {
                let list
                res.forEach(item => {
                    list += `<option value="${item.id}">${item.keterangan}</option>`
                })
                $('#modalInputInformation').html(list)
            }
        })

        //listener row on click
        showDetailRow()

    })

    const showTableInput = () => {
        $.ajax({
            url: baseurl + 'PengirimanDokumen/ajax/showInput',
            dataType: 'json',
            beforeSend: () => {
                let loading = `<tr><td colspan="8"><center><img src="${baseurl + 'assets/img/gif/spinner.gif'}" /></center></td></tr>`
                $('table > tbody').html(loading)
            },
            success: res => {
                let row
                let i = 1
                res.forEach(item => {
                    row += `<tr">
								<td>${i++}</td>
								<td>${item.noind}</td>
								<td>${item.nama}</td>
								<td class='detail' data-id='${item.id_data}' data-app1='${item.approver1}' data-app2='${item.approver2}'>${item.keterangan}</td>
								<td>${item.tgl_input}</td>
								<td>${item.tanggal}</td>
								${getStatus(item.status, item.approver1, item.approver2)}
								<td>${getAlasan(item.alasan)}</td>
							</tr>`
                })
                $('.table-input-dokumen > tbody').html(row)
                showDetailRow()
            }
        })
    }

    const getStatus = (stat, ap1, ap2) => {
        let status
        switch (stat) {
            case '0':
                status = '<td class="bg-yellow">Pending</td>'
                break
            case '1':
                status = `<td class="bg-green">Approve by ${ap1}</td>`
                break
            case '2':
                status = `<td class="bg-red">Reject by ${ap1}</td>`
                break
            case '3':
                status = `<td class="bg-green">Approve by ${ap2}</td>`
                break
            case '4':
                status = `<td class="bg-red">Reject by ${ap2}</td>`
                break
            default:
                status = 'null'
        }

        return status
    }

    const getAlasan = val => {
        if (val == null) {
            return ''
        }
        if (val.length > 10) {
            return val.substr(0, 10) + '...'
        }
        return val
    }

    const showDetailRow = () => {
        $('.table-input-dokumen>tbody>tr').each(function() {
            let elem = $(this).find('.detail')

            let id = elem.data('id')
            let detail = elem.text()
            let app1 = elem.data('app1')
            let app2 = elem.data('app2')
            
            $(this).click(function() {

                $('#modalDetail').val(detail)
                $('#modalApp1').val(app1)
                $('#modalApp2').val(app2)

                $.ajax({
                    method: 'GET',
                    url: baseurl + 'PengirimanDokumen/ajax/showDetail',
                    data: {
                        id: id,
                    },
                    beforeSend: () => {
                        let loading = `<center><img src="${baseurl + 'assets/img/gif/spinner.gif'}" /></center>`
                        $('.modalHistoryDiv').html(loading)
                    },
                    success: res => {
                        let textHistory = res
                        let history = `<div><label for="modalHistory">History</label></div>
										
											${textHistory}`

                        $('.modalHistoryDiv').html(history)
                    }
                })
                $('#modalInfo').modal()
            })
        })
    }
</script>