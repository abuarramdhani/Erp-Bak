<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/PrintPPCatering');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('CateringManagement/PrintPPCatering/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblPrintpp" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>No PP</th>
												<th>Tanggal Dibuat</th>
												<th>Kepada Sie Pembelian</th>
												<th>Jenis PP</th>
												<th>No Proposal</th>
												<th>Seksi Pemesan</th>
												<th>Branch</th>
												<th>Cost Center</th>
												<th>Barang Untuk</th>
												<th>Sub Inventory</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($Printpp as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['pp_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                    <a style="margin-right:4px" href="<?php echo base_url('CateringManagement/PrintPPCatering/export_data_load/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Export Data Load"><span class="fa fa-file-excel-o fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('CateringManagement/PrintPPCatering/cetakPDF/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Cetak Data" ><span class="fa fa-print fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('CateringManagement/PrintPPCatering/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('CateringManagement/PrintPPCatering/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['no_pp'] ?></td>
												<td><?php echo date('d M Y',strtotime($row['tgl_buat'])) ?></td>
												<td><?php if($row['pp_kepada']==1) {
															echo "SUPPLIER";
														}else{
															echo "SUBKONTRAKTOR";}?></td>
												<td><?php if($row['pp_jenis']==1) {
															echo "ASET";
														}else{
															echo "NON ASET";}?></td>
												<td><?php echo $row['pp_no_proposal'] ?></td>
												<td><?php foreach($Section as $seksi) {
														if($row['pp_seksi_pemesan'] == $seksi['er_section_id'])  {
															echo $seksi['section_name'];
														}}?></td>
												<td><?php foreach ($Branch as $cab ) {
														if ($row['pp_branch'] == $cab['branch_id']) {
															echo $cab['branch_code'];
														}} ?></td>
												<td><?php foreach ($CostCenter as $coser) {
														if ($row['pp_cost_center'] == $coser['cc_id']) {
															echo $coser['cc_code'];
														}} ?></td>
												<td><?php if($row['pp_kat_barang']==1) {
															echo "PRODUKSI";
														}else{
															echo "NON PRODUKSI";}?></td>
												<td><?php echo $row['pp_sub_invent'] ?></td>
											</tr>
                                            <?php endforeach; ?>
                                        </tbody>                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>