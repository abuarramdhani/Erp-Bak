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
                <label class="label label-secondary"
                    style="color:black;margin-left: 7px;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    <span onclick="editTopPME('<?= $top['0']['NAMA_MESIN'] ?>')">Edit</span>
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
                <label class="label label-secondary"
                    style="color:black;margin-left: 7px;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
                    <span onclick="editTopPME('<?= $top['0']['NAMA_MESIN'] ?>')">Edit</span>
                </label>
            </div>
        <?php } ?>
            
            <br>
            <div class="table-responsive">
                <table id="tablePME" class="table table-bordered table-hover table-striped text-center"
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
                            <!-- <td><?= $row['header']['HEADER'] ?></td> -->
                            <td><span class="btn btn-warning" onclick="getDetailPME(this, <?= $no ?>)">Detail</span>
                            </td>
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
                                                <th width="20%">Header</th>
                                                <th width="30%">Uraian Kerja</th>
                                                <th width="15%">Standar</th>
                                                <th width="10%">Periode</th>
                                                <th width="20%">Action</th>
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
                                                        value="<?= $v['HEADER'] ?>" /><?= $v['HEADER'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="subheader[]"
                                                        id="subheader<?= $no ?><?= $nomor ?>"
                                                        value="<?= $v['SUB_HEADER'] ?>" /><?= $v['SUB_HEADER'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="standar[]"
                                                        value="<?= $v['STANDAR'] ?>" /><?= $v['STANDAR'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="periode[]"
                                                        value="<?= $v['PERIODE'] ?>" /><?= $v['PERIODE'] ?></td>
                                                <td class="text-center"><button type="button"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="editRowPME('<?= $v['SUB_HEADER'] ?>')"> Edit </button>
                                                    <button class="btn btn-danger btn-sm" type="button"
                                                        onclick="deleteRowPME('<?= $v['SUB_HEADER'] ?>')">Delete</button>
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
        <?php
            if(sizeof($gambar) == "0") {
            ?>
                 <div class="col-md-12" style="text-align:center"><br>
            <span ><b>Belum ada lampiran gambar</b></span>
            <br><br>
        </div>                
            <?php } 
                else { ?>
                <div class="col-md-12" style="text-align:center"><br>
            <span ><b>Lampiran gambar :  </b></span>
            <br><br>
            <span >
            <?php $filename = $gambar['0']['FILE_DIR_ADDRESS']; ?>

                                        <a href="<?php echo base_url($filename)?>" target="_blank">
                            <img style="max-width: 300px;max-height: 300px"  src="<?php echo base_url($filename)?>">
                        </a>
                        <br><span style="color:#3A4C52;font-size:11px">*Klik gambar untuk membuka di Tab baru</span>
                            </span>
                            <br><br>
        </div>                
            <?php } ?>
       


        <form class="form-horizontal" enctype="multipart/form-data" method="post"
            action="<?php echo site_url('PeriodicalMaintenance/Management/Uploadimg'); ?>">
            
            <div id="addgambarMPA">
            <?php
            if(sizeof($top) == "0") {
            ?>
                <input type="hidden" name="mesin" value="" />                
            <?php } 
                else { ?>
                <input type="hidden" name="mesin" value="<?= $top['0']['NAMA_MESIN'] ?>" />                
            <?php } ?>
                <div class="panel-body">
                    <div class="col-md-4" style="text-align: right;"><label>Gambar</label></div>
                    <div class="col-md-4"><input required type="file" name="gambarMPA[]" class="form-control"
                            accept="image/*"><br>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" /></div>
                    <!-- <div class="col-md-2"><a class="btn btn-default" onclick="addgambarMPA()"><i
                                class="fa fa-plus"></i></a></div> -->
                </div>
            </div>
            <?php
            if(sizeof($gambar) == "0") {
            ?>          
            <div class="panel-body">
                <div class="col-md-12" style="text-align: center;"><button id="save_mpa"
                        class="btn btn-success"><i class="fa fa-save"></i> Simpan Gambar</button></div>
            </div>     
            <?php } 
                else { ?>
                <div class="panel-body">
                <div class="col-md-12" style="text-align: center;"><button id="save_mpa"
                        class="btn btn-primary"><i class="fa fa-pencil"></i>&nbsp; Ubah Gambar&nbsp;</button></div>
            </div>         
            <?php } ?>
            
        </form>

            <?php
            if(sizeof($gambar) == "0") {
            ?>               
            <?php } 
                else { ?>
                 <!-- <input type="hidden" name="del_mesin" value="<?= $top['0']['NAMA_MESIN'] ?>" />       -->
                   <div class="panel-body">
                <div class="col-md-12" style="text-align: center;">
                <button id="delete_img_mpa"
                        class="btn btn-danger" onclick="delImageMPA('<?= $top['0']['NAMA_MESIN'] ?>','<?= $gambar['0']['FILE_DIR_ADDRESS'] ?>')"><i class="fa fa-trash"></i> Hapus Gambar</button></div>
            </div>             
            <?php } ?>
            
    </div>
</div>