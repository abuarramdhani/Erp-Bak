<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>EDIT TIPE</center></b></h3>
				<p class="help-block" style="text-align:center;">
				Hint! : Input with complete data on each form , except for the data marked with an asterisk * , can be not filled.
				</p>
			</div>
			<div class="box-body">
				<div class="row">
				<form method="post" action="<?php echo base_url('CBOPainting/Setup/Tipe/update')?>">
					<div class="col-md-4">
							<label>TIPE</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<input type="text" name="textTipe" class="form-control" value="<?php echo $tipe[0]['tipe']?>"required>
						<input type="hidden" name="textId" class="form-control" value="<?php echo $tipe[0]['id']?>" required>
						</div>
					</div>
				</div>
				<div style="float:right">
				<a href="<?php echo base_url('CBOPainting/Setup/Tipe')?>" class="btn btn-danger">BACK</a>
				<button type ='submit'class="btn btn-success">EDIT</button>
			</div>
			</form>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>