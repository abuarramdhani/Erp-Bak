<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Data Batch LPPB</b></span>
							<a href="<?php echo base_url('MonitoringLPPB/ListBatch/newLppbNumber');?>">
							<button type="button"  class="btn btn-lg btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i></button>
							</a>
						</div>
					</div>
					<div class="col-md-4" style="margin-bottom: 20px">
					  	<select id="id_gudang" name="id_gudang" onchange="getOptionGudang($(this))" class="form-control select2 select2-hidden-accessible" style="width:100%;">
							<!-- <option value="<?php echo $gudang[0]['SECTION_ID']?>"> <?php echo $gudang[0]['SECTION_NAME'] ?></option> -->
							<?php foreach ($gudang as $gd) { ?>
							<option value="<?php echo $gd['SECTION_ID'] ?>" ><?php echo $gd['SECTION_NAME'] ?></option>
							<?php } ?>
							<?php foreach ($gudang2 as $gd) { ?>
							<option value="<?php echo $gd['SECTION_ID'] ?>" ><?php echo $gd['SECTION_NAME'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<br />
				<div id="showOptionLppb">
					
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var id_gd = <?php echo $gudang[0]['SECTION_ID'] ?>;
</script>