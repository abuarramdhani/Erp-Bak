<section class="content">
	<div class="inner"">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>INPUT PENGAJUAN PENANGANAN BARANG CABANG BERMASALAH</center></b></h2>
			</div>
			<div class="box-body">
			<form method="post" action="<?php echo base_url('BranchItem/PenangananBarang/Input')?>">
			<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>NO FPPB</label>
					</div>
					<input type="hidden" name="nonono" id="nonono" value="<?php echo $no_fppbb ?>">
					<div class="col-md-5">
						<div class="form-group">
							<select id="no_no_fppb" class="form-control" required>
								<option></option>
								<?php foreach ($fppb as $fppb) {?>
								<option><?php echo $fppb['no_fppb']; ?></option>
								<?php }; ?>
							</select>
						</div>
					</div>
				</div>
				<div style="float:right">
					<a href="<?php echo base_url('BranchItem/PenangananBarang/Input/'.$no_fppbb)?>" class="btn btn-success">NEXT<span class="icon-chevron-right" style="padding-left: 5px"></span></a>
				</div>
			</form>
			</div>
			<div class="box box-info">
		<div class="box-body">
			<table id="ta" class="table table-striped table-bordered table-responsive table-hover" >
			
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">No</th>
					<th style="text-align:center">Kode Barang</th>
					<th style="text-align:center">Deskripsi Barang</th>
					<th style="text-align:center">Jumlah</th>
					<th style="text-align:center">Kategori Masalah</th>
					<th style="text-align:center">Pilihan</th>
				</thead>
				<tbody id="body_val" style="text-align: center">
					<div style="display:none;width: 100%;height: auto;position: absolute;z-index: 999;top:300px;"  class="row" id="loadingArea" style="display: none; padding-top:30px; color: #3c8dbc;">
               			<div class="col-md-12 text-center">
                    	<i class="fa fa-spinner fa-5x fa-pulse"></i>
                		</div>
           			 </div>
				</tbody>
			</table>
		</div>
		<div class="box box-info"></div>
		</div>
	</div>
</section>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
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
		<div class="box box-info"><input type="hidden" id="kode_barang_txt" value=""></input>
			<div class="box-header with-border">
				<h3><b><center>PREVIEW BARANG CABANG BERMASALAH</center></b></h3>
			</div>
			<div class="box-body">
				<!-- <form method="post" enctype="multipart/form-data"> -->
					<div class="row">
						<div class="col-md-4">
							<label>PREVIEW</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<textarea cols="10" rows="5" class="form-control" id="preview" name="preview" required></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>USULAN KACAB</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<textarea cols="10" rows="5" class="form-control" id="usulan_kacab" name="usulan_kacab" required></textarea>
							</div>
						</div>
					</div>
					<div style="float:right">
						<button id="save_line_penanganan" type='submit' class="btn btn-success"><span class="icon-save" style="padding-right: 5px"></span>SAVE</button>
					</div>
				<!-- </form> -->
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