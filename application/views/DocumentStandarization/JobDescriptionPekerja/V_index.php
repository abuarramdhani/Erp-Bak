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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/JobDescriptionPekerja');?>">
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
                                <a href="<?php echo site_url('DocumentStandarization/JobDescriptionPekerja/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-jobDescriptionPekerja" style="font-size:12px; overflow-x: auto; width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>Pekerja</th>
												<th>Hirarki</th>
                                                <th>Job Description</th>
                                                <th>Dokumen</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($JobDescriptionPekerja as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['kode_detail_jobdesc_pekerja']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/JobDescriptionPekerja/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php echo base_url('DocumentStandarization/JobDescriptionPekerja/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php echo base_url('DocumentStandarization/JobDescriptionPekerja/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
												<td>
                                                    <b><?php echo $row['nomor_induk_pekerja'];?></b>                                    
                                                    <?php echo $row['nama_pekerja'];?>
                                                </td>
												<td style="white-space: nowrap">
                                                    <ul>
                                                        <li>Departemen : <b><?php echo $row['nama_departemen'];?></b></li>
                                                        <li>Bidang : <b><?php echo $row['nama_bidang'];?></b></li>
                                                        <li>Unit : <b><?php echo $row['nama_unit'];?></b></li>
                                                        <li>Seksi : <b><?php echo $row['nama_seksi'];?></b></li>
                                                    </ul>
                                                </td>
                                                <td style="width: 10%;"><?php echo $row['job_description'];?></td>
                                                <td style="white-space: nowrap;">
                                                    <?php
                                                        foreach ($DocumentJobDescription as $dokumenJD) 
                                                        {
                                                            if($dokumenJD['kode_jobdesc']==$row['kode_jobdesc'])
                                                            {
                                                                            if($dokumenJD['file']==NULL)
                                                                                {                                                                                    echo '  <li>
                                                                                            '.$dokumenJD['nama_dokumen'].'
                                                                                        </li>';
                                                                            }
                                                                            else
                                                                            {
                                                                                echo '  <li>
                                                                                            <a href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen/').'/'.$dokumenJD['file'].'" target="_blank">
                                                                                                '.$dokumenJD['nama_dokumen'].'
                                                                                            </a>
                                                                                        </li>';
                                                                            }
                                                            }
                                                        }
                                                    ?>                                                    
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