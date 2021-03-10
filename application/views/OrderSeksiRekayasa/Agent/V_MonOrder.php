<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#Order-Diterima" data-toggle="tab">Order Diterima</a></li>
                    <li><a href="#Menunggu-Diterima" data-toggle="tab">Menunggu Diterima</a></li>
                    <li><a href="#Belum-Otorisasi" data-toggle="tab">Belum Otorisasi</a></li>
                    <li class="active"><a href="#All-Order" data-toggle="tab">All Order</a></li>
                    <li class="pull-left header"><i class="fa fa-tag"></i>Monitoring Order</li>
                </ul>
                <div class="tab-content">
                    <?php 
                        $desc[0]['name'] = 'All Order';
                        $desc[0]['id_tab'] = 'All-Order';
                        $desc[0]['id_table'] = 'tblAllOrder';
                        $desc[0]['name_array'] = 'All_Order';
                        $desc[0]['bg_color'] = 'bg-info';
            
                        $desc[1]['name'] = 'Belum Otorisasi';
                        $desc[1]['id_tab'] = 'Belum-Otorisasi';
                        $desc[1]['id_table'] = 'tblBelumOtorisasi';
                        $desc[1]['name_array'] = 'Belum_Otorisasi';
                        $desc[1][ 'bg_color'] = 'bg-yellow';
            
                        $desc[2]['name'] = 'Menunggu Diterima';
                        $desc[2]['id_tab'] = 'Menunggu-Diterima';
                        $desc[2]['id_table'] = 'tblMenungguDiterima';
                        $desc[2]['name_array'] = 'Menunggu_Diterima';
                        $desc[2]['bg_color'] = 'bg-primary';
            
                        $desc[3]['name'] = 'Order Diterima';
                        $desc[3]['id_tab'] = 'Order-Diterima';
                        $desc[3]['id_table'] = 'tblOrderDiterima';
                        $desc[3]['name_array'] = 'Order_Diterima';
                        $desc[3]['bg_color'] = 'bg-green';
                    
                    for ($a=0; $a < 4; $a++) { ?>
                    <div class="tab-pane <?= $a == 0 ? 'active' : '' ?>" id="<?= $desc[$a]['id_tab'] ?>">
                        <div class="">
                            <table width="100%" class="table table-bordered table-fit tblOSROrder" id="<?= $desc[$a]['id_table'] ?>">
                                <thead>
                                    <tr class="<?= $desc[$a]['bg_color'] ?>">
                                        <th class="text-center" style="vertical-align: middle;" width="5%">No Order</th>
                                        <th class="text-center" style="vertical-align: middle;" width="15%">Nama Pengorder</th>
                                        <th class="text-center" style="vertical-align: middle;" width="25%">Seksi Pengorder</th>
                                        <th class="text-center" style="vertical-align: middle;" width="20%">Jenis Order</th>
                                        <th class="text-center" style="vertical-align: middle;" width="10%">Nama Alat/Mesin</th>
                                        <th class="text-center" style="vertical-align: middle;" width="10%">Tanggal Order</th>
                                        <th class="text-center" style="vertical-align: middle;" width="5%">Action</th>
                                        <th class="text-center" style="vertical-align: middle;" width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($$desc[$a]['name_array']): $no = 0; foreach ($$desc[$a]['name_array'] as $row): $no++
                                ?>
                                <tr>
                                    <td class="text-center"><?= $row['id_order']; ?></td>
                                    <td><?= $row['nama']; ?></td>
                                    <td><?= $row['seksi']; ?></td>
                                    <td><?= $row['jenis_order']; ?></td>
                                    <td><?= $row['nama_alat_mesin']; ?></td>
                                    <td class="text-center"><?= date("d M Y", strtotime($row['tanggal_order'])); ?></td>
                                    <td class="text-center">
                                        <!-- <a title="Cek Order.." class="btn btn-xs btn-danger" href="<?= base_url('AgentOrderSeksiRekayasa/MonOrder/emailAlert/'.$row['id_order']); ?>"><i class="fa fa-eye"></i></a> -->
                                        <a title="View Order.." class="btn btn-xs btn-success" href="<?= base_url('OrderSeksiRekayasa/View/'.$row['id_order']); ?>"><i class="fa fa-eye"></i></a>
                                        <a title="Export Pdf.." class="btn btn-xs  btn-info" href="<?= base_url('OrderSeksiRekayasa/Pdf/'.$row['id_order']); ?>"><i class="fa fa-download"></i></a>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == '0') { ?>
                                        <span class="label label-warning">Belum Upload Otorisasi</span>
                                        <?php } elseif ($row['status'] == '1') { ?>
                                        <button class="label label-primary btn-real-ena faa-flash faa-slow animated" onclick="terimaOrder('<?= $row['id_order']; ?>')">Terima Order<b class="fa fa-arrow-right"></b>&nbsp;</button>
                                        <?php } elseif ($row['status'] == '2') {?>
                                        <span class="label label-success">Order Diterima <b class="fa fa-check-circle"></b>&nbsp;</span>
                                        <?php } else {?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>