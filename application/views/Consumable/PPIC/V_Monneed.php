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
                <!-- <form name="Orderform" action="<?php echo base_url('ConsumableSEKSI/Inputkebutuhan/'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-1"><label>Seksi</label></div>
                                        <div class="col-md-4"><select class="form-control select2" id="pilhseksi">
                                                <option value="Semua Seksi">Semua Seksi</option>
                                                <?php foreach ($seksi as $key => $sie) { ?>
                                                    <option value="<?= $sie['kodesie'] ?>"><?= $sie['seksi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2"><button class="btn btn-default" onclick="monneed()">Lihat</button></div>
                                    </div>
                                </div>
                                <div class="panel-body" id="monitoringkebutuhann"></div>
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
</section>