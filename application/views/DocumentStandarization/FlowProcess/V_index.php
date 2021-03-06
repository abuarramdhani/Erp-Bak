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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/FlowProcess');?>">
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
                                <a href="<?php echo site_url('DocumentStandarization/FlowProcess/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblFlowProcess" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Fp Name</th>
												<th>Fp File</th>
												<th>No Kontrol</th>
												<th>No Revisi</th>
												<th>Tanggal</th>
												<th>Dibuat</th>
												<th>Diperiksa 1</th>
												<th>Diperiksa 2</th>
												<th>Diputuskan</th>
												<th>Jml Halaman</th>
												<th>Fp Info</th>
												<th>Tgl Upload</th>
												<th>Tgl Insert</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($FlowProcess as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['fp_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/FlowProcess/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/FlowProcess/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('DocumentStandarization/FlowProcess/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td><?php echo $row['fp_name'] ?></td>
												<td><?php echo $row['fp_file'] ?></td>
												<td><?php echo $row['no_kontrol'] ?></td>
												<td><?php echo $row['no_revisi'] ?></td>
												<td><?php echo $row['tanggal'] ?></td>
												<td><?php echo $row['dibuat'] ?></td>
												<td><?php echo $row['diperiksa_1'] ?></td>
												<td><?php echo $row['diperiksa_2'] ?></td>
												<td><?php echo $row['diputuskan'] ?></td>
												<td><?php echo $row['jml_halaman'] ?></td>
												<td><?php echo $row['fp_info'] ?></td>
												<td><?php echo $row['tgl_upload'] ?></td>
												<td><?php echo $row['tgl_insert'] ?></td>
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