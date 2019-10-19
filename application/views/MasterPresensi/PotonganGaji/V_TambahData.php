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
        margin-bottom: 2px;
    }
    .dataTable_Filter {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-bottom: 2px;
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
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h4 id="data-title" style="margin: 0 6px 0 6px;">Tambah Potongan</h4>
							</div>
							<div class="box-body">
                                <form id="pg_formPotongan" method="POST">
                                    <div class="row" style="padding: 12px;">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12 no-padding">
                                                    <div class="col-lg-6 no-padding">
                                                        <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                            <label for="pg_selectPekerja">Pekerja :</label>
                                                        </div>
                                                        <div class="col-lg-3" style="width: 70%;">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div style="max-height: 35px;" class="input-group-addon"><i class="fa fa-user"></i></div>
                                                                    <select style="max-height: 35px;" id="pg_selectPekerja" class="form-control" required></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 no-padding">
                                                        <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                            <label for="pg_textTipePembayaran">Tipe Pembayaran :</label>
                                                        </div>
                                                        <div class="col-lg-3" style="width: 70%;">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input style="max-height: 35px;" id="pg_inputTipePembayaran" type="number" class="form-control" min="1" max="100" value="1" required />
                                                                    <div style="max-height: 35px;" class="input-group-addon"><b>kali</b></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 no-padding" >
                                                    <div class="col-lg-6 no-padding">
                                                        <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                            <label for="pg_selectJenisPotongan">Jenis Potongan :</label>
                                                        </div>
                                                        <div class="col-lg-3" style="width: 70%;">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div style="max-height: 35px;" class="input-group-addon"><i class="fa fa-ticket"></i></div>
                                                                    <select style="max-height: 35px;" id="pg_selectJenisPotongan" class="form-control" required></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 no-padding">
                                                        <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                            <label for="pg_inputPeriode">Dipotong Mulai Periode Penggajian :</label>
                                                        </div>
                                                        <div id="pg_datePickerPeriode" class="col-lg-3" style="width: 70%;">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div style="max-height: 35px;" class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                                    <input style="max-height: 35px;" id="pg_inputPeriode" class="form-control" value="<?= date('M-Y') ?>" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 no-padding">
                                                    <div class="col-lg-6 no-padding">
                                                        <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                            <label for="pg_textNominalTotal">Nominal Total :</label>
                                                        </div>
                                                        <div class="col-lg-3" style="width: 70%;">
                                                            <div class="input-group">
                                                                <div style="max-height: 35px;" class="input-group-addon"><i class="fa fa-money"></i></div>
                                                                <input style="max-height: 35px;" id="pg_inputNominalTotal" type="text" class="form-control inputnumber" placeholder="Masukkan Nominal Total" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 0 12px 12px 12px">
                                        <div class="col-lg-12">
                                            <button id="pg_buttonSimulasi" type="submit" class="btn btn-primary pull-right"><i class="fa fa-eye" style="margin-right: 8px"></i>Simulasi</button>
                                            <a href="<?= base_url('MasterPresensi/PotonganGaji/ListData') ?>" class="btn btn-primary pull-right" style="margin-right: 8px;"><i class="fa fa-arrow-left" style="margin-right: 8px"></i>Kembali ke List Data</a>
                                        </div>
                                    </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
				<div id="pg_divTabelSimulasi" class="row animated" style="display: none;">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
                                <div class="col-lg-6 no-padding">
								    <h4 id="data-title" style="margin: 8px 6px 0 6px;">Tabel Simulasi</h4>
                                </div>
                                <div class="col-lg-6 no-padding">
                                    <button id="pg_buttonCloseSimulasi" type="button" class="btn btn-primary pull-right"><i class="fa fa-close" style="margin-right: 8px"></i>Tutup</button>
                                </div>
                            </div>
							<div class="box-body">
                                <div class="row" style="padding: 12px;">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="pg_tabelSimulasi" class="datatable table table-striped table-bordered table-hover text-left" style="width: 100%;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center" style="width: 24px;">No</th>
                                                        <th class="text-center">Periode</th>
                                                        <th class="text-center" style="width: 100px;">Potongan Ke</th>
                                                        <th class="text-center" style="width: 250px;">Nominal Potongan</th>
                                                        <th class="text-center" style="width: 250px;">Sisa</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                    <tbody id="pg_bodyTabelSimulasi"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 0 12px 12px 12px">
                                    <div class="col-lg-12">
                                        <button id="pg_buttonSaveData" type="button" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" style="margin-right: 8px"></i>Simpan</button>
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
    let tabelSimulasi = null
    let formData = null

    document.addEventListener('DOMContentLoaded', async _ => {
        pgTambahData.initSelect()
        pgTambahData.initInput()
        pgTambahData.initButton()
        pgTambahData.initForm()
        pgTambahData.initDataTable()
    })

    const pgTambahData = {
        async initSelect() {
            $('#pg_selectPekerja').select2({
                placeholder: 'Pilih Pekerja',
                allowClear: true,
                minimumInputLength: 3,
                delay: 250,
                ajax: {
                    url: '<?= base_url('MasterPresensi/PotonganGaji/TambahData/getPekerjaList') ?>',
                    method: 'POST',
                    dataType: 'json',
                    data: params => {
                        return {
                            term: params.term
                        }
                    },
                    processResults: data => {
                        return {
                            results: data.map(item => {
                                return {
                                    id: item.noind,
                                    text: item.noind + ' - ' + item.nama
                                }
                            })

                        }
                    }
                }
            })
            $('#pg_selectJenisPotongan').select2({
                placeholder: 'Pilih Jenis Potongan',
                allowClear: true,
                autoCapitalize: true,
                delay: 250,
                ajax: {
                    url: '<?= base_url('MasterPresensi/PotonganGaji/TambahData/getJenisPotonganList') ?>',
                    method: 'POST',
                    dataType: 'json',
                    data: params => {
                        return {
                            term: params.term
                        }
                    },
                    processResults: data => {
                        return {
                            results: data.map(item => {
                                return {
                                    id: item.jenis_potongan_id,
                                    text: item.jenis_potongan
                                }
                            })

                        }
                    }
                }
            })
        },
        async initInput() {
            $('#pg_inputPeriode').datepicker({
                format: 'M-yyyy',
                viewMode: 'months',
                minViewMode: 'months'
            })
        },
        async initForm() {
            document.getElementById('pg_formPotongan').addEventListener('submit', pgTambahData.simulateData.bind(event))
        },
        async initButton() {
            element('#pg_buttonCloseSimulasi').onClick( _ => {
                element('#pg_divTabelSimulasi').animate.css('fadeOut', _ => {
                    element('#pg_divTabelSimulasi').hide()
                    formData = null
                })
            })
            element('#pg_buttonSaveData').onClick( _ => {
                element('#pg_buttonSaveData').animate.showLoading()
                if(!formData) {
                    $.toaster('Mohon untuk simulasi data terlebih dahulu', '', 'danger')
                    element('#pg_buttonSaveData').animate.hideLoading('fa-floppy-o')
                }
                formData.append('pekerja', $('#pg_selectPekerja').select2('data')[0].id)
                formData.append('jenisPotongan', $('#pg_selectJenisPotongan').select2('data')[0].id)
                formData.append('nominalTotal', document.getElementById('pg_inputNominalTotal').value.replace(/[^0-9]/g, ""))
                formData.append('tipePembayaran', document.getElementById('pg_inputTipePembayaran').value)
                formData.append('periode', pgTambahData.formatPeriode(document.getElementById('pg_inputPeriode').value))
                fetch('<?= base_url('MasterPresensi/PotonganGaji/TambahData/saveData') ?>', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json()).then(response => {
                    if(response.success) {
                        window.location.replace('<?= base_url('MasterPresensi/PotonganGaji/ListData') ?>')
                    } else {
                        console.error('saving data response unsuccessful')
                        $.toaster('Terjadi kesalahan saat menyimpan data', '', 'danger')
                        element('#pg_buttonSaveData').animate.hideLoading('fa-floppy-o')
                    }
                }).catch(e => {
                    console.error(e)
                    $.toaster('Terjadi kesalahan saat menyimpan data', '', 'danger')
                    element('#pg_buttonSaveData').animate.hideLoading('fa-floppy-o')
                })
            })
        },
        async initDataTable() {
            tabelSimulasi = $('#pg_tabelSimulasi').DataTable({
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4] }
                ]
            })
        },
        async simulateData(event) {
            event.preventDefault()
            potongan_total = document.getElementById('pg_inputNominalTotal').value;
            element('#pg_buttonSimulasi').animate.showLoading()
            const pekerja = $('#pg_selectPekerja').select2('data')[0].id
            const jenisPotongan = $('#pg_selectJenisPotongan').select2('data')[0].id
            const nominalTotal = parseInt(potongan_total.replace(/[^0-9]/g, ""))
            const tipePembayaran = document.getElementById('pg_inputTipePembayaran').value
            const periode = pgTambahData.formatPeriode(document.getElementById('pg_inputPeriode').value)
            if(pekerja && jenisPotongan && nominalTotal && tipePembayaran && periode) {
                formData = new FormData()
                var periodeSimulasi = new Array()
                var potonganSimulasi = new Array()
                var nominalSimulasi = new Array()
                var sisaSimulasi = new Array()
                var statusSimulasi = new Array()
                if(element('#pg_divTabelSimulasi').isHidden()) {
                    tabelSimulasi.clear()
                    var nominal = Math.round(nominalTotal / tipePembayaran)
                    let sisaNominal = nominalTotal
                    for(let i = 0; i < tipePembayaran; i++) {
                        if (i == (tipePembayaran - 1)) {
                          nominal = sisaNominal
                        }
                        periodeSimulasi[i] = moment(periode, 'YYYY-MM-DD').add(i, 'M').format('YYYY-MM-DD')
                        potonganSimulasi[i] = i + 1
                        nominalSimulasi[i] = nominal
                        sisaSimulasi[i] = sisaNominal -= nominal
                        statusSimulasi[i] = 1
                        tabelSimulasi.row.add([
                            (i + 1) + '.',
                            moment(periode, 'YYYY-MM-DD').add(i, 'M').format('MMM-YYYY'),
                            i + 1,
                            '<div class="input-group"><div style="max-height: 35px;" class="input-group-addon"><b>Rp. </b></div><input type="text" class="form-control inputnumber" data-nama="potongan" data-default="' + nominal.toLocaleString('id') + '" data-row="' + (i + 1) +'" data-pembayaran="' + tipePembayaran + '" value="' + nominal.toLocaleString('id') + '" ></div>',
                            '<div class="input-group"><div style="max-height: 35px;" class="input-group-addon"><b>Rp. </b></div><input type="text" class="form-control inputnumber disabled" data-nama="sisa" data-default="' + sisaNominal.toLocaleString('id') + '" data-row="' + (i + 1) +'" data-pembayaran="' + tipePembayaran + '" value="' + sisaNominal.toLocaleString('id') + '" disabled></div>',
                            'Belum terpotong'
                        ]).draw(false)
                    }
                    setTimeout( _ => {
                        element('#pg_divTabelSimulasi').show()
                        element('#pg_divTabelSimulasi').animate.css('fadeIn', _ => {
                            element('#pg_buttonSimulasi').animate.hideLoading('fa-eye')
                        })
                    }, 750)
                    formData.append('periodeSimulasi', JSON.stringify(periodeSimulasi))
                    formData.append('potonganSimulasi', JSON.stringify(potonganSimulasi))
                    formData.append('nominalSimulasi', JSON.stringify(nominalSimulasi))
                    formData.append('sisaSimulasi', JSON.stringify(sisaSimulasi))
                    formData.append('statusSimulasi', JSON.stringify(statusSimulasi))
                } else {
                    element('#pg_divTabelSimulasi').animate.css('fadeOut', _ => {
                        tabelSimulasi.clear()
                        var nominal = Math.round(nominalTotal / tipePembayaran)
                        let sisaNominal = nominalTotal
                        for(let i = 0; i < tipePembayaran; i++) {
                            if (i == (tipePembayaran - 1)) {
                              nominal = sisaNominal
                            }
                            periodeSimulasi[i] = moment(periode, 'YYYY-MM-DD').add(i, 'M').format('YYYY-MM-DD')
                            potonganSimulasi[i] = i + 1
                            nominalSimulasi[i] = nominal
                            sisaSimulasi[i] = sisaNominal -= nominal
                            statusSimulasi[i] = 1
                            tabelSimulasi.row.add([
                                (i + 1) + '.',
                                moment(periode, 'YYYY-MM-DD').add(i, 'M').format('MMM-YYYY'),
                                i + 1,
                                '<div class="input-group"><div style="max-height: 35px;" class="input-group-addon"><b>Rp. </b></div><input type="text" class="form-control inputnumber" data-nama="potongan" data-default="' + nominal.toLocaleString('id') + '" data-row="' + (i + 1) +'" data-pembayaran="' + tipePembayaran + '" value="' + nominal.toLocaleString('id') + '" ></div>',
                                '<div class="input-group"><div style="max-height: 35px;" class="input-group-addon"><b>Rp. </b></div><input type="text" class="form-control inputnumber disabled" data-nama="sisa" data-default="' + sisaNominal.toLocaleString('id') + '" data-row="' + (i + 1) +'" data-pembayaran="' + tipePembayaran + '" value="' + sisaNominal.toLocaleString('id') + '" disabled></div>',
                                'Belum terpotong'
                            ]).draw(false)
                        }
                        element('#pg_divTabelSimulasi').animate.css('fadeIn', _ => {
                            element('#pg_buttonSimulasi').animate.hideLoading('fa-eye')
                        })
                        formData.append('periodeSimulasi', JSON.stringify(periodeSimulasi))
                        formData.append('potonganSimulasi', JSON.stringify(potonganSimulasi))
                        formData.append('nominalSimulasi', JSON.stringify(nominalSimulasi))
                        formData.append('sisaSimulasi', JSON.stringify(sisaSimulasi))
                        formData.append('statusSimulasi', JSON.stringify(statusSimulasi))
                    })
                }
            } else {
                $.toaster('Mohon lengkapi form sebelum simulasi data', '', 'danger')
                element('#pg_buttonSimulasi').animate.hideLoading('fa-eye')
            }
        },
        formatPeriode(periode) {
            return moment(periode, 'MMM-YYYY').format('YYYY-MM-DD')
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

    String.prototype.isEmpty = function() { return this.toString() == '' }

    String.prototype.isNotEmpty = function() { return this.toString() != '' }

    String.prototype.isNull = function() { return this.toString() == null }

    String.prototype.isNotNull = function() { return this.toString() != null }

    String.prototype.isNullAndEmpty = function() { return this.toString() == null && this.toString() == '' }

    String.prototype.isNullOrEmpty = function() { return this.toString() == null || this.toString() == '' }

    String.prototype.isNotNullAndEmpty = function() { return this.toString() == null && this.toString() == '' }

    String.prototype.isNotNullOrEmpty = function() { return this.toString() != null || this.toString() != '' }

    $(document).on('ready',function(){
      $("section").on("keyup",".inputnumber", function(event ) {
        val_number = $(this).val()
        if (val_number.length > 0) {
          val_number = val_number.replace(/[^0-9]/g, "")
          val_number = parseFloat(val_number).toLocaleString('id')
          $(this).val(val_number)
        }else{
          $(this).val("");
        }

      })

      $("section").on("blur",".inputnumber", function(event ) {
        val_number = $(this).val()
        if (val_number.length == 0) {
          $(this).val("0");
        }

      })

      $("table").on("keyup",".inputnumber", function(event){
        val_number = $(this).val()
        val_number = val_number.replace(/[^0-9]/g, "")
        val_nama = $(this).attr("data-nama")
        val_default = $(this).attr("data-default")
        val_default = val_default.replace(/[^0-9]/g, "")
        val_row = $(this).attr("data-row")
        val_sisa = $(this).closest("tr").find("[data-nama=sisa]").val();
        val_sisa = val_sisa.replace(/[^0-9]/g, "")
        // val_sisa_sebelumnya = $(this).closest("tbody").find("[data-row=" + (val_row - 1) + "]").closest("tr").find("[data-nama=sisa]").val();
        if (val_row == 1) {
          val_sisa_sebelumnya = $("#pg_inputNominalTotal").val();
          val_sisa_sebelumnya = val_sisa_sebelumnya.replace(/[^0-9]/g, "")
        }else{
          val_sisa_sebelumnya = $("[data-row=" + (val_row - 1) + "]").closest("tr").find("[data-nama=sisa]").val();
          val_sisa_sebelumnya = val_sisa_sebelumnya.replace(/[^0-9]/g, "")
        }

        val_pembayaran = $(this).attr("data-pembayaran")
        if(parseInt(val_number) > parseInt(val_sisa)){
          alert("Jumlah Potongan Melebihi Sisa Potongan di bulan tersebut")
          $(this).val(val_default)
        }else{
          $("[data-row=" + val_row + "]").closest("tr").find("[data-nama=sisa]").val(parseFloat(val_sisa_sebelumnya - val_number).toLocaleString('id'))
          $("[data-row=" + val_row + "]").closest("tr").find("[data-nama=sisa]").attr("data-default",parseFloat(val_sisa_sebelumnya - val_number).toLocaleString('id'))
          $(this).attr("data-default",parseFloat(val_number).toLocaleString('id'))
          for (var i = val_row; i <= val_pembayaran; i++) {
            if (i == 1) {
              val_sisa_sebelumnya = $("#pg_inputNominalTotal").val();
              val_sisa_sebelumnya = val_sisa_sebelumnya.replace(/[^0-9]/g, "")
            }else{
              val_sisa_sebelumnya = $("[data-row=" + (i - 1) + "]").closest("tr").find("[data-nama=sisa]").val()
              val_sisa_sebelumnya = val_sisa_sebelumnya.replace(/[^0-9]/g, "")
            }

            val_potongan = $("[data-row=" + i + "]").closest("tr").find("[data-nama=potongan]").val()
            val_potongan = val_potongan.replace(/[^0-9]/g, "")

            if (parseFloat(val_sisa_sebelumnya) < parseFloat(val_potongan) || i == val_pembayaran) {
              $("[data-row=" + i + "]").closest("tr").find("[data-nama=potongan]").val(parseFloat(val_sisa_sebelumnya).toLocaleString('id'))
              $("[data-row=" + i + "]").closest("tr").find("[data-nama=potongan]").attr("data-default",parseFloat(val_sisa_sebelumnya).toLocaleString('id'))
            }
            val_potongan = $("[data-row=" + i + "]").closest("tr").find("[data-nama=potongan]").val()
            val_potongan = val_potongan.replace(/[^0-9]/g, "")
            $("[data-row=" + i + "]").closest("tr").find("[data-nama=sisa]").val(parseFloat(val_sisa_sebelumnya - val_potongan).toLocaleString('id'))
            $("[data-row=" + i + "]").closest("tr").find("[data-nama=sisa]").attr("data-default",parseFloat(val_sisa_sebelumnya - val_potongan).toLocaleString('id'))
          }

          var nominalSimulasi = new Array();
          var sisaSimulasi = new Array();
          for (var i = 1; i <= val_pembayaran; i++) {
            val_potongan = $("[data-row=" + i + "]").closest("tr").find("[data-nama=potongan]").val()
            val_potongan = val_potongan.replace(/[^0-9]/g, "")
            val_sisa = $("[data-row=" + i + "]").closest("tr").find("[data-nama=sisa]").val()
            val_sisa = val_sisa.replace(/[^0-9]/g, "")

            nominalSimulasi[i - 1] = val_potongan
            sisaSimulasi[i - 1] = val_sisa
          }
          formData.set('nominalSimulasi', JSON.stringify(nominalSimulasi))
          formData.set('sisaSimulasi', JSON.stringify(sisaSimulasi))
          console.log(formData.getAll('nominalSimulasi'))
        }

      })
    })

</script>
