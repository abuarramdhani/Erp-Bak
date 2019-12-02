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
							<span style="font-family: sans-serif;"><i class="fa fa-truck"></i> Terima Barang <span style="font-size: 16px">(gudang)</span></span>
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
									<table class="table table-bordered table-hover text-center table-striped tbTBSMSgdg">
										<thead class="toscahead">
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 8%"  class="text-center">Gudang</th>
												<th style="width: 15%" class="text-center">Nama Barang</th>
												<th style="width: 5%"  class="text-center">Qty </th>
												<th style="width: 10%" class="text-center">Cabang Tujuan </th>
												<th style="width: 10%" class="text-center">Provinsi Tujuan</th>
												<th style="width: 10%" class="text-center">Kota Tujuan</th>
												<th style="width: 20%" class="text-center">Alamat Tujuan</th>
												<th style="width: 10%" class="text-center">Qty Diterima Gudang</th>
												<th style="width: 10%" class="text-center">Sudah diterima?</th>
												<th style="width: 10%" class="text-center">Qty Dikirim Gudang</th>
												<th style="width: 10%" class="text-center">Sudah dikirim?</th>
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
												<td><input type="number" class="form-control" style="width: 100%;" id="jumlah_beneran" placeholder="QUANTITY" value="<?php echo $a['accepted_quantity']?>" name="jumlah_beneran[]"></td>
												<td><button id="btnSaveQty" onclick="saveJumlahAsli(<?php echo $a['entrusted_id'];?>);" type="button" class="btn btn-success pull-right zoom" style="margin-top: 10px; margin-bottom: 20px;color:white;"><i class="fa fa-check"></i><b> Yes! </b></button></td>
												<td><input type="number" class="form-control" style="width: 100%;" id="jumlah_dikirim" placeholder="DELIVERED" value="<?php echo $a['delivered_quantity']?>" name="jumlah_dikirim[]"></td>
												<td><button id="btnSaveQty" onclick="saveJumlahDikirim(<?php echo $a['entrusted_id'];?>);" type="button" class="btn btn-success pull-right zoom" style="margin-top: 10px; margin-bottom: 20px;color:white;"><i class="fa fa-check"></i><b> Yes! </b></button></td>
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
	$('.tbTBSMSgdg').DataTable({
		"paging": true,
		"info": true,
		"language" : {
		"zeroRecords": " "             
		}
	})

	})
</script>