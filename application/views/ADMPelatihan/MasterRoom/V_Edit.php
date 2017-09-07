<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Ruangan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterRuangan');?>">
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
						<b>Form Edit Daftar Ruangan</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterRoom/Update')?>">
						<?php foreach($room as $rm){?>
						<!-- INPUT GROUP 1 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Ruangan</label>
								<div class="col-lg-6">
									<input name="txtNamaRuang" class="form-control toupper" placeholder="Nama Ruang" value="<?php echo $rm['room_name'] ?>" required >
									<input name="txtIdRuang" value="<?php echo $rm['room_id'] ?>" hidden >
								</div>
								<label class="col-lg-1 control-label">Kapasitas</label>
								<div class="col-lg-3">
									<input name="txtKapasitas" class="form-control" placeholder="Kapasitas" onkeypress="return isNumberKey(event)" value="<?php echo $rm['capacity'] ?>" required >
								</div>
							</div>
						</div>
						<?php }?>
						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterRoom');?>"  class="btn btn-primary btn btn-flat">Back</a>
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
			
				
