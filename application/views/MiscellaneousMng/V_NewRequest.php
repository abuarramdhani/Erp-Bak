<script>
        $(document).ready(function () {
            $('#tblongoingreq').dataTable({
                "scrollX": true,
                "paging" : false,
                "searching" : false,
                "bInfo": false,
                "ordering" : false,
            });
            $('#tblongoingreq2').dataTable({
                "scrollX": true,
                "scrollY": 500,
                "paging" : false,
                "searching" : false,
                "bInfo": false,
                "ordering" : false,
            });
    });
</script>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <h2 class="text-center" style="font-weight:bold;color:#444">REQUEST MISCELLANEOUS</h2>
                                <div class="box box-primary">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="col-md-6 text-right">
                                            <input type="radio" name="order" class="order_misc" value="ISSUE">ISSUE
                                            <input type="hidden" name="ini_io" id="iniio" value="<?= $ioo?>">
                                        </div>
                                        <div class="col-md-6 text-left">
                                            <input type="radio" name="order" class="order_misc" value="RECEIPT">RECEIPT
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Cost Center : 
                                            </div>
                                            <div class="col-md-1">
                                            <?php $ionya = substr($ioo, 0,1);
                                                if ($ionya == 'A' || $ionya == 'B' || $ionya == 'G' || $ionya == 'H' || $ionya == 'J' || $ionya == 'K' || $ionya == 'M' || $ionya == 'S' || $ionya == 'U') { 
                                                    $cek_cost = 'checked';
                                                }else {
                                                    $cek_cost = '';
                                                }?>
                                                <input type="radio" name="ket_cost" class="ketcost" value="Seksi" <?= $cek_cost?>>Seksi
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="ket_cost" class="ketcost" value="Resource">Resource
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right"></div>
                                            <div class="col-md-6">
                                            <?php $ionya = substr($ioo, 0,1);
                                                if ($ionya == 'A' || $ionya == 'B' || $ionya == 'G' || $ionya == 'H' || $ionya == 'J' || $ionya == 'K' || $ionya == 'M' || $ionya == 'S' || $ionya == 'U') { ?>
                                                    <select name="cost_center" class="form-control select2 getcost" style="width:100%" data-placeholder="Pilih Cost Center" required>
                                                        <option value="3J99">3J99 - PENAMPUNGAN MARKERING CABANG</option>
                                                    </select>
                                            <?php }else { ?>
                                                <select name="cost_center" class="form-control select2 getcost" style="width:100%" data-placeholder="Pilih Cost Center" required>
                                                    <option></option>
                                                </select>
                                            <?php }?>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Subinventory : 
                                            </div>
                                            <div class="col-md-6">
                                                <select name="inventory" id="subinvmis" class="form-control select2" style="width:100%" data-placeholder="Pilih Subinventory" required>
                                                    <option></option>
                                                    <?php foreach ($subinvv as $key => $sb) {
                                                        echo '<option value="'.$sb['SECONDARY_INVENTORY_NAME'].'">'.$sb['SECONDARY_INVENTORY_NAME'].'</option>';
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Locator : 
                                            </div>
                                            <div class="col-md-6" id="gantilocatormis">
                                                <input name="locator" id="locatormis" class="form-control" placeholder="Pilih Locator">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Item : 
                                            </div>
                                            <div class="col-md-6">
                                                <select name="item" id="item" class="form-control select2 itemreq" style="width:100%" onchange="getdescreq(this)">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Deskripsi : 
                                            </div>
                                            <div class="col-md-6">
                                                <input name="deskripsi" id="desc" class="form-control" placeholder="Deskripsi Item" readonly>
                                                <input type="hidden" name="inv_item" id="inv_item" readonly>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Qty : 
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="qty" id="qtymis" class="form-control" placeholder="Masukkan Quantity" autocomplete="off" readonly required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="onhand" id="onhandmis" class="form-control" placeholder="Onhand" readonly >
                                            </div>
                                            <div class="col-md-2"><span style="color:red;font-size:13px;font-weight:bold" id="warning_qty"></span></div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                UOM : 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="uom" class="pilihuom" id="single_uom" value="Single Uom">Single Uom
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="uom" class="pilihuom" id="dual_uom" value="Dual Uom">Dual Uom
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right"></div>
                                            <div class="col-md-3">
                                                <input name="first_uom" id="first_uom" class="form-control" placeholder="Primary Uom" autocomplete="off" readonly>
                                                <!-- <select name="first_uom" id="first_uom" class="form-control select2" style="width:100%" data-placeholder="pilih uom">
                                                    <option></option>
                                                </select> -->
                                            </div>
                                            <div class="col-md-3" id="sec_uom">
                                                <input name="second_uom" id="second_uom" class="form-control" placeholder="secondary uom" autocomplete="off" readonly>
                                                <!-- <select name="second_uom" id="second_uom" class="form-control select2" style="width:100%" data-placeholder="secondary uom" disabled>
                                                    <option></option>
                                                </select> -->
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                No Seri : 
                                            </div>
                                            <div class="col-md-6">
                                                <select name="no_serial[]" id="noseri" class="form-control select2" multiple style="width:100%" data-placeholder="Masukkan No Serial">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-2"><span style="color:red;font-size:13px;font-weight:bold" id="warning_noseri"></span></div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Alasan : 
                                            </div>
                                            <div class="col-md-6">
                                                <select name="alasan" class="form-control select2" style="width:100%" data-placeholder="Pilih Jenis Alasan">
                                                    <option></option>
                                                    <?php foreach ($alasan as $key => $als) {
                                                        echo '<option value="'.$als['alasan'].'">'.$als['alasan'].'</option>';
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right"></div>
                                            <div class="col-md-6">
                                                <textarea name="desc_alasan" class="form-control" placeholder="Detail Alasan (Minimal 10 Karakter)"></textarea>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-right" style="font-weight:bold;color:#444">
                                                Attachment (.pdf) :
                                            </div>
                                            <div class="col-md-6">
                                                <input type="file" id="file_pdf" name="file_pdf" accept=".pdf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body text-center">
                                        <button id="tambah_req" formaction="<?= base_url("MiscellaneousKasie/Request/addRequest")?>" class="btn bg-orange"><i class="fa fa-plus"></i> Tambah</button>
                                        <!-- <button type="button" id="tambah_req" onclick="addrequest()" class="btn bg-orange"><i class="fa fa-plus"></i> Tambah</button> -->
                                    </div>
                                </div>
                            </form>

                            <!-- tabel data temporary -->
                            <form method="post" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div class="col-md-1" style="font-weight:bold;color:#444">
                                        IO :
                                    </div>
                                    <div class="col-md-3" style="margin-left:-50px">
                                        <input name="io" id="io" class="form-control" value="<?= $ioo?>" readonly>
                                    </div>
                                </div>
                                <?php $datatbl = count($data) < 10 ? 'tblongoingreq' : 'tblongoingreq2';?>
                                <div class="panel-body">
                                    <table class="datatable table table-bordered table-hover table-striped text-center" id="<?= $datatbl?>">
                                        <thead style="background-color:#49D3F5">
                                            <tr class="text-nowrap">
                                                <th style="vertical-align:middle">Issue / Receipt</th>
                                                <th style="font-size:15px;vertical-align:middle;width:100px">Kode Item</th>
                                                <th style="vertical-align:middle;;width:300px">Deskripsi Item</th>
                                                <th style="vertical-align:middle">Qty</th>
                                                <th style="vertical-align:middle">Uom</th>
                                                <th style="vertical-align:middle">Subinventory</th>
                                                <th style="vertical-align:middle">Locator</th>
                                                <th style="vertical-align:middle">No. Serial</th>
                                                <th style="vertical-align:middle;width:300px">Alasan</th>
                                                <th style="vertical-align:middle">Attachment (.pdf)</th>
                                                <th style="vertical-align:middle">Cost Center</th>
                                                <th style="vertical-align:middle">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="inirequest">
                                            <?php $no = 1; foreach ($data as $key => $value) { ?>
                                            <tr id="baris<?= $no?>">
                                                <td><?= $value['jenis']?>
                                                    <input type="hidden" id="jenis<?= $no?>" name="jenis2[]" value="<?= $value['jenis']?>">
                                                    <input type="hidden" id="ket_cost<?= $no?>" name="ket_cost2[]" value="<?= $value['ket_cost']?>">
                                                    <input type="hidden" id="cost_center<?= $no?>" name="cost_center2[]" value="<?= $value['cost_center']?>">
                                                    <input type="hidden" id="item<?= $no?>" name="item2[]" value="<?= $value['item']?>">
                                                    <input type="hidden" id="desc<?= $no?>" name="desc2[]" value="<?= $value['description']?>">
                                                    <input type="hidden" id="qty<?= $no?>" name="qty2[]" value="<?= $value['qty']?>">
                                                    <input type="hidden" id="onhand<?= $no?>" name="onhand2[]" value="<?= $value['onhand']?>">
                                                    <input type="hidden" id="ket_uom<?= $no?>" name="ket_uom2[]" value="<?= $value['ket_uom']?>">
                                                    <input type="hidden" id="first_uom<?= $no?>" name="first_uom2[]" value="<?= $value['first_uom']?>">
                                                    <input type="hidden" id="secondary_uom<?= $no?>" name="secondary_uom2[]" value="<?= $value['secondary_uom']?>">
                                                    <input type="hidden" id="inventory<?= $no?>" name="inventory2[]" value="<?= $value['inventory']?>">
                                                    <input type="hidden" id="locator<?= $no?>" name="locator2[]" value="<?= $value['locator']?>">
                                                    <input type="hidden" id="no_serial<?= $no?>" name="no_serial2[]" value="<?= $value['no_serial']?>">
                                                    <input type="hidden" id="alasan<?= $no?>" name="alasan2[]" value="<?= $value['alasan']?>">
                                                    <input type="hidden" id="desc_alasan<?= $no?>" name="desc_alasan2[]" value="<?= $value['desc_alasan']?>">
                                                    <input type="hidden" id="attachment<?= $no?>" name="attachment2[]" value="<?= $value['attachment']?>">
                                                    <input type="hidden" id="pic<?= $no?>" name="pic2[]" value="<?= $value['pic']?>">
                                                    <input type="hidden" id="nomor<?= $no?>" name="nomor2[]" value="<?= $value['nomor']?>">
                                                    <input type="hidden" id="inv_item<?= $no?>" name="inv_item2[]" value="<?= $value['inv_item_id']?>">
                                                </td>
                                                <td class="text-nowrap"><?= $value['item']?></td>
                                                <td><?= $value['description']?></td>
                                                <td><?= $value['qty']?></td>
                                                <td><?= $value['first_uom']?></td>
                                                <td><?= $value['inventory']?></td>
                                                <td><?= $value['locator']?></td>
                                                <td><?= $value['no_serial']?></td>
                                                <td><?= $value['alasan']?> <br> <?= $value['desc_alasan']?></td>
                                                <td>
                                                    <a href="<?php echo base_url("assets/upload/Miscellaneous/Temp/".$value['attachment']."")?>" target="_blank">
                                                        <span class="btn btn-sm btn-info"><i class="fa fa-eye"></i></span>
                                                    </a>
                                                    <button type="button" id="edit_attach<?= $no?>" class="btn btn-sm btn-warning" onclick="edit_attach(<?= $no?>)"><i class="fa fa-edit"></i></button>
                                                    <button type="button" id="delete_attach<?= $no?>" class="btn btn-sm btn-danger" onclick="delete_attach(<?= $no?>)"><i class="fa fa-trash"></i></button>
                                                </td>
                                                <td><?= $value['cost_center']?></td>
                                                <td><button class="btn btn-danger" onclick="deletebaris(<?= $no?>)"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                            <?php $no++;}?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body text-center" <?php echo empty($data) ? 'style="display:none"' : '' ?>>
                                    <button type="button" data-toggle="modal" data-target="#mdlsubmitRequest" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                </div>
                                
                                <!-- Modal Submit -->
                                <div class="modal fade" id="mdlsubmitRequest" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center" style="background-color:#49D3F5;font-size:18px">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <label>ASSIGN APPROVAL REQUEST</label>
                                            </div>
                                            <div class="modal-body">
                                                <div class="panel-body">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8">
                                                        <label>Pilih Ka. Seksi Utama / Aska / Ka. Unit :</label>
                                                        <select name="assign_order" id="assign_order" class="form-control select2 getapproverReq" style="width:100%" data-placeholder="Pilih Ka. Seksi Utama / Aska / Ka. Unit">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8">
                                                        <?php $ionya = substr($ioo, 0,1);
                                                            if ($ionya == 'A' || $ionya == 'B' || $ionya == 'G' || $ionya == 'H' || $ionya == 'J' || $ionya == 'K' || $ionya == 'M' || $ionya == 'S' || $ionya == 'U') { ?>
                                                                <label>Pilih Kepala Cabang / Showroom :</label>
                                                                <select name="assign_cabang" id="assign_cabang" class="form-control select2 getcabangReq" style="width:100%" data-placeholder="Pilih Kepala Cabang/Showroom">
                                                                    <option></option>
                                                                </select>
                                                        <?php }else { ?>
                                                            <label>Pilih Seksi PPC :</label>
                                                            <select name="assign_ppc" id="assign_ppc" class="form-control select2 getppcReq" style="width:100%" data-placeholder="Pilih Seksi PPC">
                                                                <option></option>
                                                            </select>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="panel-body text-center">
                                                    <button id="submit_req" class="btn btn-success" formaction="<?php echo base_url("MiscellaneousKasie/Request/SaveRequest")?>"><i class="fa fa-check"></i> Submit</button>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Submit -->

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Modal Edit Attachment-->
<form method="post" enctype="multipart/form-data">
<div class="modal fade" id="mdleditattach" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-center" style="background-color:#49D3F5;font-size:18px">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <label>Edit Attachment</label>
        </div>
        <div class="modal-body">
            <div class="panel-body">
                <div class="col-md-1"></div>
				<div class="col-md-10 text-center">
                    <label>File Attachment (.pdf)</label>
                    <div class="input-group">
                        <span id="data_edit_attach"></span>
                        <span class="input-group-btn">
                            <button id="save_edit" class="btn btn-success" formaction="<?php echo base_url("MiscellaneousKasie/Request/SaveEditAttach")?>"><i class="fa fa-check"></i> Submit</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>
