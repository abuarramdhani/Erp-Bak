<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>ADD KOMPONEN</center></b></h3>
				<p class="help-block" style="text-align:center;">
				Hint! : Input with complete data on each form , except for the data marked with an asterisk * , can be not filled.
				</p>
			</div>
			<div class="box-body">
				<div class="row">
				<form method="post" action="<?php echo base_url('CBOPainting/Setup/Komponen/Add')?>">
					<div class="col-md-4">
							<label>KOMPONEN</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<input type="text" name="textKomponen" class="form-control" required>
						</div>
					</div>
				</div>
				<div style="float:right">
				<a  class="btn btn-danger">BACK</a>
				<button type ='submit'class="btn btn-success">SAVE</button>
			</div>
			</form>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>