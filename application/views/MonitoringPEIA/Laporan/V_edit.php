<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>EDIT LAPORAN</center></b></h3>
				<p class="help-block" style="text-align:center;">
				Hint! : Input with complete data on each form , except for the data marked with an asterisk * , can be not filled.
				</p>
			</div>
			<div class="box-body">
			<form method="post" action="<?php echo base_url('ProductionEngineering/Laporan/update')?>">
				<div class="row">
					<div class="col-md-4">
							<label>TANGGAL ORDER</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<input type="date" name="textDate" class="form-control" value="<?php echo $laporan[0]['tanggal']?>"required>
						</div>
					</div>
				</div>
				<div class="row">
				
					<div class="col-md-4">
							<label>SEKSI</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<select class="form-control" name="slcseksi">
							<option></option>
							<?php foreach  ($seksi as $sks) {
								 if($sks['seksi']==$laporan[0]['seksi']){
								 	$selected = 'selected';
								 }else{
								 	$selected = '';
								 } ?>
							<option <?php echo $selected?> > <?php echo $sks['seksi']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>NAMA</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<input type="text" name="textNama" class="form-control" value="<?php echo $laporan[0]['nama']?>"required>
						<input type="hidden" name="textId" class="form-control" value="<?php echo $laporan[0]['id']?>" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>ORDER</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" name="slcorder">
						<option></option>
							<?php foreach  ($order as $ord) {
								 if($ord['order_']==$laporan[0]['order_']){
								 	$selected = 'selected';
								 }else{
								 	$selected = '';
								 } ?>
							<option <?php echo $selected?> > <?php echo $ord['order_']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>JENIS ORDER</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" name="slcjenis">
						<option></option>
							<?php foreach  ($jenisOrder as $JO) {
								 if($JO['jenis_order']==$laporan[0]['jenis_order']){
								 	$selected = 'selected';
								 }else{
								 	$selected = '';
								 } ?>
							<option <?php echo $selected?> > <?php echo $JO['jenis_order']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>KETERANGAN</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<textarea name="textKeterangan" class="form-control" required><?php echo $laporan[0]['keterangan']?></textarea>
						</div>
					</div>
				</div>
				<div style="float:right">
				<a href="<?php echo base_url('ProductionEngineering/Laporan')?>" class="btn btn-danger">BACK</a>
				<button type ='submit'class="btn btn-success">SAVE</button>
			</div>
			</form>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>