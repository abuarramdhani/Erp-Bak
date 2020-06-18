<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Unit Group</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterUnitGroup');?>">
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
						<b>View Master Unit Group</b>
					</div>
					<?php foreach ($GetUnitGroup as $gu) { ?>
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroup/update/'.$gu['id_unit_group'])?>">
					<input type="text" name="txtIdUnit" value="<?php echo $gu['id_unit_group']; ?>" hidden>
					<div class="box-body">					
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Unit Group </label>
								<div class="col-lg-7">
									<input name="txtUnitGroup" class="form-control" value="<?php echo $gu['unit_group']; ?>">
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterUnitGroup');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
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
			
				
