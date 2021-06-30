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
                                            No Dokumen
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
                                            Status :
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            IO
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
                                            Tanggal Request
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
                                            Requester
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
                                                <th style="width:300px">Alasan</th>
                                                <th>Attachment (.pdf)</th>
                                                <th>No Serial</th>
                                                <th>Cost Center</th>
                                                <th>Notes History</th>
                                                <th style="width:100px">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1; foreach ($data as $key => $val) {
                                            if ($val['status'] == '') {
                                                $col = 'green'; 
                                                $isi = 'Next Process';
                                            }else {
                                                $col = '#CF3222'; 
                                                $isi = $val['status'];
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $no?>
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
                                                    <input type="hidden" name="id_item[]" id="id_item<?= $no?>" value="<?= $val['id_item']?>">
                                                </td>
                                                <td><?= $val['issue_receipt']?></td>
                                                <td><?= $val['kode_item']?></td>
                                                <td><?= $val['deskripsi_item']?></td>
                                                <td><?= $val['qty']?></td>
                                                <td><?= $val['uom']?></td>
                                                <td><?= $val['inventory']?></td>
                                                <td><?= $val['locator']?></td>
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
                                                <?php if ($val['status'] == '') {
                                                        echo '<td style="color:green;font-weight:bold">Next Process</td>';
                                                    }else {
                                                        echo '<td style="color:#CF3222;font-weight:bold">'.$val['status'].'</td>';
                                                    }
                                                ?>
                                            </tr>
                                        <?php $no++; }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body text-center">
                                    <button class="btn" style="background-color:#D2D6D5" formaction="<?php echo base_url($linkket)?>"><i class="fa fa-step-backward"></i> Back</button>
                                    <button class="btn btn-info" style="<?= strpos($ket, 'Costing') ? '' : 'display:none' ?>" formtarget="_blank" formaction="<?php echo base_url("MiscellaneousCosting/Request/pdf_miscellaneous")?>"><i class="fa fa-print"></i> Print</button>
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