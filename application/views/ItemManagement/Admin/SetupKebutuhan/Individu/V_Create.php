<section class="content-header">
	<h1>
		Setup Kebutuhan Standar Individu
	</h1>
</section>
<section class="content">
	<form method="post" action="<?php echo base_url('ItemManagement/SetupKebutuhan/Individu/insert') ?>">
		<div class="row">
			<div class="col-lg-12">	
				<div class="box box-primary">
					<div class="box-body with-border">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">KODE STANDAR</label>
										<div class="col-lg-4">
											<input type="text" class="form-control text-uppercase" style="width: 100%" placeholder="KODE STANDAR" name="txt_kode_standar" value="<?php echo $kode_standar;?>" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">KODESIE</label>
										<div class="col-lg-4">
											<select id="slcKodesie" name="txt_kodesie" class="form-control" data-placeholder="KODESIE" style="width: 100%;" required>
											</select>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">NO INDUK</label>
										<div class="col-lg-4">
											<select id="slcNoInduk" name="txt_noind" class="form-control" data-placeholder="NO INDUK" style="width: 100%;" required disabled>
											</select>
										</div>
										<div class="col-lg-6">
											<button id="save-btn" type="submit" class="btn btn-primary" disabled>SAVE</button>
											<button type="button" class="btn btn-primary" onclick="window.history.back()">BACK</button>
											<button type="button" onclick="addNewForm()" class="btn btn-primary"><i class="fa fa-plus"></i> ADD NEW FORM</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="multiple-form" class="row">
			<div class="col-md-6 form-clone">
				<div class="box box-primary">
					<div class="box-header">
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-danger btn-xs delete-form"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-4 control-label">KODE BARANG</label>
							<div class="col-lg-8">
								<select name="txt_kode_barang[]" class="form-control slcKodeBrg" data-placeholder="KODE BARANG" style="width: 100%;" required>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-4 control-label">NAMA BARANG</label>
							<div class="col-lg-8">
								<input type="text" class="form-control text-uppercase nama-barang" style="width: 100%" placeholder="NAMA BARANG" name="txt_detail[]" value="" required></input>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-4 control-label">PERIODE MULAI</label>
							<div class="col-lg-8">
								<input type="text" class="form-control im-datepicker" style="width: 100%" placeholder="TANGGAL AKTIF" name="txt_tgl_aktif[]" value="" required></input>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-4 control-label">PERIODE SELESAI</label>
							<div class="col-lg-8">
								<input type="text" class="form-control im-datepicker periode-selesai" style="width: 100%" placeholder="PERIODE" name="txt_periode[]" value="" required></input>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-4 control-label">JUMLAH</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" style="width: 100%" placeholder="JUMLAH" name="txt_jumlah[]" value="" required></input>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 add-col">
				<div class="col-sm-12 add-form-div">
					<button onclick="addNewForm()" type="button" class="btn btn-primary add-form-button"><i class="fa fa-plus fa-3x"></i></button>
				</div>
			</div>
		</div>
	</form>
	<div class="alert alert-danger flyover flyover-top">
		<span style="float: right;cursor:pointer" onclick="$('.flyover-top').removeClass('in')">
			<b style="color: #fff;">&times;</b>
		</span>
		<b class="alert-text"></b>
	</div>
</section>