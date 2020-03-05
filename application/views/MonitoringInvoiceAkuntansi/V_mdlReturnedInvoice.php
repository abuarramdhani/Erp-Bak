    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		<span><b>PILIH KETERANGAN DOKUMEN YANG DISERTAKAN</b></span><br/>
		      		<!-- <input disabled type="text" class="form-control text-center" style="width: 400px;margin-bottom: 10px;margin-top: 10px;" id="defaultBuyer" name="txtBuyerDefault" value="<?php echo $default[0]['BUYER']?>"> -->
		      		<select data-toggle="tooltip" data-placement="top" title="Kategori 'Dokumen Lain' harap sertakan keterangan nama dokumen di Note" onchange="kelengkapanDokumen(this)" name="slcKelengkapanDokumen[]" id="slcKelengkapanDokumen" multiple class="form-control select2 select2-hidden-accessible selectBuyer" style="width:400px;">
												<option value="Invoice">Invoice</option>
												<option value="FP">FP</option>
												<option value="LPPB">LPPB</option>
												<option value="SJ">SJ</option> 
												<option value="Without Document">Without Document</option> 
												<option value="DokumenLain">Dokumen Lain</option> 
					</select>
					<textarea data-toggle="tooltip" data-placement="top" title="Kategori 'Dokumen Lain' harap sertakan keterangan nama dokumen di Note" placeholder="Masukkan Note untuk Purchasing" class="form-control" id="noteForPurcReturned" name="noteForPurcReturned" style="width: 400px;margin-top: 10px;"><?php echo $returned[0]['NOTE_RETURN_AKT']?></textarea>
		      	<center>
		      </div>
		    </div>

<script type="text/javascript">
	$( document ).ready(function() {
	$('.selectBuyer').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
})
</script>