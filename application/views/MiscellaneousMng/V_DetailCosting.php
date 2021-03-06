<script>
    $(document).ready(function () {
        $('#tbldetailreq').dataTable({
            "scrollX": true,
        });
        $('#tbldetailreq2').dataTable({
            "scrollX": true,
            "scrollY": 500,
            "paging": false,
        });
    });
</script>
<form method="post">
<section class="content" id="detailmiscellaneous">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <br />
                <div class="row" style="color:#444">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header text-center" style="font-size:20px;color:#444">
                                <strong>MISCELLANEOUS REQUEST</strong>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>No Dokumen </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>: <?= $no_dokumen?></label>
                                            <input type="hidden" id="id_header" name="id_header" value="<?= $id_header?>">
                                            <input type="hidden" id="no_dokumen" name="no_dokumen" value="<?= $no_dokumen?>">
                                            <input type="hidden" id="io" name="io" value="<?= $io?>">
                                            <input type="hidden" id="status" name="status" value="<?= $status?>">
                                            <input type="hidden" id="tgl_request" name="tgl_request" value="<?= $tgl?>">
                                            <input type="hidden" id="requester" name="requester" value="<?= $requester?>">
                                            <input type="hidden" id="nama_req" name="nama_req" value="<?= $nama_req?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Status :</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>IO </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>: <?= $io?></label>
                                        </div>
                                        <div class="col-md-6" style="font-size:20px">
                                            <label><?= $status?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Tanggal Request </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>: <?= $tgl?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label><button type="button" class="btn btn-xs btn-info" style="border-radius:25px" onclick="mdlhistoryMis()"><i class="fa fa-hourglass-end"></i> History</button></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Requester </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label>: <?= $requester?> - <?= $nama_req?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                <?php $datatbl = count($data) < 10 ? 'tbldetailreq' : 'tbldetailreq2'; ?>
                                    <table class="datatable table table-bordered table-hover table-striped text-center" id="<?= $datatbl?>">
                                        <thead style="background-color:#49D3F5;">
                                            <tr>
                                                <th>No</th>
                                                <th>Issue / Receipt</th>
                                                <th style="width:100px">Item</th>
                                                <th style="width:300px">Deskripsi</th>
                                                <th>Qty</th>
                                                <th>Uom</th>
                                                <th>Subinventory</th>
                                                <th>Locator</th>
                                                <?php echo (stripos($ket, 'approve') !== FALSE) ? '<th>Action</th><th>Note</th>' :'' ?>
                                                <th style="width:300px"><?= (stripos($ket, 'finishedCosting') !== FALSE) ? 'Referensi' : 'Alasan' ?></th>
                                                <th>Attachment (.pdf)</th>
                                                <th>No Serial</th>
                                                <th>Cost Center</th>
                                                <?php echo (stripos($ket, 'finished') !== FALSE) ? '<th style="width:100px">Status</th>' : '' ?>
                                                <th>Tipe Transaksi</th>
                                                <th>COA</th>
                                                <th>Deskripsi Akun Biaya</th>
                                                <th>Deskripsi CC</th>
                                                <th>Total Cost</th>
                                                <th>Notes History</th>
                                                <?php if ((stripos($ket, 'approveCosting') !== FALSE)) { ?>
                                                    <th>Delete Item</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1; foreach ($data as $key => $val) {
                                                // $input1 = (stripos($ket, 'approve') !== FALSE)  ? '' : 'disabled';
                                                // $input = (stripos($ket, 'approveCosting') !== FALSE)  ? '' : 'disabled';
                                                $save = (stripos($ket, 'approve') !== FALSE) ? '' : 'display:none';
                                                $back = (stripos($ket, 'finished') !== FALSE) ? '' : 'display:none';
                                                $print = (stripos($ket, 'finishedCosting') !== FALSE) ? '' : 'display:none';
                                           ?>
                                            <tr id="hapusdata<?= $val['id_item']?>">
                                                <td><?= $no?>
                                                    <input type="hidden" name="id_item[]" id="id_item<?= $no?>" value="<?= $val['id_item']?>">
                                                    <input type="hidden" name="cost_center[]" id="cost_center<?= $no?>" value="<?= $val['cost_center']?>">
                                                    <input type="hidden" name="issue_receipt[]" id="issue_receipt<?= $no?>" value="<?= $val['issue_receipt']?>">
                                                    <input type="hidden" name="kode_item[]" id="kode_item<?= $no?>" value="<?= $val['kode_item']?>">
                                                    <input type="hidden" name="deskripsi_item[]" id="deskripsi_item<?= $no?>" value="<?= $val['deskripsi_item']?>">
                                                    <input type="hidden" name="qty[]" id="qty<?= $no?>" value="<?= $val['qty']?>">
                                                    <input type="hidden" name="uom[]" id="uom<?= $no?>" value="<?= $val['uom']?>">
                                                    <input type="hidden" name="inventory[]" id="inventory<?= $no?>" value="<?= $val['inventory']?>">
                                                    <input type="hidden" name="locator[]" id="locator<?= $no?>" value="<?= $val['locator']?>">
                                                    <input type="hidden" name="no_serial[]" id="no_serial<?= $no?>" value="<?= $val['no_serial']?>">
                                                    <input type="hidden" name="alasan[]" id="alasan<?= $no?>" value="<?= $val['alasan']?>">
                                                    <input type="hidden" name="deskripsi_alasan[]" id="deskripsi_alasan<?= $no?>" value="<?= $val['deskripsi_alasan']?>">
                                                    <input type="hidden" name="status[]" id="status<?= $no?>" value="<?= $val['status']?>">
                                                </td>
                                                <td><?= $val['issue_receipt']?></td>
                                                <td><?= $val['kode_item']?></td>
                                                <td><?= $val['deskripsi_item']?></td>
                                                <td><?= $val['qty']?></td>
                                                <td><?= $val['uom']?></td>
                                                <td><?= $val['inventory']?></td>
                                                <td><?= $val['locator']?></td>
                                                <?php if (stripos($ket, 'approve') !== FALSE) { // tampil kalau detail untuk approve costing / akuntansi 
                                                    if ($val['status'] == '') { // item tidak reject ?> 
                                                        <td><select name="action[]" id="action_costing<?= $no?>" class="form-control select2" style="width:150px" <?= stripos($ket, 'approveCosting') !== FALSE ? 'required' : '' ?> onchange="gantiAction(<?= $no?>)">
                                                                <?= stripos($ket, 'approveCosting') !== FALSE ? '<option></option>' : '' ?>
                                                                <option value="Approve">Approve</option>
                                                                <option value="Reject">Reject</option>
                                                            </select>    
                                                        </td>
                                                        <td><input name="note[]" id="note<?= $no?>" class="form-control" style="width:150px" autocomplete="off"></td>
                                                    <?php } else{ //item reject
                                                            for ($i=0; $i < 2 ; $i++) { 
                                                                $statuus = explode("|", $val['status']);
                                                                $komen = $i == 1 ? $statuus[1] : 'Rejected';
                                                            echo '<td style="color:#CF3222;font-weight:bold">'.$komen.'</td>';
                                                            }
                                                        }
                                                    }?>
                                                <td><?= (stripos($ket, 'finishedCosting') !== FALSE) ? $val['reference'] : $val['alasan'].'<br>'.$val['deskripsi_alasan'] ?></td>
                                                <td>
                                                    <?php $filename = "assets/upload/Miscellaneous/Attachment/".$val['attachment']."";
                                                        $attach = file_exists($filename) ? '' : 'disabled'; ?>
                                                    <a href="<?php echo base_url("assets/upload/Miscellaneous/Attachment/".$val['attachment']."")?>" target="_blank">
                                                        <span class="btn btn-sm btn-info" style="border-radius:25px" <?= $attach?>><i class="fa fa-eye"></i> View</span>
                                                    </a>
                                                </td>
                                                <td><?= $val['no_serial']?></td>
                                                <td><?= $val['cost_center']?></td>
                                                <?php if ($val['status'] == '') { // item tidak reject
                                                    if (stripos($ket, 'finished') !== FALSE) { // cuma tampil kalau detail finished
                                                        if ($val['status'] == '') {
                                                            echo '<td style="color:green;font-weight:bold">Sudah Input</td>';
                                                        }else {
                                                            echo '<td style="color:#CF3222;font-weight:bold">'.$val['status'].'</td>';
                                                        }?> 
                                                    <?php }
                                                    if ((stripos($ket, 'approveCosting') !== FALSE)) { // cuma tampil kalau approve costing ?>
                                                            <td id="gantitipe<?= $no?>"><select name="type_transaksi[]" id="type_transaksi<?= $no?>" class="form-control select2 getTipeTrans" style="width:150px" required></select></td>
                                                            <td>1-<?= $branch?>-
                                                                <span id="ganticoa<?= $no?>"><select name="coa[]" id="coa<?= $no?>" class="form-control select2 getAkunCOA coa_yuk" style="width:150px" onchange="getdescCOA(<?= $no?>)" required></select></span>
                                                                -<?= $val['cost_center']?>-
                                                                <input name="produk[]" id="produk<?= $no?>" class="form-control" style="width:150px" required>
                                                                -000-000
                                                            </td>
                                                            <td><input name="desc_biaya[]" id="desc_biaya<?= $no?>" class="form-control" style="width:400px" readonly></td>
                                                            <td><input name="desc_cc[]" id="desc_cc<?= $no?>" class="form-control" style="width:400px" readonly></td>
                                                            <td><input class="form-control" style="width:150px" value="Rp. <?= number_format($val['item_cost'], 2) ?>" readonly>
                                                                <input type="hidden" name="total_cost[]" id="total_cost<?= $no?>" value="<?= $val['item_cost'] ?>">
                                                            </td>
                                                    <?php }else { ?>
                                                            <td><input name="type_transaksi[]" class="form-control" style="width:250px" value="<?= $val['tipe_transaksi']?>" readonly></td>
                                                            <td>1-<?= $branch?>-<input name="coa[]" class="form-control" style="width:150px" value="<?= $val['coa']?>" readonly>-<?= $val['cost_center']?>-<?= $val['produk']?>-000-000</td>
                                                            <td><input name="desc_biaya[]" class="form-control" style="width:400px" value="<?= $val['deskripsi_biaya']?>" readonly></td>
                                                            <td><input name="desc_cc[]" class="form-control" style="width:400px" value="<?= $val['deskripsi_cc']?>" readonly></td>
                                                            <td><input name="total_cost[]" class="form-control" style="width:150px" value="Rp. <?= number_format($val['total_cost'], 2)?>" readonly></td>
                                                    <?php }?>
                                                <?php }else{ //item reject
                                                    $x = stripos($ket, 'approve') !== FALSE ? 5 : 6;
                                                    for ($i=0; $i < $x ; $i++) { 
                                                        if (stripos($ket, 'finished') !== FALSE) {
                                                            $komen = $i == 0 ? $val['status'] : 'Rejected';
                                                        }else {
                                                            $statuus = explode("|", $val['status']);
                                                            $komen = $i == 1 ? $statuus[1] : 'Rejected';
                                                        }
                                                       echo '<td style="color:#CF3222;font-weight:bold">'.$komen.'</td>';
                                                    }
                                                }?>
                                                <td><button type="button" class="btn btn-sm btn-info" style="border-radius:25px" onclick="mdlnotesMis(<?= $val['id_item']?>)"><i class="fa  fa-sticky-note"></i> Notes</button></td>
                                                <?php if ((stripos($ket, 'approveCosting') !== FALSE)) { // jika detail approve costing ?>
                                                    <td>
                                                    <?php if ($val['status'] != '') {?>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteitem(<?= $val['id_item']?>)"><i class="fa  fa-trash"></i></button>
                                                    <?php } ?>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <?php $no++; }?>
                                        </tbody>
                                    </table>
                                    <p style="color:red;<?= stripos($ket, 'approveAkuntansi') !== FALSE ? '' : 'display:none' ?>">*jika ingin menolak item yang diajukan miscellaneous, klik "Approve" kemudian ubah menjadi "Reject"</p>
                                </div>
                                <div class="panel-body text-center">
                                    <button class="btn btn-success" style="<?= $save?>" formaction="<?php echo base_url($linkket)?>"><i class="fa fa-check"></i> Submit</button>
                                    <button class="btn" style="<?= $back?>;background-color:#D2D6D5" formaction="<?php echo base_url($linkket)?>"><i class="fa fa-step-backward"></i> Back</button>
                                    <button class="btn btn-info" style="<?= $print?>" formtarget="_blank" formaction="<?php echo base_url("MiscellaneousCosting/Request/pdf_miscellaneous")?>"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>



<div class="modal fade" id="mdldetailMis" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header text-center" style="background-color:#49D3F5;font-size:18px">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <label id="judul_modal"></label>
        </div>
        <div class="modal-body">
            <div id="datareq"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>