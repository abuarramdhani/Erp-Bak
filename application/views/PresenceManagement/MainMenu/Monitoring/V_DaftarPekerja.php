<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Presence Monitoring</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List');?>">
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
						<b>Single Access Connection to Presence Device</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
						<div class="box box-primary">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
				                  <label for="nama" class="col-sm-2 control-label">Nama :</label>

				                  <div class="col-sm-4">
				                    <select type="text" class="form-control select-nama" id="NamaPekerja" name="NamaPekerja" style="width: 100%"></select>
				                  </div>
				                  <div class="col-sm-2">
				                  	<a href="" class="btn btn-primary disabled" id="CariLokasiPekerja">SEARCH</a>
				                  </div>
				                </div> 
							</div>
							<br>
						</div>
						<div id="table-presensi" class="hidden">
							<table class="table table-striped table-bordered table-hover text-left" id="data-presensi-data-pekerja" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;width:5%">NOIND</th>
										<th style="text-align:center;width:15%">NAMA</th>
										<th style="text-align:center;width:25%"">SEKSI</th>
										<th style="text-align:center;width:35%">LOKASI FINGER</th>
										<th style="text-align:center;width:20%">ADD LOKASI</th>
									</tr>
								</thead>
								<tbody id="TampilDataLokasi">
								</tbody>
							</table>
						</div>
						
							
						</div>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('PresenceManagement/Monitoring');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>	