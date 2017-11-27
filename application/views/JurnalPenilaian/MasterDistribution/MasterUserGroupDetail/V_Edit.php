<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Unit Group Detail</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterUnitGroupDetail');?>">
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
						<b>Edit Master Unit Group Detail</b>
					</div>
					<div class="box-body">
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDetail/update')?>">
					<?php foreach ($GetUnitGroupDetail as $gu) { ?>
					<input name="txtIdUnitDetail" value="<?php echo $gu['id_unit_group_list']; ?>" hidden>
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Periode</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" name="txtDate" placeholder="Tanggal" value="<?php echo $gu['tberlaku']; ?>" >
								</div>
							</div>
						</div>
						
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> ID Unit Group </label>
								<div class="col-lg-7">
									<input name="txtIDUnitGroup" class="form-control" value="<?php echo $gu['id_unit_group']; ?>">
									<!-- <select class="form-control SlcUnitGroup" name="txtIDUnitGroup" data-placeholder="Unit Group" value="<?php echo $gu['id_unit_group']; ?>">
										<option></option>
										<?php foreach($GetUnitGroup as $gug){?>
										<option value="<?php echo $gug['unit_group']?>"><?php echo $gug['unit_group'] ?></option>
										<?php }?>
									</select> -->
								</div>

							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Unit </label>
								<div class="col-lg-7">
									<input name="txtUnitDetail" class="form-control" value="<?php echo $gu['unit']; ?>">
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterUnitGroupDetail');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					<?php } ?>
					</form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
