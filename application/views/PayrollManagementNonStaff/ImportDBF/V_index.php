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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/Kondite');?>">
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
                                Import Data Target
                            </div>
                            <div class="box-body">
                                <div class="col-lg-8">
                                    <input placeholder="Choose File" class="form-control uploadFile" type="text" required readonly/>
                                </div>
                                <div class="col-lg-2">
                                    <div class="fileUpload btn btn-block btn-primary">
                                        <span>Browse</span>
                                        <input name="userfile" type="file" class="upload uploadBtn" accept=".xls,.xlsx,.png" required/>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-block btn-primary">Import</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Import Data Target
                            </div>
                            <div class="box-body">
                                <div class="col-lg-8">
                                    <input placeholder="Choose File" class="form-control uploadFile" type="text" required readonly/>
                                </div>
                                <div class="col-lg-2">
                                    <div class="fileUpload btn btn-block btn-primary">
                                        <span>Browse</span>
                                        <input name="userfile" type="file" class="upload uploadBtn" accept=".xls,.xlsx,.png" required/>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-block btn-primary">Import</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Import Data Target
                            </div>
                            <div class="box-body">
                                <div class="col-lg-8">
                                    <input placeholder="Choose File" class="form-control uploadFile" type="text" required readonly/>
                                </div>
                                <div class="col-lg-2">
                                    <div class="fileUpload btn btn-block btn-primary">
                                        <span>Browse</span>
                                        <input name="userfile" type="file" class="upload uploadBtn" accept=".xls,.xlsx,.png" multiple="" required/>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-block btn-primary">Import</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(".uploadBtn").change(function () {
                        var path = $(this)[0].files;
                        if (path.length > 1) {
                            $(this).closest('.row').find('.uploadFile').val(path.length + ' Files selected');
                        }
                        else{
                            for (var i = path.length - 1; i >= 0; i--) {
                                $(this).closest('.row').find('.uploadFile').val(path[i].name);
                            }
                        }
                    });
                </script>
            </div>    
        </div>
    </div>
</section>