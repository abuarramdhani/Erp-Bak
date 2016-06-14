<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4>Mengubah Data Configuration</h4>
		</div>
		<div class="box-body" style="padding-top:50px;">
		<form method="post" id="editConfig" action="<?php echo base_url('MorningGreeting/configuration/save')?>">
		<table class="table">
		<?php foreach($search as $search_item){ ?>
			<tr>
				<td>Parameter</td>
				<td><input class="form-control" name="parameter" value="<?php echo $search_item['parameter']; ?>" type="text"/></td>
			</tr>
			<tr>
				<td>Value</td>
				<td><input class="form-control" name="value" value="<?php echo $search_item['value']; ?>" type="text"/></td>
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
	</div>
</section>