<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Kuesioner</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterQuestionnaire');?>">
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
						<b>Form Pembuatan Master Kuesioner</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterQuestionnaire/Add')?>">
						
						<!-- INPUT GROUP 1 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Judul Kuesioner</label>
								<div class="col-lg-4">
									<input name="txtKuesioner" class="form-control toupper" placeholder="Judul Kuesioner" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Sub Bagian</label>
								<div class="col-lg-4">
									<select class="select2" class="form-control" data-placeholder="Sub Bagian" name="slcSubBagian" style="width:100%;">
										<option></option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-6 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterQuestionnaire');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn-flat">Save Data</button>
							</div>
						</div>
					</form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
