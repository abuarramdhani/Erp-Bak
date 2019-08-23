<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CetakStikerCC/Cetak/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Add Data</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-6" style="float:none; margin: 0 auto">
                                        <center><label class="control-label">Input Cost Center</label></center>
                                        <select class="form-control select2" multiple
                                            data-placeholder="Nomor Cost Center" id="search_cc" name="search_cc">
                                        </select><br /><br>
                                    </div>
                                    <div class="col-md-6 import" style="float:none; margin: 0 auto">
                                        <center><label>OR</label></center>
                                    </div>
                                    <br>
                                    <div class="col-md-12 import">
                                        <center>
                                            <table style="border: none;">
                                                <form method="post" class="import_excel" id="import_excel"
                                                    enctype="multipart/form-data"
                                                    action="<?= base_url(); ?>CetakStikerCC/Cetak/Import">
                                                    <tr>
                                                        <td class="btn-default" style="padding-left: none;width: 10px" >
                                                            <div class="col-md-1"  >
                                                                <input type="file" name="excel_file" id="excel_file"
                                                                    accept=".csv, .xls,.xlsx" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-1">
                                                                <button type="submit" title="Import Excel"
                                                                    name="import_excel" class="btn button1 btn-success "
                                                                    id="import_excel_btn"> Import Excel</button>
                                                            </div>
                                                        </td>
                                                </form>
                                                <td>
                                                    <div class="col-md-1">
                                                        <a href="<?php echo site_url('CetakStikerCC/Cetak/Export');?>">
                                                            <button type="submit" title="Download Layout"
                                                                name="download" class="btn button1 btn-primary "
                                                                id="download_btn"> Download Contoh Layout</button>
                                                        </a>
                                                    </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                                </div>


                                <form name="Orderform" class="form-horizontal" target="_blank"
                                    onsubmit="return validasi();window.location.reload();"
                                    action="<?php echo base_url('CetakStikerCC/Cetak/Report'); ?>" method="post">
                                    <table class="table table-striped table-bordered table-hover text-left saveall"
                                        style="font-size:12px;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>
                                                    <center>No</center>
                                                </th>
                                                <th>
                                                    <center>Cost Center</center>
                                                </th>
                                                <th>
                                                    <center>Seksi dan NO Mesin</center>
                                                </th>
                                                <th>
                                                    <center>Tag Number</center>
                                                </th>
                                                <th>
                                                    <center>Kode Resource</center>
                                                </th>
                                                <th>
                                                    <center>Deskripsi</center>
                                                </th>
                                                <th>
                                                    <center>Tanggal Update</center>
                                                </th>
                                                <th>
                                                    <center>Action</center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="body-cc">
                                        </tbody>
                                    </table>
                                    <br>
                                    <div style="float:none; margin: 0 auto" class="col-md-2 saveall">
                                        <center><button class="btn btn-success" onclick="" title="Create Stiker"> Create
                                                Stiker </button></center>
                                    </div>
                                </form>
                            </div>
                            <!--                 <div class="row">
                    <div class="panel-body">
                        <div class="col-md-12" id="ResultImport" ></div>
                    </div>
                </div> -->
                        </div>
                    </div>
                </div>
</section>