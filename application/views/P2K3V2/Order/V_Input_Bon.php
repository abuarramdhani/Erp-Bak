<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>Input Bon</b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1 "></div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body" style="overflow-x: scroll;">
									<form method="post" action="<?php echo site_url('P2K3_V2/Order/InputBon'); ?>">
										<div class="col-md-1 text-left" align="right">
											<label for="lb_periode" class="control-label">Periode : </label>
										</div>
										<div class="col-md-2">
											<div class="input-group col-md-12">
												<input required="" class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" value="<?php echo $pr; ?>"/>
											</div>
										</div>
										<div class="col-md-2">
											<button type="submit" class="btn btn-primary">Lihat</button>
										</div>
									</form>
									<form onsubmit="setTimeout(function () { window.location.href = baseurl+'P2K3_V2/Order/InputBon'; }, 1)" method="post" target="_blank" action="<?php echo site_url('P2K3_V2/Order/SubmitInputBon');?>" enctype="multipart/form-data">
										<div class="col-md-12" style="margin-top: 30px; padding: 0px;">
											<label class="col-md-2 control-label">Seksi Pemakai</label>
										</div>
										<div class="col-md-10">
											<div class="col-md-9" style="padding: 3px">
												<select required="" id="pemakai_2" name="txt_pemakai_2" class="form-control p2k3_select2" data-placeholder="Pilih Seksi">
													<option></option>
												</select>
											</div>
										</div>
										<label class="col-md-2"></label>
										<div class="col-md-10">
											<div class="col-md-9" style="padding: 3px">
												<div class="col-md-6" style="padding: 0px">
													<label>Cost Center</label>
													<input id="cost_center" type="text" name="txt_cost" class="form-control" readonly placeholder="Cost Center" value="">
												</div>
												<div class="col-md-6" style="padding-right: 0px;padding-left: 5px">
													<label>Branch</label>
													<input id="kodCab1" type="text" name="kode_cabang1" class="form-control" readonly placeholder="Kode Cabang">
												</div>
											</div>	
										</div>
										<label class="col-md-12 control-label">Lokasi</label>
										<div class="col-md-10">
											<div class="col-md-9" style="padding:3px">
												<select required="" id="p2k3_lokasi" name="txt_lokasi" class="form-control p2k3_select2" data-placeholder="Pilih Lokasi Gudang" disabled="">
													<option selected="" value="142">Yogyakarta </option>
													<!-- <?php foreach ($lokasi as $data_lokasi) {?>
													<option value="<?php echo $data_lokasi['LOCATION_ID'] ?>"><?php echo $data_lokasi['LOCATION_CODE'] ?> </option>
													<?php } ?> -->
												</select>
											</div>
										</div>
										<label class="col-md-12 control-label">Subinventory</label>
										<div class="col-md-10">
											<div class="col-md-9" style="padding:3px">
												<select required="" id="p2k3_gudang_hilangkanini" name="txt_gudang" class="form-control p2k3_select2" data-placeholder="Pilih Subinventory" disabled="">
													<option selected="" value="PNL-NPR">[PNL-NPR] GUDANG BAHAN PENOLONG NON-PRODUKSI</option>
												</select>
											</div>
											<input id="gudang_print" type="hidden" name="txt_gudang_print">
										</div>
										<div class="form-group" style="margin: 8 auto;">
											<label class="col-md-12 control-label">Locator</label>
											<div class="col-md-10">
												<div class="col-md-9" style="padding: 3px">
													<select style="width: 100%" id="p2k3_locator_hilangkanini" name="txt_locator" class="form-control p2k3_select2" data-placeholder="Pilih Locator" disabled="">
														<option selected="" value="783">UMUM</option>
													</select>
												</div>
											</div>
										</div>
										<table style="margin-top: 50px;" id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
											<!-- <caption style="color: #000;font-weight: bold;"><?php echo $seksi[0]['section_name']; ?></caption> -->
											<input hidden="" name="p2k3_seksi_bon" value="<?php echo $seksi[0]['section_name']; ?>">
											<caption style="color: #000;">Barang</caption>
											<thead>
												<tr class="bg-info">
													<th>No</th>
													<th>APD</th>
													<th>Jumlah Kebutuhan</th>
													<th>Total Bon Terakhir</th>
													<th>Jumlah Bon</th>
													<th>Sisa Saldo</th>
												</tr>
											</thead>
											<tbody id="DetailInputKebutuhanAPD">
												<?php $a=1; foreach ($listtobon as $key): ?>    
												<tr style="color: #000;" class="multiinput">
													<td id="nomor"><?php echo $a; ?></td>
													<td>
														<a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $key['item']; ?></a>
														<input hidden="" name="p2k3_apd[]" value="<?php echo $key['kode_item']; ?>">
														<input hidden="" name="p2k3_nama_apd[]" value="<?php echo $key['item']; ?>">
														<input hidden="" name="p2k3_satuan_apd[]" value="<?php echo $key['satuan']; ?>">
													</td>
													<td>
														<p><?php echo $key['jml_kebutuhan']; ?></p>
														<input class="p2k3_inKeb" hidden="" name="p2k3_jmlKebutuhan[]" value="<?php echo $key['jml_kebutuhan']; ?>">
													</td>
													<td>
														<?php echo $key['bon']; ?>
														<input class="p2k3_bont" hidden="" value="<?php echo $key['bon']; ?>">
													</td>
													<td>
														<input class="form-control p2k3_inBon" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
														type = "number"
														maxlength = "4" name="p2k3_jmlBon[]" required="" min="0">
													</td>
													<td>
														<p style="font-weight: bold;" class="p2k3_pHasil"></p>
														<input hidden="" type="text" class="p2k3_inHasil" name="p2k3_sisaSaldo[]" value="">
													</td>
												</tr>
												<?php $a++; endforeach ?>
											</tbody>
										</table>
										<input hidden="" name="p2k3_pr" value="<?php echo $pri; ?>">
										<input hidden="" name="p2k3_ks" value="<?php echo $ks; ?>">
										<div class="col-md-3 pull-right text-right">
											<button <?php if ($a == 1) {
												echo "disabled";
											}else{ echo ""; } ?> type="submit" class="btn btn-success btn-lg p2k3_btn_bon" onclick="return confirm('Apa anda yakin Akan Input Bon?')">Input</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
	<img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>

<div class="modal fade" id="p2k3_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Pop Up Tidak Aktif</label>
			</div>
			<div class="modal-body">
				<h3 style="font-weight: bold; text-align: center;">Cara mengaktifkan Pop-up</h3>
				<p style="color: red; text-align: center;">*(Refresh/Reload Halaman ini setelah Pop up di Aktifkan!)</p>
				<p style="text-align: center;">
					<strong>Cara pertama</strong>
				</p>
				<p style="text-align: center;">
					<img src="http://erp.quick.com/./assets/upload_kaizen/Screenshot_83.png" style="width: 559px;">
				</p>
				<p style="text-align: center;">
					<strong>Cara Kedua</strong>
				</p>
				<p style="text-align: center;">
					1. Clik pada bagian kiri atas browser dan pilih 
					<strong style="background-color: initial;">Site Setting</strong>
				</p>
				<p style="text-align: center;">
					<img src="http://erp.quick.com/./assets/upload_kaizen/Screenshot_81.png" style="width: 412px;">
				</p>
				<p style="text-align: center;">
					2. Ubah bagian Pop-up menjadi 
					<strong>Allow</strong>
				</p>
				<p style="text-align: center;">
					<img src="http://erp.quick.com/./assets/upload_kaizen/Screenshot_82.png">
				</p>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('tr.multiinput').each(function(){
			var gkeb = $(this).find('input.p2k3_inKeb').val();
			var gbon = $(this).find('input.p2k3_bont').val();
			var hit = Number(gkeb) - Number(gbon);
			$(this).find('input.p2k3_inHasil').val(hit);
			$(this).find('p.p2k3_pHasil').text(hit);
			if ($(this).find('input.p2k3_inHasil').val() < 0) {
				$(this).find('p.p2k3_pHasil').closest('td').css('background-color', '#da251d');
				$(this).find('p.p2k3_pHasil').closest('td').css('color', 'white');
			}else{
				$(this).find('p.p2k3_pHasil').closest('td').css('background-color', '');
				$(this).find('p.p2k3_pHasil').closest('td').css('color', 'black');
			}
		})

		$(".p2k3_inBon").bind("change paste keyup", function() {
			var keb = $(this).closest('tr').find('input.p2k3_inKeb').val();
			var bont = $(this).closest('tr').find('input.p2k3_bont').val();
			var bon = $(this).val();
			var cal = Number(keb) - Number(bont) - Number(bon);
			$(this).closest('tr').find('input.p2k3_inHasil').val(cal);
			$(this).closest('tr').find('p.p2k3_pHasil').text(cal);

			if ($(this).closest('tr').find('input.p2k3_inHasil').val() < 0) {
				$(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('background-color', '#da251d');
				$(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('color', 'white');
			}else{
				$(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('background-color', '');
				$(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('color', 'black');
			}
		});

		$('#surat-loading').attr('hidden', false);

		var value = 'Seksi';
		$.ajax({
			type:'POST',
			data:{pemakai_1:value},
			url:baseurl+'P2K3_V2/Order/searchOracle',
			success:function(result)
			{
				$("#pemakai_2").html(result);
				$('#surat-loading').attr('hidden', true);

			}
		});

		var jum = '<?php echo $a; ?>';
		if (jum == '1') {
			$('#pemakai_2').attr('disabled', true);
			// $('#p2k3_lokasi').attr('disabled', true);
			$('#surat-loading').attr('hidden', true);
		}
	});
	window.addEventListener('load', function () {
		erp_checkPopUp();
	});
</script>