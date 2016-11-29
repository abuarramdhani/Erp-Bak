<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Edit Relation</h2>
	</div>
	<div class="box-body">
		<form method="post" id="editrelation" action="<?php echo base_url('MorningGreeting/relation/editsave')?>">
		<table class="table">
		<?php foreach($search as $search_item){ ?>
		<input type="hidden" name="relation_id" value="<?php echo $search_item['relation_id']?>"></input>
			<tr>
				<td style="width:20%;">Relation Name</td>
				<td style="width:80%;">
					<input class="form-control" name="relation_name" value="<?php echo $search_item['relation_name'] ?>" type="text" required>
					</input>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">NPWP</td>
				<td style="width:80%;"><input class="form-control" type="text" name="npwp" value="<?php echo $search_item['npwp'] ?>" required></input></td>
			</tr>
			<tr>
				<td style="width:20%;">Oracle Cust ID</td>
				<td style="width:80%;"><input class="form-control" type="number" name="oracle_cust_id" value="<?php echo $search_item['oracle_cust_id'] ?>" required></input></td>
			</tr>

			

			<tr>
				<td style="width:20%;">Province</td>
				<td style="width:80%;">
					<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4" required>
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
						<?php
						foreach($province as $ct){
							if($ct['province_id'] == $search_item['province_id']){ ?>
								<option selected value="<?php echo $ct['province_id'];?>">
									<?php echo $ct['province_name']; ?>
								</option>
							<?php
							}else{
							?>
								<option value="<?php echo $ct['province_id'];?>" >
									<?php echo $ct['province_name']; ?>
								</option>
							<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">City / Regency</td>
				<td style="width:80%;">
					<select  class="form-control select4" required data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')">
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
						<?php
						foreach($data_city as $dc){
							if($dc['city_regency_id'] == $search_item['city'] ){
							?>
							<option value="<?php echo $dc['city_regency_id'];?>" selected >
								<?php echo $dc['regency_name'];?>
							</option>
							<?php
							}else{
							?>
							<option value="<?php echo $dc['city_regency_id'];?>">
								<?php echo $dc['regency_name'];?>
							</option>
							<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">Branch</td>
				<td style="width:80%;">
					<select data-placeholder="Branch"  id="org_id" class="form-control" name ="org_id" required>
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
				<td style="width:20%;">HP</td>
				<td style="width:80%;">
					<input class="form-control" value="<?php foreach($search_cn as $scn){ echo $scn['contact_number'].', '; }?>" type="text" name="contact_number" required>
					</input>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td>
				</td>
				<td>
					<a class="btn btn-default" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Back</a>
					<input class="btn btn-primary" type="submit" style="float:right" value="Save"/>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div class="box box-info"></div>
	</div>
	</div>
</section>