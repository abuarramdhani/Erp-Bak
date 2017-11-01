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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/DocumentJobDescription');?>">
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
                                <a href="<?php echo site_url('DocumentStandarization/DocumentJobDescription/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-documentJobDescription" style="font-size:12px; overflow-x: auto; width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Hirarki</th>
												<th>Job Description</th>
												<th>Dokumen Job Description</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($JobDescription as $JD):
                                            	$encrypted_string = $this->encrypt->encode($JD['kode_jobdesc']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/DocumentJobDescription/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/DocumentJobDescription/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('DocumentStandarization/DocumentJobDescription/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td style="white-space: nowrap;">
                                                    <ul>
                                                        <li>Departemen : <b><?php echo $JD['departemen'];?></b></li>
                                                        <li>Bidang : <b><?php echo $JD['bidang'];?></b></li>
                                                        <li>Unit : <b><?php echo $JD['unit'];?></b></li>
                                                        <li>Seksi : <b><?php echo $JD['seksi'];?></b></li>
                                                    </ul>
                                                </td>
												<td><?php echo $JD['nama_jobdesc'] ?></td>
												<td>
                                                    <ul>
                                                        <?php
                                                            foreach ($DocumentJobDescription as $dokumenJD) 
                                                            {
                                                                if($dokumenJD['kode_jobdesc']==$JD['kode_jobdesc'])
                                                                {
                                                                    echo '  <li>
                                                                                <a href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen/').'/'.$row['file'].'" target="_blank">
                                                                                    '.$dokumenJD['nama_dokumen'].'
                                                                                </a>
                                                                            </li>';
                                                                }
                                                            }
                                                        ?>
                                                    </ul>
                                                </td>
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