<style type="text/css">
	.slc-20{
		width: 20% !important;
	}
	.slc-50{
		width: 50% !important;
	}
	.hh {
		text-align: right;
	}

	.btn-add-row-2{
		height: 50px;
		border-radius: 0px !important;
		border-top-right-radius: 20px !important;
		border-bottom-right-radius: 20px !important;
	}
</style>

<?php switch ($jenis) {
	case 'setting_account': ?>
<form method="post" action="<?= base_url('InternalAudit/SettingAccount/AuditObject/SaveAuditProject')?>">
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Audit Project :</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Audit Project.." type="text" name="txtAuditProject" class="form-control">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >PIC :</label>
		</div>
		<div class="col-lg-6">
		    <select class="slc2" data-placeholder ="Select PIC.." name="slcPicAuditProject">
		    	<option></option>
		    	<?php foreach ($user_erp as $key => $value) { ?>
		    		<option value="<?= $value['user_id'] ?>"> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
		    	<?php } ?>
		    </select>
		</div>
	</div>
	<div class="form-group col-lg-12 ">
		<div class="col-lg-4 hh">
		    <label >STAFF :</label>
		</div>
		<div class="col-lg-6 ">
			<table width="100%">
				<tr>
					<td width="90%">
					<table style="width: 100%" class="table table-responsive table-curved" id="tbl-acc-set-ia" >
						<tr>
							<td width="90%">
							    <select class="slc2" data-placeholder ="Select STAFF.." name="slcStaffAuditProject[]">
							    	<option></option>
							    	<?php foreach ($user_erp as $key => $value) { ?>
							    		<option value="<?= $value['user_id'] ?>"> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
							    	<?php } ?>
							    </select>
							</td>
							<td width="10%" style="vertical-align: middle;">
							    <button class="btn btn-danger btn-xs btn-del-ia" type="button" onclick="delRowTblSettAccountIA(this)">
							    	<b class="fa fa-times "></b>
							    </button>
							</td>
						</tr>
					</table>
					</td>
					<td style="vertical-align: bottom; text-align: left; padding-bottom: 20px" width="10%">
				<button type="button" onclick="addRowTblSettAccountIA('#tbl-acc-set-ia')" style="float: right; " class="btn btn-success btn-add-row-2">
					<b class="fa fa-plus"> </b>
				</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="form-group col-lg-12 ">
		<div class="col-lg-4 hh">
		    <label >AUDITOR :</label>
		</div>
		<div class="col-lg-6 ">
			<table width="100%">
				<tr>
					<td width="90%">
					<table style="width: 100%" class="table table-responsive table-curved" id="tbl-acc-set-ia2" >
						<tr>
							<td width="90%">
							    <select class="slc2" data-placeholder ="Select Auditor.." name="slcAuditorAuditProject[]">
							    	<option></option>
							    	<?php foreach ($user_erp as $key => $value) { ?>
							    		<option value="<?= $value['user_id'] ?>"> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
							    	<?php } ?>
							    </select>
							</td>
							<td width="10%" style="vertical-align: middle;">
							    <button class="btn btn-danger btn-xs btn-del-ia" type="button" onclick="delRowTblSettAccountIA(this)">
							    	<b class="fa fa-times "></b>
							    </button>
							</td>
						</tr>
					</table>
					</td>
					<td style="vertical-align: bottom; text-align: left; padding-bottom: 20px" width="10%">
				<button type="button" onclick="addRowTblSettAccountIA('#tbl-acc-set-ia2')" style="float: right; " class="btn btn-success btn-add-row-2">
					<b class="fa fa-plus"> </b>
				</button>
					</td>
				</tr>
			</table>
		</div>
	</div>


	<div class="form-group col-lg-12" >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
			<a href="">
			<button class="btn btn-default btn-cust-f" type="button"><B> BACK </B></button>
			</a>
			<button class="btn btn-primary btn-cust-e " type="submit" ><B> SAVE DATA </B></button>
		</div>
	</div>
	</form>
</div>
<?php break;
	  case 'completion_report': ?>
	  <table class="table table-curved table-striped table-bordered table-hover">
	  		<thead>
	  			<tr>
	  				<th width="3%">No.</th>
	  				<th width="17%">Improvement</th>
	  				<th width="10%">Status</th>
	  				<th width="10%">Duedate</th>
	  				<th width="15%">Target Indicator</th>
	  				<th width="25%">Comment</th>
	  				<th width="20%">Attachment</th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<td><center>1</center></td>
	  				<td>
	  					<b>Kondisi :</b> Kondisi 1 <br/>
						<b>Kriteria :</b> Kriteria 1 <br/>
						<b>Akibat :</b> Akibat 1 <br/>
						<b>Penyebab :</b> Penyebab 1 <br/>
	  				</td>
	  				<td>
	  					<center>OPEN</center>
	  				</td>
	  				<td>
	  					<center>2019/03/31</center>
	  				</td>
	  				<td>
	  					<center>Tercapai</center>
	  				</td>
	  				<td>
	  				<textarea class="form-control" placeholder="add comment.."></textarea>
	  				</td>
	  				<td> <input type="file" class="btnfile" name=""> </td>
	  			</tr>
	  		</tbody>
	  </table>
<?php break;
	case 'edit_account': ?>
<div class="col-lg-12 " style=" margin-top: 20px">
	<form method="post" action="<?= base_url('InternalAudit/SettingAccount/AuditObject/SaveEditAuditProject')?>">
	<input type="hidden" name="id_audit" value="<?= $id_audit ?>">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Audit Project :</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Audit Project.." type="text" name="txtAuditProject" class="form-control" value="<?= $data_audit[0]['audit_object'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >PIC :</label>
		</div>
		<div class="col-lg-6">
		    <select class="slc2" data-placeholder ="Select PIC.." name="slcPicAuditProject">
		    	<option></option>
		    	<?php foreach ($user_erp as $key => $value) { ?>
		    		<option value="<?= $value['user_id'] ?>" <?= $data_audit[0]['pic'] == $value['user_id'] ? 'selected' : '' ?>> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
		    	<?php } ?>
		    </select>
		</div>
	</div>
	<div class="form-group col-lg-12 ">
		<div class="col-lg-4 hh">
		    <label >STAFF :</label>
		</div>
		<div class="col-lg-6 ">
			<table width="100%">
				<tr>
					<td width="90%">
					<table style="width: 100%" class="table table-responsive table-curved" id="tbl-acc-set-ia" >
					<?php if ($data_audit[0]['staff']) {
					foreach ($data_audit[0]['staff'] as $k => $v) { ?>
						<tr>
							<td width="90%">
							    <select class="slc2" data-placeholder ="Select STAFF.." name="slcStaffAuditProject[]">
							    	<option></option>
							    	<?php foreach ($user_erp as $key => $value) { ?>
							    		<option value="<?= $value['user_id'] ?>" <?= $v['staff_id'] == $value['user_id'] ? 'selected' : '' ?>> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
							    	<?php } ?>
							    </select>
							</td>
							<td width="10%" style="vertical-align: middle;">
							    <button class="btn btn-danger btn-xs btn-del-ia" type="button" onclick="delRowTblSettAccountIA(this)">
							    	<b class="fa fa-times "></b>
							    </button>
							</td>
						</tr>
					<?php	}
					}else{ ?>
						<tr>
							<td width="90%">
							    <select class="slc2" data-placeholder ="Select STAFF.." name="slcStaffAuditProject[]">
							    	<option></option>
							    	<?php foreach ($user_erp as $key => $value) { ?>
							    		<option value="<?= $value['user_id'] ?>"> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
							    	<?php } ?>
							    </select>
							</td>
							<td width="10%" style="vertical-align: middle;">
							    <button class="btn btn-danger btn-xs btn-del-ia" type="button" onclick="delRowTblSettAccountIA(this)">
							    	<b class="fa fa-times "></b>
							    </button>
							</td>
						</tr>
				<?php } ?>
					</table>
					</td>
					<td style="vertical-align: bottom; text-align: left; padding-bottom: 20px" width="10%">
						<button type="button" onclick="addRowTblSettAccountIA('#tbl-acc-set-ia')" style="float: right; " class="btn btn-success btn-add-row-2">
							<b class="fa fa-plus"> </b>
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="form-group col-lg-12 ">
		<div class="col-lg-4 hh">
		    <label >AUDITOR :</label>
		</div>
		<div class="col-lg-6 ">
			<table width="100%">
				<tr>
					<td width="90%">
					<table style="width: 100%" class="table table-responsive table-curved" id="tbl-acc-set-ia2" >
					<?php if ($data_audit[0]['auditor']) {
					foreach ($data_audit[0]['auditor'] as $k => $v) { ?>
						<tr>
							<td width="90%">
							    <select class="slc2" data-placeholder ="Select Auditor.." name="slcAuditorAuditProject[]">
							    	<option></option>
							    	<?php foreach ($user_erp as $key => $value) { ?>
							    		<option value="<?= $value['user_id'] ?>" <?= $v['auditor_id'] == $value['user_id'] ? 'selected' : '' ?>> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
							    	<?php } ?>
							    </select>
							</td>
							<td width="10%" style="vertical-align: middle;">
							    <button class="btn btn-danger btn-xs btn-del-ia" type="button" onclick="delRowTblSettAccountIA(this)">
							    	<b class="fa fa-times "></b>
							    </button>
							</td>
						</tr>
					<?php	}
					}else{ ?>
						<tr>
							<td width="90%">
							    <select class="slc2" data-placeholder ="Select Auditor.." name="slcAuditorAuditProject[]">
							    	<option></option>
							    	<?php foreach ($user_erp as $key => $value) { ?>
							    		<option value="<?= $value['user_id'] ?>"> <?= $value['user_name'].' - '.$value['employee_name'] ?> </option>
							    	<?php } ?>
							    </select>
							</td>
							<td width="10%" style="vertical-align: middle;">
							    <button class="btn btn-danger btn-xs btn-del-ia" type="button" onclick="delRowTblSettAccountIA(this)">
							    	<b class="fa fa-times "></b>
							    </button>
							</td>
						</tr>
				<?php } ?>
					</table>
					</td>
					<td style="vertical-align: bottom; text-align: left; padding-bottom: 20px" width="10%">
						<button type="button" onclick="addRowTblSettAccountIA('#tbl-acc-set-ia2')" style="float: right; " class="btn btn-success btn-add-row-2">
							<b class="fa fa-plus"> </b>
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
			<a href="">
			<button class="btn btn-default btn-cust-f" type="button"><B> BACK </B></button>
			</a>
			<button class="btn btn-primary btn-cust-e " type="submit" ><B> UPDATE DATA </B></button>
		</div>
	</div>
	</form>
</div>
<?php break;
case 'detail_progress': ?>
<style type="text/css">
	.dataTables_length{
			display: none;
		}

</style>
	<div class="col-lg-12">
	<table class="table dtb2 table-curved table-responsive table-striped table-hover" width="100%">
  		<thead>
  			<tr>
  				<th width="5%">No.</th>
  				<th width="10%">Date</th>
  				<th width="30%">Progress History</th>
  				<th width="10%">Attachment</th>
  				<th width="10%">Modified By</th>
  				<th width="30%">Auditor Response</th>
  				<th width="5%"></th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php foreach ($progress as $k => $v) { ?>
  			<tr class="<?= $v['sign_req_close'] ?>">
  				<td><center><?= $v['no']; ?></center></td>
  				<td><center>
  					<?= $v['date']; ?>
  					<?php if ($v['sign_show_history'] == '1') { ?>
	  					<!-- <br/>
	  					<a href="#" data-toggle="tooltip" title="Show History">
	  						<i class="fa fa-clock-o"> history..</i>
	  					</a> -->
  					<?php } ?>

  				</center>
  				</td>
  				<td ><p class="desc_progress"><?= $v['description']; ?></p>
  					<?php if ($v['type'] == '5') { ?>
  						<br>
  						<span class="btn btn-xs  btn-default">
  						( request close )
  						</span>
  					<?php } ?>
  				</td>
  				<td>
  					<center>
  					<a href="<?= $v['link_attachment'] ?>" target="blank_">
  					<button class="btn btn-xs <?= $v['attachment_sign'] ?>"> <b class="fa fa-search"></b> <?= $v['attachment'] ? 'View Attachment' : 'No attachment..' ?> </button>
  					</a>
  					</center>
  				</td>
  				<td><?= $v['modified_by'] ?></td>
  				<td>
  					<?= $v['auditor_response'] ?>
  				</td>
  				<td><center><button data-imp_list_id="<?= $imp_list_id ?>" data-imp_id="<?= $imp_id ?>" class="btn btn-xs btn-primary" onclick="showFormEditAuditeeResponse(this)" data-id="<?= $v['id'] ?>"> <b class="fa fa-edit"></b> Edit</button></center>
  				</td>
  			</tr>
  			<?php } ?>
  		</tbody>
  	</table>
	</div>
	<div class="col-lg-12 text-left">
  	<button data-id="<?= $imp_list_id ?>" data-im="<?= $imp_id ?>" class="btn btn-success btn-cust-b" onclick="showFormAddHistory(this)" data-toggle="modal" data-target="#ModAddHistory">
  		<b class="fa fa-plus"> Add History</b>
		</button>
	</div>

<?php	break;
	case 'detail_progress_auditor': ?>
<style type="text/css">
	.dataTables_length{
			display: none;
		}
	.bg-request{
		background-color: #7fe5f2 !important;
	}
</style>
	<div class="col-lg-12">
	<table class="table dtb2 table-curved table-responsive table-striped table-hover">
  		<thead>
  			<tr>
  				<th width="5%">No.</th>
  				<th width="10%">Date</th>
  				<th width="30%">Progress History</th>
  				<th width="10%">Attachment</th>
  				<th width="15%">Modified By</th>
  				<th width="30%">Auditor Response</th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php foreach ($progress as $k => $v) { ?>
  			<tr class="<?= $v['sign_req_close'] ?>">
  				<td><center><?= $v['no']; ?></center></td>
  				<td><center>
  					<?= $v['date']; ?>
  					<?php if ($v['sign_show_history'] == '1') { ?>
	  					<!-- <br/>
	  					<a href="#" data-toggle="tooltip" title="Show History">
	  						<i class="fa fa-clock-o"> history..</i>
	  					</a> -->
  					<?php } ?>

  				</center>
  				</td>
  				<td><?= $v['description']; ?>
  					<?php if ($v['type'] == '5') { ?>
  						<br>
  						<span class="btn btn-xs  btn-default">
  						( request close )
  						</span>
  					<?php } ?>
  				</td>
  				<td>
  					<center>
  					<a href="<?= $v['link_attachment'] ?>" target="blank_">
  					<button class="btn btn-xs <?= $v['attachment_sign'] ?>"> <b class="fa fa-search"></b> <?= $v['attachment'] ? 'View Attachment' : 'No attachment..' ?> </button>
  					</a>
  					</center>
  				</td>
  				<td><a class="userIa" data-id="<?= $v['modified_by_id'] ?>"><?= $v['modified_by'] ?></a></td>
  				<td class="text-right">
						<?php if ($v['auditor_response']) { ?>
								<textarea class="form-control" readonly="readonly"><?= $v['auditor_response'] ?></textarea>
							<?php if ($v['type'] == '6') { ?>
								<button class="btn btn-xs btn-success"> <b class="fa fa-check"> approve closed</b></button>
							<?php } ?>
								<!-- <button class="btn btn-xs btn-primary"> <b class="fa fa-edit"> edit</b></button> -->
						<?php }else{ ?>
	  					<center>
							<?php if ($v['type'] == '5') { ?>
			  					<button class="btn btn-xs btn-success " data-toggle="modal" onclick="replyAuditor('<?= $v['id'] ?>','<?= $imp_list_id ?>','<?= $imp_id ?>','<?= $v['type'] ?>')" data-target="#ModResponse" > <b class="fa fa-reply"> Reply & Approve </b> </button>
		  					<?php }else{ ?>
			  					<button class="btn btn-xs btn-warning " data-toggle="modal" onclick="replyAuditor('<?= $v['id'] ?>','<?= $imp_list_id ?>','<?= $imp_id ?>','<?= $v['type'] ?>')" data-target="#ModResponse" > <b class="fa fa-reply"> Reply </b> </button>
		  					<?php } ?>
	  					</center>
						<?php } ?>
  				</td>
  			</tr>
  			<?php } ?>
  		</tbody>
  	</table>
	</div>
		<script type="text/javascript">
		$('.userIa').click(function () {
			var user_id = $(this).attr('data-id');
			// $('.modal').modal('hide');
			// $('body').removeClass('modal-open');
			// $('.modal-backdrop').remove();
			$('#ModUserIa').modal('show');
			$('#viewDataUser').html('<div style="height:400px; padding-top:25%"><center><img style="width:100px; height:auto;" src="'+baseurl+'assets/img/gif/loading3.gif"></center></div>');
			$.ajax({
				url : baseurl+"InternalAudit/SettingAccount/User/getUserData",
				type: "POST",
				data: {
					user_id:user_id
				},
				datatype: "html",
				success: function (result) {
					$('#viewDataUser').html(result);
				}
			})

		});
	</script>
<?php	break;
case 'view_user': ?>
 <div class="box box-widget widget-user">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-aqua-active">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	              <h3 class="widget-user-username"><?= $user['name'] ?></h3>
	              <h5 class="widget-user-desc"><?= $user['section'] ?></h5>
	            </div>
	            <div class="widget-user-image">
	              <div style="width: 100%; text-align: center;">
	              <div class="image-cropper" style="display: inline-block">
				    <?php
					$path_photo  		=	base_url('assets/img/foto').'/';
					$file 			= 	$path_photo.$user['no_induk'].'.'.'JPG';
					$file_headers 	= 	@get_headers($file);
					if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
						$file 			= 	$path_photo.$this->session->user.'.'.'JPG';
						$file_headers 	= 	@get_headers($file);
						if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
							$ekstensi 	= 	'Not Found';
						}else{
							$ekstensi 	= 	'JPG';
						}
					}else{
						$ekstensi 	= 	"JPG";
					}

					if($ekstensi=='jpg' || $ekstensi=='JPG'){
						echo '<img src="'.$path_photo.$user['no_induk'].'.'.$ekstensi.'" class="rounded imgs" alt="User Image" title="'.$user['name'].' - '.$user['no_induk'].'">';
					}else{
						echo '<img src="'.base_url('assets/theme/img/user.png').'" class="rounded imgs" alt="User Image" />';
					}
	              	?>
					</div>
	              </div>
	            </div>
	            <div class="box-footer">
	              <div class="col-md-12">
	              	<form class="form-horizontal">
                 <strong><i class="fa fa-phone margin-r-5"></i> VOIP</strong>

	              <p class="text-muted">
	                <?= $user['no_voip'] ?>
	              </p>

	              <hr>
	              <strong><i class="fa fa-mobile-phone margin-r-5"></i> My Group</strong>

	              <p class="text-muted">
	                <?= $user['no_mygroup'] ?>
	              </p>

	              <hr>
	              <strong><i class="fa fa-envelope margin-r-5"></i> Email Internal</strong>

	              <p class="text-muted">
	                <?= $user['email'] ?>
	              </p>

	              <hr>
	              <strong><i class="fa fa-user margin-r-5"></i> Initial</strong>

	              <p class="text-muted">
	                <?= $user['initial'] ?>
	              </p>

	              <hr>
                </form>
	              </div>
	              <!-- /.row -->
	            </div>
	          </div>
<?php	break;
} ?>
