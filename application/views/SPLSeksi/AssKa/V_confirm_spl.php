	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>Konfirm Approv</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('ALA/ListLembur');?>">
								<i class="icon-wrench icon-2x"></i>
								<span><br/></span>	
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<section class="col-lg-12 connectedSortable">
				<?php if(empty($result)){ ?>
					<div class="callout callout-info">
						<h4>Info!</h4>
						<p>Pass code sudah di kirim ke email anda, silahkan cek <a href="https://mail.quick.com/">disini</a></p>
					</div>
				<?php }else{ ?>
					<div class="callout <?php echo $result[0]; ?>">
						<h4><?php echo $result[1]; ?></h4>
						<p><?php echo $result[2]; ?></p>
					</div>
				<?php } ?>

				<form class="form-horizontal" action="<?php echo site_URL('SPLSeksi/C_splasska/confirm_spl_submit'); ?>" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Pass code</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" name="passcode" required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Persetujuan</label>
										<div class="col-sm-3">
											<label style="margin-left:2%; top:+3;"><input type="radio" name="approve" value="25" style="transform: scale(1.5); vertical-align:top;" checked> Terima</label>
										</div>
										<div class="col-sm-7">
											<label style="margin-left:5%; vertical-align:bottom;"><input type="radio" name="approve" value="35" style="transform: scale(1.5); vertical-align:top;"> Batalkan</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Keterangan</label>
										<div class="col-sm-10">
											<textarea class="form-control" rows="3" name="keterangan"></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-sm-12">
											<button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Submit</button>
											<button type="reset" style="margin-right:3px" class="btn btn-primary pull-right" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
										</div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>