<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Catering Receipt</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/ReceiptBatch');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Catering Receipt</b>
					</div>
					<div class="box-body">

						<?php
							$this->load->helper('terbilang_helper');
							foreach ($Receipt as $rc) {

								$bonus_qty= 0; 
								if($rc['order_type_id']==2 && $rc['bonus']==1){
									$bonus_qty = floor($rc['order_qty']/50);
								}else {
									$bonus_qty = 0;}

								$total_qty 	= $rc['order_qty']-$bonus_qty;
								$total 		= $total_qty*$rc['order_price'];
								$grand 		= $rc['payment'];
						?>
						<div class="col-md-12">
							<a href="<?php echo base_url('CateringManagement/ReceiptBatch/Edit/'.$rc['receipt_id'])?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
							<a href="<?php echo base_url('CateringManagement/ReceiptBatch/PrintReceipt/'.$rc['receipt_id'])?>" class="btn btn-info" target="blank_"><i class="fa fa-print"></i> Print</a>
							<a data-toggle="modal" data-target="#deletealert" class="btn btn-danger"><i class="fa fa-remove"></i> Delete</a>
							<hr>
						</div>
						<div style="margin-left:20px;padding-top:10px;">
							<h4>
								RECEIPT CATERING<br>
								<small style="font-size:10px;">CV.Karya Hidup Sentosa Jl. Magelang No. 144 Yogyakarta 55241</small>
							</h4>
						</div>
						<div style="border-style: double;border-width:1px;width:98%;margin:0 auto;"></div>
						<div style="margin-left:10px;margin-top:10px;">
							<table style="font-size:12px;">
								<tr>
									<td height="15">No.</td>
									<td width="20" style="text-align:center;">:</td>
									<td><?php echo $rc['receipt_no'] ?></td>
								</tr>
								<tr>
									<td>Telah Diterima Dari</td>
									<td width="20" style="text-align:center;">:</td>
									<td><?php echo $rc['receipt_from'] ?></td>
								</tr>
								<tr style="vertical-align:top">
									<td>Guna Pembayaran</td>
									<td width="20" style="text-align:center;">:</td>
									<td><?php echo $rc['type_description'].' '.$rc['catering_name'].' DARI TANGGAL '.$rc['order_start_date'].' - '.$rc['order_end_date']
									.' <br>DENGAN MENU '.$rc['order_description'] ?>
										<table style="width: 100%">
											<?php 
											if (!empty($ReceiptQty)) {
												foreach ($ReceiptQty as $rq) {
													?>
											<tr>
												<td>- Dept <?php echo $rq['dept'] ?></td>
												<td style="text-align: right;"><?php echo $rq['qty'] ?></td>
												<td style="text-align: center"> Box/Pcs </td>
												<td style="text-align: center"> @ </td>
												<td style="text-align: center"> Rp. </td>
												<td style="text-align: right;"><?php echo number_format($rc['order_price'],0,',','.') ?></td>
											</tr>
													<?php
												}
											}
											?>
										</table>
									</td>
								</tr>
								<tr>
									<td>Uang Sebanyak</td>
									<td width="20" style="text-align:center;">:</td>
									<td>Rp. <?php  echo number_format($grand,0,",",".")?></td>
								</tr>
								<tr>
									<td>Terbilang</td>
									<td width="20" style="text-align:center;">:</td>
									<td><?php echo ucwords(number_to_words($grand))." Rupiah" ?></td>
								</tr>
							</table>
						</div>
						<div class="row" style="width:100%;">
							<div class="col-md-12">
							<div style="margin-left:10px;margin-top:5px;border:1px solid black;width:27%;float:left;">
								<table style="font-size:10px;margin:3px auto;">
									<tr>
										<td height="15" colspan="3" style="border-bottom:1p solid black;"><b>Rincian Pembayaran</b></td>
									</tr>
									<tr>
										<td>Total Pesanan</td>
										<td width="20" style="text-align:center;">:</td>
										<td style="text-align:right;"><?php if($bonus_qty > 0){ echo $rc['order_qty']." - ".$bonus_qty."(Bonus)"; }else{ echo $rc['order_qty']; } ?></td>
									</tr>
									<tr>
										<td>Total Harga</td>
										<td width="20" style="text-align:center;">:</td>
										<td style="text-align:right;"><?php echo "Rp. ".number_format($total, 0 , ',' , '.' ) ?></td>
									</tr>
									<tr>
										<td>Total Denda</td>
										<td width="20" style="text-align:center;">:</td>
										<td style="text-align:right;"><?php echo "Rp. ".number_format($rc['fine'], 0 , ',' , '.' ) ?></td>
									</tr>
									<tr>
										<td>Pajak</td>
										<td width="20" style="text-align:center;">:</td>
										<td style="text-align:right;">Rp. <?php  echo number_format($rc['pph'], 0 , ',' , '.' )?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td width="20" style="text-align:center;">( - )</td>
										<td style="text-align:right;">-----------------------------</td>
									</tr>
									<tr>
										<td><b>Total Pembayaran</b></td>
										<td width="20" style="text-align:center;"><b>:</b></td>
										<td style="text-align:right;"><b><?php echo "Rp. ".number_format($grand, 0 , ',' , '.' ) ?></b></td>
									</tr>
								</table>
							</div>
							<div style="margin-left:10px;margin-top:5px;border:1px solid black;width:43%;float:left;">
								<table style="font-size:10px;margin:3px;margin-left:5px;margin-right:5px;auto;">
									<tr>
										<td height="15" colspan="6" style="border-bottom:1p solid black;"><b>Rincian Denda</b></td>
									</tr>
									<tr>
										<td style="width:30px;text-align:center;">No.</td>
										<td style="width:70px;text-align:center;">Tanggal</td>
										<td style="width:40px;text-align:center;">Qty</td>
										<td style="width:30px;text-align:center;">(%)</td>
										<td style="width:40px;text-align:right;">Harga</td>
										<td style="width:160px;text-align:right;">Deskripsi</td>
										<td style="width:80px;text-align:right;">Total</td>
									</tr>
									<?php $no=0; foreach($ReceiptFine as $rf){ $no++;?>
									<tr>
										<td style="text-align:center;"><?php echo $no; ?></td>
										<td style="text-align:center;"><?php echo $rf['receipt_fine_date'] ?></td>
										<td style="text-align:center;"><?php echo $rf['receipt_fine_qty'] ?></td>
										<td style="text-align:center;"><?php echo $rf['fine_type_percentage'] ?> %</td>
										<td style="text-align:right;"><?php echo number_format($rf['receipt_fine_price'], 0 , ',' , '.' ); ?></td>
										<td style="text-align:right;"><?php echo $rf['fine_description'] ?></td>
										<td style="text-align:right;"><?php echo number_format($rf['fine_nominal'], 0 , ',' , '.' ); ?></td>
									</tr>
									<?php } ?>
								</table>
							</div>
							</div>
						</div>
						<div style="width:100%;">
							<div style="width:40%;float:left;"> 
								<table style="margin:3px auto;font-size:12px;">
									<tr>
										<td style="text-align:center;">&nbsp; </td>
									</tr>
									<tr>
										<td style="text-align:center;">Mengetahui, </td>
									</tr>
									<tr>
										<td style="text-align:center;height:30px;">&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:center;">( .......................................... )</td>
									</tr>
								</table>
							</div>
							<div style="width:40%;float:right;">
								<table style="margin:3px auto;font-size:12px;">
									<tr>
										<td><?php echo $rc['receipt_place'].', '.$rc['receipt_date'] ?></td>
									</tr>
									<tr>
										<td style="text-align:center;">Pekerja, </td>
									</tr>
									<tr>
										<td style="text-align:center;height:30px;">&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:center;"><?php echo "(       ".$rc['receipt_signer']."       )"; ?></td>
									</tr>
								</table>
							</div>
						</div>
						
						<!-- DELETE ALERT/CONFIRMATION -->
						<div class="modal fade modal-danger" id="deletealert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-sm-2"></div>
										<div class="col-sm-8" align="center"><h5><b>WARNING !</b></h5></div>
										<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
										</br>
									</div>
									<div class="modal-body" align="center">
										Are you sure want to delete receipt No. <b><?php echo $rc['receipt_no'] ?></b> signed by <b><?php echo $rc['receipt_signer']?></b> ? <br>
										<small>*) Data that has been deleted cannot be retrieved.<small>
										<div class="row">
											<br>
											<a href="<?php echo base_url('CateringManagement/ReceiptBatch/Delete/'.$rc['receipt_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<?php } ?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
