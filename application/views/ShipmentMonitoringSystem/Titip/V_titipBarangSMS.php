<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
.capitalize{
    text-transform: uppercase;
		}

	thead.toscahead tr th {
    background-color: #5c94bd;
    font-family: sans-serif;
      }
.zoom {
  transition: transform .2s;
}

.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3); 
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
 .itsfun1 {
        border-top-color: #5c94bd;
      }
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><i class="fa fa-truck"></i> Titip Barang <span style="font-size: 16px">(ke gudang)</span></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsfun1">
							<div class="box-header with-border">
					  		</div>
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12 tbl_ship" style="margin-bottom: 5px;margin-left: 100px">
													<tr>
																
																<td>
																	<span><label>Finish Good</label></span>
																</td>
																<td style="width:400px">
																	<select id="finishgudtb" name="finishgud" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($fingo as $k) { ?>
																		<option value="<?php echo $k['fg_id'] ?>"><?php echo $k['fg_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																<td>
																	<span><label>Tujuan</label></span>
																</td>
																<td>
															<select id="cabangsmstb" name="cabang" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required" 
															onchange="selectTipBar()">
																		<option value="" > Pilih  </option>
																		<?php foreach ($cabang as $k) { ?>
																		<option value="<?php echo $k['cabang_id'] ?>"><?php echo $k['nama_cabang'] ?></option>
																		<?php } ?>
																	</select>
																</td>
													</tr>
													<tr>
																<td>
																	<span><label>Nama Barang</label></span>
																</td>
																<td>
																	<select id="unitsms_idtb" name="unitsms[]" class="form-control select2 select2-hidden-accessible" style="width:300px;">
																		<option value="" >Pilih</option>
																		<?php foreach ($good as $k) { ?>
																		<option value="<?php echo $k['goods_id'] ?>"><?php echo $k['goods_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																<td>
																	<span><label>Provinsi</label></span>
																</td>
																<td>
																	<select id="provinsismstb" name="provinsi" class="form-control select2 select2-hidden-accessible provcabang" style="width:300px;" required="required" onchange="selectKotaTitipBarang()">
																		<option value="" > Pilih  </option>
																		<?php foreach ($prov as $k) { ?>
																		<option value="<?php echo $k['prov_id'] ?>"><?php echo $k['prov_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
													</tr>
													<tr>
																<td>
																	<span><label>Quantity</label></span>
																</td>
																<td>
																	<input type="number" class="form-control jumlahsms" style="width: 300px" type="text" id="jumlahsms_idtb" placeholder="MASUKKAN QUANTITY" name="jumlahsms[]">
																</td>
																<td>
																	<span><label>Kota</label></span>
																</td>
																<td>
																	<select id="kotasmstb" name="kota" class="form-control select2 select2-hidden-accessible kotacabang" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($kota as $k) { ?>
																		<option value="<?php echo $k['city_id'] ?>"><?php echo $k['city_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
													</tr>
													<tr>
														<td>
														</td>
															<td>
															</td>
																<td>
																	<span><label>Alamat</label></span>
																</td>
																<td> <textarea style="width: 300px;" placeholder="Masukkan Alamat" class="form-control capitalize inialamatplz" id="alamatsmstb" name="alamatsms"></textarea>
																</td>
													</tr>
											</table>
											<br>
											<br>
											<br>
										</div>
									</div>
								</div>
									<div class="col-md-12 pull-left">
										<button id="new-shipment-sms" onclick="saveTitipBarang();" type="button" class="btn btn-primary pull-right zoom" style="margin-top: 10px; margin-bottom: 20px;color:white;background-color:#5c94bd;border-color:#5c94bd  "><i class="fa fa-plus"></i><b> Add </b></button>
									</div>
									<table class="table table-bordered table-hover text-center table-striped tbTBSMS">
										<thead class="toscahead">
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 8%"  class="text-center">Gudang</th>
												<th style="width: 15%" class="text-center">Nama Barang</th>
												<th style="width: 5%"  class="text-center">Qty </th>
												<th style="width: 15%" class="text-center">Cabang Tujuan </th>
												<th style="width: 10%" class="text-center">Provinsi Tujuan</th>
												<th style="width: 10%" class="text-center">Kota Tujuan</th>
												<th style="width: 15%" class="text-center">Alamat Tujuan</th>
												<th style="width: 15%" class="text-center">Status</th>
											</tr>
										</thead>
										<tbody id="tabelAddsms">
									    <?php $no=1;foreach($atta as $a) { ?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $a['nama_gudang']?></td>
												<td><?php echo $a['goods_name']?></td>
												<td><?php echo $a['quantity']?></td>
												<td><?php echo $a['nama_cabang']?></td>
												<td><?php echo $a['province_name']?></td>
												<td><?php echo $a['city_name']?></td>
												<td><?php echo $a['ship_to_address']?></td>
											<?php if ($a['accepted_quantity'] == NULL && $a['delivered_quantity'] == NULL) { ?>
												<td><span class="label label-danger">Belum Diterima Gudang &nbsp;<br></span><br>
												<span class="label label-danger">Belum Dikirim Gudang &nbsp;<br></span> </td>
											<?php }else if ($a['accepted_quantity'] !== NULL && $a['delivered_quantity'] == NULL){?>
												<td><span class="label label-warning">Diterima Gudang : <?php echo $a['accepted_quantity']?> 
												barang &nbsp;<br></span> <br>
												<span class="label label-danger">Belum Dikirim Gudang &nbsp;<br></span> </td>
											<?php }else if ($a['accepted_quantity'] !== NULL && $a['delivered_quantity'] !== NULL) {?>
												<td><span class="label label-warning">Diterima Gudang : <?php echo $a['accepted_quantity']?> 
												barang &nbsp;<br></span> <br>
												<span class="label label-success">Dikirim Gudang : <?php echo $a['delivered_quantity']?> 
												barang &nbsp;<br></span> <br></td>
											<?php }?>
											</tr>
											<?php $no++; } ?>
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

<script type="text/javascript">
			var user = $('#userhidden').val();
$(document).ready(function(){
	$('.tbTBSMS').DataTable({
		"paging": true,
		"filter" : false,
		"info": true,
		"language" : {
		"zeroRecords": " "             
		}
	})

	})
</script>