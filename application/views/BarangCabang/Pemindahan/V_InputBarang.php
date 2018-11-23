<section class="content">
<?php 
	if($cek!=0){
		$cekExist = 1;
	}else{
		$cekExist = 0;
	}; 
?>
<script type="text/javascript"> var cekExist= "<?php echo $cekExist; ?>" </script>
	<div class="inner box box-info" >
		<div class="row">
			<div class="col-md-12">
				<div class="text-center box-header with-border">
					<h2><b>INPUT PEMINDAHAN BARANG CABANG BERMASALAH</b></h2>
				</div>
			</div>
		</div>
		<div class="box-body">
			<form method="post" action="<?php echo base_url('BranchItem/PemindahanBarang/Input/AddMasalah/flagging'); ?>">
			<div class="row">
					<div class="col-md-4">
							<input type="hidden" id="inp_fppb" name= "no_fppb" value="<?= $regen ?>">
					</div>
					<div class="col-md-8">
						<div class="form-group">
				<!-- 		<h5></h5> -->
						<p style="text-align:right;position:absolute;right:20px;"><b>NO FPPB :</b>
							<span  id="no_fppb"></span></b> 
							<?= $regen ?></p>
						</div>
					</div>
				</div><p>
				<div class="row">
					<div class="col-md-4" style="padding-left: 20px">
							<label>TANGGAL</label>
					</div>
					<div class="col-md-8">
						<?php if ($cek!=0) {
							$tglCek = $cek[0]['tanggal'];
						}else{
							$tglCek = '';
						} ?>
						<div class="form-group">
						<input id="tgl_bi" type="text" name="textDate" class="form-control datepicker_bi" placeholder="Pilih Tanggal" value="<?php echo $tglCek; ?>" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="padding-left: 20px">
							<label>CABANG</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<select class="form-control select4" data-placeholder="Pilih Cabang" id="cabang"  name="cabang" required>
								<?php 
									$Padang='';
									$Nganjuk='';
									$Banjarmasin='';
									$Pekanbaru='';
									$Tanjung='';
									$Yogyakarta='';
									$Surabaya='';
									$Makassar='';
									$Sidrap='';
									$Tugumulyo='';
									$Medan='';
									$Jakarta='';
									if ($cek[0]['cabang']=='Padang') {
										$Padang='selected="selected"';
									}elseif ($cek[0]['cabang']=='Nganjuk') {
										$Nganjuk='selected="selected"';
									}elseif ($cek[0]['cabang']=='Banjarmasin') {
										$Banjarmasin='selected="selected"';
									}elseif ($cek[0]['cabang']=='Pekanbaru') {
										$Pekanbaru='selected="selected"';
									}elseif ($cek[0]['cabang']=='Tanjung Karang') {
										$Tanjung='selected="selected"';
									}elseif ($cek[0]['cabang']=='Yogyakarta') {
										$Yogyakarta='selected="selected"';
									}elseif ($cek[0]['cabang']=='Surabaya') {
										$Surabaya='selected="selected"';
									}elseif ($cek[0]['cabang']=='Makassar') {
										$Makassar='selected="selected"';
									}elseif ($cek[0]['cabang']=='Sidrap') {
										$Sidrap='selected="selected"';
									}elseif ($cek[0]['cabang']=='Tugumulyo') {
										$Tugumulyo='selected="selected"';
									}elseif ($cek[0]['cabang']=='Medan') {
										$Medan='selected="selected"';
									}elseif ($cek[0]['cabang']=='Jakarta') {
										$Jakarta='selected="selected"';
									}
								?>
								<option></option>
								<option <?php echo $Padang; ?> value='Padang'>Padang</option>
								<option <?php echo $Nganjuk; ?> value='Nganjuk'>Nganjuk</option>
								<option <?php echo $Banjarmasin; ?> value='Banjarmasin'>Banjarmasin</option>
								<option <?php echo $Pekanbaru; ?> value='Pekanbaru'>Pekanbaru</option>
								<option <?php echo $Tanjung; ?> value='Tanjung Karang'>Tanjung Karang</option>
								<option <?php echo $Yogyakarta; ?> value='Yogyakarta'>Yogyakarta</option>
								<option <?php echo $Surabaya; ?> value='Surabaya'>Surabaya</option>
								<option <?php echo $Makassar; ?> value='Makassar'>Makassar</option>
								<option <?php echo $Sidrap; ?> value='Sidrap'>Sidrap</option>
								<option <?php echo $Tugumulyo; ?> value='Tugumulyo'>Tugumulyo</option>
								<option <?php echo $Medan; ?> value='Medan'>Medan</option>
								<option <?php echo $Jakarta; ?> value='Jakarta'>Jakarta</option>
							</select>
						</div>
					</div>
			</div>
				<div class="row">
					<div class="col-md-4" style="padding-left: 20px">
							<label>ORGANISASI</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" id="organisasi" name="organisasi" required>
							<?php if ($cek!=0) {
								echo "<option selected='selected'>".$cek[0]['organisasi']."</option>";
							}else{
								echo "<option>Pilih Cabang Terlebih Dahulu</option>";
							} ?>
							<?php foreach ($organisasi as $organisasi) {?>
							<option <?php echo $selected; ?> ><?php echo $organisasi['ORGANIZATION_CODE']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="padding-left: 20px">
						<label>GUDANG ASAL</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" id="gdgasal" name="gdgasal" required>
							<?php if ($cek!=0) {
								echo "<option selected='selected'>".$cek[0]['gudang_asal']."</option>";
							}else{
								echo "<option> Pilih Organisasi Terlebih Dahulu </option>";
							} ?>
							<?php foreach ($gudang as $gudang) {?>
							<option><?php echo $gudang['SECONDARY_INVENTORY_NAME']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="padding-left: 20px">
						<label>GUDANG TUJUAN</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" data-placeholder="Pilih Gudang tujuan" id="gdgtujuan" name="gdgtujuan" required>
							<?php if ($cek!=0) {
								echo "<option selected='selected'>".$cek[0]['gudang_tujuan']."</option>";
							}else{
								echo "<option>Pilih Gudang Tujuan</option>";
							} ?>
							<option value='FG-REJECT'>FG-REJECT</option>
						</select>
						</div>
					</div>	
					<div class="col-md-1" style="padding-left: 1015px">
						<button type="button" id="button_insert_header_modal" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">
							<i class="icon-plus icon-2x"></i>
							<span ><br></span>
						</button>
					</div>
				</div>
			</div>
	<div class="box box-info">
		<div class="box-body">
			<table id="ta" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">No</th>
					<th style="text-align:center">Kode Barang</th>
					<th style="text-align:center">Deskripsi</th>
					<th style="text-align:center">Jumlah</th>
					<th style="text-align:center">Kategori Masalah</th>
					<th style="text-align:center">Pilihan</th>
				</thead>
				<tbody>
					<?php $no = 1; foreach ($tampil as $cl) { ?>
					<tr row-id="<?php echo $cl['id'];?>">
						<td style="text-align:center;"><?php echo $no; ?></td>
						<td style="text-align:center;"><?php echo $cl['kode_barang']; ?></td>
						<td style="text-align:center;"><?php echo $cl['deskripsi']; ?></td>
						<td style="text-align:center;"><?php echo $cl['jumlah']; ?></td>
						<td style="text-align:center;"><?php echo $cl['kategori_masalah']; ?></td>
						<td style="text-align:center;" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning" href="<?php echo base_url(); ?>BranchItem/PemindahanBarang/Input/<?php echo 'edit/'.$cl['id'] ?>"><span class="icon-edit" style="padding-right: 3px"></span> EDIT</a>
								<a class="btn btn-danger hapus" onclick="DeletePemindahanLine('<?php echo $cl['id'];?>')"><span class="icon-trash" style="padding-right: 3px"></span> DELETE</a>
							</div>
						</td>
					</tr>
				<?php $no++;} ?>
				</tbody>
			</table><p>
			<div style="float:right">
				<button type ='submit' class="btn btn-success"><span class="icon-save" style="padding-right: 3px"></span> SAVE</button>
			</div>
			</form>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <script type="text/template" id="qq-template-manual-trigger">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button">
                    <div>Select files</div>
                </div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar">
                        </div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                    <!--<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>-->
                </li>
            </ul>
            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>
            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>
            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
<section class="content">
	<div class="inner" style="padding-top: 20px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>INPUT BARANG CABANG BERMASALAH</center></b></h3>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url('BranchItem/PemindahanBarang/Input/AddMasalah/insert/line'); ?>" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-4">
								<label>Kode Barang</label>
								<input type="hidden" id="inp_fppb" name= "no_fppb" value="<?= $regen ?>">
						</div>

						<div class="col-md-8">
							<div class="form-group">
								<select style="width:50%" class="form-control select2" id="kode" name="code">
									<option></option>
									<?php foreach ($barang as $barang) {?>
									<option><?php echo $barang['SEGMENT1']; ?></option>
									<?php }; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Deskripsi</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="form-control" readonly id="deskripsi" name="deskripsi">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jumlah</label>
						</div>
						<div style="width:100px" class="col-md-8">
							<div class="form-group">
								<input type="number" id="jumlah" name="jumlah" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-md-offset-4">
							<img src="" style="max-height:120px" id="prevPhoto"><p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Gambar</label>
						</div>
						<div class="col-md-8">
							<p><input type="file" id="upload_gambar" name="upload_form" class="form-control" onchange="readURL(this)">
						</div><br>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Kategori Masalah</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
							<select class="form-control" id="kategori" name="kategori_masalah">
								<option></option>
								<option name='rusak_fisik' value='Rusak Fisik'>Rusak Fisik</option>
								<option name='salah_kirim' value='Salah Kirim'>Salah Kirim</option>
								<option name='discontinue' value='Discontinue'>Discontinue</option>
							</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Detail Masalah</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
							<textarea class="form-control" rows="10" cols="70" id="detail" name="detail_masalah" required></textarea>
							</div>
						</div>
					</div>
					<div style="float:right">
						<button id="save_line_pemindahan" type='submit' class="btn btn-success"><span class="icon-save" style="padding-right: 5px"></span>SAVE</button>
					</div>
				</form>
			</div>
			<div class="box box-info"></div>
			</div>
		</div>
	</div>
</section>
      </div>
    </div>
  </div>
</div>
</section>