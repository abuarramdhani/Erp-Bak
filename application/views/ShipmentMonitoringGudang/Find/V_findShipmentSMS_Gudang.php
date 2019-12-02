<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px;
	}
	/*table.dataTable thead tr {
  		background-color: #bd3735;
		}*/ 

		thead.toscahead tr th {
        background-color: #105e62;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #105e62;
      }
      .itsfun2 {
        border: #105e62;
      }
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<h1><span style="font-family: sans-serif;"><b><i class="fa fa-search"></i> Find Shipment Gudang</b></span></h1>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-info">
							<div class="box-header with-border">
					  		</div>
					  		<div class="box-body">
								<div class="box box-info box-solid">
									<div class="box-body">
										<div class="box-header with-border">
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="col-md-8">
													<table>
														<tr>
															<td style="padding: 0 0 25px 0"><label style="width: 100px">No. Shipment</label></td>
															<td>
																<input type="text" class="form-control" name="no_ship" id="no_ship" style="margin-top: 10px; margin-bottom: 50px; width:300px" placeholder="Masukkan Nomor Shipment">
															</td>
															<td style="padding: 0 0 37px 0">
															<div class="pull-right" style="padding: 0 0 0 50px">
																<button type="button" class="btn btn-primary" class="btn_search_sms_gudang" id="btn_search_sms_gudang"><i class="fa fa-search"></i> Cari</button>
															</div>
														</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="loading_mpm">
									<table id="tblSMSGudang"></table>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>