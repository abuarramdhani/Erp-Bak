<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <div class="col-md-6 text-left">
                        <h4>
                            <strong>
                                <?php
                                if ($action == 'input') {
                                    echo "Create Grouping Item";
                                    $group = '';
                                    $desc = '';
                                    $id = '';
                                    $button = 'SAVE';
                                } else if ($action = 'update') {
                                    echo "Update Grouping Item";
                                    $group = $header[0]['GROUP_NAME'];
                                    $desc = $header[0]['DESCRIPTION'];
                                    $id = $header[0]['HEADER_ID'];
                                    $button = 'UPDATE';
                                }
                                ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="box-body">
                    <table width="100%" id="tbl-input-group-GMI">
                        <tr>
                            <td width="10%" height="15">NAMA GROUP</td>
                            <td width="5%"> : </td>
                            <td width="75%">
                                <div class="col-md-6" style="margin-top: 6px;">
                                    <input type="text" class="form-control" name="group_name" id="inp-group-name-GMI" value="<?= $group ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">DESKRIPSI</td>
                            <td width="2%"> : </td>
                            <td width="75%">
                                <div class="col-md-6" style="margin-top: 6px;">
                                    <input type="text" class="form-control" name="description" id="inp-group-desc-GMI" value="<?= $desc ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">ADD ITEM</td>
                            <td width="5%"> : </td>
                            <td width="75%">
                                <div class="col-md-3" style="margin-top: 6px;">
                                    <!-- <input type="text" class="form-control" name="item_code[]" id="inp-item-code-GMI"> -->
                                    <select name="item_code" id="inp-item-code-GMI" class="form-control"></select>
                                </div>
                                <div class="col-md-3" style="margin-top: 6px;">
                                    <input type="text" class="form-control" name="item_desc" id="inp-item-desc-GMI" disabled>
                                </div>
                                <div class="col-md-2" style="margin-top: 6px;">
                                    <button class="btn btn-xl btn-success" type="button" id="btn-input-item-GMI" value="<?= $button ?>">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">UPLOAD FILE</td>
                            <td width="5%"> : </td>
                            <td width="75%">
                                <div class="col-md-3">
                                    <input type="file" name="myfile" id="inp-input-file-GMI" style="margin-top: 12px;">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-xl btn-info" type="button" id="btn-input-file-GMI" value="upload" style="margin-top: 6px; margin-left: 2px;">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <img src="<?= base_url('assets/img/gif/loading5.gif')?>" alt="Loading" id="loading-upl-file-GMI" style="margin-top: 6px; display: None;">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div id="content-lines-GMI">
                        <table width="100%" class="table table-bordered table-striped" id="tbl-input-line-GMI" style="margin-top: 20px;">
                            <thead>
                                <tr class="bg-info">
                                    <th width="5%" class="text-center">No</th>
                                    <th width="25%" class="text-center">Kode Barang</th>
                                    <th width="35%" class="text-center">Deskripsi</th>
                                    <th width="20%" class="text-center">Item Type</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-add-item-GMI" data-source="manual-db">
                                <?php if ($action == 'input') { ?>
                                    <tr id="tr-item-null-GMI">
                                        <td colspan="5" style="text-align: center;">
                                            Pilih item yang ingin di group
                                        </td>
                                    </tr>
                                    <?php } else if ($action = 'update') {
                                        $line_num = 0;
                                        foreach ($lines as $key => $line) {
                                            $line_num++; ?>
                                        <tr id="tr-item-<?= $line['LINE_ID'] ?>-GMI" class="tr-update-item-GMI" data-row="<?= $line_num ?>" data-item="<?= $line['ITEM_ID'] ?>" data-source="database">
                                            <td style="text-align: center;">
                                                <?= $line_num ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?= $line['SEGMENT1'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?= $line['DESCRIPTION'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?= $line['TYPE_CODE'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <button type="button" class="btn btn-danger btn-sm btn-delete-item-GMI" value="line-update" data-id="<?= $line['LINE_ID'] ?>">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" align="right">
                                        <button type="button" class="btn btn-xl btn-primary" id="btn-save-iteml-GMI" value="<?= $id ?>" data-action="<?= $button ?>">SAVE</button>
                                    <?php if ($action != 'update') {?>
                                        <button type="button" class="btn btn-xl btn-danger btn-delete-item-GMI" style="margin-left: 3px;" value="all">DELETE</button>
                                    <?php } ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>