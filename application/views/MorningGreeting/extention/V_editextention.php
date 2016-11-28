<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2>Edit Branch Extention</h2>
	</div>
	<div class="box-body">
		<form method="post" id="newbranch" action="<?php echo base_url('MorningGreeting/extention/editsave')?>">
		<table class="table">
		<?php foreach($search as $search_item){ ?>
		<input type="hidden" name="branch_extention_id" value="<?php echo $search_item['branch_extention_id']?>"></input>
			<tr>
				<td style="width:20%;">Branch</td>
				<td style="width:80%;">
					<select data-placeholder="Branch"  id="org_id" class="form-control select4" name="org_id"  required>
						<option value="muach" disabled>-- PILIH SALAH SATU --</option>
						<?php foreach ($data_branch as $data_branch_item){
							if($data_branch_item['org_id'] == $search_item['org_id'] ){			?>
								<option value="<?php echo $data_branch_item['org_id'];?>" selected >
									<?php echo $data_branch_item['org_name'];?>
								</option>
							<?php }else{		?>
								<option value="<?php echo $data_branch_item['org_id'];?>">
									<?php echo $data_branch_item['org_name']; ?>
								</option>
					<?php	}
						}?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">Extention</td>
				<td style="width:80%;"><input onkeypress="return isNumberKey(event)" class="form-control" name="ext_number" value="<?php echo $search_item['ext_number']; ?>" type="text" required></td>
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
</section>