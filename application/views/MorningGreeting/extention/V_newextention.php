<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2 class="pull-left">Add New Extention</h2>
	</div>
	<div class="box-body">
		<form method="post" action="<?php echo base_url('MorningGreeting/extention/new/save')?>">
		<table class="table">
			<tr>
				<td style="width:20%;">Branch</td>
				<td style="width:80%;">
					<select data-placeholder="Branch" class="form-control select4" name ="org_id" required>
						<option value="" disabled selected>-- PILIH SALAH SATU --</option>
						<option value="muach" disabled>-- PILIH SALAH SATU --</option>
							<?php foreach ($data_branch as $data_branch_item){?>
								<option value="<?php echo $data_branch_item['org_id'];?>">
									<?php echo $data_branch_item['org_name']; ?>
								</option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width:20%;">Extention</td>
				<td style="width:80%;"><input onkeypress="return isNumberKey(event)" class="form-control" placeholder="Extention.Example: 12300,200,etc." type="text" name="ext_number" required></input></td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<a class="btn btn-default" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> BACK</a>
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
