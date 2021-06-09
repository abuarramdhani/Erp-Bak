<style type="text/css">
	.custNotifBody {
		padding-bottom: 5px;
		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px;
		background-color: #ffeed6;
	}

	.custNotifHeader {
		color: white;
		vertical-align: middle;
		height: 25px;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		background-color: #e69724;
	}

	.custGaris {
		border: 0.5px solid #e69724;
		margin-top: 5px;
		margin-bottom: 5px;
	}

	.custHeadNotif {
		border-radius: 5px;
		margin-right: 5px;
		padding: 5px;
		margin-top: 2px;
		vertical-align: middle;
	}

	.has-error .select2-selection {
		border-color: rgb(185, 74, 72) !important;
	}

	.text-approve {
		color: #77ac4f;
	}

	.text-revisi {
		color: #c98b2d;
	}

	.text-reject {
		color: #dd5a4e;
	}

	html {
		scroll-behavior: smooth;
		overflow-y: scroll;
	}
</style>

<section class="content">
	<div class="box box-default color-palette-box">
    	<div class="box-header with-border">
			<?php $arrKaiDone = array('3','6','7','9') ?>
			<?php $arrAppDone = array('3','4','5','6','7','9') ?>
			<?php $arrKaiReal = array('6','7','9') ?>
      		<h3 class="box-title"><i class="fa fa-dashboard"></i> <b>Lihat Kaizen</b></h3>
        	<?php  if($kaizen[0]['employee_code'] == $this->session->user): ?>
			<h5 id="textcheckbox" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'hidden' : ($statusku == 3 ? 'hidden' : '') ?> class="text-right"><b>Lengkapi checkbox untuk Melakukan Approval</b></h5>
        	<?php endif; ?>
      		<div class="pull-right">
				<!-- BUTTON FOR USER-->
        		<?php if($kaizen[0]['user_id'] == $this->session->userid): ?>
          		<!-- Button Request Realisasi -->
          		<?php if ($kaizen[0]['status'] == 6 || $kaizen[0]['status'] == 7 || $kaizen[0]['status'] == 9 ) { ?>
          		<a title="Request Approve Realisasi"
            		class="btn btn-sm <?php echo ($kaizen[0]['status'] == 6 && $kaizen[0]['approval_realisasi'] == 0) ? ' btn-success' : ' btn-default disabled' ?> "
            		href="#" data-toggle="modal" data-target="#req<?php echo  $kaizen[0]['kaizen_id'] ?>" >
                	<i class="fa fa-check"> Request Approve Realisasi</i>
          		</a>
          		<?php } ?>
				<!-- Button Request -->
				<a title="Request Approve"
            		class="btn btn-sm  <?php echo $kaizen[0]['status'] == 0 ? 'btn-info' : ($kaizen[0]['status'] == 1 ? 'btn-info ' : ' btn-default disabled') ?> "
            		href="#" data-toggle="modal" data-target="#req<?php echo  $kaizen[0]['kaizen_id'] ?>" >
                	<i class="fa fa-check"> Request Approve Ide</i>
          		</a>
          		<!-- Button Edit -->
          		<a title="Edit Kaizen.."
           			class="btn btn-sm
					<?php echo ($kaizen[0]['status'] == 2)
							? 'btn-default disabled' : (in_array($kaizen[0]['status'], $arrKaiDone)
                            ? 'btn-default disabled' : ($kaizen[0]['status'] == 5 ? 'btn-default disabled' : 'btn-primary')); ?>"
           			href="<?php echo base_url('SystemIntegration/KaizenGenerator/Edit/'.$kaizen[0]['kaizen_id']); ?>">
                	<i class="fa fa-edit"></i>
         		</a>
          		<!-- Button Delete -->
          		<a title="Delete Kaizen.."
           			class="btn btn-sm btn-danger <?php // echo ($kaizen[0]['status'] == 3) ? '' : 'disabled'; ?>"
           			onclick="return confirm('Are you sure you want to delete this item?');"
           			href="<?php echo base_url('SystemIntegration/KaizenGenerator/Delete/'.$kaizen[0]['kaizen_id']); ?>">
              		<i class="fa fa-trash-o"></i>
          		</a>
          		<!-- Button Export -->
          		<a title="Export Pdf.."
           			class="btn btn-sm  <?php echo (in_array($kaizen[0]['status'], $arrKaiDone)) ? 'btn-info' : 'btn-default disabled'; ?>"
           			href="<?php echo base_url('SystemIntegration/KaizenGenerator/Pdf/'.$kaizen[0]['kaizen_id']); ?>">
              		<i class="fa fa-download"></i>
          		</a>
        		<?php endif; ?>
        		<!-- END OF BUTTON -->
				
				<!-- BUTTON FOR APPROVER -->
				<?php  if($kaizen[0]['employee_code'] == $this->session->user): ?>
				<?php $colorSign = $statusku == 3 ? 'green' : ($statusku == '4' ? '#e69724' : 'red') ?>
				<?php if ($statusku != 2 ){ ?>
				<span class="custHeadNotif" style="border: 1px solid <?= $colorSign ?>">
					<b>Keputusan anda :</b>
					<b style="color: <?= $colorSign; ?>"><?= $statusku == 3 ? 'Approve' : ($statusku == '4' ? 'Revisi' : 'Reject')?></b>
				</span>
				<?php } ?>
				<button id="btnAprroveOkSI" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?> class="btn btn-sm btn-success"
            			data-id="<?= $kaizen[0]['kaizen_id'] ?>" data-approve="3" data-level=<?= $levelku; ?> disabled > Approve</button>
				<button id="btnAprroveRevSI" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?> class="btn btn-sm btn-warning text-warning"
					data-id="<?= $kaizen[0]['kaizen_id'] ?>" data-approve="4" data-level=<?= $levelku; ?>  > Revisi</button>
				<button id="btnAprroveNotSI" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?> class="btn btn-sm btn-danger"
					data-id="<?= $kaizen[0]['kaizen_id'] ?>" data-approve="5" data-level=<?= $levelku; ?>  > Reject</button>
        		<?php  endif; ?>
				<!-- END OF BUTTON -->
				
				<!-- BUTTON FOR APPROVER REALISASI-->
				<?php if (($kaizen[0]['status'] == 6) && ($kaizen[0]['approval_realisasi'] == 1) && (isset($kaizen[0]['employee_code_realisasi']))) {
				if ($kaizen[0]['employee_code_realisasi'] == $this->session->user) { ?>
				<button id="<?= $kaizen[0]['status'] == 6 ? 'btnAprroveRealSI' : '' ?>" class="btn btn-sm <?= $kaizen[0]['status'] == 7 ? 'disabled btn-default' : ($kaizen[0]['status'] == 9 ? 'disabled btn-default' : 'btn-success') ?>"
					data-id="<?= $kaizen[0]['kaizen_id'] ?>" data-approve="3" data-level="6"> Approve Realisasi
				</button>
				<?php } } ?>
        		<!-- END OF BUTTON -->
      		</div>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<?php if ($kaizen[0]['status'] != 0) { ?>
				<?php
				switch ($kaizen[0]['status']) {
					case '1':
						$header_color = '#989898';
						$body_color = '#e8e8e8';
						$kaizen_status = 'Edited';
						$body_notif = 'Kaizen sudah diedit, silahkan request Approve.';
					break;
					case '2':
						$header_color = '#59d6f4';
						$body_color = '#e0f9ff';
						$kaizen_status = 'Unchecked';
						$body_notif = 'Kaizen menunggu proses Approval selesai.';
					break;
					case '3':
						$header_color = '#49b51a';
						$body_color = '#deffd9';
						$kaizen_status = 'Ide Kaizen Approved!';
						if($kaizen[0]['user_id'] == $this->session->userid){
						$body_notif = 'Ide Kaizen Sudah Disetujui, Silahkan laksanakan Kaizen <br/> Jika sudah , Silahkan <a href="'.base_url('SystemIntegration/KaizenGenerator/SubmitRealisasi/'.$kaizen[0]['kaizen_id']).'"><b> Submit Realisasi</b></a>';
						}else{
						$body_notif = 'Ide Kaizen Sudah Disetujui, Silahkan laksanakan Kaizen <br/> Jika sudah , langkah selanjutnya yaitu Submit Realisasi</a>';
						}
					break;
					case '4':
						$header_color = '#e69724';
						$body_color = '#ffeed6';
						$kaizen_status = 'Revisi';
						if($kaizen[0]['user_id'] == $this->session->userid){
						$body_notif = '<b> Alasan: </b> </br>
									"'.$kaizen[0]['reason_rev'].'" </br>
									<hr class="custGaris" >
									Silahkan lakukan <a href="'.base_url('SystemIntegration/KaizenGenerator/Edit/'.$kaizen[0]['kaizen_id']).'">
										<b><u>Revisi</u></b></a> , kemudian Request approve kembali.';
						}else{
						$body_notif = '<b> Alasan: </b> </br>
									"'.$kaizen[0]['reason_rev'].'" </br>
									<hr class="custGaris" >
									Silahkan lakukan Revisi, kemudian Request approve kembali.';
						}
					break;
					case '5':
						$header_color = '#e86363';
						$body_color = '#ffe2e2';
						$kaizen_status = 'Rejected';
						if($kaizen[0]['user_id'] == $this->session->userid){
						$body_notif = '<b> Alasan: </b> </br>
									"'.$kaizen[0]['reason_rej'].'" </br>
									<hr class="custGaris" style=" border: 0.5px solid #e62424;">
									Silahkan membuat kaizen yang baru.  <a href="'.base_url('SystemIntegration/KaizenGenerator/Submit/index').'">
										<b><u>Disini</u></b></a>';
						}else{
						$body_notif = '<b> Alasan: </b> </br>
									"'.$kaizen[0]['reason_rej'].'" </br>
									<hr class="custGaris" style=" border: 0.5px solid #e62424;">
									Silahkan membuat kaizen yang baru.';
						}
					break;
					case '6':
						if ($kaizen[0]['approval_realisasi'] == 0) {
						$header_color = '#989898';
						$body_color = '#e8e8e8';
						$kaizen_status = 'Submit Realisasi';
						$body_notif = 'Silahkan Request Approve Realisasi.';
						}else{
						$header_color = '#59d6f4';
						$body_color = '#e0f9ff';
						$kaizen_status = 'Unchecked Realisasi';
						$body_notif = 'Kaizen menunggu approval Realisasi';
						}
					break;
					case '7':
						$header_color = '#49b51a';
						$body_color = '#deffd9';
						$kaizen_status = 'Kaizen Realisasi Approved!';
						$body_notif = 'Kaizen Sudah Disetujui dan direalisasikan, kaizen sudah siap dilaporkan !';
					break;
					case '9':
						$header_color = '#49b51a';
						$body_color = '#deffd9';
						$kaizen_status = 'Kaizen Terlaporkan!';
						$body_notif = 'Kaizen Sudah selesai, kaizen sudah siap dicetak!';
					break;
				}
				?>
				<div class="col-lg-12" style="margin-bottom: 20px">
					<div class="row">
						<div class="col-lg-12 custNotifHeader" style="background-color: <?= $header_color; ?> " >
							<strong> Kaizen Status : <?= $kaizen_status; ?> </strong>  <span class="fa fa-angle-down pull-right btn-xs btn buttonsi" style=" font-size: 24.3px "></span>
						</div>
						<div class="col-lg-12 custNotifBody" style="background-color: <?= $body_color; ?>"><?= $body_notif; ?></div>
					</div>
				</div>
				<?php } ?>
				<table class="table" style="border: 1px solid #000">
					<tbody>
						<tr>
							<td style="border-top: 1px solid #000" width="13%">Pencetus Ide</td>
							<td style="border-top: 1px solid #000" width="2%">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000" width="35%"><?= $kaizen[0]['pencetus'] ?><span class="pull-right">No. Induk: <?= $kaizen[0]['noinduk'] ?></span></td>
							<td style="border-top: 1px solid #000" width="10%">Nomor</td>
							<td style="border-top: 1px solid #000" width="2%">:</td>
							<td style="border-top: 1px solid #000" width="38%" rowspan="2"><strong><?= $kaizen[0]['no_kaizen'] ?></strong></td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000">Seksi</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $section_user[0]['section_name'] ?></td>
							<td style="border: none" colspan="3"></td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000">Unit</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $section_user[0]['unit_name'] ?></td>
							<td style="border-top: 1px solid #000">tembusan</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000"></td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000">Departemen</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $section_user[0]['department_name'] ?></td>
							<td style="border-top: 1px solid #000" colspan="3">1. Kepala Unit</td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000">Produk/Jasa</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $kaizen[0]['judul'] ?></td>
							<td style="border-top: 1px solid #000" colspan="3">2. Tim Kaizen (Cq. Sekretaris)</td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000">Nama Komponen</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000">
								<?php if($kaizen[0]['komponen']): foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
									<?= '-'.$value['name'].'<br>'; ?>
								<?php } else: echo '-'; endif; ?>
							<td>
							<td style="border-top: 1px solid #000" colspan="3">3.</td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000">Kode Komponen</td>
							<td style="border-top: 1px solid #000">:</td>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000">
								<?php if($kaizen[0]['komponen']): foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
								<?= '-'.$value['code'].'<br>'; ?>
								<?php } else: echo '-'; endif; ?>
							</td>
							<td style="border-top: 1px solid #000" colspan="3">4.</td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000" colspan="3" class="text-center"><b>Kondisi saat ini(Uraian/gambar/Sket/Foto)</b>
								<?php if($kaizen[0]['employee_code'] == $this->session->user): ?>
								<br/><input class="text-right" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?>  type="checkbox" id="myCheck"></br>
								<?php endif; ?>
							</td>
							<td style="border-top: 1px solid #000" colspan="3" class="text-center">
								<?php if (in_array($kaizen[0]['status'], $arrKaiReal)) { ?>
								<b>Kondisi Akhir(Uraian/gambar/Sket/Foto)</b>
								<?php }else{ ?>
								<b>Usulan Kaizen(Uraian/gambar/Sket/Foto)</b>
								<?php } ?>
								<?php  if($kaizen[0]['employee_code'] == $this->session->user): { ?>
								<br>
								<input class="text-right" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?>  type="checkbox" id="youCheck"  onclick="myFunction()"></br>
								<?php } ?>
								<?php  endif; ?>
							</td>
						</tr>
						<tr>
							<td style="border-right: 1px solid #000"colspan="3"><?= $kaizen[0]['kondisi_awal'] ?></td>
							<td style="border-right: 1px solid #000"colspan="3"><?= (in_array($kaizen[0]['status'], $arrKaiReal)) ? $kaizen[0]['kondisi_akhir'] : $kaizen[0]['usulan_kaizen'] ?></td>
						</tr>
						<tr>
							<td style="border-top: 1px solid #000; border-right: 1px solid #000" colspan="3" class="text-center"><b>Pertimbangan Usulan Kaizen</b>
								<?php if($kaizen[0]['employee_code'] == $this->session->user): ?>
								<br/><input class="text-right" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?>  type="checkbox" id="Check"  onclick="myFunction()"></br>
								<?php endif; ?>
							</td>
							<td style="border-top: 1px solid #000" colspan="3" class="text-center">
								<?php if (in_array($kaizen[0]['status'], $arrKaiReal)) { ?>
								<b>Tanggal Realisasi</b>
								<?php } else { ?>
								<b>Rencana Realisasi</b>
								<?php } ?>
								<?php if($kaizen[0]['employee_code'] == $this->session->user): { ?>
								<br/><input class="text-right" <?= in_array($kaizen[0]['status'], $arrAppDone) ? 'disabled' : ($statusku == 3 ? 'disabled' : '') ?>  type="checkbox" id="tglCheck"  onclick="myFunction()"></br>
								<?php } ?>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid #000; border-right: 1px solid #000" colspan="3"><?= $kaizen[0]['pertimbangan'] ?></td>
							<td style="border-bottom: 1px solid #000; border-right: 1px solid #000" colspan="3" class="text-center">
								<?= (in_array($kaizen[0]['status'], $arrKaiReal)) ? date("d M Y", strtotime($kaizen[0]['tgl_realisasi'])) : date("d M Y", strtotime($kaizen[0]['rencana_realisasi'])) ?>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="col-lg-12">
					<div style="border: 1px solid black" class="row">
						<label class="col-lg-12 " style="background-color: #88cbf1;">Log Thread</label>
						<div class="col-lg-12" style="overflow: auto; height: 120px;">
							<?php
								$y = count($thread);$x = 0;
								foreach ($thread as $key => $value) {
									$colortext = ($value['status'] == '3') ? 'approve'
										: ($value['status'] == '4' ? 'revisi'
										: ($value['status'] == '5' ? 'reject' : 'default') );
							?>
							<?php if ($x >= 5) { ?>
								<?php if ($x == 5) { ?>
								<span id="rmthreadkai">
									<a style="cursor: pointer;">Read More</a> .. <br>
								</span>
								<span id="threadmorekai" style="display: none">
								<?php } ?>
								<em class="text-<?= $colortext ?>" >[ <?= date('d/M/Y h:i:s', strtotime($value['waktu'])) ?> ] - <?= $value['detail'] ?></em><br>
								<?php if ($x == ($y-1)) { ?>
									</span>
									<span id="rlthreadkai" style="display: none"> ..
										<a style="cursor: pointer;">Read less</a><br>
									</span>
								<?php } ?>
							<?php } else { ?>
								<em class="text-<?= $colortext ?>" >[ <?= date('d/M/Y h:i:s ', strtotime($value['waktu'])) ?> ] - <?= $value['detail'] ?> </em><br>
							<?php } ?>
							<?php $x++; } ?>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
</section>

<?php
if (in_array($kaizen[0]['status'], $needthisform = array(0,1,6))) { ?>
	<div class="modal fade"  id="req<?= $kaizen[0]['kaizen_id'] ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	<div class="modal-dialog" style="min-width: 800px;">
			<div class="modal-content">
        		<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          			<h4 class="modal-title" id="myModalLabel">Request Approve</h4>
        		</div>
        		<form action="<?= base_url('SystemIntegration/KaizenGenerator/MyKaizen/SaveApprover'); ?>" method="POST">
          			<input type="hidden" name="typeApp" value="<?= $kaizen[0]['status'] != 6 ? '1' : '2' ?>"/>
          			<div class="modal-body">
            			<div class="row">
							<?php
								$arrayTerisi = array();
								foreach ($form_approval as $key => $frmapp) {
								// print_r('<pre>'); print_r($frmapp);
							?>
							<div class="col-lg-12" style="margin: 5px; text-align: left;">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4"><?= $frmapp['title'] ?></label>
									<div class="col-lg-8 sel1">
										<input type="hidden" name="kaizen_id" value="<?= $kaizen[0]['kaizen_id']; ?>"/>
										<input type="hidden" name="approval_level[]" value="<?= $frmapp['level']?>"/>
										<select data-placeholder="Pilih Atasan" class="form-control select4 siSlcTgr" style="width: 100%" name="<?= $frmapp['namefrm'] ?>">
											<option></option>
											<?php foreach ($frmapp['option'] as $key => $value) { ?>
												<option
													<?= ($frmapp['level'] != 6 && $kaizen[0]['status_app']) ? (($kaizen[0]['status_app'][$frmapp['level']]['staff_code'] == $value['employee_code'] ) ? 'selected' : '' ) : ''; ?>
													value="<?= $value['employee_code'] ?>"><?= $value['employee_code'].' - '.$value['employee_name']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<?php
								if ($kaizen[0]['status_app']) {
									if (isset($kaizen[0]['status_app'][$frmapp['level']]['staff_code'])) {
										$terisi = ($kaizen[0]['status_app'][$frmapp['level']]['staff_code']) ? $kaizen[0]['status_app'][$frmapp['level']]['staff_code'] : 0;
										array_push($arrayTerisi, $terisi);
									}
								}
							}
							?>
						</div>
              		</div>
					<div class="modal-footer">
						<?php
						$filled = 0;
						if ($arrayTerisi):
							if (in_array('0', $arrayTerisi)) {
								$filled = 0;
							} else {
								$filled = 1;
							}
						endif;
						?>
						<button type="submit" class="btn btn-success " <?= $filled == 0 ? 'disabled' :'' ?> id="subApprSI" >Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
        </div>
    </div>
<?php } ?>

<div class="modal fade" role="dialog" id="modalReason">
	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Keterangan / Alasan </h4>
			</div>
			<form method="POST" id="formReason">
				<div class="modal-body">
					<input type="hidden" name="hdnKaizenId" id="hdnKaizenId" value="<?= $kaizen[0]['kaizen_id'] ?>">
					<input type="hidden" name="hdnStatus" id="hdnStatus">
					<input type="hidden" name="levelApproval" id="levelApproval" value="<?= $kaizen[0]['kaizen_id'] == 6 ? '6' : $levelku;  ?>">
					<div class="form-group" id="formReasonApprover">
						<textarea class="textareaKaizenAprove" name="txtReason" id="txtReason" placeholder="Masukkan keterangan" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
					</div>
					<?php if ($levelku == 2 || $levelku  == 3) { $next_level = $levelku == 2 ? 'level Departemen' : 'Direktur Utama'?>
					<div class="form-group" id= "formNextApprover" style="display: none">
						<div style="border: 1px solid green" class="col-lg-12">
            				<label>Alasan Approve :</label>
							<b class="fa fa-check" style="color: green"></b>
            			</div>
						<br/><br/>
						<h6>Jika Kaizen ini memerlukan Persetujuan dari <?= $next_level ?> maka silahkan pilih dibawah ini</h6>
						<h6>Jika tidak , silahkan langsung Submit</h6>
            			<input type="hidden" name="next" id="next" value="0">
            			<label class="checkbox-inline" style="padding: 5px"><input type="checkbox" value="1" name="checkNextApprover" id="checkNextApprover"><b> Set Approver Selanjutnya</b></label>
            			<br/>
						<input type="hidden" name="levelnext" value="<?= $levelku == 2 ? '3' : ($levelku == 3 ? '4' : '') ?>">
						<select class="form-control select2si" style="width: 100%" data-placeholder="Select Employee" id="slcApprover" name="slcApprover" required disabled>
							<option></option>
							<?php
								if($next_level == 'level Departemen'){
									foreach($option_atasan as $key => $value) { ?>
										<option value="<?= $value['employee_code'] ?>"><?= $value['employee_code'].' - '.$value['employee_name']; ?></option>
									<?php 
									}
								} else {
									foreach($option_atasan2 as $key => $value) { ?>
										<option value="<?= $value['employee_code'] ?>"><?= $value['employee_code'].' - '.$value['employee_name']; ?></option>
									<?php }
								}
							?>
						</select>
					</div>
					<?php } ?>
        		</div>
				<div class="modal-footer">
					<button id="btn_result" style="display: none" type="button" class="btn btn-success" > Selanjutnya </button>
					<button id="btn_result2" type="submit" class="btn btn-success" > <b>Submit</b> </button>
					<button id="btn_batal"type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
				</div>
      		</form>
    	</div>
  	</div>
</div>

<a href="#" id="buttonGoTop" class="fa fa-arrow-up" style="display: none;  position: fixed;  bottom: 48px;  right: 26px;  z-index: 99;  font-size: 18px;  border: none; outline: none; background-color: red;  color: white; cursor: pointer; padding: 15px; border-radius: 4px;" title="Go to top"></a>

<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js');?>"></script>
<script>
	CKEDITOR.disableAutoInline = true
	window.onscroll = _ => {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("buttonGoTop").style.display = "block";
		} else {
			document.getElementById("buttonGoTop").style.display = "none";
		}
	}
</script>