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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('TicketingMaintenance/Agent/OrderList'); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>Order #0001 (Open)</b>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="datatable table table-striped table-bordered table-hover text-left" id="tblOrderListAgent" style="">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center">No Order</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Tanggal Order</th>
                                                    <th class="text-center">Nama Mesin</th>
                                                    <th class="text-center">Kerusakan</th>
                                                    <th class="text-center">Last Response</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <form action="" method="post">
                                            <tbody>
                                            <?php foreach ($orderList as $nganggur) { ?>
                                                <tr>
                                                    <td class="text-center"><?= $nganggur['no_order']?></td>
                                                    <td><?= "-"?></td>
                                                    <td><?= $nganggur['tgl_order']?></td>
                                                    <td><?= $nganggur['nama_mesin']?></td>
                                                    <td><?= $nganggur['kerusakan']?></td>
                                                    <td><?= "embuh kapan"?></td>
                                                    <td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            </form>
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