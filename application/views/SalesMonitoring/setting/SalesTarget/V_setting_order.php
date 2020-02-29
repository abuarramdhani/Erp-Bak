<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Setting Order</b></h1>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('SalesMonitoring/salestarget/Created')?>">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-body">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-lg-4 control-label">Organization</label>
								<div class="col-lg-5">
									<select id="slcOrgSM2" style="width:500px" class="form-control select4" onchange="testtt(this)" name="txt_organization2" class="form-control">
										<option value=""></option>
										<?php $no = 0; foreach($source as $src) { $no++ ?>
										<?php echo '<option value="'.$src['org_id'].'">'.$src['org_name'].'</option>' ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Order Type</label>
								<div class="col-lg-5">
									<input type ="text" placeholder="Inputkan Order Type Baru" class="form-control" style="width:500px" name="txtOrderType" id="ordertype_id">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-5 pull-right">
									<button type="button" onclick="insertOrder(this)" class="btn btn-sm btn-success" id="btnSubmitSMM" style="width: 100px;margin-left:50px"><i class="fa fa-paper-plane"></i> Submit </button>
								</div>
							</div>
							<div class="tabel-setup-sales-monitoring">
								
							</div>
						</div>
					</div>
				</div>
				</div>
			
			</form>
						
					
		</div>
	</div>
	</div>
</section>