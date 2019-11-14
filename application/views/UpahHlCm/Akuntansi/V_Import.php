<section class="content">
	<div class="panel panel-primary" >
			<div class="panel-heading"  style="padding-top: 10px;padding-bottom: 10px;">
				<h3> Import Data Absen Penggajian Harian Lepas </h3>
			</div>
	
		<div class="panel-body" >
		<form action="<?php echo base_url('UpahHlCm/Akuntansi/do_import'); ?>" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group col-md-12">
			    <label for="exampleFormControlFile1">Import Data</label>
			    <input name="file" type="file" class="form-control-file" id="exampleFormControlFile1">
			 </div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<button class="btn btn-success">Import</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</section>