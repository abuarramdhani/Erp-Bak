<style>
    .dataTables_filter{
        float: right;
    }
    .center {
        text-align: center;
    }

    table{
        width: 100% !important;
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
        top: 1em !important;
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
                                                <td>Action</td>
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
                                    <small style="color: red;">*klik data untuk melihat detail</small>
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
            <div class="modal-body clearfix">
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <form id="modalForm">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="modalNoInduk">No Induk</label>
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
                            <label class="col-sm-2 col-form-label">Lokasi Distribusi</label>
                                <div class="col-sm-10">
                                    <select id="pdp_lokasidis" class="form-control select2" style="width: 100%" data-allow-clear="false" required="" data-placeholder="Pilih Lokasi">
                                        <option></option>
                                        <option value="01">JOGJA</option>
                                        <option value="02">TUKSONO</option>
                                    </select>
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
                                <!-- js is (not) powerfull -->
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
                <h3 class="modal-title center"><b>Detail</b></h3>
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

<!-- Modal edit  -->
<div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-detail">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title center"><b>Edit</b></h3>
            </div>
            <div class="modal-body">
                <form id="modalForm">
                    <input type="hidden" class="form-control" type="text" id="modalIdData" readonly>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="modalEditNoInduk">No Induk</label>
                        <div class="col-sm-3">
                            <select class="form-control multiselect" placeholder="noind" id="modalEditNoInduk">
                            <!-- this is select 2 -->
                        </select>
                        </div>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" id="modalEditNameWorker" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="modalEditSeksi">Seksi</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="modalEditSeksi" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Lokasi Distribusi</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" style="width: 100%" data-allow-clear="false" required="" data-placeholder="Pilih Lokasi" id="modalEditLokasi">
                                <option></option>
                                <option value="01">JOGJA</option>
                                <option value="02">TUKSONO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="modalEditInformation">Keterangan</label>
                        <div class="col-sm-10">
                            <select class="form-control" placeholder="jenis keterangan" id="modalEditInformation">
                            <!-- ajax -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="modalEditDate">Tanggal</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="" id="modalEditDate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="deleteDokumen()" class="btn btn-danger pull-left"> <i class="fa fa-trash"></i> hapus</button>
                <button onclick="updateDataDokumen()" class="btn btn-success"> <i class="fa fa-save"></i> simpan perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- only noob write js on -->
<script>
    baseurl = '<?= base_url() ?>'
    $(document).ready(function() {
        $('#modalNoInduk').on('change', function(e) {
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
            $('.table-info-data tbody').html('')
        })

        //Listener add Data
        $('#addData').click(() => {
            let noind = $('#modalNoInduk').val(),
                name = $('#modalNameWorker').val().toLowerCase().split(' ').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
            seksi = $('#modalSeksi').val().toLowerCase().split(' ').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
            var lokasi_id = $('#pdp_lokasidis').val();
            var lokasi_nama = $('#pdp_lokasidis option:selected').text();
            if (noind == null) {
                alert("No induk kosong")
                return
            }

            if ($('#pdp_lokasidis').val() == ''){
                alert('Lokasi tidak boleh kosong!');
                return false;
            }
            if ($('#modalInputInformation').val() == null){
                alert('Keterangan tidak boleh kosong!');
                return false;
            }
            if ($('#modalDate').val() == ''){
                alert('Tanggal tidak boleh kosong!');
                return false;
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

            $('.table-info-data > tbody').append(row);
            $('#pdp_lokasidis').attr('disabled', true);
            $('#modalInputInformation').attr('disabled', true);
            $('#modalDate').attr('disabled', true);
        });
        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove()

            let last = $('.table-info-data > tbody tr').length

            let i = 1
            $('.table-info-data > tbody tr').each(function() {
                $(this).find('td').first().text(i)
                i++
            });
        });

        //listener save Changes
        $('#modalAction').click(() => {
            let allNoind = []


            $('.table-info-data tbody tr').each(function() {
                let noind = $(this).find('.noind').text()
                allNoind.push(noind)
            })

            let jsonNoind = allNoind.join(',')

            let ket = $('#modalInputInformation').val(),
                date = $('#modalDate').val();

            if (allNoind.length == 0 || ket == null || date == '') {
                showSweetAlert('Isi data dengan lengkap !')
                return
            }

            $('#pdp_lokasidis').attr('disabled', false);
            $('#modalInputInformation').attr('disabled', false);
            $('#modalDate').attr('disabled', false);


            let data = {
                noind: jsonNoind,
                ket: ket,
                date: date,
                lokasi: $('#pdp_lokasidis').val()
            }
            console.log(data);

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
                $('#modalEditInformation').html(list)
            }
        })

        //listener row on click
        showDetailRow()
        buttonEditListener()
        //remove close button header modal
        $('.modal-header > button').remove()
    })

    const showTableInput = () => {
        $.ajax({
            url: baseurl + 'PengirimanDokumen/ajax/showInput',
            dataType: 'json',
            beforeSend: () => {
                let loading = `<tr><td colspan="8"><center><img src="${baseurl + 'assets/img/gif/spinner.gif'}" /></center></td></tr>`
                $('table > tbody').first().html(loading)
            },
            success: res => {
                let row
                let i = res.length
                res.forEach(item => {
                    row += `<tr>
								<td>${--i}</td>
								<td>${item.noind}</td>
								<td>${item.nama}</td>
								<td class='detail' data-id='${item.id_data}' data-app1='${item.approver1}' data-app2='${item.approver2}'>${item.keterangan}</td>
								<td>${item.tgl_input}</td>
								<td>${(item.tanggal_start == item.tanggal_end) ? item.tanggal_start : item.tanggal_start+" - "+item.tanggal_end}</td>
								${getStatus(item.status, item.approver1, item.approver2)}
                                <td>${getAlasan(item.alasan)}</td>
                                <td>
                                    ${ (item.status == 0) ? `<button class="btn btn-sm btn-success changeDocument" data-toggle="modal" data-target="#modalEdit" type='button'><i class='fa fa-edit'></i> ubah</button>` : '' }
                                </td>
							</tr>`
                })
                $('.table-input-dokumen > tbody').html(row)
            }
        }).done( a => {
            showDetailRow()
            buttonEditListener()
        })
    }

    const getStatus = (stat, ap1, ap2) => {
        let status
        switch (stat) {
            case '0':
                status = '<td class="bg-yellow">Pending</td>'
                break
            case '1':
                status = `<td class="${(ap2 === '')? 'bg-green':'bg-blue'}">Diterima oleh seksi ${ap1}</td>`
                break
            case '2':
                status = `<td class="bg-red">Ditolak oleh seksi ${ap1}</td>`
                break
            case '3':
                status = `<td class="bg-green">Diterima oleh seksi ${ap2}</td>`
                break
            case '4':
                status = `<td class="bg-red">Ditolak oleh seksi ${ap2}</td>`
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
        if (val.length > 20) {
            return val.substr(0, 20) + '...'
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

    const buttonEditListener = () => {
        $('button.changeDocument').each(function(e) {
            let id = $(this).closest('tr').find('.detail').data('id')
            let url = baseurl + 'PengirimanDokumen/ajax/showData'
            $(this).click(function(e){
                e.stopPropagation()
                $.ajax({
                    method: 'post',
                    url,
                    data: {
                        id
                    },
                    dataType: 'json',
                    success: data => {
                        data.forEach(res => {
                        //THIIIIIIIIIIIIISISSPARTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
                            let option = $("<option selected></option>").val(res.noind).text(res.noind);
                            $('#modalEditNoInduk').append(option).trigger('change')
                            
                            $('#modalIdData').val(res.id_data);
                            $('#modalEditNameWorker').val(res.name);
                            $('#modalEditSeksi').val(res.seksi);
                            $('#modalEditLokasi').val(res.lokasi).trigger('change');
                            $('#modalEditInformation').val(res.id_master);
                            $('#modalEditDate').daterangepicker({
                                startDate: new Date(res.tanggal_start),
                                endDate: new Date(res.tanggal_end),
                                locale: {
                                    format: 'DD/MM/YYYY'
                                }
                            })
                        })
                    }
                })
                $('#modalEdit').modal()
            })
        })
    }

    const updateDataDokumen = () => {
        let id = $('#modalIdData').val()
        let noind = $('#modalEditNoInduk').val()
        let inform = $('#modalEditInformation').val()
        let lokasi = $('#modalEditLokasi').val()
        let date  = $('#modalEditDate').val()

        $.ajax({
            method: 'POST',
            url: baseurl + 'PengirimanDokumen/ajax/updateData',
            data: {
                id,
                noind,
                inform,
                date,
                lokasi
            },
            success: a => {
                $('#modalEdit').modal('toggle')
                swal.fire('sukses','','success')
                showTableInput()
            },
            error: e => {
                swal.fire('error','','error')
            }
        })
    }

    const deleteDokumen = () => {
        let id = $('#modalIdData').val()
        showSweetAlertQuestion('Yakin untuk menghapus dokumen ?', '', 'warning').then(a => {
            if(a.value){
                $.ajax({
                    method: 'POST',
                    url: baseurl + 'PengirimanDokumen/ajax/deleteData',
                    data: {
                        id
                    },
                    success: a => {
                        $('#modalEdit').modal('toggle')
                        $("td[data-id="+id+"]").parent().css({
                                background: '#dd4b39'
                            }).fadeOut(2000, () => {
                                $(this).remove()
                            })
                    }
                })
            } 
        })
    }
</script>