<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Menambahkan data Relation</h2>
	</div>
	<div class="box-body">
		<form method="post" action="<?php echo base_url('MorningGreeting/relation/new/save')?>">
		<table class="table">
			<tr>
				<td class="col-md-3">Relation Name</td>
				<td><input class="form-control" placeholder="Text..." type="text" name="relation_name" required></input></td>
			</tr>
			<tr>
				<td>NPWP</td>
				<td><input class="form-control" placeholder="Text..." type="text" name="npwp" required></input></td>
			</tr>
			<tr>
				<td>Oracle Cust ID</td>
				<td><input class="form-control" placeholder="Text..." type="text" name="oracle_cust_id" required></input></td>
			</tr>
			<tr>
				<td>City</td>
				<td>
					<select class="form-control" name ="city_regency_id" required>
						<option value="" disabled selected> PILIH SALAH SATU </option>
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
					<select class="form-control" name ="org_id" required>
						<option value="" disabled selected> PILIH SALAH SATU </option>
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
				<td><input class="form-control" placeholder="08xxxxxx,08xxxxxx,02xxxxxx" type="text" name="contact_number" required></input></td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<a class="btn btn-default" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back</a>
					<button class="btn btn-primary pull-right" type="submit">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ADD
					</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div class="box box-info"></div>
	</div>
</section>	