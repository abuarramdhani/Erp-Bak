<div class="box box-solid">
    <div class="box-body">
        <div class="panel-body">
        <?php
            if(sizeof($top) == "0") {
            ?>
        <!-- <div style="margin-top:8px;">
                <label class="label label-secondary"
                    style="color:black;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    Doc. No : <strong class="text-primary"> - </strong>
                </label>
                <label class="label label-secondary"
                    style="color:black;margin-left: 7px;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    Rev. No : <strong class="text-primary"> - </strong>
                </label>
                <label class="label label-secondary"
                    style="color:black;margin-left: 7px;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    Rev. Date : <strong class="text-primary"> - </strong>
                </label>
            </div> -->
        <?php } 
            else { ?>
        <div style="margin-top:8px;">
                <label class="label label-secondary"
                    style="color:black;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    Doc. No : <strong class="text-primary"><?php echo $top['0']['NO_DOKUMEN'] ?></strong>
                </label>
                <label class="label label-secondary"
                    style="color:black;margin-left: 7px;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    Rev. No : <strong class="text-primary"><?php echo $top['0']['NO_REVISI'] ?></strong>
                </label>
                <label class="label label-secondary"
                    style="color:black;margin-left: 7px;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    Rev. Date : <strong class="text-primary"><?php echo $top['0']['TANGGAL_REVISI'] ?></strong>
                </label>
            </div>
        <?php } ?>

            
            <br>

            <div class="table-responsive">
                <table id="tablePMEMon" class="table table-bordered table-hover table-striped text-center"
                    style="width: 100%; table-layout:fixed;">
                    <thead class="btn-primary">
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="50%">NAMA MESIN</th>
                            <th width="20%">KONDISI MESIN</th>
                            <!-- <th width="40%">HEADER</th> -->
                            <th width="25%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($value as $k => $row) { ?>
                        <tr class="text-center">
                            <td><?= $no; ?></td>
                            <td><?= $row['header']['NAMA_MESIN'] ?></td>
                            <td><?= $row['header']['KONDISI_MESIN'] ?></td>
                            <!-- <td><?= $row['header']['HEADER_MESIN'] ?></td> -->
                            <td><span class="btn btn-warning" onclick="getDetailPMEMon(this, <?= $no ?>)"><i
                                        class="fa fa-eye"></i> Detail</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4">
                                <div id="detail<?= $no ?>" style="display:none">
                                    <table class="table table-bordered table-hover table-striped table-responsive "
                                        style="width: 100%; border: 2px solid #ddd;">
                                        <thead class="btn-danger">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="15%">Header</th>
                                                <th width="20%">Uraian Kerja</th>
                                                <th width="10%">Standar</th>
                                                <th width="5%">Periode</th>
                                                <th width="5%">Durasi</th>
                                                <th width="10%">Kondisi</th>
                                                <th width="15%">Catatan</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $nomor = 1;
                                                foreach ($row['body'] as $v) {
                                                ?>
                                            <tr>
                                                <td><?= $nomor++ ?>

                                                    <input type="hidden" id="idPME<?= $nomor ?>"
                                                        value="<?= $v['SUB_HEADER'] ?>" />

                                                </td>
                                                <td style="text-align:left"><input type="hidden" name="header[]"
                                                        value="<?= $v['HEADER_MESIN'] ?>" /><?= $v['HEADER_MESIN'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="subheader[]"
                                                        id="subheader<?= $no ?><?= $nomor ?>"
                                                        value="<?= $v['SUB_HEADER'] ?>" /><?= $v['SUB_HEADER'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="standar[]"
                                                        value="<?= $v['STANDAR'] ?>" /><?= $v['STANDAR'] ?></td>
                                                <td style="text-align:center"><input type="hidden" name="periode[]"
                                                        value="<?= $v['PERIODE_CHECK'] ?>" /><?= $v['PERIODE_CHECK'] ?>
                                                </td>
                                                <td style="text-align:center"><input type="hidden" name="durasi[]"
                                                        value="<?= $v['DURASI'] ?>" /><?= $v['DURASI'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="kondisi[]"
                                                        value="<?= $v['KONDISI'] ?>" /><?= $v['KONDISI'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="catatan[]"
                                                        value="<?= $v['CATATAN'] ?>" /><?= $v['CATATAN'] ?></td>
                                                <td class="text-center">
                                                    <?php
                                                        if ($footer['0']['APPROVED_DATE'] == null) {
                                                        ?>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="editRowPMEMon('<?= $v['SUB_HEADER'] ?>')"> Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" type="button"
                                                        onclick="deleteRowPMEMon('<?= $v['SUB_HEADER'] ?>')">Delete</button>
                                                    <?php } 
                                                        else { ?>
                                                    <span class="label label-success">Approved <b
                                                            class="fa fa-check-circle"> </b></span>
                                                    <?php } ?>
                                                </td>

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
    </div>
</div>