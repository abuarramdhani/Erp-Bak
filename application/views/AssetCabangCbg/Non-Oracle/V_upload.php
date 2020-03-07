<style type="text/css">
.capital{
    text-transform: uppercase;
}
</style>
    <div class="row">
		      	<?php echo form_open_multipart('AssetCabang/NewProposal/upload_berkas/'.$id) ?>
		      	<center>
		      		<div class="col-md-6 pull-left">
		      		<input type="file" data-target="tooltip" data-position="top" title="Klik button Upload untuk menyimpan berkas" name="txfBerkasAC" style="margin-left:350px">
		      		</div>
		      		<div class="col-md-6 pull-right">
		      		<button type="submit" class="btn btn-sm btn-primary pull-right zoom" style="width: 100px;margin-bottom:30px;margin-left:10px;border-radius:50px;margin-right:320px" id="button-submit-berkas-draft"> Upload </button>	
		      		</div>
		      	<center>
		      </div>
		    </div>

<script type="text/javascript">
	$( document ).ready(function() {
	$('.selectBuyer').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
})
</script>

