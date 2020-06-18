<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="control-label col-lg-2">Pekerja</label>
													<div class="col-lg-4">
														<select id="slc-CM-PekerjaMakanKhusus-Pekerja" style="width: 100%" data-placeholder="Pilih Pekerja...">
															<?php 
															if (isset($data) && !empty($data)) {
																echo "<option value=\"".$data->noind."\">".$data->noind." - ".$data->nama."</option>";
															}
															?>
														</select>
													</div>
													<?php 
													if (isset($data) && !empty($data)) {
														?>
														<input type="hidden" id="txt-CM-PekerjMakanKhusus-Id" value="<?php echo $data->pekerja_menu_khusus_id ?>">
														<?php
													}else{
														?>
														<input type="hidden" id="txt-CM-PekerjMakanKhusus-Id" value="0">
														<?php
													}
													?>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label class="form-label col-lg-12">Menu</label>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Sayur</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-Sayur" style="width: 100%" data-placeholder="Pilih Sayur...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->menu_sayur == "Semua Sayur") {
																	?>
																	<option selected>Semua Sayur</option>
																	<?php
																}else{
																	?>
																	<option>Semua Sayur</option>
																	<option selected><?php echo $data->menu_sayur ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Sayur</option>
																<?php
															}  
															if (isset($sayur) && !empty($sayur)) {
																foreach ($sayur as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->menu_sayur) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Lauk Utama</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-LaukUtama" style="width: 100%" data-placeholder="Pilih Lauk Utama...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->menu_lauk_utama == "Semua Lauk Utama") {
																	?>
																	<option selected>Semua Lauk Utama</option>
																	<?php
																}else{
																	?>
																	<option>Semua Lauk Utama</option>
																	<option selected><?php echo $data->menu_lauk_utama ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Lauk Utama</option>
																<?php
															}  
															if (isset($lauk_utama) && !empty($lauk_utama)) {
																foreach ($lauk_utama as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->menu_lauk_utama) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Lauk Pendamping</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-LaukPendamping" style="width: 100%" data-placeholder="Pilih Lauk Pendamping...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->menu_lauk_pendamping == "Semua Lauk Pendamping") {
																	?>
																	<option selected>Semua Lauk Pendamping</option>
																	<?php
																}else{
																	?>
																	<option>Semua Lauk Pendamping</option>
																	<option selected><?php echo $data->menu_lauk_pendamping ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Lauk Pendamping</option>
																<?php
															}  
															if (isset($lauk_pendamping) && !empty($lauk_pendamping)) {
																foreach ($lauk_pendamping as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->menu_lauk_pendamping) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Buah</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-Buah" style="width: 100%" data-placeholder="Pilih Buah...">
															<option></option>
															<?php
															if (isset($data) && !empty($data)) {
																if ($data->menu_buah == "Semua Buah") {
																	?>
																	<option selected>Semua Buah</option>
																	<?php
																}else{
																	?>
																	<option>Semua Buah</option>
																	<option selected><?php echo $data->menu_buah ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Buah</option>
																<?php
															}   
															if (isset($buah) && !empty($buah)) {
																foreach ($buah as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->menu_buah) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label class="form-label col-lg-12">Pengganti</label>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Sayur</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-SayurPengganti" style="width: 100%" data-placeholder="Pilih Sayur...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->pengganti_sayur == "Semua Sayur") {
																	?>
																	<option selected>Semua Sayur</option>
																	<?php
																}else{
																	?>
																	<option>Semua Sayur</option>
																	<option selected><?php echo $data->pengganti_sayur ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Sayur</option>
																<?php
															}  
															if (isset($sayur) && !empty($sayur)) {
																foreach ($sayur as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->pengganti_sayur) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Lauk Utama</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-LaukUtamaPengganti" style="width: 100%" data-placeholder="Pilih Lauk Utama...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->pengganti_lauk_utama == "Semua Lauk Utama") {
																	?>
																	<option selected>Semua Lauk Utama</option>
																	<?php
																}else{
																	?>
																	<option>Semua Lauk Utama</option>
																	<option selected><?php echo $data->pengganti_lauk_utama ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Lauk Utama</option>
																<?php
															}  
															if (isset($lauk_utama) && !empty($lauk_utama)) {
																foreach ($lauk_utama as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->pengganti_lauk_utama) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Lauk Pendamping</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-LaukPendampingPengganti" style="width: 100%" data-placeholder="Pilih Lauk Pendamping...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->pengganti_lauk_pendamping == "Semua Lauk Pendamping") {
																	?>
																	<option selected>Semua Lauk Pendamping</option>
																	<?php
																}else{
																	?>
																	<option>Semua Lauk Pendamping</option>
																	<option selected><?php echo $data->pengganti_lauk_pendamping ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Lauk Pendamping</option>
																<?php
															}  
															if (isset($lauk_pendamping) && !empty($lauk_pendamping)) {
																foreach ($lauk_pendamping as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->pengganti_lauk_pendamping) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-lg-4">Buah</label>
													<div class="col-lg-8">
														<select id="slc-CM-PekerjaMakanKhusus-BuahPengganti" style="width: 100%" data-placeholder="Pilih Buah...">
															<option></option>
															<?php 
															if (isset($data) && !empty($data)) {
																if ($data->pengganti_buah == "Semua Buah") {
																	?>
																	<option selected>Semua Buah</option>
																	<?php
																}else{
																	?>
																	<option>Semua Buah</option>
																	<option selected><?php echo $data->pengganti_buah ?></option>
																	<?php
																}
															}else{
																?>
																<option>Semua Buah</option>
																<?php
															}  
															if (isset($buah) && !empty($buah)) {
																foreach ($buah as $key => $value) {
																	if (isset($data) && !empty($data)) {
																		if ($value['text'] !== $data->pengganti_buah) {
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																		}
																	}else{
																		?>
																		<option><?php echo $value['text'] ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<div class="col-lg-12 text-right">
														<a href="javascript:history.back()" class="btn btn-info">kembali</a>
														<button type="button" class="btn btn-primary" id="btn-CM-PekerjaMakanKhusus-Simpan">Simpan</button>
													</div>
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
		</div>
	</div>
</section>

<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 9999 !important;
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>
<div class="loading" id="ldg-CM-PekerjaMakanKhusus-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>