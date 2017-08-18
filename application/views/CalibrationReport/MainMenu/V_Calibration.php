<!-- <script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script> -->
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>LAMPIRAN ORDER UNTUK ARSIP IR</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('QuickDataCat');?>">
                                <i class="fa fa-tint fa-2x"></i>
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
							<b>- DOKUMENT SECARA SOFTCOPY QUALITY CONTROL -</b>
						</div>
					
					<div class="box-body">
						<div class="box-header">
							<div class="col-xs-6">
								<label align="center"><h4>Tanggal Hari ini : <?php echo date('Y-m-d') ?></h4></label>
							</div>
							<div class="col-xs-6 text-right">
								<a class="btn btn-default leftmargin"  href="<?php echo site_url($action);?>">
									<i class="fa fa-file-text-o"></i>&nbsp; New
								</a>
								<a class="btn btn-default leftmargin" id="seachDocument">
									<i class="fa fa-search"></i>&nbsp; Search
								</a>
							</div>
						</div>
							<div class="col-md-12">
								<table class="table table-bordered table-striped table-hover table_document" style="width:150%;">
									<thead style="background:#3c8dbc;color:#FFFFFF;">
										<tr>
											<th style="text-align:center;width:2%;">No.</th>
											<th style="text-align:center;width:10%;">Code</th>
											<th style="text-align:center;width:10%;">Name</th>
											<th style="text-align:center;width:5%;">Type</th>
											<th style="text-align:center;width:5%;">Qty</th>
											<th style="text-align:center;width:10%;">Inspection Date</th>
											<th style="text-align:center;width:10%;">Process</th>
											<th style="text-align:center;width:5%;">Shift Inspeksi</th>
											<th style="text-align:center;width:10%;">Judgement</th>
											<th style="text-align:center;width:10%;">Description</th>
											<th style="text-align:center;width:10%;">Action</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>		
	</div>
</div>
</section>	
  
<!-- MODAL SEARCH DOCUMENT -->
  <div class="modal fade" id="modalSearch" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" style="color:red;" data-dismiss="modal">&times;</button>
          <b>- Search Data Component Document -</b>
        </div>
        <div class="modal-body">
			<div class="row">
				<div class="col-lg-6">
					<label>
						Period
					</label>
					<input type="text" class="form-control" name="txtPeriode" id="txtPeriode"></input>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<label>
						Code
					</label>
					<input type="text" class="form-control" name="txtCode" id="txtCode"></input>
				</div>
				<div class="col-lg-8">
					<label>
						Name
					</label>
					<input type="text" class="form-control" name="txtName" id="txtName"></input>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<label>
						Type
					</label>
					<input type="text" class="form-control" name="txtType" id="txtType"></input>
				</div>
				<div class="col-lg-4">
					<label>
						Judgement
					</label>
					<select name="txsJudgement"  class="form-control" id="txsJudgement">
						<option value="">- ALL -</option>
						<option value="OK">OK</option>
						<option value="OKB">OKB</option>
						<option value="OKM">OKM</option>
						<option value="OKK">OKK</option>
						<option value="NG">NG</option>
					</select >
				</div>
			</div>
        </div>
		<div class="modal-footer">
			<button class="btn bg-green" id="searchDocument">Search</button>
		</div>
      </div>
    </div>
  </div>	  