<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
<style>
.buttons-html5{
    display:none;
}
</style>
<section class="content">
	<div class="inner">
		<div class="box box-info box-solid">
			<div class="box-body">
				<h3><b><center>Export dan Upload File Min Max</center></b></h3>
				<br>
				<div class="panel-body">
					<div class="col-md-6 text-right">
						<button type="button" class="btn btn-success" id="exportminmaxstock"><i class="fa fa-download"></i> Export</button>
                        <a href="<?php echo base_url('StockGdSparepart/MinMaxStock/exportminmaxstock'); ?>" type="button" class="btn btn-success" id="export2" style="display:none"><i class="fa fa-download"></i> Export</a>
					</div>
					<div class="col-md-6 text-left">
						<button type="button" class="btn btn-info" id="importminmax" data-toggle="modal" data-target="#mdlminmax"><i class="fa fa-upload"></i> Import</button>
					</div>
				</div>

				<div class="panel-body">
                    <div class="table-responsive">
                        <table class="datatable table table-bordered table-hover table-striped myTable text-center" id="tblminmaxstock" style="width: 100%;">
                            <thead class="bg-info">
                            <tr>
                                <th style="width:10%">No</th>
                                <th style="width:10%" class="text-center check_semua">
                                    <span class='btn check_semua' style="background-color:inherit" id='check_semua'><i id="cekall" class="fa fa-square-o"></i></span>
                                    <input type="hidden" id="tandacek" value="cek">
                                </th>
                                <th>Item</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Uom</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; foreach ($data as $val) {?>
                                <tr class="haha">
                                    <td><?= $no?></td>
                                    <td></td>
                                    <td><input type="hidden" name="item[]" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                                    <td><input type="hidden" name="min[]" value="<?= $val['MIN']?>"><?= $val['MIN']?></td>
                                    <td><input type="hidden" name="max[]" value="<?= $val['MAX']?>"><?= $val['MAX']?></td>
                                    <td><input type="hidden" name="uom[]" value="<?= $val['UOM']?>"><?= $val['UOM']?></td>
                                </tr>
                            <?php $no++; }?>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="mdlminmax" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3><b><center>Upload File Min Max</center></b></h3>
        </div>
        <div class="modal-body">
			<center>
				<table style="border: none;">
					<form method="post" class="import_excel" id="import_excel" enctype="multipart/form-data" action="<?php echo base_url('StockGdSparepart/MinMaxStock/uploadminmax')?>">
					<tr>
						<td>
							<div class="col-md-1"> 
								<input type="file" name="excel_file" id="excel_file" accept=".csv, .xls,.xlsx" />
							</div>
						</td>
						<td>
							<div class="col-md-1">
								<button type="submit" title="upload" name="upload" class="btn button1 btn-success " id="import_excel_btn"> Upload</button>
							</div>
						</td>
					</tr>
					<tr>
					</tr>
					</form> 
				</table> 
			</center>
        </div>
      </div>
      
    </div>
</div>

<script type="text/javascript">

$(document).ready(function () {

    

    // var pilih = $('#tblminmaxstock').dataTable({
    //     dom: 'Bfrtip',
    //     columnDefs: [
    //     {
    //         orderable: false,
    //         className: 'select-checkbox',
    //         targets: 1,
    //     }
    //     ],
    //     buttons: [{
    //         extend: 'excel',
    //         title: 'Min Max Stock Gudang Sparepart',
    //         exportOptions: {
    //         columns: ':visible',
    //         // rows: ':visible',
    //         modifier: {
    //                 selected: true
    //         },
    //         columns: [0, 2, 3, 4, 5],

    //     }
    //     }        
    
    // ],
    // select: {
    //         style: 'multi',
    //         selector: 'td:nth-child(2)'
    // },
    //  order: [[0, 'asc']]
    // });


    // $('#check_semua').change(function(){
    //     console.log('hahahahaha');
    // //   if($(this).is(':checked')) {
    // //       // Checkbox is checked..
    // //       console.log('hai');
    // //       pilih.rows().select();
    // //   } else {
    // //       // Checkbox is not checked..
    // //       console.log('hai hai');
    // //       pilih.rows().deselect();
    // //   }
    // });
});

</script>