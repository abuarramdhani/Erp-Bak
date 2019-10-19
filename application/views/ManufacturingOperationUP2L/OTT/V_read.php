<style>
    table {
        display: table;
        border-collapse: separate;
        border-spacing: 20px;
        border-color: gray;
        border-width: 0.5px;
    }

    .title {
        font-weight: bold;
    }
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/OTT'); ?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Read
                            </div>
                            <div class="box-body">
                                <div class="col-lg-12"> 
                                    <table>
                                        <tr>
                                            <td class="title">Nama</td>
                                            <td>: <?= $show[0]['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="title">Tanggal</td>
                                            <td>: <?= $show[0]['otttgl'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="title">Kode Cor</td>
                                            <td>: <?= $show[0]['kode_cor'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="title">Shift</td>
                                            <td>: <?= $show[0]['shift'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="title">Pekerjaan</td>
                                            <td>: <?= $show[0]['pekerjaan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="title">Kode Kelompok</td>
                                            <td>: <?= $show[0]['kode'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="title">Nilai OTT</td>
                                            <td>: <?= $show[0]['nil_ott'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer text-right">
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/OTT'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>