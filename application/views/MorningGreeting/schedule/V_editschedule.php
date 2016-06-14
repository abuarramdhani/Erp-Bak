<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Mengubah data Schedule</h2>
	</div>
	<div class="box-body">
		<form method="post" id="editschedule" action="<?php echo base_url('MorningGreeting/schedule/editsave')?>">
		<table class="table">
		<?php foreach($search as $search_item){ ?>
		<input type="hidden" name="schedule_id" value="<?php echo $search_item['schedule_id']?>"></input>
			<tr>
				<td>Alias</td>
				<td>
					<input class="form-control" name="schedule_description" value="<?php echo $search_item['schedule_description'] ?>" type="text" required>
					</input>
				</td>
			</tr>
			<tr>
				<td>Day</td>
				<td>
					<select class="form-control" name ="day" required>
						<option value="" disabled> PILIH SALAH SATU </option>
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
				<td>Relation</td>
				<td>
					<select class="form-control" name ="relation_id" required>
						<option value="" disabled> PILIH SALAH SATU </option>
							<?php foreach($data_relation as $dr){ ?>
								<option value="<?php echo $dr['relation_id'];?>">
									<?php echo $dr['relation_name']; ?>
								</option>
							<?php } ?>
					</select>
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