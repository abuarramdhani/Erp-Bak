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
						<b>Form Pembuatan Master Unit Group Detail</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDetail/Add')?>">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Tanggal Berlaku</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" name="txtDate" placeholder="Tanggal" required >
								</div>
							</div>
						</div>
						
					<?php foreach($GetUnitGroupCreate as $gug){
						// echo "<pre>";
						// print_r($i); 
						// echo "</pre>";
						$g=$gug['unit_group'];
						for ($i=0; $i < $g ; $i++) {
						?>
						<hr>
						<div class="row" style="margin: 10px 10px;display:none;">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Unit Group </label>
								<div class="col-lg-7">
									<input name="number" value="<?php echo $number++; ?>" class="form-control" readonly>
									<input name="txtIDUnitGroup[]" value="<?php echo $gug['unit_group']; ?>" hidden>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Unit Group </label>
								<div class="col-lg-4">
									<input name="txtUnitGroup[]" id="txtUnitGroup" value="" class="form-control">
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Seksi </label>
								<div class="col-lg-7">
									<select class="form-control js-slcSectionPK" name="txtUnitDetail<?php echo $i; ?>[]" multiple="multiple" data-placeholder="Ambil Seksi pada Unit terkait">
									</select>
								</div>
							</div>
						</div>
						<?php } 
					}?>
						<br>
						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterUnitGroupDetail');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
						
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
