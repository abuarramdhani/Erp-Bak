<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/DocumentJobDescription/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/DocumentJobDescription/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Update Jobdesk Document</div>
                                <?php
                                    foreach ($JobDescription as $headerRow):

                                        $kodesie            =   $headerRow['kodesie'];

                                        $kodeDepartemen     =   substr($headerRow['kodesie'], 0, 1);
                                        $namaDepartemen     =   $headerRow['nama_departemen'];
                                        $kodeBidang         =   substr($headerRow['kodesie'], 1, 2);
                                        $namaBidang         =   $headerRow['nama_bidang'];
                                        $kodeUnit           =   substr($headerRow['kodesie'], 3, 2);
                                        $namaUnit           =   $headerRow['nama_unit'];
                                        $kodeSeksi          =   substr($headerRow['kodesie'], 5, 2);
                                        $namaSeksi          =   $headerRow['nama_seksi'];

                                        $kodeDepartemenList =   $kodeDepartemen.'00000000';
                                        $kodeBidangList     =   $kodeDepartemen.$kodeBidang.'000000';
                                        $kodeUnitList       =   $kodeDepartemen.$kodeBidang.$kodeUnit.'0000';
                                        $kodeSeksiList      =   $kodeDepartemen.$kodeBidang.$kodeUnit.$kodeSeksi.'00';

                                        if($namaDepartemen=='-')
                                        {
                                            $kodeDepartemen =   NULL;
                                            $namaDepartemen =   NULL;
                                        }

                                        if($namaBidang=='-')
                                        {
                                            $kodeBidang     =   NULL;
                                            $namaBidang     =   NULL;
                                        }

                                        if($namaUnit=='-')
                                        {
                                            $kodeUnit       =   NULL;
                                            $namaUnit       =   NULL;
                                        }

                                        if($namaSeksi=='-')
                                        {
                                            $kodeSeksi      =   NULL;
                                            $namaSeksi      =   NULL;
                                        }
                                ?>                            
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Departemen</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbDepartemen-DocumentJobDesc" name="cmbDepartemen" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($ambilDepartemen as $Departemen) 
                                                            {
                                                                $status_data    =   '';
                                                                if(substr($Departemen['kode_departemen'], 0, 1)==$kodeDepartemen)
                                                                {
                                                                    $status_data    =   'selected';
                                                                }
                                                                echo '  <option value="'.$Departemen['kode_departemen'].'" '.$status_data.'>
                                                                            '.$Departemen['nama_departemen'].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Bidang</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbBidang-DocumentJobDesc" name="cmbBidang" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="<?php echo $kodeBidangList;?>" selected><?php echo $namaBidang;?></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Unit</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbUnit-DocumentJobDesc" name="cmbUnit" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="<?php echo $kodeUnitList;?>" selected><?php echo $namaUnit;?></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Seksi</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSeksi-DocumentJobDesc" name="cmbSeksi" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="<?php echo $kodeSeksiList;?>" selected><?php echo $namaSeksi;?></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbJD" class="control-label col-lg-4">Job Description</label>
                                                <div class="col-lg-4">
                                                    <select name="cmbJD" id="cmbJD" class="select2 form-control" required="" style="width: 100%">
                                                        <option value="<?php echo $headerRow['kode_jobdesc'];?>" selected=""><?php echo $headerRow['nama_jobdesc'];?></option>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#lines_ds_document_jobdesc" data-toggle="tab">Dokumen Job Description</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="lines_ds_document_jobdesc">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Daftar Dokumen Job Description</div>
                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table id="tblDokumenJobDescription" class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                            <thead>
                                                                                <tr class="bg-primary">
                                                                                    <th style="text-align:center; width:30px">No</th>
                                                                                    <th style="text-align:center;">Action</th>
                                                                                    <th style="text-align:center;">Dokumen</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DokumenJobDescription">
                                                                                <?php 
                                                                                    foreach ($DocumentJobDescription as $dokumenJD) 
                                                                                    {
                                                                                        $encrypted_string = $this->encrypt->encode($dokumenJD['kode_detail_dokumen']);        
                                                                                        $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);                                                                                        
                                                                                        echo '  <tr class="clone">
                                                                                                    <td style="text-align:center; width:30px"></td>
                                                                                                    <td align="center" width="60px">
                                                                                                        <a class="del-row btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Data" onclick="delSpesifikRowDokumenJobDescriptionCreate(this)"><span class="fa fa-times"></span></a>
                                                                                                        <input type="hidden" name="hdndetailDokumenJobDesc[]" value="'.$encrypted_string.'" class="form-control hdndetailDokumenJobDesc" id="hdndetailDokumenJobDesc" />
                                                                                                    </td>
                                                                                                    
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <div class="col-lg-12">
                                                                                                                <select class="select2 form-control cmbDokumenJobDescription" id="cmbDokumenJobDescription" name="cmbDokumenJobDescription[]">
                                                                                                                    <option value="'.$dokumenJD['kode_dokumen'].'">'.$dokumenJD['nama_dokumen'].'</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>';
                                                                                    }
                                                                                ?>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <a class="add-row btn btn-sm btn-success" onclick="TambahBarisDokumenJobDescription(base)"><i class="fa fa-plus"></i> Add New</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>