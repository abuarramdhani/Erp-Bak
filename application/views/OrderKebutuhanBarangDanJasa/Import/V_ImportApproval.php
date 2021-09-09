<section class="content-header">
    <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>
<section class="content">
    <div class="row">
        <form class="ImportApprovalOkbj" method="POST" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <div class="panel-body">
                            <div class="col-md-3" style="text-align: right;"><b>File Approval</b></div>
                            <div class="col-md-4">
                                <input type="file" class="form-control" name="FileApprovalOkebaja" accept=".xlsx,.xls">
                            </div>
                            <div class="col-md-3" style="text-align: left;">
                                <button type="submit" class="btn btn-success">Import Approval</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="TablHasilImportOkbj"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>