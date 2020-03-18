<form name="Orderform" class="form-horizontal" action="<?php echo site_url('RKHKasie/Bom/exportbomall');?>" target="_blank" onsubmit="return validasi();window.location.reload();" method="post" >
<table class="table table-bordered" style="width: 100%" id="result_bom">
			<thead class="bg-yellow">
					<tr>
							<th class="text-center" >No</th>
							<th class="text-center">Kode Item</th>
							<th class="text-center">Nama Item</th>
							<th class="text-center">BOM</th>
					</tr>
			</thead>
			<tbody>
				<?php 
				$nomor=1;
				foreach ($result_bom as $bom) { ?>
					<tr>
							<td class="text-center"><?=$nomor?></td>
							<td class="text-center"><input id="codeitem<?=$nomor?>"  type="hidden" name="kodeitem[]" value="<?=$bom['KODE_BARANG']?>" ><?=$bom['KODE_BARANG']?></td>
							<td class="text-center"><input id="namaitem1"  type="hidden" name="namaitem[]" value ="<?=$bom['DESCRIPTION']?>"><?=$bom['DESCRIPTION']?></td>
							<td class="text-center" ><a class="btn bg-teal btn-flat btn-sm" onclick="lihatbomm(this, <?=$nomor?>)">Lihat</a><a class="btn bg-yellow btn-flat btn-sm" onclick="editbomm(this, <?=$nomor?>)">Edit</a></td>
					</tr>
				<?php $nomor++; } ?>
		</tbody>
</table>	
<div class="col-md-12">
	<center><button class="btn btn-success btn-flat">Export</button></center>
</div>
</form>

  <div class="modal fade" id="modalakuaku" role="dialog">
    <div class="modal-dialog" style="width:60%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Detail BOM</h3></center>
        </div>
        <div class="modal-body">
            <div id="lalalala"></div>
        </div>
      </div>
      
    </div>
</div>