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
                                <a class="btn btn-default btn-lg">
                                    <i class="fa  fa-file-text-o fa-2x">
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
                        <div class="box box-success">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-2" style="text-align: right;">
                                        <b>File</b>
                                    </div>
                                    <form class="frm_create_memo_komisi_penjualan">
                                        <div class="col-md-4">
                                            <input type="file" required class="form-control" accept=".xls,.xlsx" name="FileMemo">
                                        </div>
                                        <div class="col-md-2" style="text-align: center;">
                                            <button type="submit" class="btn btn-success btnCrtMemoKomisi">Create Memo</button>
                                        </div>
                                    </form>
                                    <form method="post" action="<?= base_url('KomisiPenjualanMarketing/CreateMemo/ExportFileExcel') ?>">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btnlayoutMemoKomisi">Download Layout</button>
                                        </div>
                                    </form>
                                    <div class="col-md-2 loadingMemoKomisi">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>