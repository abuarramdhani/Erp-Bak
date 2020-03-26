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
						<b>Edit Master TIM</b>
					</div>
					
					<?php foreach ($GetTIM as $gt) {?>
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterTIM/update/'.$gt['id_tim_dtl'])?>">
					<input type="text" name="txtIdTIM" value="<?php echo $gt['id_tim_dtl']; ?>" hidden>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Batas Atas </label>
								<div class="col-lg-7">
									<input name="txtbts_A" class="form-control" type="number" value="<?php echo $gt['bts_ats']; ?>" >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Batas Bawah </label>
								<div class="col-lg-7">
									<input name="txtbts_B" class="form-control" type="number" value="<?php echo $gt['bts_bwh']; ?>" >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Nilai </label>
								<div class="col-lg-7">
									<input name="txtNilai" class="form-control" type="number"  value="<?php echo $gt['nilai']; ?>" >
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterTIM');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					</div>
					<form>
					<?php } ?>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
