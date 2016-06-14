<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Mengubah data Relation</h2>
	</div>
	<div class="box-body">
		<form method="post" id="editrelation" action="<?php echo base_url('MorningGreeting/relation/editsave')?>">
		<table class="table">
		<?php foreach($search as $search_item){ ?>
		<input type="hidden" name="relation_id" value="<?php echo $search_item['relation_id']?>"></input>
			<tr>
				<td>Relation Name</td>
				<td>
					<input class="form-control" name="relation_name" value="<?php echo $search_item['relation_name'] ?>" type="text" required>
					</input>
				</td>
			</tr>
			<tr>
				<td>NPWP</td>
				<td><input class="form-control" type="text" name="npwp" value="<?php echo $search_item['npwp'] ?>" required></input></td>
			</tr>
			<tr>
				<td>Oracle Cust ID</td>
				<td><input class="form-control" type="text" name="oracle_cust_id" value="<?php echo $search_item['oracle_cust_id'] ?>" required></input></td>
			</tr>
			<tr>
				<td>City</td>
				<td>
					<select class="form-control" name ="city_regency_id" required>
						<option value="" disabled> PILIH SALAH SATU </option>
							<?php foreach($data_city as $dc){ ?>
								<option value="<?php echo $dc['city_regency_id'];?>">
									<?php echo $dc['regency_name']; ?>
								</option>
							<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Branch</td>
				<td>
					<select id="org_id" class="form-control" name ="org_id" required>
						<option value="" disabled> PILIH SALAH SATU </option>
						<?php foreach ($data_branch as $data_branch_item){?>
						<option value="<?php echo $data_branch_item['org_id'];?>">
							<?php echo $data_branch_item['org_name']; ?>
							</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td>HP</td>
				<td>
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