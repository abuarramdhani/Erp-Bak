<style type="text/css">
	.capitalize{
    text-transform: uppercase;
		}
</style>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-left">
						<h1><b>Setup Organizations</b></h1>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<br />
							<table class="table" style="width:100%">
								<tr>
									<td><span><label>Provinsi</label></span></td>
									<td>
										<select required id="slcProvinsi2" class="form-control select4" style="width:300px" onchange="province_filter2(this)" name="slcProvinsi2" class="form-control">
										<option value="" ></option>
																		<?php foreach ($province as $k) { 
																		$s='';
																	    if ($k['province_id']==$list[0]['province_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['province_id'] ?>" <?= $s?>><?php echo $k['province_name'] ?></option>
																		<?php } ?>
										</select>
									</td>
									<td><span><label>Organization Code</label></span></td>
									<td>
										<input required placeholder="Masukkan Organization Code" type="text" class="form-control capitalize" name="txtOrgID2" id="org_code2" value="<?php echo $list[0]['org_code']?>" style="width: 300px;">
									</td>
								</tr>

								<tr>
									<td><span><label>Kota/Kabupaten</label></span></td>
									<td>
										<select disabled required id="slcKotaKab2" style="width:300px" class="form-control select4" onchange="kotakab_filter2(this)" name="slcKotaKab2" class="form-control">
										<option value="<?php echo $list[0]['city_regency_id'] ?>"><?php echo $list[0]['regency_name'] ?></option>
										
										</select>
									</td>

									<td><span><label>Organization ID</label></span></td>
									<td>
										<input required placeholder="Masukkan Organization ID" type="text" class="form-control capitalize" name="txtOrgID2" id="org_id2"  value="<?php echo $list[0]['org_id']?>" style="width: 300px;">
									</td>
								</tr>

								<tr>
									<td><span><label>Kecamatan</label></span></td>
									<td>
										<select disabled required id="slcKecamatan2" style="width:300px" class="form-control select4" onchange="district_filterr2(this)" name="slcKecamatan2" class="form-control">
										<option value="<?php echo $list[0]['district_id'] ?>"><?php echo $list[0]['district_name'] ?></option>
										
										</select>
									</td>
									<td><span><label>Organization Name</label></span></td>
									<td>
										<input required placeholder="Masukkan Organization Name" type="text" class="form-control capitalize" name="txtOrgID2" id="org_name2"  value="<?php echo $list[0]['org_name']?>" style="width: 300px;">
									</td>
								</tr>

								<tr>
									<td><span><label>Kelurahan/Desa</label></span></td>
									<td>
										<select disabled required style="width:300px" id="slcKelurahanDesa2" class="form-control select4" name="slcKelurahanDesa2" class="form-control">
										<option value="<?php echo $list[0]['village_id'] ?>"><?php echo $list[0]['village_name'] ?></option>
										
										</select>
									</td>

									<td><span><label>Alamat</label></span></td>
									<td>
										<textarea required placeholder="Masukkan Alamat" class="form-control" id="alamat_id2" name="txaAlamat2" style="width:300px"><?php echo $list[0]['address']?></textarea>
									</td>

									<td><button type="button" onclick="updateSetupOrganizations(this)" class="btn btn-m btn-success" id="btnsubmit2" style="width:100px;margin-top:22px;"><i class="fa fa-check"></i> Update</td>
								</tr>
							</table>
							<br/>
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

	function province_filter2(th) {

		var prov = $('#slcProvinsi2').val()
		var city = jQuery('select[name=slcKotaKab2]')

		console.log(prov)

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/filterCity2",
			dataType: 'JSON',
			data:{
					prov:prov,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.city_regency_id+'">'+item.regency_name+'</option>'
					val1 = item.regency_name
				})	

				city.html(dataItem1);
				city.val(response[0].city_regency_id);
				city.trigger('change')

				$('#slcKotaKab2').prop('disabled', false);
				$('#slcKecamatan2').prop('disabled', false);
				$('#slcKelurahanDesa2').prop('disabled', false);

			}
		})
	}

	function kotakab_filter2(th) {
		var city = $('#slcKotaKab2').val();
		var kecamatan = jQuery('select[name=slcKecamatan2]');

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/filterDistrict2",
			dataType: 'JSON',
			data:{
					city:city,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.district_id+'">'+item.district_name+'</option>'
					val1 = item.district_name
				})	

				kecamatan.html(dataItem1);
				kecamatan.val(response[0].district_id);
				kecamatan.trigger('change')

			}
		})
	}

	function district_filterr2(th) {
		var kcmtn = $('#slcKecamatan2').val();
		var desa = $('#slcKelurahanDesa2');

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/filterVillage2",
			dataType: 'JSON',
			data:{
					kcmtn:kcmtn,
				},
			success: function(response) {
				var dataItem1 = '';
				var val1 = '';
			$.each(response, (i, item) => {
					dataItem1 += '<option value="'+item.village_id+'">'+item.village_name+'</option>'
					val1 = item.village_name
				})	

				desa.html(dataItem1);
				desa.val(response[0].village_id);
				desa.trigger('change')

			}
		})

	}

	function updateSetupOrganizations(th) {

		var province = $('#slcProvinsi2').val() ;
		var city = $('#slcKotaKab2').val();
		var kecamatan = $('#slcKecamatan2').val();
		var kelurahan = $('#slcKelurahanDesa2').val();
		var org_code = $('#org_code2').val();
		var org_id = $('#org_id2').val();
		var org_name = $('#org_name2').val();
		var alamat = $('#alamat_id2').val();

		$.ajax({
			method: "POST",
			url: baseurl+"SalesMonitoring/setting_org/updateSetupOrg",
			data:{
					province:province,
					city:city,
					kecamatan:kecamatan,
					kelurahan:kelurahan,
					org_code:org_code,
					org_id:org_id,
					org_name:org_name,
					alamat:alamat,
				},
			success: function(response) {
						Swal.fire({
								  type: 'success',
								  title: 'Yeay! data sudah diedit',
								  showConfirmButton: false,
								  timer: 1000
							})
					$('#mdlOrgSM').modal('hide');
					window.location.reload()

				}
			})
	}
</script>