<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
	.capital{
    text-transform: uppercase;
}

thead.cabang tr th {
	background-color: #00a65a;
}

.zoom {
  transition: transform .2s;
}

.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3); 
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<!-- <span style="font-family: sans-serif;"><i class="fa fa-gear"></i> Setting Customer</span> -->
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h2><b><center><span style="font-family: 'Source Sans Pro',sans-serif;padding-left: 20px"><i class="fa fa-gear"></i> SETTING CUSTOMER <i class="fa fa-gear"></i></span></center></b></h2>
							</div>
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter" class="col-md-12" style="margin-bottom: 20px">
															<tr>
																<td style="width: 5%">
																	<span><label>Nama Customer</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px; border-radius: 100px" type="text" id="txtNamaCustomerSet" name="txtNamaCustomerSet" placeholder="Masukkan Nama Customer"></input>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-right">
										<button onclick="saveSetupCustomer(this)" type="button" class="btn btn-primary pull-right zoom" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-plus"></i> Add</button>
									</div>
									<table class="table table-bordered table-hover text-center tblSetting">
										<thead>
											<tr class="bg-primary">
												<th style="width: 5%" class="text-center">NO.</th>
												<th style="width: 15%" class="text-center">NAMA CUSTOMER</th>
												<th style="width: 10%" class="text-center">ACTION</th>

											</tr>
										</thead>
										<tbody id="tabelAddCabang">
											<?php $no=1; 
										 foreach($setcus as $key => $p) { ?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $p['nama_customer']; ?></td>
												<td>
												<a title="edit ..." rownum="<?php echo $no ?>" class="btn btn-warning btn-sm zoom" data-target="MdlCustomer" data-toggle="modal" onclick="OpenModalCustomer(<?php echo $p['id_customer'];?>)"><i class="fa fa-caret-square-o-up"></i> Edit</a>
												<a title="delete ..." rownum="<?php echo $no ?>" class="btn btn-danger btn-sm zoom" onclick="DeleteCustomer(<?php echo $p['id_customer'];?>)"><i class="fa fa-times"></i> Delete</a></td>
											</tr>
											<?php $no++; } ?>
										</tbody>
									</table>
								<div class="col-md-1 pull-right">
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

<div class="modal fade MdlCustomer"  id="MdlCustomer" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:800px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="width: 100%;">
                	<div class="modal-tabel" >
					</div>
                   
                    	<div class="modal-footer">
                    		<div class="col-md-2 pull-left">
                    		</div>
                    	</div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <div class="modal fade MdlSettingEks"  id="MdlSettingEks" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div> -->