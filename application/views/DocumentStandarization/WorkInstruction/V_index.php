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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/WI');?>">
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
                                <a href="<?php echo site_url('DocumentStandarization/WI/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-workInstruction" style="font-size:12px; overflow-x: auto; width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th style="white-space: nowrap;">Nama</th>
												<th style="white-space: nowrap;">Nomor Kontrol</th>
												<th style="white-space: nowrap;">Nomor Revisi</th>
												<th style="white-space: nowrap;">Tanggal</th>
												<th class="hidden">Dibuat</th>
												<th class="hidden">Diperiksa 1</th>
												<th class="hidden">Diperiksa 2</th>
												<th class="hidden">Diputuskan</th>
												<th class="hidden">Business Process</th>
												<th class="hidden">Context Diagram</th>
												<th class="hidden">Standard Operating Procedure</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($WorkInstruction as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['kode_work_instruction']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/WI/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/WI/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('DocumentStandarization/WI/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td style="white-space: nowrap;"><?php echo $row['nama_work_instruction'] ?></td>
												<td style="white-space: nowrap;"><?php echo $row['nomor_dokumen'] ?></td>
												<td style="white-space: nowrap;"><?php echo $row['nomor_revisi'] ?></td>
												<td style="white-space: nowrap;"><?php echo $row['tanggal_revisi'] ?></td>
												<td class="hidden"><?php echo $row['pekerja_pembuat'] ?></td>
												<td class="hidden"><?php echo $row['pekerja_pemeriksa_1'] ?></td>
												<td class="hidden"><?php echo $row['pekerja_pemeriksa_2'] ?></td>
												<td class="hidden"><?php echo $row['pekerja_pemberi_keputusan'] ?></td>
												<td class="hidden"><?php echo $row['nama_business_process'] ?></td>
												<td class="hidden"><?php echo $row['nama_context_diagram'] ?></td>
												<td class="hidden"><?php echo $row['nama_standard_operating_procedure'] ?></td>
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