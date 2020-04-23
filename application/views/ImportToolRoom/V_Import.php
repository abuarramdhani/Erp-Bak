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
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('ImportToolRoom/Import');?>">
                                    <i class="fa fa-2x fa-file-text-o">
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
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                    <br>
                                        <center>
                                            <table style="border: none;">
                                                <form method="post" target="_blank" class="import_excel" id="import_excel" enctype="multipart/form-data" action="<?php echo base_url('ImportToolRoom/Import/importsheet')?>">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


