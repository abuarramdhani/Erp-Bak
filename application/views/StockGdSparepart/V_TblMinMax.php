<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('#myTable').dataTable({
                "scrollX": true,
                "paging" : false, 
                "scrollY": 500,
            });
         });
    </script>

<section class="content">
	<div class="inner">
		<div class="box box-info box-solid">
			<div class="box-body">
				<div class="panel-body">
                    <div class="table-responsive">
                        <table class="datatable table table-bordered table-hover table-striped myTable text-center" id="myTable" style="width: 100%;">
                            <thead class="bg-info">
                            <tr>
                                <th style="width:10%">No</th>
                                <th>Item</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Uom</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; foreach ($import as $val) {?>
                                <tr>
                                    <td><?= $no?></td>
                                    <td><input type="hidden" name="item[]" value="<?= $val['item']?>"><?= $val['item']?></td>
                                    <td><input type="hidden" name="min[]" value="<?= $val['min']?>"><?= $val['min']?></td>
                                    <td><input type="hidden" name="max[]" value="<?= $val['max']?>"><?= $val['max']?></td>
                                    <td><input type="hidden" name="uom[]" value="<?= $val['uom']?>"><?= $val['uom']?></td>
                                </tr>
                            <?php $no++; }?>
                            </tbody>
                        </table>
                    </div>
				</div>
                <div class="panel-body text-center">
                    <button type="button" class="btn btn-lg btn-primary" onclick="saveminmax(this)">Save</button>
                </div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="mdlloading" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="padding-top:200px;width:20%">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
				<!-- <h3 class="modal-title" style="text-align:center;"><b>Konfirmasi Penerimaan Komponen</b></h3> -->
			</div>
			<div class="modal-body">
            <h3 class="modal-title" style="text-align:center;"><b>Mohon Tunggu Sebentar...</b></h3>
		    </div>
		</div>
	</div>
</div>