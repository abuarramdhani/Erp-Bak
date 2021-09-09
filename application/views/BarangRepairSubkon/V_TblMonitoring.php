<div class="panel-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#Open" data-toggle="tab">Kasus Repair Open</a></li>
            <li><a href="#Closed" data-toggle="tab">Kasus Repair Closed</a></li>
        </ul>
        <div class="tab-content">
            <?php 
                $status[0]['name'] = 'Open';
                $status[0]['id_tab'] = 'Open';
                $status[0]['id_table'] = 'Open';
                $status[0]['name_array'] = 'open';
                $status[0]['bg_color'] = 'bg-danger';

                $status[1]['name'] = 'Closed';
                $status[1]['id_tab'] = 'Closed';
                $status[1]['id_table'] = 'Closed';
                $status[1]['name_array'] = 'closed';
                $status[1]['bg_color'] = 'bg-success';
            for ($a=0; $a < 2; $a++) { ?>
                <div class="tab-pane <?= $a == 0 ? 'active' : '' ?>" id="<?= $status[$a]['id_tab'] ?>">
                    <table width="100%" class="datatable table table-bordered table-fit tblMonBrgRepair" id="<?= $status[$a]['id_table'] ?>">
                        <thead>
                            <tr class="<?= $status[$a]['bg_color'] ?>">
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Barang</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Jumlah Repair</th>
                                <th class="text-center">No PO</th>
                                <th class="text-center">No Receipt</th>
                                <th class="text-center">Nama Subkon</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($$status[$a]['name_array']): $no = 0; foreach ($$status[$a]['name_array'] as $v): $no++
                        ?>
                            <tr>
                                <td class="text-center"><?= $no?></td>
                                <td><?= $v['KODE_BARANG'] ?></td>
                                <td><?= $v['DESCRIPTION'] ?></td>
                                <td class="text-center"><?= $v['JUMLAH_REPAIR'] ?></td>
                                <td class="text-center"><?= $v['NO_PO'] ?></td>
                                <td class="text-center"><?= $v['RECEIPT_NUM'] ?></td>
                                <td><?= $v['NAMA_SUBKON'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>