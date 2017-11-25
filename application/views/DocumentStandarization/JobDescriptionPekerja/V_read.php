<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/JobdeskEmployee/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br />
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Jobdesk Employee</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($JobDescriptionPekerja as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Departemen</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_departemen']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Bidang</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_bidang']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Unit</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_unit']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Seksi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_seksi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Pekerja</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_induk_pekerja']; ?> - <?php echo $headerRow['nama_pekerja'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nama Job Description</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_job_description']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tugas Utama</strong></td>
                                                            <td style="border: 0"><?php echo $headerRow['job_description'];?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Dokumen</strong></td>
                                                            <td style="border: 0">
                                                                <ul>
                                                                    <?php
                                                                        foreach ($DocumentJobDescription as $dokumenJD) 
                                                                        {
                                                                            if($dokumenJD['kode_jobdesc']==$headerRow['kode_jobdesc'])
                                                                            {
                                                                                if($dokumenJD['file']==NULL)
                                                                                {
                                                                                    echo '  <li>
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
                                                                </ul>
                                                            </td>
                                                        </tr>

													<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
													</ul>
                                                    <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div align="right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>