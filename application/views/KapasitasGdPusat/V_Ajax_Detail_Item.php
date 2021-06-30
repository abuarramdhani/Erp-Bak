<div class="table-responsive">
    <div class="panel-body">
        <div class="table-responsive" >
            <table class="datatable table table-bordered table-hover table-striped text-center tblDetailDOK" id="tblDetailDOK" style="width: 100%;">
                <thead class="bg-primary">
                    <tr>
                        <th>NO</th>
                        <th>ITEM CODE</th>
                        <th>DESCRIPTION</th>
                        <th>QUANTITY</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0; $no=1; foreach($detail as $key => $i) { ?>
                        <tr id="baris<?= $i['NO_DOKUMEN']?>" class="baris<?= $i['NO_DOKUMEN']?>">
                            <td>
                                <?= $no; ?>
                                <input type="hidden" id="no_dokumen_<?= $i['NO_DOKUMEN']?>_<?= $no?>" value="<?= $i['NO_DOKUMEN']?>">
                            </td>
                            <td>
                                <input type="hidden" id="item_<?= $i['NO_DOKUMEN']?>_<?= $no?>" value="<?= $i['ITEM']?>">
                                <?= $i['ITEM']?>
                            </td>
                            <td>
                                <input type="hidden" id="desc_<?= $i['NO_DOKUMEN']?>_<?= $no?>" value="<?= $i['DESCRIPTION']?>">
                                <?= $i['DESCRIPTION']?>
                                </td>
                            <td>
                                <input type="hidden" id="qty_<?= $i['NO_DOKUMEN']?>_<?= $no?>" value="<?= $i['QTY']?>">
                                <?= $i['QTY']?>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" onclick="btnEditQtyKGP(`<?= $i['NO_DOKUMEN']?>`,`<?= $no?>`)">
                                    <i class="fa fa-pencil"></i>&nbsp; Edit Qty
                                </a>
                                <a class="btn btn-danger btn-sm" onclick="btnHapusDetailKGP(`<?= $i['NO_DOKUMEN']?>`,`<?= $no?>`)">
                                    <i class="fa fa-trash"></i>&nbsp; Hapus
                                </a>
                            </td>
                        </tr>
                    <?php $no++; $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script type="text/javascript">
  $('.tblDetailDOK').DataTable();  
</script> -->