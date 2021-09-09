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
                                    <i class="fa fa-list fa-2x">
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
                        <form method="post">
                            <div class="box box-warning">
                                <div class="box-header with-border"></div>
                                <div class="box-body" id="View_history_Rekap_Data_Ekspedisi_Express">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead class="bg-teal">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Ekspedisi</th>
                                                    <th class="text-center">Bulan</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($ekspedisi as $key => $eks) { ?>
                                                    <tr>
                                                        <td class="text-center"><?= $key + 1 ?></td>
                                                        <td class="text-center"><?= $eks['EKSPEDISI'] ?><input type="hidden" name="eks_name<?= $key + 1 ?>" value="<?= $eks['EKSPEDISI'] ?>"></td>

                                                        <td class="text-center"><?= $eks['BULAN'] ?><input type="hidden" name="eks_bulan<?= $key + 1 ?>" value="<?= $eks['ID_BULAN'] ?>"></td>
                                                        <td class="text-center"><button class="btn btn-success" formaction="<?= base_url('ReportEkspedisi/HistoryReport/ViewDataRekap/' . $no) ?>">View</button></td>
                                                    </tr>
                                                <?php $no++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>