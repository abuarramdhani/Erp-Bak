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
                                        <b>Nomor Memo</b>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <input type="text" class="form-control" placeholder="Masukan Nomor Memo" id="NomorMemoKoMisi"> -->
                                        <select id="NomorMemoKoMisi" class="form-control select2" data-placeholder="Pilih Nomor Memo">
                                            <option value=""></option>
                                            <?php foreach ($memo_num as $key => $memo) { ?>
                                                <option value="<?= $memo['PROGRAM_ID'] ?>"><?= $memo['MEMO_NUM'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success" id="BtnInvoiceMemoKoMisi" onclick="CreateInvoiceKomisi()">Create Invoice</button>
                                    </div>
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