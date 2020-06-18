<form name="Orderform" class="form-horizontal" action="<?php echo site_url('RKHKasie/Bom/exportbomtdk');?>" target="_blank" onsubmit="return validasi();window.location.reload();" method="post" >
<table class="table table-bordered" style="width: 100%" id="tdk_bom">
			<thead class="bg-red">
					<tr>
							<th class="text-center" style="width: 50px" >No</th>
							<th class="text-center">Kode Item</th>
							<th class="text-center">Nama Item</th>
					</tr>
			</thead>
			<tbody>
				<?php 
				$nomor=1;
				foreach ($result_bom as $bom) {
				if ($bom['DETAIL_BOM'] ==null) {?>
					<tr>
							<td class="text-center"><?=$nomor?></td>
							<td class="text-center"><input id="codeitem"  type="hidden" name="kodeitem[]" value="<?=$bom['KODE_BARANG']?>" ><?=$bom['KODE_BARANG']?></td>
							<td class="text-center"><input id="namaitem"  type="hidden" name="namaitem[]" value ="<?=$bom['DESCRIPTION']?>"><?=$bom['DESCRIPTION']?></td>
					</tr>
				<?php $nomor++; }else { ?>
				<?php } }?>
		</tbody>
</table>
<div class="col-md-12">
	<center><button class="btn btn-success btn-flat">Export</button></center>
</div>	
</form>