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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('TicketingMaintenance/Seksi/MyOrder'); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                
                <div class="row">
                <form enctype="multipart/form-data" autocomplete="off" action="<?php echo site_url('TicketingMaintenance/Seksi/MyOrder/search'); ?>" method="post">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Status Order</option>
                                <option value="">Open</option>
                                <option value="ACC">ACC</option>
                                <option value="Reviewed">Reviewed</option>
                                <option value="Action">Action</option>
                                <option value="Overdue">Overdue</option>
                                <option value="Done">Done</option>
                            </select>
                        </div> &nbsp; &nbsp;
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="text" name="tanggal_awal" class="form-control time-form1 ajaxOnChange" placeholder="Tanggal Awal" id="tanggal_awal" required>
                        </div> &nbsp; &nbsp;
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="text" name="tanggal_akhir" class="form-control time-form1 ajaxOnChange" placeholder="Tanggal Akhir" id="tanggal_akhir" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>  Search</button>
                    </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>My Order</b>
                            </div>
                            <div class="box-body">
                                <div class="col-lg-12">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblOrderList" style="">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">Nomor Order</th>
                                                <th style="text-align:center;">Status</th>
                                                <th style="text-align:center;">Tanggal Order</th>
                                                <th style="text-align:center;">Nama Mesin</th>
                                                <th style="text-align:center;">Kerusakan</th>
                                                <th style="text-align:center;">Last Response</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order as $diGarap) {  
                                                $tanggal_order = substr($diGarap['tgl_order'],0,10);
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $diGarap['no_order']?></td>
                                                <td><?= '-' ?></td>
                                                <td><?= $tanggal_order?></td>
                                                <td><?= $diGarap['nama_mesin']?></td>
                                                <td><?= $diGarap['kerusakan']?></td>
                                                <td><?= '-'?></td>
                                                <td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $diGarap['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
                                            </tr>
                                            <?php } ?>
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
</section>