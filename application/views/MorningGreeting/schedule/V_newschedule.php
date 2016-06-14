<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Menambahkan data Schedule</h2>
	</div>
	<div class="box-body">
		<form method="post" action="<?php echo base_url('MorningGreeting/schedule/new/save')?>">
		<table class="table">
			<tr>
				<td class="col-md-3">Schedule Description</td>
				<td><input class="form-control" placeholder="Text..." type="text" name="schedule_description" required></input></td>
			</tr>
			<tr>
				<td>Day</td>
				<td>
					<select class="form-control" name ="day" required>
						<option value="" disabled selected> PILIH SALAH SATU </option>
						<option value="1">Senin</option>
						<option value="2">Selasa</option>
						<option value="3">Rabu</option>
						<option value="4">Kamis</option>
						<option value="5">Jumat</option>
						<option value="6">Sabtu</option>
						<option value="7">Minggu</option>
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
				<td>Relation</td>
				<td>
					<select class="form-control" name ="relation_id" required>
						<option value="" disabled selected> PILIH SALAH SATU </option>
							<?php foreach($data_relation as $dr){ ?>
								<option value="<?php echo $dr['relation_id'];?>">
									<?php echo $dr['relation_name']; ?>
								</option>
							<?php } ?>
					</select>
				</td>
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
	</div>
</section>