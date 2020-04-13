<style>
    .table-sm td,
    .table-sm th{padding:.1rem}
    td.details-control {
        background: url('../../assets/img/icon/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../../assets/img/icon/details_close.png') no-repeat center center;
    }
    div.slider {
        display: none;
    }

    table.dataTable tbody td.no-padding {
        padding: 0;
    }
    #p2k3_img{
        transition: transform 0.8s;
    }
    #p2k3_img:hover{
     transform: rotate(180deg);
 }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Monitoring Stok</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover table-striped p2k3_tblstok">
                                            <thead class="bg-primary">
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>APD</th>
                                                <th>Jumlah Stok</th>
                                                <th>Satuan</th>
                                            </thead>
                                            <tbody>
                                                <?php $x=1; foreach ($stok as $key): ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td>
                                                        <a style="cursor:pointer;" class="p2k3_to_input"><?= $key['ITEM_CODE'] ?></a>
                                                        <input hidden="" value="<?= $key['ITEM_CODE'] ?>" class="p2k3_see_apd">
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $key['DESCRIPTION']; ?></a>
                                                        <input hidden="" class="p2k3_item" type="text" value="<?php echo $key['DESCRIPTION']; ?>">
                                                    </td>
                                                    <td><?= $key['STOCK'] ?></td>
                                                    <td><?= $key['UOM'] ?></td>
                                                </tr>
                                                <?php $x++; endforeach ?>
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
    </div>
</section>