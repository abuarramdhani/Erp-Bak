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
                                <?php $datatbl = count($data) < 10 ? 'tbldetailreq' : 'tbldetailreq2';?>
                                    <table class="table table-bordered table-hover table-striped text-center" id="<?= $datatbl?>">
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
                                                <th>Action</th>
                                                <th>Note</th>
                                                <th style="width:300px">Alasan</th>
                                                <th>Attachment (.pdf)</th>
                                                <th>No Serial</th>
                                                <th>Cost Center</th>
                                                <th>Notes History</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1; foreach ($data as $key => $val) {
                                            if ($val['status'] == '') { // item accept
                                                $action = '<select name="action[]" class="form-control select2" style="width:150px">
                                                            <option value="Approve">Approve</option>
                                                            <option value="Reject">Reject</option>
                                                        </select>  ';
                                                $note = '<input name="note[]" class="form-control" style="width:150px" autocomplete="off">';
                                                $iditem = '<input type="hidden" name="id_item[]" value="'.$val['id_item'].'">
                                                            <input type="hidden" name="kode_item[]" value="'.$val['kode_item'].'">
                                                            <input type="hidden" name="qty[]" value="'.$val['qty'].'">
                                                            <input type="hidden" name="no_serial[]" value="'.$val['no_serial'].'">
                                                            <input type="hidden" name="uom[]" value="'.$val['uom'].'">';
                                            } else { // item reject
                                                $statuus = explode("|", $val['status']);
                                                $action = '<span style="color:#CF3222;font-weight:bold">Rejected</span>';
                                                $note = '<span style="color:#CF3222;font-weight:bold">'.$statuus[1].'</span>';
                                                $iditem = '';
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $no?><?= $iditem?></td>
                                                <td><?= $val['issue_receipt']?></td>
                                                <td class="text-nowrap"><?= $val['kode_item']?></td>
                                                <td><?= $val['deskripsi_item']?></td>
                                                <td><?= $val['qty']?></td>
                                                <td><?= $val['uom']?></td>
                                                <td><?= $val['inventory']?></td>
                                                <td><?= $val['locator']?></td>
                                                <td><?= $action?></td>
                                                <td><?= $note?></td>
                                                <td><?= $val['alasan']?> <br> <?= $val['deskripsi_alasan']?></td>
                                                <td>
                                                    <?php $filename = "assets/upload/Miscellaneous/Attachment/".$val['attachment']."";
                                                        $attach = file_exists($filename) ? '' : 'disabled'; ?>
                                                    <a href="<?php echo base_url("assets/upload/Miscellaneous/Attachment/".$val['attachment']."")?>" target="_blank">
                                                        <span class="btn btn-sm btn-info" style="border-radius:25px" <?= $attach?>><i class="fa fa-eye"></i> View</span>
                                                    </a>
                                                </td>
                                                <td><?= $val['no_serial']?></td>
                                                <td><?= $val['cost_center']?></td>
                                                <td><button type="button" class="btn btn-sm btn-info" style="border-radius:25px" onclick="mdlnotesMis(<?= $val['id_item']?>)"><i class="fa  fa-sticky-note"></i> Notes</button></td>
                                            </tr>
                                        <?php $no++;}?>
                                        </tbody>
                                    </table>
                                    <p style="color:red">*jika ingin menolak item yang diajukan miscellaneous, klik "Approve" kemudian ubah menjadi "Reject"</p>
                                </div>
                                <div class="panel-body text-center">
                                    <button class="btn btn-success" formaction="<?php echo base_url($linkket)?>"><i class="fa fa-check"></i> Submit</button>
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