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
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>INPUT BARANG CABANG BERMASALAH</center></b></h3>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url('BranchItem/PemindahanBarang/Input/AddMasalah/insert/line')?>" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
								<label>Kode Barang</label>
								<input type="hidden" name="no_fppb" value="<?php echo $no_fppb; ?>">
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="form-control select2" id="kode" name="kode" onchange="barangChange()">
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
						<div class="col-md-12">
							<img src="" id="prevPhoto">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Gambar</label>
						</div>
						<div class="col-md-10 col-md-offset-1">
							<input type="file" name="upload_form" class="form-control" onchange="readURL(this)">
							<!-- <div id="fine-uploader-aldi" name="fine-uploader-aldi"> -->
						</div><br>
					</div>
					</div>
					<div class="row">
						<div class="col-md-4">
								<label>Kategori Masalah</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
							<select class="form-control" id="kategori" name="kategori">
								<option></option>
								<option value='Rusak Fisik'>Rusak Fisik</option>
								<option value='Salah Kirim'>Salah Kirim</option>
								<option value='Discontinue'>Discontinue</option>
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
							<textarea class="form-control" rows="10" cols="70" id="detail"  name="detail" required=""></textarea>
							</div>
						</div>
					</div>
					<div style="float:right">
						<button type ='submit'class="btn btn-success">SAVE</button>
					</div>
				</form>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>