<form name="Orderform" class="form-horizontal" action="<?php echo site_url('RKHKasie/Bom/exportbomada');?>" target="_blank" onsubmit="return validasi();window.location.reload();" method="post" >
<table class="table table-bordered" style="width: 100%" id="ada_bom">
			<thead class="bg-green">
					<tr>
							<th class="text-center" style="width: 50px" >No</th>
							<th class="text-center">Kode Item</th>
							<th class="text-center">Nama Item</th>
							<th class="text-center" style="width: 150px">BOM</th>
					</tr>
			</thead>
			<tbody>
				<?php 
				$nomor=1;
				foreach ($result_bom as $bom) {
				if ($bom['DETAIL_BOM'] !=null) {?>
					<tr>
							<td class="text-center"><?=$nomor?></td>
							<td class="text-center"><input id="codeitem"  type="hidden" name="kodeitem[]" value="<?=$bom['KODE_BARANG']?>" ><?=$bom['KODE_BARANG']?></td>
							<td class="text-center"><input id="namaitem"  type="hidden" name="namaitem[]" value ="<?=$bom['DESCRIPTION']?>"><?=$bom['DESCRIPTION']?></td>
							<td class="text-center" ><a class="btn btn-flat bg-teal btn-sm" onclick="lihatbom(this, <?=$nomor?>)">Lihat</a><a class="btn bg-yellow btn-flat btn-sm" onclick="editbom(this, <?=$nomor?>)">Edit</a></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<div id="lihatbom<?=$nomor?>" style="display: none;" >
								<table class="table table-bordered">
									<thead class="bg-teal">
										<th class="text-center" style="width: 100px">Pack</th>
										<th class="text-center" style="width: 50px">Kode</th>
										<th class="text-center" style="width: 50px">Nama</th>
										<th class="text-center" style="width: 50px">Qty</th>
										<th class="text-center" style="width: 50px">Isi</th>


									</thead>
									<tbody>
										<?php 
											$urut=1;
											foreach ($bom['DETAIL_BOM'] as $detbom) { ?>
										<tr>
											<td class="text-center">Pack <?=$urut?></td>
											<td class="text-center"><input type="hidden" name="kodebom[]" value="<?=$detbom['KODE']?>"><?=$detbom['KODE']?></td>
											<td class="text-center"><input type="hidden" name="namabom[]" value="<?=$detbom['NAMA']?>"><?=$detbom['NAMA']?></td>
											<td class="text-center"><input   type="hidden" name="qtybom[]" value="<?=$detbom['QTY']?>"><?=$detbom['QTY']?></td>
											<td class="text-center"><input   type="hidden"  value="<?=$detbom['ISI']?>"><?=$detbom['ISI']?></td>
										</tr>
										<?php $urut++; } ?>
									</tbody>
								</table>
							</div>
							<div id="editbom<?=$nomor?>" style="display: none;" >
								<table class="table table-bordered">
									<thead class="bg-yellow">
										<!-- <th class="text-center" style="width: 50px">Pack</th> -->
										<th class="text-center" style="width: 50px">Kode</th>
										<th class="text-center" style="width: 200px">Nama</th>
										<th class="text-center" style="width: 50px">Qty</th>
										<th class="text-center" style="width: 20px">Action</th>
									</thead>
									<tbody id="tambahpack<?=$nomor?>">

										<?php 
											$urut=1;
											foreach ($bom['DETAIL_BOM'] as $detbom) { ?>
											<tr class="trlama">
												<input type="hidden" value="<?=$urut?>" name="urutan<?=$nomor?>[]">

												<td class="text-center"><input type="text" class="form-control" value="<?=$detbom['KODE']?>" id="kodebomedit<?=$nomor?><?=$urut?>" onkeyup="getdesckompp(<?=$nomor?>,<?=$urut?>)"></td>

												<td class="text-center"><input type="text" class="form-control" id="namabomedit<?=$nomor?><?=$urut?>" name="namabomedit[]" value="<?=$detbom['NAMA']?>" readonly="readonly"></td>

												<td class="text-center"><input onkeypress="return angkasaja(event, false)" type="text" class="form-control"  id="qtybom<?=$nomor?><?=$urut?>"  value="<?=$detbom['QTY']?>"> </td>
												<td class="text-center"><a class="btn btn-sm btn-danger hpspack<?=$nomor?><?=$urut?>" onclick="hapuspack(<?=$nomor?>,<?=$urut?>)"><i class="fa fa-minus"></i></a> </td>
											</tr>
										<?php $urut++; } ?>
									</tbody>
								</table>
								<div style="text-align: right;">
									<a class="btn btn-info btn-sm" onclick="tambahpackk(<?=$nomor?>,<?=$urut?>)">Tambah Pack</a>
									<a class="btn btn-success btn-sm">Usulkan</a>

								</div>
							</div>
						</td>
				</tr>
				<?php $nomor++; }else { ?>
				<?php } }?>
		</tbody>
</table>	
<div class="col-md-12">
	<center><button class="btn btn-success btn-flat">Export</button></center>
</div>
</form>