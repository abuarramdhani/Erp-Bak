<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Add New Relation</h2>
	</div>
	<div class="box-body">
		<form method="post" action="<?php echo base_url('MorningGreeting/relation/new/save')?>">
		<table class="table">
			<tr>
				<td class="col-md-3">Relation Name</td>
				<td><input class="form-control" placeholder="Relation Name.Example: Subur Makmur Jaya Abadi" type="text" name="relation_name" required></input></td>
			</tr>
			<tr>
				<td>NPWP</td>
				<td><input class="form-control" placeholder="NPWP.Example: 35.223.961.0-406.000‬" type="text" name="npwp" required></input></td>
			</tr>
			<tr>
				<td>Oracle Cust ID</td>
				<td><input onkeypress="return isNumberKey(event)" class="form-control" placeholder="Oracle Cust ID" type="text" name="oracle_cust_id" required></input></td>
			</tr>
			<tr>
				<td>Province</td>
				<td>
					<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4" required>
						<option value="" disabled selected>-- PILIH SALAH SATU --</option>
						<option value="muach" disabled>-- PILIH SALAH SATU --</option>
						<?php
						foreach($province as $ct){
						?>
							<option value="<?php echo $ct['province_id'];?>">
								<?php echo $ct['province_name'];?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>City / Regency</td>
				<td>
					<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4" disabled required>
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Branch</td>
				<td>
					<select data-placeholder="Branch"  class="form-control select4" name ="org_id" required>
						<option value="" disabled selected>-- PILIH SALAH SATU --</option>
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
							<?php foreach ($data_branch as $data_branch_item){?>
								<option value="<?php echo $data_branch_item['org_id'];?>">
									<?php echo $data_branch_item['org_name']; ?>
								</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Handphone</td>
				<td><input onkeypress="return isNumberKeyAndComma(event)" class="form-control" placeholder="08xxxxxx,08xxxxxx,02xxxxxx" type="text" name="contact_number" required></input></td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<a class="btn btn-default" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> BACK
					</a>
					<button class="btn btn-primary pull-right" type="submit">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> SAVE DATA
					</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div class="box box-info"></div>
	</div>
</section>	