<style type="text/css">
    .dataTable_Button {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-bottom: 2px;
    }
    .dataTable_Filter {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-bottom: 2px;
    }
    .dataTable_Information {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-top: 7px;
    }
    .dataTable_Pagination {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-top: 14px;
    }
    .dataTable_Processing {
        z-index: 999;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title;?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?= site_url('MasterPekerja/Surat/BAPSP3');?>">
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
                                <a href="<?= site_url('MasterPekerja/Surat/BAPSP3/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-responsive" id="tbl" style="width:100%; font-size:12px; overflow-x: scroll;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center; min-width: 80px;">Action</th>
                                                <th style="text-align:center;">Nomor Induk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Jabatan</th>
                                                <th style="text-align:center;">Departemen / Bidang / Unit / Seksi</th>
                                                <th style="text-align:center;">Tanggal Cetak</th>
                                                <th style="text-align:center;">Cetak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($view as $surat) : $parameter = $this->general->enkripsi($surat['bap_id']);
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?= $no++.'.' ?></td>
                                                <td style="text-align: center;">
                                                    <a target="_blank" style="margin-right:4px" href="<?= base_url('MasterPekerja/Surat/BAPSP3/previewcetak/'.$parameter.''); ?>" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?= base_url('MasterPekerja/Surat/BAPSP3/update/'.$parameter.''); ?>" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?= base_url('MasterPekerja/Surat/BAPSP3/delete/'.$parameter.''); ?>" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?= $surat['noind'];?></td>
                                                <td><?= $surat['employee_name'];?></td>
                                                <td><?= $surat['pekerjaan_jabatan'];?></td>
                                                <td><?= $surat['section'];?></td>
                                                <td style="text-align: center;"><?= $surat['tgl'];?></td>
                                                <td style="text-align: center;">-</td>
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