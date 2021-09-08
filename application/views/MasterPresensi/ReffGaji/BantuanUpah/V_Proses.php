<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h3><b><?=$Title ?></b></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row div-MPR-BantuanUpah-nonLoading">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Penggajian</label>
												<div class="col-lg-2">
													<input type="text" placeholder="YYYY-MM-DD s/d YYYY-MM-DD" class="form-control" id="txt-MPR-BantuanUpah-Periode">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Status Pekerja</label>
												<div class="col-lg-4">
													<select id="slc-MPR-BantuanUpah-StatusPekerja" class="select2" data-placeholder="Pilih Status Pekerja" multiple="multiple" style="width: 100%">
														<option></option>
														<?php 
														if (isset($hubker) && !empty($hubker)) {
															foreach ($hubker as $hk) {
																?>
																<option value="<?php echo $hk['fs_noind'] ?>"><?php echo $hk['fs_noind']." - ".$hk['fs_ket'] ?></option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group text-center">
												<button type="button" class="btn btn-primary" id="btn-MPR-BantuanUpah-Proses">  
													<span class="fa fa-gear"></span>
													Proses
												</button>
											</div>
										</form>
									</div>
								</div>
								<div class="row div-MPR-BantuanUpah-nonLoading">
									<div class="col-lg-6">
										<span style="font-size: 20pt">Data Hasil Proses</span>
									</div>
									<div class="col-lg-6 text-right">
										<button type="button" class="btn btn-danger" data-id="" id="btn-MPR-BantuanUpah-Proses-Pdf">
											<span class="fa fa-file-pdf-o"></span>
											PDF
										</button>
										<button type="button" class="btn btn-success" data-id="" id="btn-MPR-BantuanUpah-Proses-Excel">
											<span class="fa fa-file-excel-o"></span>
											Excel
										</button>
									</div>
								</div>
								<div class="row div-MPR-BantuanUpah-loading" style="display: none;">
									<div class="col-lg-12">
										<div class="progress">
										  	<div
											  	class="progress-bar progress-bar-striped active"
											  	role="progressbar"
											  	aria-valuenow="0"
											  	aria-valuemin="0"
											  	aria-valuemax="100"
											  	style="width:0%"
											  	id="ldg-MPR-BantuanUpah-progress">
										    	0%
										  	</div>
										</div>
									</div>
								</div>
								<div class="row div-MPR-BantuanUpah-loading" style="display: none;">
									<div class="col-lg-12">
										<h4 id="h4-MPR-BantuanUpah-progress-keterangan"></h4>
										<input type="hidden" id="MPR-status-Read" value="0">
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}
										</style>
										<table class="table table-bordered table-hover table-striped" id="tbl-MPR-BantuanUpah-HasilProses">
											<thead>
												<tr>
													<th rowspan="2" class="bg-primary text-center">No</th>
													<th rowspan="2" class="bg-primary text-center">No. Induk</th>
													<th rowspan="2" class="bg-primary text-center">Nama</th>
													<th rowspan="2" class="bg-primary text-center">Tanggal Perhitungan</th>
													<th rowspan="2" class="bg-primary text-center">Lokasi Kerja</th>
													<th colspan="2" class="bg-primary text-center">GP</th>
													<th colspan="2" class="bg-primary text-center">IF</th>
													<th colspan="2" class="bg-primary text-center">IP</th>
													<th colspan="2" class="bg-primary text-center">IPT</th>
													<th colspan="2" class="bg-primary text-center">IK</th>
													<th colspan="2" class="bg-primary text-center">IKR</th>
													<th colspan="2" class="bg-primary text-center">Ins. Kepatuhan</th>
													<th colspan="2" class="bg-primary text-center">Ins. Kemahalan</th>
													<th colspan="2" class="bg-primary text-center">Ins. Penempatan</th>
													<th rowspan="2" class="bg-primary text-center">Kategori</th>
													<th rowspan="2" class="bg-primary text-center">Keterangan</th>
												</tr>
												<tr>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
													<th class="bg-primary text-center">Kom</th>
													<th class="bg-primary text-center">Prs(%)</th>
												</tr>
											</thead>
											<tbody>
												
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
<script type="text/javascript">
	$(document).ready(function(){
        setInterval(function(){
			status = $('#MPR-status-Read').val();
			if(status == 1){
				$('.div-MPR-BantuanUpah-nonLoading').hide();
				$('.div-MPR-BantuanUpah-loading').show();
	            $.ajax({
					type:'get',
					data: {user: '<?php echo $user; ?>'},
					dataType: 'json',
					url: baseurl + 'MasterPresensi/ReffGaji/BantuanUpah/cekProgress',
					success: function(data){
	              	if (data !== "kosong") {
	              		$('#ldg-MPR-BantuanUpah-progress').attr('aria-valuenow',data.progress);
		                $('#ldg-MPR-BantuanUpah-progress').css('width',data.progress+'%');
		                $('#ldg-MPR-BantuanUpah-progress').text(data.progress+' % ');
		                $('#h4-MPR-BantuanUpah-progress-keterangan').text(data.keterangan);
	              	}
	              }
	            });
			}else{
				$('.div-MPR-BantuanUpah-loading').hide();
				$('.div-MPR-BantuanUpah-nonLoading').show();

			}
        },1000);
    });
</script>