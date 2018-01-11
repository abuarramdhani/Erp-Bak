<!-- MODAL  DELETE-->
<?php $number=0;  foreach ($recPackage as $rp) {?>
	<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$rp['scheduling_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-sm-2"></div>
					<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
					<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
					<br>
				</div>
				<div class="modal-body" align="center">
					Apakah anda yakin ingin menghapus <b><?php echo $rp['scheduling_name'] ?></b> dari jadwal pelatihan ? <br>
					<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
					<div class="row">
						<br>
						<a href="<?php echo base_url('ADMPelatihan/Record/Delete/'.$rp['scheduling_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }?>