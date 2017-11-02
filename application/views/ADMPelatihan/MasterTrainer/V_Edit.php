<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Trainer</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>">
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
						<b>Form Edit Master Trainer</b>
					</div>
					
					<div class="box-body">
						<form method="post" action="<?php echo base_url('ADMPelatihan/MasterTrainer/Update')?>">
						<?php foreach($detail as $dt){?>	
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Id Trainer</label>
									<div class="col-lg-6">
										<input name="txtIdTrainer" class="form-control" value="<?php echo $dt['trainer_id'] ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">No. Induk</label>
									<div class="col-lg-6">
										<input name="txtNoind" class="form-control toupper" placeholder="Nomor Induk" value="<?php echo $dt['noind'] ?>" maxlength="5" required>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Nama Trainer</label>
									<div class="col-lg-6">
										<input name="txtNamaTrainer" class="form-control" placeholder="Nama Trainer" value="<?php echo $dt['trainer_name'] ?>" required>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Status</label>
									<div class="col-lg-3">
										<select class="form-control select4" name="slcStatus" required disabled="TRUE">
											<?php
												$a='';$b='';
												if($dt['trainer_status'] == 1){$a='selected';}
												if($dt['trainer_status'] == 0){$b='selected';}
											?>
											<option <?php echo $a ?> value="1" >Trainer Internal</option>
											<option <?php echo $b ?> value="0" >Trainer Eksternal</option>
										</select>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<div class="col-lg-8 text-right">
									<a href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>"  class="btn btn-primary btn btn-flat">Back</a>
									<button type="submit" class="btn btn-success btn btn-flat">Save Change</button>
								</div>
							</div>
						<?php } ?>
						<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
