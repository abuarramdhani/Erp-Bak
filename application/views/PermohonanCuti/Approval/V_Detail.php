<style media="screen">
	label{
		left: 15px;
	}

	.container{
		width: auto;
	}
</style>
<?php	$encrypted_text = $this->encrypt->encode($Detail['0']['id_cuti']);
			$encrypted_text = str_replace(array('+','/','='), array('-','_','~'), $encrypted_text);
?>
<section class="content">
	<div class="inner">
		<div class="panel-body">
		<div class="row">
			<form class="form-horizontal" action="<?php echo base_url('PermohonanCuti/Approval/Inprocess/Approve').'/'.$encrypted_text ?>" method="get">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 align="center"><strong><?=$Menu?></strong></h3>
							</div><br>
								<input type="hidden" name="" id="id_cuti" value="<?=$Detail['0']['id_cuti'] ?>">
								<div class="container">
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Nama</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="text" name="" value="<?=$Detail['0']['nama'] ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">No Induk</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="text" name="" id="noind" value="<?=$Detail['0']['noind'] ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Seksi</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="text" name="" value="<?=$DetailCutiPekerja['0']['seksi'] ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Unit</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="text" name="" value="<?=$DetailCutiPekerja['0']['unit'] ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Departemen</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="text" name="" value="<?=$DetailCutiPekerja['0']['dept'] ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Jenis Cuti</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="hidden" id="tipeCuti" value="<?=$Detail['0']['tipe']?>">
												<input type="text" name="" value="<?=$Detail['0']['jenis'] ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Keperluan</label>
										<div class="col-lg-4 col-sm-8">
											<div class="col-lg-12">
												<input type="text" name="" value="<?php if (empty($Detail['kp'])){ echo $Detail['0']['keperluan'];}else{ echo $Detail['0']['kp'];} ?>" class="form-control" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4 col-sm-3">Tanggal Pengambilan Cuti</label>
										<div class="col-lg-4 col-sm-7">
											<div class="col-lg-12 col-md-11 col-sm-12 col-xs-10">
												<textarea class="form-control" style="resize:none;" name="txtKeperluan" id="txtKeperluan" rows="5" cols="50" readonly><?php if($Detail['0']['jenis'] == 'Istirahat Melahirkan'){ echo $tglambilhpl;}else{ echo $tglambil;}?></textarea>
											</div>
										</div>
										<div class="col">
											<span class="label label-info"><?=$banyakcuti." Hari"?></span>
										</div>
									</div>
									<?php if((strstr($this->session->kodesie, '4090101') AND strstr('4,5,6,7', $Detail['0']['id_jenis']) ) OR !strstr($this->session->kodesie, '4090101')) { ?>
										<div class="form-group">
											<label class="control-label col-lg-4">Alasan</label>
											<div class="col-lg-4">
												<div class="col-lg-12">
													<input type="text" name="txtAlasan" id="txtAlasan" autocomplete="off" value="<?php if(!empty($Detail['0']['alasan'])){echo $Detail['0']['alasan'] ;} ?>" class="form-control" required <?php if(!empty($Detail['0']['alasan'])){echo "readonly"; } ?> >
												</div>
											</div>
										</div>
									<?php } ?>
									<div class="container-fluid">
										<div class="col-lg-11">
											<div style="border: 1px solid black" class="row">
												<label class="col-lg-12 " style="background-color: #88cbf1;">
												 Log Thread Approval
												</label>
												<div class="col-lg-12" style="overflow-x: scroll; height: 120px; white-space: nowrap;">
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
									<br>
									<?php if(isset($ApproverStatus['0']['status']) && $ApproverStatus['0']['status'] == 1): ?>
									<div class="form-group">
										<div class="col-lg-12 text-center">
											<button type="button" id="approveCuti" class="btn btn-success"><i class="fa fa-check"> Setuju</i></button>
											<button type="button" id="rejectCuti" class="btn btn-danger"><i class="fa fa-close"> Tolak</i></button>
											<button type="submit" style="display:none;" id="approveCuti2" name="approve" value="2"></button>
											<button type="submit" style="display:none;" id="rejectCuti2" name="approve" value="3"></button>
											<a href="<?php echo base_url('PermohonanCuti/Approval/Inprocess') ?>" class="btn btn-warning" onclick="$('#loading1').attr('class','fa fa-spinner fa-spin')"><i id="loading1"></i> Back</a>
										</div>
									</div>
								<?php else: ?>
										<div class="form-group">
											<div class="col-lg-12 text-center">
												<!-- <?php //$status = $ApproverStatus['0']['status']; if ($status == '1') { $back ="Inprocess";}elseif($status == '2' || $status == '4'){ $back = "Approved";}else{$back = "Rejected";} ?> -->
													<!-- ini dihilangi karena nanti error :v -->
													<!-- <a href="<?php //echo base_url('PermohonanCuti/Approval/'.$back) ?>" class="btn btn-warning">Back</a> -->
													<button type="button" onclick="window.history.go(-1)" class="btn btn-warning">back</button>
												<?php if(strstr($kodesie, '4090101') && $Detail['0']['status'] == 2 ):?>
													<button type="button" name="button" id="cancelCuti" class="btn btn-danger"><i class=""> Batalkan Cuti</i></button>
												<?php endif; ?>
											</div>
										</div>
								<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
