<style type="text/css">
    .dataTables_wrapper .dataTables_processing {
        position: absolute;
        text-align: center;
        font-size: 1.2em;
        z-index: 999;
    }
    #datepicker, #filterPeriode {
        cursor: pointer;
    }
    .dataTable_Button {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-bottom: 8px;
    }
    .dataTable_Filter {
        width: 450px;
        float: right;
        margin-right: 1px;
    }
    .dataTable_Information {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-top: 7px;
    }
    .dataTable_Pagination {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-top: 14px;
    }
    .dataTable_Processing {
        z-index: 999;
    }
    .fade-transition {
        -webkit-transition: background-color 1000ms linear;
        -moz-transition: background-color 1000ms linear;
        -o-transition: background-color 1000ms linear;
        -ms-transition: background-color 1000ms linear;
        transition: background-color 1000ms linear;
    }
    .no-padding {
        padding: 0;
    }
    .fadeIn {
        -webkit-animation: fadeIn 0.5s;
        -moz-animation: fadeIn 0.5s;
        -o-animation: fadeIn 0.5s;
        animation: fadeIn 0.5s;
    }
    .fadeOut {
        -webkit-animation: fadeOut 0.5s;
        -moz-animation: fadeOut 0.5s;
        -o-animation: fadeOut 0.5s;
        animation: fadeOut 0.5s;
    }
    .btn-info:hover, .btn-info:active, .btn-info.hover{
      background-color: #00acd6 !important;
    }
    .btn-success:hover, .btn-success:active, .btn-success.hover{
      background-color: #008d4c !important;
    }
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left" style="margin-top: -12px; margin-bottom: 18px;">
							<h1><b><?= $Title ?></b></h1>
						</div>
					</div>
				</div>
				<div id="pg_divTabelListData" class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
                                <div class="col-lg-6 no-padding">
								    <h4 id="data-title" style="margin: 7px 6px 0 6px;">List Data Potongan Gaji</h4>
                                </div>
                                <div class="col-lg-6 no-padding">
                                    <a href="<?= base_url('MasterPresensi/PotonganGaji/ListData') ?>" class="btn btn-info pull-right"><i class="fa fa-refresh" style="margin-right: 8px"></i>Refresh</button>
                                    <a href="<?= base_url('MasterPresensi/PotonganGaji/TambahData') ?>" class="btn btn-success pull-right" style="margin-right: 8px;"><i class="fa fa-plus" style="margin-right: 8px"></i>Tambah</a>
                                </div>
                            </div>
							<div class="box-body">
                                <div class="row" style="padding: 12px;">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="pg_tabelListData" class="datatable table table-striped table-bordered table-hover text-left" style="width: 100%; overflow-x: auto;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center" style="min-width: 102px;">Action</th>
                                                        <th class="text-center">Noind</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Jenis Potongan</th>
                                                        <th class="text-center" style="min-width: 100px;">Nominal Potongan</th>
                                                        <th class="text-center">Tipe Pembayaran</th>
                                                        <th class="text-center" style="min-width: 100px;">Sudah Dibayar</th>
                                                        <th class="text-center" style="min-width: 100px;">Kurang Bayar</th>
                                                        <th class="text-center">Awal Periode</th>
                                                        <th class="text-center">Akhir Periode</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pg_bodyTabelListData">
                                                    <?php $no = 1; foreach($list as $item): ?>
                                                    <tr id="potonganRow<?= $no ?>">
                                                        <td class="text-center potonganRowNumber"><?= $no ?>.</td>
                                                        <td class="text-center">
                                                            <form id="formDetail<?= $no ?>" action="<?= base_url('MasterPresensi/PotonganGaji/DetailData'); ?>" method="POST" hidden><input name="potonganId" type="text" value="<?= $item['potongan_id'] ?>" /></form>
                                                            <form id="formEdit<?= $no ?>" action="<?= base_url('MasterPresensi/PotonganGaji/EditData'); ?>" method="POST" hidden><input name="potonganId" type="text" value="<?= $item['potongan_id'] ?>" /></form>
                                                            <div class="btn-group">
                                                                <button title="Detail" onclick="javascript:pgListData.triggerFormDetail(<?= $no ?>)" class="btn btn-primary"><i class="fa fa-info-circle"></i></button>
                                                                <button title="Edit" onclick="javascript:pgListData.triggerFormEdit(<?= $no ?>)" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                                <button title="Hapus" onclick="javascript:pgListData.openDeleteModal('<?= $item['potongan_id'] ?>', <?= $no ?>, '<?= $item['nama'] ?>')" type="button" class="btn btn-danger" id="buttonDelete<?= $no++ ?>"><i class='fa fa-trash'></i></button>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?= $item['noind'] ?></td>
                                                        <td class="text-left"><?= $item['nama'] ?></td>
                                                        <td class="text-left"><?= $item['jenis_potongan'] ?></td>
                                                        <td class="text-right">Rp. <?= number_format($item['nominal_total'],0,',','.') ?></td>
                                                        <td class="text-center"><?= $item['tipe_pembayaran'] ?></td>
                                                        <td class="text-right">Rp. <?= number_format($item['sudah_bayar'],0,',','.') ?></td>
                                                        <td class="text-right">Rp. <?= number_format($item['kurang_bayar'],0,',','.') ?></td>
                                                        <td class="text-center"><?= $item['awal_periode'] ?></td>
                                                        <td class="text-center"><?= $item['akhir_periode'] ?></td>
                                                    </tr>
                                                  <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</section>
<script>
    let dataTable = null

    document.addEventListener('DOMContentLoaded', _ => {
        dataTable = $('#pg_tabelListData').DataTable({
            dom: '<"dataTable_Button"B><"dataTable_Filter"f>rt<"dataTable_Information"i><"dataTable_Pagination"p>',
			buttons: [
				{
					extend: 'collection',
					text: 'Ekspor Data',
					buttons: [
						{
							extend: 'copyHtml5',
							title: 'List Data Potongan Gaji',
							exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7, 8 , 9, 10]
							}
						},
						{
                            extend: 'excelHtml5',
							title: 'List Data Potongan Gaji',
							filename: 'List Data Potongan Gaji',
							exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7, 8 , 9, 10]
							}
						},
						{
							extend: 'csvHtml5',
							title: 'List Data Potongan Gaji',
							filename: 'List Data Potongan Gaji',
							exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7, 8 , 9, 10]
							}
						},
						{
							extend: 'pdfHtml5',
							title: 'List Data Potongan Gaji',
							filename: 'List Data Potongan Gaji',
							exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7, 8 , 9, 10]
							}
						},
						{
							extend: 'print',
							title: 'List Data Potongan Gaji',
							filename: 'List Data Potongan Gaji',
							autoPrint: true,
							exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7, 8 , 9, 10]
							}
						},
					]
				},
                'pageLength'
			]
        })
    })

    const pgListData = {
        triggerFormDetail: id => {
            const form = document.getElementById(`formDetail${id}`)
            if(form) form.submit();
        },
        triggerFormEdit: id => {
            const form = document.getElementById(`formEdit${id}`)
            if(form) form.submit();
        },
        deleteData: (id, row, employeeName) => {
            element(`#buttonDelete${row}`).animate.showLoading()
            const formData = new FormData()
            formData.append('id', id)
            fetch('<?= base_url('MasterPresensi/PotonganGaji/ListData/deleteData') ?>', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(response => {
                if(response.success) {
                    $.toaster(`Data potongan ${employeeName} berhasil dihapus`, '', 'success')
                    element(`#buttonDelete${row}`).animate.hideLoading('fa-trash')
                    if(dataTable) {
                        dataTable.row($(`#potonganRow${row}`)).remove().draw()
                        $('.potonganRowNumber').each((i, item) => { $(item).html(`${i + 1}.`) })
                    }
                } else {
                    console.error('delete data response unsuccessful')
                    $.toaster('Terjadi kesalahan saat menghapus data', '', 'danger')
                    element(`#buttonDelete${row}`).animate.hideLoading('fa-trash')
                }
            }).catch(e => {
                console.error(e)
                $.toaster('Terjadi kesalahan saat menghapus data', '', 'danger')
                element(`#buttonDelete${row}`).animate.hideLoading('fa-trash')
            })
        },
        openDeleteModal: (id, row, employeeName) => {
            if(confirm(`Anda yakin ingin menghapus data potongan ${employeeName} ?`)) pgListData.deleteData(id, row, employeeName)
        }
    }

    function element(selector) {
        try {
            let e
            const object = {
                get(selector) {
                    if(e) return e
                    return document.querySelector(selector)
                },
                getContext(type) {
                    return e.getContext(type)
                },
                setColor(color) {
                    e.style.color = color
                    return this
                },
                getHTML() {
                    return e.innerHTML
                },
                setHTML(html = '') {
                    e.innerHTML = html
                    return this
                },
                enable() {
                    e.disabled = false
                    return this
                },
                disable() {
                    e.disabled = true
                    return this
                },
                show() {
                    e.style.display = 'block'
                    return this
                },
                isShown() {
                    return element.style.display === 'block'
                },
                hide() {
                    e.style.display = 'none'
                    return this
                },
                isHidden() {
                    return e.style.display === 'none'
                },
                isInvisible() {
                    return e.style.visibility === 'hidden'
                },
                onClick(callback) {
                    e.addEventListener('click', callback)
                    return this
                },
                animate: {
                    css(animationName, callback) {
                        e.classList.add('animated', animationName)
                        const onAnimationEnd = _ => {
                            e.classList.remove('animated', animationName)
                            e.removeEventListener('animationend', onAnimationEnd)
                            if (typeof callback === 'function') callback()
                        }
                        e.addEventListener('animationend', onAnimationEnd)
                        return this
                    },
                    showLoading() {
                        e.disabled = true;
                        e.childNodes[0].classList = '';
                        e.childNodes[0].classList.add('fa', 'fa-spin', 'fa-spinner')
                        return this
                    },
                    hideLoading(icon) {
                        e.childNodes[0].classList = ''
                        if(icon) e.childNodes[0].classList.add('fa', icon)
                        if(!icon) e.childNodes[0].style.marginRight = ''
                        e.disabled = false
                        return this
                    }
                }
            }
            e = object.get(selector)
            return object
        } catch(e) {
            console.error(e)
        }
    }

    // note, if u not know what is this, learn es6 syntax js
    String.prototype.isEmpty = () => this.toString() == '' 

    String.prototype.isNotEmpty = () => this.toString() != ''

    String.prototype.isNull = () => this.toString() == null

    String.prototype.isNotNull = () => this.toString() != null

    String.prototype.isNullAndEmpty = () => this.toString() == null && this.toString() == ''

    String.prototype.isNullOrEmpty = () => this.toString() == null || this.toString() == ''

    String.prototype.isNotNullAndEmpty = () => this.toString() == null && this.toString() == ''

    String.prototype.isNotNullOrEmpty = () => this.toString() != null || this.toString() != ''
</script>
