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
    .bold {
        font-weight: bold;
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
								<h4 id="data-title" style="margin: 0 6px 0 6px;">Detail Potongan</h4>
							</div>
							<div class="box-body">
                                <div class="row" style="padding: 12px;">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12 no-padding">
                                                <div class="col-lg-6 no-padding">
                                                    <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                        <label for="pg_selectPekerja" class="bold">Pekerja :</label>
                                                    </div>
                                                    <div class="col-lg-3" style="width: 70%;">
                                                        <span id="pg_selectPekerja"><?= $pekerja ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 no-padding">
                                                    <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                        <label for="pg_textTipePembayaran" class="bold">Tipe Pembayaran :</label>
                                                    </div>
                                                    <div class="col-lg-3" style="width: 70%;">
                                                        <span id="pg_inputTipePembayaran"><?= $tipePembayaran ?> kali</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 no-padding" >
                                                <div class="col-lg-6 no-padding">
                                                    <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                        <label for="pg_selectJenisPotongan" class="bold">Jenis Potongan :</label>
                                                    </div>
                                                    <div class="col-lg-3" style="width: 70%;">
                                                        <span id="pg_selectJenisPotongan"><?= $jenisPotongan ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 no-padding">
                                                    <div class="col-lg-3" style="width: 30%; text-align: left;">
                                                        <label for="pg_inputPeriode" class="bold">Dipotong Mulai Periode Penggajian :</label>
                                                    </div>
                                                    <div id="pg_datePickerPeriode" class="col-lg-3" style="width: 70%;">
                                                        <span id="pg_inputPeriode"><?= $periode ?></span>
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
                                                        <span id="pg_textNominalTotal">Rp. <?= $nominalTotal ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 0 12px 12px 12px">
                                    <form id="pg_formPotongan" method="POST" action="<?= base_url('MasterPresensi/PotonganGaji/EditData') ?>">
                                        <input type="text" name="potonganId" value="<?= $potonganId ?>" hidden />
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-edit" style="margin-right: 8px"></i>Edit</button>
                                            <a href="<?= base_url('MasterPresensi/PotonganGaji/ListData') ?>" class="btn btn-primary pull-right" style="margin-right: 8px;"><i class="fa fa-arrow-left" style="margin-right: 8px"></i>Kembali ke List Data</a>                                        
                                        </div>
                                    </form>
                                </div>
							</div>
						</div>
					</div>
				</div>
				<div id="pg_divTabelSimulasi" class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
                                <div class="col-lg-6 no-padding">
								    <h4 id="data-title" style="margin: 0 6px 0 6px;">Tabel Simulasi</h4>
                                </div>
                                <div class="col-lg-6 no-padding"></div>
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
                                                    <tbody id="pg_bodyTabelSimulasi">
                                                        <?php $no = 1; foreach($simulasi as $row): ?>
                                                        <tr>
                                                            <td><?= $no ?>.</td>
                                                            <td><?= date('M Y', strtotime($row['periode_potongan'])) ?></td>
                                                            <td><?= $no++ ?></td>
                                                            <td>Rp. <?= $row['nominal_potongan'] ?></td>
                                                            <td>Rp. <?= $row['sisa'] ?></td>
                                                            <td><?= $row['status_potongan'] ?></td>
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
    document.addEventListener('DOMContentLoaded', () => {
        pgDetailData.initDataTable()
    })

    const pgDetailData = {
        initDataTable: () => {
            $('#pg_tabelSimulasi').DataTable({
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4,5] }
                ]
            })
        }
    }
</script>