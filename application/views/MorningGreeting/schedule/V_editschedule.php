<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Edit Schedule</h2>
	</div>
	<div class="box-body">
		<form method="post" id="editschedule" action="<?php echo base_url('MorningGreeting/schedule/editsave')?>">
		<table class="table">
		<?php foreach($search as $search_item){ ?>
		<input type="hidden" name="schedule_id" value="<?php echo $search_item['schedule_id']?>"></input>
			<tr>
				<td style="width:20%;">Schedule Description</td>
				<td style="width:80%;">
					<input placeholder="Schedule Description" class="form-control" name="schedule_description" value="<?php echo $search_item['schedule_description'] ?>" type="text" required>
					</input>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">Day</td>
				<td style="width:80%;">
					<select data-placeholder="Day" class="form-control select4" name="day" required>
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
						<?php
							$a='';$b='';$c='';$d='';$e='';$f='';$g='';
							
							if($search_item['day'] == 1){$a = 'selected';}
							else if($search_item['day'] == 2){$b = 'selected';}
							else if($search_item['day'] == 3){$c = 'selected';}
							else if($search_item['day'] == 4){$d = 'selected';}
							else if($search_item['day'] == 5){$e = 'selected';}
							else if($search_item['day'] == 6){$f = 'selected';}
							else if($search_item['day'] == 7){$g = 'selected';}
						?>
						<option <?php echo $a; ?> value="1">Senin</option>
						<option <?php echo $b; ?> value="2">Selasa</option>
						<option <?php echo $c; ?> value="3">Rabu</option>
						<option <?php echo $d; ?> value="4">Kamis</option>
						<option <?php echo $e; ?> value="5">Jumat</option>
						<option <?php echo $f; ?> value="6">Sabtu</option>
						<option <?php echo $g; ?> value="7">Minggu</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">Branch</td>
				<td style="width:80%;">
					<select data-placeholder="Branch" id="org_id" class="form-control select4" name ="org_id" required>
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
						<?php foreach ($data_branch as $data_branch_item){
							if($data_branch_item['org_id'] == $search_item['org_id'] ){			?>
								<option value="<?php echo $data_branch_item['org_id'];?>" selected >
									<?php echo $data_branch_item['org_name'];?>
								</option>
							<?php }else{		?>
								<option value="<?php echo $data_branch_item['org_id'];?>">
									<?php echo $data_branch_item['org_name']; ?>
								</option>
					<?php 	}
						}?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">Relation</td>
				<td style="width:80%;">
					<select data-placeholder="Relation" class="form-control select4" name ="relation_id" required>
						<option value="muach" disabled >-- PILIH SALAH SATU --</option>
							<?php foreach($data_relation as $dr){
								if($dr['relation_id'] == $search_item['relation_id'] ){			?>
									<option value="<?php echo $dr['relation_id'];?>" selected >
										<?php echo $dr['org_name'].'  -  '.$dr['relation_name'].'  -  '.$dr['regency_name']; ?>
									</option>
								<?php }else{		?>
									<option value="<?php echo $dr['relation_id'];?>">
										<?php echo $dr['org_name'].'  -  '.$dr['relation_name'].'  -  '.$dr['regency_name']; ?>
									</option>
						<?php 	}
							}	?>
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