<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?= $Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal</label>
												<div class="col-lg-4">
													<input type="text" name="txtTanggalCutiBersama" id="txtTanggalCutiBersama" class="form-control" required placeholder="Pilih Tanggal..." autocomplete="off">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<input type="text" name="txtKeteranganCutiBersama" id="txtKeteranganCutiBersama" class="form-control" required placeholder="Tuliskan Keterangan..." value="Cuti Bersama" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 col-lg-offset-3">
													<div class="progress">
													  	<div
														  	class="progress-bar progress-bar-striped active"
														  	role="progressbar"
														  	aria-valuenow="40"
														  	aria-valuemin="0"
														  	aria-valuemax="100"
														  	style="width:0%"
														  	id="MPR-cutibersama-progress">
													    	0%
													  	</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button type="button" id="MPR-cutibersama-submit" class="btn btn-primary">Proses</button>
												</div>
											</div>
											<div class="form-group">
												<input value="0" type="hidden" id="MPR-status-Read">
											</div>
											<div class="form-group" id="MPR-cutibersama-download">
												
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-striped table-hover" id="tbl-MPR-CutiBersama-index">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Tanggal</th>
													<th>Cuti Bersama</th>
													<th>Mangkir Tidak Berpoint</th>
													<th>Mangkir Berpoint</th>
													<th>Lainnya</th>
													<th>Jumlah Total</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td><?php echo date('d M Y', strtotime($dt['tanggal'])) ?></td>
															<td data-tanggal="<?php echo $dt['tanggal'] ?>" data-ket="cb" class="td-MPR-CutiBersama-cb"><?php echo $dt['cuti_bersama'] ?></td>
															<td data-tanggal="<?php echo $dt['tanggal'] ?>" data-ket="mtp" class="td-MPR-CutiBersama-mtp"><?php echo $dt['mangkir_tanpa_point'] ?></td>
															<td data-tanggal="<?php echo $dt['tanggal'] ?>" data-ket="mp" class="td-MPR-CutiBersama-mp"><?php echo $dt['mangkir_berpoint'] ?></td>
															<td data-tanggal="<?php echo $dt['tanggal'] ?>" data-ket="l" class="td-MPR-CutiBersama-l"><?php echo $dt['lain'] ?></td>
															<td data-tanggal="<?php echo $dt['tanggal'] ?>" data-ket="j" class="td-MPR-CutiBersama-j"><?php echo $dt['jumlah'] ?></td>
															<td>
																<?php 
																if (strtotime($dt['tanggal']) <= strtotime(date('Y-m-d'))) {
																	echo "Sudah Melewati Tanggal";
																}else{
																	?>
																<a href="<?php echo base_url('MasterPresensi/Proses/CutiBersama/Hapus?tanggal='.$dt['tanggal']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Cuti Bersama Tanggal <?php echo date('d M Y', strtotime($dt['tanggal'])) ?>')">
																	<span class="fa fa-trash"></span>Hapus
																</a>
																	<?php
																}
																?>
															</td>
														</tr>
														<?php
														$nomor++;
													}
												}
												?>
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
</section>

<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>

<!-- <div class="loading"> -->
<div class="loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="modal-MPR-CutiBersama">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label>Detail Absen Pekerja</label>
				<button class="btn btn-danger modal-close-MPR-CutiBersama" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-off"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-12" style="overflow-x: scroll" id="modal-MPR-CutiBersama-isi">
							
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
        setInterval(function(){
			status = $('#MPR-status-Read').val();
			if(status == 1){
	            $.ajax({
					type:'get',
					data: {user: '<?php echo $user; ?>'},
					dataType: 'json',
					url: baseurl + 'MasterPresensi/Proses/CutiBersama/cekProgress',
					success: function(data){
	              	if (data !== "kosong") {
	              		$('#MPR-cutibersama-progress').attr('aria-valuenow',data);
		                $('#MPR-cutibersama-progress').css('width',data+'%');
		                $('#MPR-cutibersama-progress').text(data+' %');
	              	}
	              }
	            });
			}
        },1000);
    });
</script>