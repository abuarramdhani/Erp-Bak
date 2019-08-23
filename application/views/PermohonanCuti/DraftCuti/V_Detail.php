<style>
	input{
		cursor: default;
	}
	label{
		left: 15px;
	}
	.container{
		width: auto;
	}
	#ubahKeperluan, #saveKeperluan, #ubahTglCuti, #saveTglCuti{
		cursor: pointer;
	}
	#DetailTglCuti, #txtPengambilanCutiTahunanSusulan{
		cursor: default;
	}
</style>
<section class="content">
	<div class="panel-body">
		<div class="row">
	    <div class="box box-primary box-solid">
	  		<div style="height: 5em" class="box-header with-border">
	  			<h2 align="center"><strong><?=$Menu ?></strong></h2>
	        <div class="box-tools pull-right">
	          <button type="button" class="btn btn-box-tool" data-widget="collapse">
	            <i class="fa fa-minus"></i>
	          </button>
	        </div>
	  		</div>
	      <div class="box-body  bg-info">
	        <div class="row">
	      		<div class="col-lg-12">
	      			<div class="row">
	      				<div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
	      					<text>Nama 			  </text><br>
	      					<text>No Induk	  </text><br>
	      					<text>Seksi 		  </text><br>
	      					<text>Unit			  </text><br>
	      					<text>Departemen  </text>
	      				</div>
	      				<div class="ccol-lg-11 col-md-10 col-sm-10 col-xs-9">
	      					<?php foreach ($Info as $key): ?>
	      						<text>: <?=$key['nama']?></text> <br>
	      						<text>: <?=$key['noind']?> </text><br>
	      						<text>: <?=$key['seksi']?> </text><br>
	      						<text>: <?=$key['unit']?> </text><br>
	      						<text>: <?=$key['dept']?> </text>
	      					<?php endforeach; ?>
	      				</div>
	      			</div>
	      		</div>
	        </div>
	      </div>
	  	</div>
		</div>
		<div class="inner">
			<div class="row">
				<form class="form-horizontal">
					<div class="col-lg-12">
						<div class="row">
							<div class="box ">
								<br>
								<div class="form-group">
									<label class="control-label col-lg-4">Id Cuti</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
												<input type="text" class="form-control" name="" id="id_cuti" value="<?php echo $Detail['0']['id_cuti'] ?>" readonly>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Tanggal Pembuatan</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
												<input type="text" class="form-control" name="" id="" value="<?php echo date("d M Y",strtotime($Detail['0']['tgl_pengajuan'])) ?>" readonly>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">No Induk</label>
									<div class="col-lg-4">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
												<input type="text" class="form-control" name="" id="" value="<?=$Detail['0']['noind'] ?>" readonly>
										</div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
												<input type="text" class="form-control" name="" value="<?=$Detail['0']['nama']?>" readonly>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Keterangan</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
												<input type="text" class="form-control" name="" id="" value="<?=$keterangan['0']['kd_ket'].' - '.$keterangan['0']['keterangan'] ?>" readonly>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Tipe Cuti</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
												<input type="text" class="form-control" name="" id="" value="<?=$Detail['0']['tipe'] ?>" readonly>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Jenis Cuti</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
												<input type="text" class="form-control" name="" id="" value="<?=$Detail['0']['jenis'] ?>" readonly>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Keperluan</label>
									<div class="col-lg-4 col-xs-10">
										<div class="col-lg-12">
												<input type="text" class="form-control" name="" id="DetailKeperluan" value="<?php if(empty($Detail['0']['keperluan'])){ echo "-";}else{echo $Detail['0']['keperluan'];} ?>" readonly>
										</div>
									</div>
									<?php if($Detail['0']['status'] == '0' OR $Detail['0']['status'] == '1' ): ?>
									<div class="col">
										<a id="ubahKeperluan" class="btn btn-success btn-sm fa fa-edit" onclick="ubahKeperluan()"></a>
										<?php if($Detail['0']['jenis_id'] != '13'): ?>
											<a id="saveKeperluan" class="btn btn-primary btn-sm fa fa-save hidden" onclick="saveKeperluan(1)"></a>
											<button type="button" onclick="batalKeperluan()" id="cancelKeperluan" class="btn btn-danger btn-sm hidden">batal</button>
										<?php else: ?>
											<a id="saveKeperluan" class="btn btn-primary btn-sm fa fa-save hidden" onclick="saveKeperluan(2)"></a>
											<button type="button" onclick="batalKeperluan()" id="cancelKeperluan" class="btn btn-danger btn-sm hidden">batal</button>
										<?php endif; ?>
									</div>
								<?php endif;?>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Tanggal Pengambilan Cuti</label>
									<div class="col-lg-4">
										<div class="col-lg-12 col-xs-10">
											<!-- <?php //if($Detail['0']['jenis_id'] != '13'): ?> -->
												<input type="text" value="<?php if($Detail['0']['jenis'] == 'Istirahat Melahirkan'){ echo $tglambilhpl;}else{ echo $tglambil;}?>" id="DetailTglCuti" class="form-control" data-date-format="yyyy-mm-dd" disabled>
											<!-- <?php //else: ?> -->
												<!-- <input type="text" value="<?php //if($Detail['0']['jenis'] == 'Istirahat Melahirkan'){ echo $tglambilhpl;}else{ echo $tglambil;}?>" id="txtPengambilanCutiTahunanSusulan" data-date-format="yyyy-mm-dd" class="form-control" disabled> -->
											<!-- <?php //endif; ?> -->
										</div>
									</div>
									<div class="col">
										<?php if($Detail['0']['status'] == '0' OR $Detail['0']['status'] == '1' ): ?>
											<a id="ubahTglCuti" class="btn btn-success btn-sm fa fa-edit" onclick="ubahTglCuti(<?=$Detail['0']['jenis_id']?>)"></a>
											<a id="saveTglCuti" class="btn btn-primary btn-sm fa fa-save hidden" onclick="saveTglCuti(<?=$Detail['0']['id_cuti']?>, '<?=$Detail['0']['tipe']?>', <?=$Detail['0']['jenis_id']?>)"></a>
											<button type="button" onclick="batalTgl()" id="cancelTglCuti" class="btn btn-danger btn-sm hidden">batal</button>
										<?php endif; ?>
										&nbsp <span class="label label-info"><?=$banyakcuti." Hari"?></span>
									</div>
								</div>
								<?php if ($Detail['0']['jenis'] == 'Istirahat Melahirkan' && $Detail['0']['status'] != '2'){ ?>
								<div class="form-group">
									<label class="control-label col-lg-4">Alamat</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
											<textarea ondblclick="this.readOnly=''" class="form-control" style="resize:none;" name="txtAlamat" id="txtAlamatEdit" rows="2" cols="50" readonly><?php echo $Detail['0']['alamat'] ?></textarea>
											<div id="noteEditAlamat" style="color:red;">*Klik 2 kali untuk edit alamat</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Lampiran HPL</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
											<?php $id_encode = $this->encrypt->encode($Detail['0']['id_cuti']);
											$id = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encode)?>
											<a href="<?php echo base_url('PermohonanCuti/DraftCuti/PreviewCetak/'.$id) ?>" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-print"> Cetak</i></a>
											<?php if($Detail['0']['status'] !='2' && $Detail['0']['status'] !='3'){?>
												<label class="label label-warning"> Harap isi dan kirim lampiran ke Hubker !!</label>
											<?php } ?>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="form-group">
									<label class="control-label col-lg-4">Status</label>
									<div class="col-lg-4">
										<div class="col-lg-12">
												<?php if ($Detail['0']['status'] == '0'){ ?>
														<span class='label label-warning'> Belum request</span>
													<?php }elseif ($Detail['0']['status'] == '1') {
														echo "<span class='label label-warning'><i class='fa fa-clock-o'></i> Menunggu Approval</span>";
													}elseif ($Detail['0']['status'] == '2') {
														echo "<span class='label label-success'><i class='fa fa-check'></i> Approved</span>";
													}elseif ($Detail['0']['status'] == '3'){
														echo "<span class='label label-danger'><i class='fa fa-close'></i> Rejected</span>";
													}elseif ($Detail['0']['status'] == '4'){
														echo "<span class='label label-danger'><i class='fa fa-ban'></i> Dibatalkan</span>";
													}
												 ?>
												 <span class="label label-primary"><i class="fa fa-calendar"></i> <?php echo date("d/M/Y",strtotime($Thread['0']['waktu'])) ?></span>
												 <span class="label label-default"><i class="fa fa-clock-o"></i> <?php echo date("H:i:s",strtotime($Thread['0']['waktu'])) ?></span>

										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-lg-11">
										<div style="border: 1px solid black" class="row">
											<div class="container">
												<label class="col-lg-12 " style="background-color: #88cbf1;">
												 	Log Thread Approval
												</label>
												<div class="col-lg-12" style="overflow: auto; height: 120px; white-space: nowrap;">
													<?php for ($i = 0 ; $i < count($Thread)  ; $i++ ) {
														$color = $Thread[$i]['status'];
														if($color == 0){
															echo "<font>[ ".$Thread[$i]['waktu']." ] ".$Thread[$i]['detail']."</font><br>";
														}else if ($color == 1){
															echo "<font color='#d9c509'>[ ".$Thread[$i]['waktu']." ] ".$Thread[$i]['detail']."</font><br>";
														}else if ($color == 2){
															echo "<font color='#14ab00'>[ ".$Thread[$i]['waktu']." ] ".$Thread[$i]['detail']."</font><br>";
														}else if($color == 3){
															echo "<font color='#d11c08'>[ ".$Thread[$i]['waktu']." ] ".$Thread[$i]['detail']."</font><br>";
														}
													} ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo base_url('PermohonanCuti/DraftCuti') ?>" class="btn btn-warning" onclick="$('#loading1').attr('class','fa fa-spinner fa-spin')"><i id="loading1"></i> Back</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- Modal Edit Cuti CM -->
<div class="modal fade" id="ModalEditCM" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div style="max-height: 100%;" class="modal-dialog">
    <div class="modal-content" style="padding-left: 10%; padding-right: 10%;">
			<div class="modal-header">
				<center><h2>Edit Tanggal Cuti Melahirkan</h2></center>
			</div>
      <div class="modal-body">
				<div class="form-group">
					<label class="col-lg-12">Hak Cuti
						<div class="input-group col-lg-3">
							<input style="text-align: center;" class="form-control" readonly type="text" value="91">
							<span class="input-group-addon">Hari</span>
						</div>
					</label>
				</div>
				<div class="form-group">
					<label class="col-lg-12">Hari Perkiraan Lahir
						<input class="form-control" id="txtPerkiraanLahir" type="text">
					</label>
				</div>
				<div class="form-group">
					<label class="col-lg-12">Sebelum Lahir
						<div class="input-group col-lg-3">
							<input style="text-align: center;" id="txtSebelumLahir" class="form-control" type="number">
							<span class="input-group-addon">Hari</span>
						</div>
					</label>
				</div>
				<div class="form-group">
					<label class="col-lg-12">Setelah Lahir
						<div class="input-group col-lg-3">
							<input style="text-align: center;" id="txtSetelahLahir" class="form-control" type="number">
							<span class="input-group-addon">Hari</span>
						</div>
					</label>
				</div>
      </div>
			<div class="modal-footer text-center">
				<button type="button" onclick="saveModalCM()" class="btn btn-success">Save</button>
				<button type="button" onclick="closeModal()" data-dismiss="modal" class="btn btn-warning">Batal</button>
			</div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Loading -->
<div class="modal fade" id="loadingEdit" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div style="transform: translateY(50%);" class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="loader"></div>
        <div clas="loader-txt">
          <center><img class="img-loading" style="width:130px; height:auto" src="<?php echo base_url('assets/img/gif/loadingquick.gif') ?>"></center>
					<p><center>Loading...</center></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
