<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Bobot Nilai</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterBobot');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Edit Master Bobot Nilai</b>
					</div>
					
					<?php foreach ($GetBobot as $gb) {?>
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterBobot/update/'.$gb['id_bobot'])?>">
					<div class="box-body">
						<input type="text" name="txtIdBobot" value="<?php echo $gb['id_bobot']; ?>" hidden>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Aspek </label>
								<div class="col-lg-7">
									<input name="txtAspek" class="form-control" value="<?php echo $gb['aspek']; ?>">
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Bobot Nilai </label>
								<div class="col-lg-7">
									<input name="txtBobot" class="form-control" value="<?php echo $gb['bobot']; ?>" type="number">
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Deskripsi </label>
								<div class="col-lg-7">
									<input name="txtDesc" class="form-control"  value="<?php echo $gb['description']; ?>">
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterBobot');?>"  class="btn btn-primary btn btn-flat">Back</a>
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					</div>
					</form>
					<?php } ?>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
