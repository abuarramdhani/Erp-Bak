<?php 
$succ =  $this->session->flashdata('response');
if ($succ != null) {
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<script type="text/javascript">
			Swal.fire({
				type: \'success\',
				title: \''.$succ.'\',
				width: 600,
				height : 500,
				showConfirmButton: false,
				timer: 2200
			})
		</script>';
} ?>
<style type="text/css">
	.form-control{
		border-radius: 20px;
	}

	.hh {
		text-align: right;
	}

	textarea.form-control{
		border-radius: 10px;
	}
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	.select2-selection{
		border-radius: 20px !important;
	}

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	input.select2-search__field{
		border-radius: 20px !important;
	}

	span.select2-dropdown{
		border-radius: 20px !important;
	}

	.loadOSIMG{
		width: 30px;
		height: auto;
	}
	/* .btn {
		border-radius: 20px !important;
	} */
	
</style>

<?php 
    // echo '<pre>';
    // echo FCPATH;
    // exit();
?>
<meta http-equiv="refresh" content="60"/>
<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Monitoring</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-cog "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<!-- <button class="btn btn-md btn-primary"><b>View Data</b></button> -->
							</div>
							<div class="box-body">
								<br>
								<table class="table table-bordered table-responsive table-hover text-left" id="tblPBD">
											<thead class="bg-primary">
												<tr>
													<th height="30px" style="text-align:center;font-size: 15px;">NO</th>
													<th style="text-align:center;font-size: 13px;">PROMISED<br>DATE</th>
                                                    <th style="text-align:center;font-size: 15px;">ITEM</th>
                                                    <th width="20%" style="text-align:center;font-size: 15px;">DESCRIPTION</th>
                                                    <th style="text-align:center;font-size: 15px;">NO PO</th>
                                                    <th style="text-align:center;font-size: 15px;">QTY</th>
                                                    <th style="text-align:center;font-size: 15px;">UOM</th>
                                                    <th style="text-align:center;font-size: 15px;">SUPPLIER</th>
                                                    <th width="20%" style="text-align:center;font-size: 15px;">BUYER</th>
                                                    <th width="15%" style="text-align:center;font-size: 15px;">REQUESTER</th>
													<th style="text-align:center; font-size: 14px;">LOCATION CODE</th>
													<th width="15%" style="text-align:center; font-size: 14px;">ACTION</th>
                                                    <!-- <th width="3.5%" style="border-left:none;"></th> -->
												</tr>
											</thead>
											<tbody>
											    <?php
												// if (empty($value)) {
												// }else{
													$no=1;
													foreach ($value as $key) {
                                                        // echo "<pre>"; print_r($value);exit;
                                                        $promised_date1 = $key['PROMISED_DATE'] ;
                                                        $promiseddate = date('Y-m-d' ,strtotime($key['PROMISED_DATE']));
                                                        $promised_date = date('d M Y' ,strtotime($promised_date1));
                                                        // $promdate1 = date('dMY' ,strtotime($promised_date1));
                                                        // $promdate = $promdate1;
                                                        $tgl = date('Y-m-d' ,strtotime($promised_date1));
                                                        $tglskrg = date('Y-m-d' ,strtotime($date));
                                                        $nextdate = date('Y-m-d', strtotime($tglskrg .' +3 day'));
                                                        $promised_time = $key['PROMISED_TIME'] ;
                                                        $buyer = $key['BUYER'] ;
                                                        $requester = $key['REQUESTER'];
                                                        $item = $key['ITEM'];
                                                        $desc = $key['DESCRIPTION'];
                                                        $nopo = $key['NO_PO'];
                                                        $qty = $key['QUANTITY'];
                                                        $line = $key['LINE'];
                                                        $status = $key['STATUS'];
                                                        $uom = strtoupper($key['UOM']);


                                                        $vendor = strtoupper($key['VENDOR_NAME']);
                                                        $locid = $key['DELIVER_TO_LOCATION_ID'];
                                                        $loccode = strtoupper($key['LOCATION_CODE']);
                                                        // echo strlen("MJBCACAEL125013B");
                                                        // echo "<pre>"; 
                                                        // print_r($tglskrg);
                                                        // print_r($nextdate);
                                                        // exit; 
                                                        if ($tgl < $tglskrg) {?>
                                                            <tr class="bg-danger">
                                                                <td style="text-align: center;"><?php echo $no; ?></td>
                                                                <td align="center"><?php echo $promised_date; ?> <?php echo $promised_time?></td>
                                                                <td align="center"><?php echo $item; ?></td>
                                                                <td align="center"><?php echo $desc; ?></td>
                                                                <td align="center"><?php echo $nopo; ?></td>
                                                                <td style="text-align:center;font-size: 15px;" align="center"><?php echo $qty; ?></td>
                                                                <td align="center" ><?php echo $uom; ?></td>
                                                                <td align="center" ><?php echo $vendor; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center" ><?php echo $buyer; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center"><?php echo $requester; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center"><?php echo $loccode; ?></td>
																<td><center>
																<!-- <?php if ($status == 'Y') {?>
																	<button class="btn btn-sm btn-success" disabled><i class="fa fa-check-circle-o"  style="font-size:15px;"></i></button> 
																<?php } else { ?>
																	<button class="btn btn-sm btn-success"><i class="fa fa-check-circle-o"  style="font-size:15px;"></i></button> 
																<?php } ?> -->
																<button onclick="editPromDate('<?= $promiseddate ?>','<?= $promised_time ?>','<?= $line ?>','<?= $nopo ?>')" class="btn btn-sm btn-info"><i class="fa fa-edit" style="font-size:15px;"></a></center></td>
															</tr>
                                                        <?php } else if ($tgl < $nextdate){ ?>
                                                            <tr class="bg-warning">
															<td style="text-align: center;"><?php echo $no; ?></td>
                                                                <td align="center"><?php echo $promised_date; ?> <?php echo $promised_time?></td>
                                                                <td align="center"><?php echo $item; ?></td>
                                                                <td align="center"><?php echo $desc; ?></td>
                                                                <td align="center"><?php echo $nopo; ?></td>
                                                                <td style="text-align:center;font-size: 15px;" align="center"><?php echo $qty; ?></td>
                                                                <td align="center" ><?php echo $uom; ?></td>
                                                                <td align="center" ><?php echo $vendor; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center" ><?php echo $buyer; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center"><?php echo $requester; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center"><?php echo $loccode; ?></td>
																<td><center>
																<!-- <?php if ($status == 'Y') {?>
																	<button class="btn btn-sm btn-success" disabled><i class="fa fa-check-circle-o"  style="font-size:15px;"></i></button> 
																<?php } else { ?>
																	<button class="btn btn-sm btn-success" onclick="editStatusPBD('<?= $line ?>','<?= $nopo ?>')"><i class="fa fa-check-circle-o"  style="font-size:15px;"></i></button> 
																<?php } ?> -->
																<button onclick="editPromDate('<?= $promiseddate ?>','<?= $promised_time ?>','<?= $line ?>','<?= $nopo ?>')" class="btn btn-sm btn-info"><i class="fa fa-edit" style="font-size:15px;"></a></center></td>
															</tr>
                                                        <?php } else { ?>
                                                            <tr class="bg-success">
																<td style="text-align: center;"><?php echo $no; ?></td>
                                                                <td align="center"><?php echo $promised_date; ?> <?php echo $promised_time?></td>
                                                                <td align="center"><?php echo $item; ?></td>
                                                                <td align="center"><?php echo $desc; ?></td>
                                                                <td align="center"><?php echo $nopo; ?></td>
                                                                <td style="text-align:center;font-size: 15px;" align="center"><?php echo $qty; ?></td>
                                                                <td align="center" ><?php echo $uom; ?></td>
                                                                <td align="center" ><?php echo $vendor; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center" ><?php echo $buyer; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center"><?php echo $requester; ?></td>
                                                                <td style="text-align:center;font-size: 13px;" align="center"><?php echo $loccode; ?></td>
																<td><center>
																<!-- <?php if ($status == 'Y') {?>
																	<button class="btn btn-sm btn-success" disabled><i class="fa fa-check-circle-o"  style="font-size:15px;"></i></button> 
																<?php } else { ?>
																	<button class="btn btn-sm btn-success"  onclick="editStatusPBD('<?= $line ?>','<?= $nopo ?>')"><i class="fa fa-check-circle-o"  style="font-size:15px;"></i></button> 
																<?php } ?> -->
																<button onclick="editPromDate('<?= $promiseddate ?>','<?= $promised_time ?>','<?= $line ?>','<?= $nopo ?>')" class="btn btn-sm btn-info"><i class="fa fa-edit" style="font-size:15px;"></a></center></td>
															</tr>
                                                       <?php }?>
												<?php
													$no++;
													}
												// }
												?>
											</tbody>                                
										</table>
								</div>

								<div class="modal modal fade" id="mdlPromdate">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Edit</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label style="text-align:left">Promised Date : </label><br/>
                                                        <input type="hidden" id="editLine" class="editLine">
                                                        <input type="hidden" id="editnoPo" class="editnoPo">
                                                        <input type="date" class="form-control editPromisedDate" id="editPromisedDate">
														<br>
                                                        <input type="time" class="form-control editPromisedTime" id="editPromisedTime">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-success btnSubmitPrmdate">Save changes</button>
                                                    </div>
                                                </div>
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