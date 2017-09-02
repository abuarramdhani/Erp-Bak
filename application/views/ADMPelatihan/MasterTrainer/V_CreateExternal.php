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
						<b>Form Penambahan Trainer Eksternal</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterTrainer/AddExternal')?>">
						
						<!-- INPUT GROUP 1 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Trainer</label>
								<div class="col-lg-6">
									<input name="txtNamaTrainer" class="form-control toupper" placeholder="Nama Trainer" required >
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-8 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>"  class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn-flat">Save Data</button>
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
			
				
