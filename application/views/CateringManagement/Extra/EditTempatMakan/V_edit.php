<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('CateringManagement/Extra/EditTempatMakan') ?>" class="btn btn-default btn-lg">
								<span class="icon-wrench icon-2x"></span>
							</a>
						</div>
					</div>
				</div>
      <div class="row">
  <div class="col-lg-12">
    <br>
    <div class="box box-primary box-solid">
      <div class="box-body">
	        <form action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/update') ?>" method="POST" class="form form-horizontal">
	          <div class="row">
	            <div class="col-lg-6">
		              <div class="form-group">
		                <label for="txtnama" class="form-label col-lg-12">Departement</label>
		                <div class="col-lg-12">
		                  <input type="text" name="txtDepartement" value="<?php echo $value[0]['dept']; ?>" class="form-control" readonly>
		                </div>
		              </div>
									<div class="form-group">
									 <label for="txtSeksi" class="form-label col-lg-12">Bidang</label>
									 <div class="col-lg-12">
										 <input type="text" name="txtBidang" value="<?php echo $value[0]['bidang']; ?>" class="form-control" readonly>
									 </div>
									 </div>
									 <div class="form-group">
										 <label for="txtnama" class="form-label col-lg-12">Unit</label>
										 <div class="col-lg-12">
											 <input type="text" name="txtUnit" value="<?php echo $value[0]['unit']; ?>" class="form-control" readonly>
										 </div>
									 </div>
									 <div class="form-group">
										 <label for="txtloc" class="form-label col-lg-12">Lokasi Kerja</label>
										 <div class="col-lg-12">
											 <input type="text" name="txtNama" value="<?php echo $value[0]['lokasi_kerja']; ?>" class="form-control" readonly>
										 </div>
									 </div>
								</div>
								<div class="col-lg-6">
								<div class="form-group">
									<label for="txtKode" class="form-label col-lg-12">Kodesie</label>
									<div class="col-lg-12">
										<input type="text" name="txtNama" value="<?php echo $value[0]['kodesie']; ?>" class="form-control" readonly>
									</div>
								</div>
								 <div class="form-group">
									 <label for="txtnama" class="form-label col-lg-12">Seksi</label>
									 <div class="col-lg-12">
										 <input type="text" name="txtSeksi" value="<?php echo $value[0]['seksi']; ?>" class="form-control" readonly>
									 </div>
								 </div>
									<div class="form-group">
									 <label for="txtSeksi" class="form-label col-lg-12">No.Induk</label>
									 <div class="col-lg-12">
										 <input type="text" name="txtNoind" value="<?php echo $value[0]['noind']; ?>" class="form-control" id="nama" readonly>
									 </div>
									 </div>
									 <div class="form-group">
										 <label for="txtnama" class="form-label col-lg-12">Nama</label>
										 <div class="col-lg-12">
											 <input type="text" name="txtNama" value="<?php echo $value[0]['nama']; ?>" class="form-control" readonly>
										 </div>
									 </div>
								 </div>
							 </div>
								 <hr>
							 <div class="row">
								 <div class="col-lg-6">
									<div class="form-group">
									 <label for="" class="form-label col-lg-12">Tempat Makan 1</label>
									 <div class="col-lg-12">
											 <select class="select select2" id="txtTempatEdit" name="txtTmp1" style="width: 100%">
												 <option></option>
												 <?php foreach ($tempat as $key) {
													 if ($value[0]['tempat_makan1'] == $key['tempat_makan1']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";
                                                                }
                                                                echo '<option value="'.$key['tempat_makan1'].'" '.$selected_data.'>'.$key['tempat_makan1'].'</option>';
																															}
												 ?>
											 </select>
									 </div>
								 </div>
							 </div>
							 <div class="col-lg-6">
								 <div class="form-group">
									 <label for="" class="form-label col-lg-12">Tempat Makan 2</label>
									 <div class="col-lg-12">
											 <select class="select select2" id="txtTempatEdit2" name="txtTmp2" style="width: 100%">
												 <option></option>
												 <?php foreach ($tempat as $key) {
													 if ($value[0]['tempat_makan2'] == $key['tempat_makan2']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";
                                                                }
                                                                echo '<option value="'.$key['tempat_makan2'].'" '.$selected_data.'>'.$key['tempat_makan2'].'</option>';
																															}
												 ?>
											 </select>
									 </div>
								 </div>
							 </div>
								</div>
								<center>
		                 <a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
		                 <button type="button" style="margin: 10px; width: 100px;" name="save" class="btn btn-primary" id="kirim">Save</button>
		                 <button type="submit" hidden="" style="margin: 10px; width: 100px;" name="kir" class="" id="kirim2">Save</button>
		             </center>
                   </div>
								 </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
