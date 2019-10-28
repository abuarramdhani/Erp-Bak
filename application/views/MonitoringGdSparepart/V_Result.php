<!-- <div class="box box-primary box-solid"> -->
	<!-- <div class="box-header with-border"><b>Hasil</b></div> -->
    <!-- <div class="box-body"> -->
    <!-- <form method="post" action=" "> -->
        <!-- <div class="panel-body"> -->
            <div class="table-responsive">
				<table class="table table-bordered table-hover table-striped text-center" id="tblMGS" style="width: 100%; table-layout:fixed;">
                    <thead class="bg-primary">
                        <tr class="text-center">
                            <th width="3%">No</th>
                            <th>Jenis Dokumen</th>
                            <th>No Dokumen</th>
                            <th>Tanggal</th>
                            <th>Jam Input</th>
                            <th>PIC</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach ($value as $k => $row) { ?>
                        <tr class="text-center">
                            <td width="3%"><?= $no; ?></td>
                            <td><?= $row['header']['JENIS_DOKUMEN'] ?></td>
                            <td><?= $row['header']['NO_DOCUMENT'] ?></td>
                            <td><?= $row['header']['CREATION_DATE'] ?></td>
                            <td><?= $row['header']['JAM_INPUT'] ?></td>
                            <td><?= $row['header']['PIC'] ?></td>
                            <td><?= $row['header']['statusket']  ?></td>
                            <td><span class="btn btn-success" onclick="addDetailMGS(this, <?= $no ?>)" >Detail</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="7" >
                                <div id="detail<?= $no ?>" style="display:none">
                                    <table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%; border: 2px solid #ddd;">
                                        <thead class="bg-teal">
                                            <tr>
                                                <th>No</th>
                                                <th>Item</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                                <th>OK</th>
                                                <th>NOT OK</th>
                                                <th>Keterangan</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $nomor=1; foreach ($row['body'] as $v) { ?>
                                            <tr>
                                                <td><?= $nomor++ ?>
                                                    <input type="hidden" name="doc[]" value="<?= $v['NO_DOCUMENT'] ?>"/>
                                                    <input type="hidden" name="jenis[]" value="<?= $v['JENIS_DOKUMEN'] ?>"/>
                                                    <input type="hidden" name="uom[]" value="<?= $v['UOM'] ?>"/>
                                                    <input type="hidden" name="tanggal[]" value="<?= $v['CREATION_DATE'] ?>"/>
                                                    <input type="hidden" name="ktrgn[]" value="<?= $row['header']['statusket'] ?>"/>
                                                </td>
                                                <td style="text-align:left"><input type="hidden" name="item[]" value="<?= $v['ITEM'] ?>"/><?= $v['ITEM'] ?></td>
                                                <td style="text-align:left"><input type="hidden" name="nama_brg[]" value="<?= $v['DESCRIPTION'] ?>"/><?= $v['DESCRIPTION'] ?></td>
                                                <td><input type="hidden" name="qty[]" value="<?= $v['QTY'] ?>"/><?= $v['QTY'] ?></td>
                                                <td><input type="hidden" name="qty_ok[]" value="<?= $v['JML_OK'] ?>"/><?= $v['JML_OK'] ?></td>
                                                <td><input type="hidden" name="qty_not[]" value="<?= $v['JML_NOT_OK'] ?>"/><?= $v['JML_NOT_OK'] ?></td>
                                                <td style="text-align:left"><?= $v['KETERANGAN'] ?></td>
                                                <td><input type="button" value="Edit" class="btn btn-warning" 
                                                        <?php if($row['header']['statusket']== 'Sudah terlayani') 
                                                        {
                                                            echo ' disabled=disabled ';
                                                        }else{
                                                            echo '';
                                                        }?>
                                                        onclick="btnEditMGS(this, <?=$no?>,<?=$nomor?>)" /></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="6">
                                                    <div id="edit<?=$no?><?= $nomor ?>" style="display:none">
                                                        <table class="table table-bordered table-hover text-center table-responsive" id="myTable" style="width: 100%; border: 2px solid #ddd">
                                                        <thead class="bg-yellow">
                                                            <tr>
                                                                <th>Status</th>
                                                                <th width="20%">Jumlah</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>OK</td>
                                                                <td><input type="number" name="jml_ok[]" class="form-control" placeholder="*Pastikan terisi"/></td>
                                                                <td></td>
                                                            </tr>    
                                                            <tr>
                                                                <td>NOT OK</td>
                                                                <td><input type="number" name="jml_not_ok[]" class="form-control" placeholder="*Pastikan terisi"/></td>
                                                                <td><input  name="keterangan[]" class="form-control" placeholder="*Pastikan terisi"/></td>
                                                            </tr>    
                                                        </tbody>                                   
                                                        </table>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>                                        
                                    </table>
                                    <input type="submit" class="btn btn-danger" name="action" value="Save">   
                                </div>
                            </td>
                        </tr>
                        <?php $no++;} ?>
                    </tbody>
                </table>
                <!-- <div class="panel-heading text-right">
                    <button type="submit" class="btn btn-lg btn-danger" title="save"> Save</button>
                </div> -->
			</div>
		<!-- </div> -->
    <!-- </form> -->
	<!-- </div> -->
<!-- </div> -->


