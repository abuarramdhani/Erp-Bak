<table class="table table-bordered" id="result_bom">
			<thead class="bg-red">
					<tr>
							<th class="text-center" style="width: 50px" >No</th>
							<th class="text-center">Kode Item</th>
							<th class="text-center">Nama Item</th>
							<th class="text-center" style="width: 150px">BOM</th>
							<th class="text-center" style="width: 150px">Action</th>
					</tr>
			</thead>
			<tbody>
				<?php 
				$nomor=1;
				foreach ($result_bom as $bom) { ?>
					<tr>
							<td class="text-center"><?=$nomor?></td>
							<td class="text-center"><input id="codeitem1"  type="hidden" name="kodeitem[]" value="<?=$bom['KODE_BARANG']?>" ><?=$bom['KODE_BARANG']?></td>
							<td class="text-center"><input id="namaitem1"  type="hidden" name="namaitem[]" value ="<?=$bom['DESCRIPTION']?>"><?=$bom['DESCRIPTION']?></td>
							<?php if ($bom['DETAIL_BOM'] == null) { ?>
								<td class="text-center" >-</td>
								<td class="text-center">-</td>
							<?php } else if ($bom['DETAIL_BOM'] != null) {  ?>

							<td class="text-center" ><button class="btn bg-teal btn-sm" onclick="lihatbom(this, 1)">Lihat</button></td>
							<td class="text-center"><button class="btn bg-yellow btn-sm" onclick="editbom(this, 1)">Edit</button></td>
						<?php } ?>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<div id="lihatbom1" style="display: none;" >
								<table class="table table-bordered">
									<thead class="bg-teal">
										<th class="text-center" style="width: 100px">Pack</th>
										<th class="text-center" style="width: 50px">Kode</th>
										<th class="text-center" style="width: 50px">Nama</th>
										<th class="text-center" style="width: 50px">Qty</th>

									</thead>
									<tbody>
										<?php 
											$urut=1;
											foreach ($bom['DETAIL_BOM'] as $detbom) { ?>
										<tr>
											<td class="text-center">Pack <?=$urut?></td>
											<td class="text-center"><input type="hidden" name="kodebom[]" value="<?=$detbom['KODE']?>"><?=$detbom['KODE']?></td>
											<td class="text-center"><input type="hidden" name="namabom[]" value="<?=$detbom['NAMA']?>"><?=$detbom['NAMA']?></td>
											<td class="text-center"><input type="hidden" name="qtybom[]" value="<?=$detbom['QTY']?>"><?=$detbom['QTY']?></td>
										</tr>
										<?php $urut++; } ?>
									</tbody>
								</table>
							</div>
							<div id="editbom1" style="display: none;" >
								<table class="table table-bordered">
									<thead class="bg-yellow">
										<th class="text-center" style="width: 50px">Pack</th>
										<th class="text-center" style="width: 50px">Kode</th>
										<th class="text-center" style="width: 200px">Nama</th>
										<th class="text-center" style="width: 50px">Qty</th>
										<!-- <th class="text-center" style="width: 20px">Action</th> -->
									</thead>
									<tbody>

										<?php 
											$urut=1;
											foreach ($bom['DETAIL_BOM'] as $detbom) { ?>
											<tr>
												<td class="text-center"><input type="text" class="form-control" value="Pack <?=$urut?>" readonly="readonly"></td>
												<td class="text-center"><input type="text" class="form-control" value="<?=$detbom['KODE']?>" name="kodebomedit[]"></td>
												<td class="text-center"><input type="text" class="form-control" name="namabomedit[]" value="<?=$detbom['NAMA']?>"></td>
												<td class="text-center"><input type="text" class="form-control" name="qtybomedit[]" value="<?=$detbom['QTY']?>"> </td>
												<!-- <td class="text-center"><button class="btn btn-sm btn-default"><i class="fa fa-plus"></i></button> </td> -->
											</tr>
										<?php $urut++; } ?>
									</tbody>
								</table>
								<div style="text-align: right;"><button class="btn btn-success btn-sm">Usulkan</button></div>
							</div>
						</td>
				</tr>
				<?php $nomor++; } ?>
		</tbody>
</table>	