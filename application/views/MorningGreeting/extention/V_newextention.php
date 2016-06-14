<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div class="box-header with-border">
		<h2 class="pull-left">Menambah Data Baru</h2>
	</div>
	<div class="box-body">
		<form method="post" action="<?php echo base_url('MorningGreeting/extention/new/save')?>">
		<table class="table">
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
				<td>Ext</td>
				<td><input class="form-control" placeholder="Text..." type="text" name="ext_number" required></input></td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<a class="btn btn-default" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Back</a>
					<a class="btn btn-primary pull-right" type="submit">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
					</a>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div class="box box-info"></div>
	</div>
</section>
