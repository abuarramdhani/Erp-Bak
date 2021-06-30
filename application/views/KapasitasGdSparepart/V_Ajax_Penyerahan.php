<div class="table-responsive">
    <div class="panel-body">
        <div class="table-responsive" >
            <table class="datatable table table-bordered table-hover table-striped text-center tblManifest" id="tblManifest" style="width: 100%;table-layout:fixed">
                <thead class="bg-primary">
                    <tr>
                        <th style="width:5%">No</th>
                        <!-- <th>No Manifest</th> -->
                        <th>No SPB/DOSP</th>
                        <th>Ekspedisi</th>
                        <th>Total Packing</th>
                        <th>Berat (KG)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0; $no=1; foreach($value as $val) { ?>
                        <tr id="baris<?= $val['REQUEST_NUMBER']?>">
                            <td width="20px">
                                <input type="hidden" id="no<?= $val['REQUEST_NUMBER']?>" value="<?= $no?>">
                                <?= $no; ?>
                            </td>
                            <!-- <td style="font-size:17px; font-weight: bold">
                                <input type="hidden" id="noman<?= $val['REQUEST_NUMBER']?>" value="<?= $val['MANIFEST_NUMBER']?>">
                                <?= $val['MANIFEST_NUMBER']?>
                            </td> -->
                            <td style="font-size:17px; font-weight: bold">
                                <input type="hidden" id="nodoc<?= $val['REQUEST_NUMBER']?>" value="<?= $val['REQUEST_NUMBER']?>">
                                <?= $val['REQUEST_NUMBER']?>
                            </td>
                            <td>
                                <?= $val['EKSPEDISI']?>
                            </td>
                            <td>
                                <?= $val['TTL_COLLY']?>                        
                            </td>
                            <td>
                                <?= $val['BERAT'] ?>                        
                            </td>
                        </tr>
                    <?php $no++; $i++; } ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-primary" style="float: right;" onclick="generateNumber()">Create</button>
        <!-- <a href="<?php echo base_url('KapasitasGdSparepart/Penyerahan/generateManifestNum') ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"> Cetak</i></a> -->
    </div>
</div>

<script type="text/javascript">
  $('#tblManifest').DataTable({
    paging: false,
    info: false,
    searching: false
  });  
</script>
