<?php if ($usr == 'B' ||$usr == 'D' ||$usr == 'J' || $no_induk == 'T0007'): ?>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?= $Title ?></b></h1></div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/ImportPolaShift');?>">
									<i class="icon-wrench icon-2x"></i>
									<span ><br /></span>
								</a>                             
							</div>
						</div>
					</div>
				</div>
				<br />

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-2">
												<p style="font-weight: bold; margin-top: 5px;">Pilih Periode :</p>
											</div>
											<div class="col-md-3">
												<input class="form-control importpola_periode"  autocomplete="off" type="text" name="periodeshift" id="yangPentingtdkKosong" placeholder="Masukkan Periode" value="" required="" />
											</div>
											<div class="col-md-1">
												<button class="btn btn-primary btn_see_shift">Lihat</button>
											</div>
										</div>
										<div class="col-md-12" id="ips_view_shift">
											
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
	<img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<?php else: ?>
	<script>
		$(document).ready(function(){
			Swal.fire({
				title: 'Access Denied',
				text: 'Anda tidak memiliki hak akses pada halaman ini!',
				type: 'error',
				focusConfirm: true
			}).then(function(result) {
				if (result.value) {
					
				}
			});
		})
	</script>
<?php endif ?>