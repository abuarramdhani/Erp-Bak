<div class="box box-solid">
    <div class="box-body">
        <!-- <form  id="formPME" target="_blank" action="<?php echo base_url('PeriodicalMaintenance/Management/Report'); ?>" method="post" > -->
        <div class="panel-body">
            <div class="table-responsive">
                <table id="tablePME" class="table table-bordered table-hover table-striped text-center" style="width: 100%; table-layout:fixed;">
                    <thead class="btn-primary">
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="25%">NAMA MESIN</th>
                            <th width="15%">KONDISI MESIN</th>
                            <th width="40%">HEADER</th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($value as $k => $row) { ?>
                            <tr class="text-center">
                                <td><?= $no; ?></td>
                                <td><?= $row['header']['NAMA_MESIN'] ?></td>
                                <td><?= $row['header']['KONDISI_MESIN'] ?></td>
                                <td><?= $row['header']['HEADER'] ?></td>
                                <td><span class="btn btn-warning" onclick="getDetailPME(this, <?= $no ?>)">Detail</span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="4">
                                    <div id="detail<?= $no ?>" style="display:none">
                                        <table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%; border: 2px solid #ddd;">
                                            <thead class="btn-danger">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="30%">Uraian Kerja</th>
                                                    <th width="30%">Standar</th>
                                                    <th width="15%">Periode</th>
                                                    <th width="20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nomor = 1;
                                                foreach ($row['body'] as $v) {
                                                    // $edit = $row['header']['statusket'] == 'Sudah terlayani' ? 'readonly' : ''
                                                ?>
                                                    <tr>
                                                        <td><?= $nomor++ ?>

                                                            <input type="hidden" id="idPME<?= $nomor ?>" value="<?= $v['SUB_HEADER'] ?>" />

                                                        </td>
                                                        <td style="text-align:left"><input type="hidden" name="subheader[]" id="subheader<?= $no ?><?= $nomor ?>" value="<?= $v['SUB_HEADER'] ?>" /><?= $v['SUB_HEADER'] ?></td>
                                                        <td style="text-align:left"><input type="hidden" name="standar[]" value="<?= $v['STANDAR'] ?>" /><?= $v['STANDAR'] ?></td>
                                                        <td style="text-align:left"><input type="hidden" name="periode[]" value="<?= $v['PERIODE'] ?>" /><?= $v['PERIODE'] ?></td>
                                                        <td class="text-center"><button type="button" class="btn btn-primary btn-sm" onclick="editRowPME('<?= $v['SUB_HEADER'] ?>')"> Edit </button> <button class="btn btn-danger btn-sm" type="button" onclick="deleteRowPME('<?= $v['SUB_HEADER'] ?>')">Delete</button></td>

                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="panel-body text-right" > 
    <input type="submit" class="btn btn-lg btn-success" value="Export">
</div> -->
        <!-- </form> -->
    </div>
</div>