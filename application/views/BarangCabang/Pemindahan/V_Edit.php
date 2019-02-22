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
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
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
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>EDIT PENGAJUAN BARANG CABANG BERMASALAH</center></b></h2>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url('BranchItem/PemindahanBarang/Input/edit/update')?>" enctype="multipart/form-data">

					<!-- KODE BARANG -->
					<div class="row">
						<div class="col-md-4">
							<label>Kode Barang</label>
							<input type="hidden" name="no_fppb" value="<?php echo $no_fppb; ?>">	
						</div>
						<div class="col-md-8">
						<div class="form-group">
							<select class="form-control select2" id="kode" name="kode_barang">
								<?php foreach ($barang as $barang) {?>
								<option value="<?php echo $barang['SEGMENT1']; ?>"><?php echo $barang['SEGMENT1']; ?></option>
								<?php } ?>
							</select>
							</div>
						</div>
					</div>

					<!-- DESKRIPSI -->
					<div class="row">
						<div class="col-md-4">
								<label>Deskripsi</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="form-control" id="deskripsi" name="deskripsi_barang" value="<?php echo $edit[0]['deskripsi']; ?>" readonly>
								<input type="hidden" name="textId" class="form-control" value="<?php echo $id_ku?>" required>
							</div>
						</div>
					</div>
					
				<!-- JUMLAH -->
				<div class="row">
					<div class="col-md-4">
							<label>Jumlah</label>
					</div>
					<div style="width:100px" class="col-md-8">
						<div class="form-group">
							<input type="number" id="jumlah" name="jumlah" class="form-control" value="<?php echo $edit[0]['jumlah']?>" required>
						</div>
					</div>
				</div>

				<!-- GAMBAR -->
				<div class="row">
					<div class="col-md-8 col-md-offset-4">
						<img src="<?php echo base_url();?>/assets/upload/BranchItem/<?php echo $edit[0]['gambar'];?>" style="max-height:120px" id="prevPhoto"><p>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
							<label>Gambar</label>
					</div>
					<div class="col-md-8">
						<p><button type="button" id="doppen" class="btn btn-default" width="200px" >Choose File</button>
						<input type="file" id="upload_form" name="upload_form" class="form-control" onchange="readURL(this)"  value="" style="display:none;" >
						<!-- <div id="fine-uploader-aldi" name="fine-uploader-aldi"> -->
						<label for="disabledInput" id="this-value"><?php echo $edit[0]['gambar'] ?> </label><br>
						</div>
					</div>

							<!-- OPTION  -->
				<div class="row">
					<div class="col-md-4">
							<label>Kategori Masalah</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" id="kategori" name="kategori_masalah">
							
							<option <?php if($edit[0]['kategori_masalah']=='Rusak Fisik'){echo "selected";}?> value='Rusak Fisik'>Rusak Fisik</option>

							<option <?php if($edit[0]['kategori_masalah']=='Salah Kirim'){echo "selected";}?> value='Salah Kirim'>Salah Kirim</option>

							<option <?php if($edit[0]['kategori_masalah']=='Discontinue'){echo "selected";}?> value='Discontinue'>Discontinue</option>
							<!-- OPTION -->
						</select>
						</div>
					</div>
				</div>

				<!-- DETAIL -->
				<div class="row">
					<div class="col-md-4">
						<label>Detail Masalah</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<textarea class="form-control" rows="10" cols="70" id="detail" name="detail_masalah" required><?php echo $edit[0]['detail_masalah']?></textarea>
						</div>
					</div>
				</div>
				<div style="float:right">
				<button type ='submit' class="btn btn-success"><span class="icon-save" style="padding-right: 5px"></span>SAVE</button>
			</div>
				</div></form>
			</form>
			<!-- </div> -->
			<div class="box box-info"></div>
		</div>
	</div>
</section>