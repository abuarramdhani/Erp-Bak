<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-left">
								<span><h2><b>Laporan Data Asset Non Oracle  - </b>Draft</h2></span>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo base_url('AssetCabang/NewProposal')?>" onclick="window.location.reload()">
									<i class="icon-plus icon-2x"></i>
									<span ><br /></span>
								</a>
								

							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div style="padding-top: 20px" class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-center" id="tblACLDAO" style="font-size:14px;">
										<thead>
											<tr style="background-color: #3c8dbc;" class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="15%"><center>Judul Proposal</center></th>
												<th width="15%"><center>Submitted Date</center></th>
												<th width="15%"><center>Kategori Asset</center></th>
												<th width="20%"><center>Cabang</center></th>
												<th width="10%"><center>Status</center></th>
												<th width="10%"><center>Attachment Title</center></th>
												<th width="10%"><center>Attach File</center></th>
												<th width="10%"><center>Proposal Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $i=1; foreach ($draft as $k) {?>
												<tr>
													<td><?= $i;?></td>
													<td><?= $k['batch_number'];?></td>
													<td><?php echo  date('d-m-Y', strtotime($k['creation_date'])) ?></td>
													<td><?= $k['nama_ka'];?></td>
													<td><?php echo $k['nama_cabang'];?></td>
													<?php if ($k['status'] == '1') { ?>
													<td>
													<span><label class="label label-default"><i class="fa fa-paper-plane"></i>&nbsp;Sent to Kacab</span>
													</td>
													<?php } ?>
													<?php if ($k['pict_title_cbg'] == null) { ?> 
													<td style="background-color: pink;"><i>Not Yet Uploaded</i></td>
													<?php }else{ ?>
													<td><b><?php echo $k['pict_title_cbg'];?></b></td>
													<?php }?>
													<td>
													<button type="button" onclick="open_modal_upload(<?php echo $k['id_proposal']?>)" data-target="#mdlUploadAC" data-toggle="modal" class="btn btn-xs btn-warning" style="width: 100px;" id="
													btn-submit-berkas-draft"><i class="fa fa-upload"></i> Upload</button>

													<a target="_blank" href="<?php echo base_url('./assets/upload/AssetCabang/AdminCabang/Berkas').'/'.$k['pict_title_cbg']?>">
													<button type="button" class="btn btn-success btn-xs" style="width:100px;margin-top: 5px" id="btnDownloadPPA"><i class="fa fa-mail-forward"></i> View</button></a>
													</td>
													<td>
													<button type="button" class="btn btn-danger btn-xs" onclick="deleteDraft(<?php echo $k['id_proposal']?>)" style="width:100px;" id="btnDeleteDraft"><i class="fa fa-trash"></i> Delete</button>
													<a target="_blank" href="<?php echo base_url('./assets/upload/AssetCabang/AdminCabang').'/'.$k['pdf_title_cbg']?>">
													<button type="button" class="btn btn-primary btn-xs" style="width:100px;margin-top: 5px;margin-bottom: 5px" id="btnDeleteDraft"><i class="fa fa-check"></i> View</button>
													</a>
													</td>
												</tr>
											<?php $i++;} ?>
													
										</tbody>
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
<div class="modal fade mdl"  id="mdlUploadAC" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1000px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >UPLOAD BERKAS UNTUK DILAMPIRKAN KE PROPOSAL
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
<script type="text/javascript">
	$( document ).ready(function() {
	$('#tblACLDAO').DataTable({
		"pageLength": 50
	});
})

</script>
