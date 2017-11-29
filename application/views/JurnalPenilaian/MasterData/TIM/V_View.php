<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master TIM</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterTIM');?>">
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
						<b>View Master TIM</b>
					</div>
					
					<?php foreach ($GetTIM as $gb) {?>
					<input type="text" name="txtIdKatNil" value="<?php echo $gb['id_tim_dtl']; ?>" hidden>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Periode</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" value="<?php echo $gb['tberlaku']; ?>" disabled >
								</div>
							</div>
						</div>
						
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Batas Atas </label>
								<div class="col-lg-7">
									<input name="txtbts_A" class="form-control" type="number" value="<?php echo $gb['bts_ats']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Batas Bawah </label>
								<div class="col-lg-7">
									<input name="txtbts_B" class="form-control" type="number" value="<?php echo $gb['bts_bwh']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Nilai </label>
								<div class="col-lg-7">
									<input name="txtNilai" class="form-control" type="number"  value="<?php echo $gb['nilai']; ?>" disabled>
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterTIM');?>"  class="btn btn-primary btn btn-flat">Back</a>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
