<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1" style="margin-bottom: 30px;">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMSeleksi/MonitoringHasilTes/');?>">
									<i class="icon-home icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="panel-body">
									<div class="col-lg-2 text-right">
										<label>Tipe Seleksi :</label>
									</div>
									<div class="col-lg-3">
										<select class="select select2 form-control" name="tipe_seleksi_psikotest" id="tipe_seleksi_psikotest" style="width:100%" data-placeholder="pilih tipe seleksi">
										<option></option>
										<option value="SMK/SMA_Reg">SMK/SMA Reg</option>
										<option value="D3/S1">D3/S1</option>
										<option value="OS">OS</option>
										<option value="Cabang">Cabang</option>
										<option value="PKL/Magang">PKL/Magang</option>
										</select>
									</div>
									<div class="col-lg-2 text-right">
										<label>Tanggal Tes :</label>
									</div>
									<div class="col-lg-3">
										<input name="tanggal_psikotest" class="form-control pickerpenjadwalan" id="tanggal_psikotest" placeholder="pilih tanggal test" autocomplete="off">
									</div>
								</div>
								<div class="panel-body">
									<div class="col-lg-2 text-right">
										<label>Nama Tes :</label>
									</div>
									<div class="col-lg-3">
										<select class="select select2 form-control get_nama_psikotest" name="nama_test_psikotest" id="nama_test_psikotest" style="width:100%" data-placeholder="pilih nama test"></select>
									</div>
									<div class="col-lg-2 text-right">
										<label>Nama Peserta :</label>
									</div>
									<div class="col-lg-3">
										<select class="select select2 form-control get_peserta_psikotest" name="nama_peserta_psikotest" id="nama_peserta_psikotest" style="width:100%" data-placeholder="pilih nama peserta"></select>
									</div>
								</div>
								<div class="panel-body text-center">
									<div class="col-lg-12">
										<button type="button" class="btn btn-success" onclick="findDataHasilPsikotest(this)" style="width:150px">Cari Hasil Tes</button>
									</div>
								</div>
								<div class="panel-body" style="margin-top: 20px;" id="view_hasil_tes"></div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<ul class="nav nav-tabs nav-justified">
									<li class="active"><a data-toggle="pill" href="#smk_sma_hasil_psikotest">SMK / SMA Reg</a></li>
									<li><a data-toggle="pill" href="#d3s1_hasil_psikotest">D3 / S1</a></li>
									<li><a data-toggle="pill" href="#os_hasil_psikotest">OS</a></li>
									<li><a data-toggle="pill" href="#cabang_hasil_psikotest">Cabang</a></li>
									<li><a data-toggle="pill" href="#pkl_magang_hasil_psikotest">PKL/Magang</a></li>
								</ul>
								<br>
								<div class="tab-content">
									<div id="smk_sma_hasil_psikotest" class="tab-pane fade in in active"></div>
                                    <div id="d3s1_hasil_psikotest" class="tab-pane fade in"></div>
                                    <div id="os_hasil_psikotest" class="tab-pane fade in"></div>
                                    <div id="magang_hasil_psikotest" class="tab-pane fade in"></div>
                                    <div id="pkl_magang_hasil_psikotest" class="tab-pane fade in"></div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
