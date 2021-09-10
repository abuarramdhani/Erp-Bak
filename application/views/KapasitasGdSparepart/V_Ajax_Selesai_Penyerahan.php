<div class="table-responsive">
    <table class="datatable table table-bordered table-hover table-striped text-center tblSdhMnfst" id="tblSdhMnfst" style="width: 100%;table-layout:fixed">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%">No</th>
                <th>No Manifest</th>
                <!-- <th>No SPB/DOSP</th> -->
                <th>Ekspedisi</th>
                <!-- <th>Total Packing</th> -->
                <!-- <th>Berat (KG)</th> -->
                <th>Tgl Dibuat</th>
                <th>PIC Penyerahan</th>
                <th style="width: 10%">Cetak</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; $no=1; foreach($value as $val) { ?>
                <tr id="baris<?= $val['MANIFEST_NUMBER']?>">
                    <td width="20px">
                        <input type="hidden" id="no<?= $val['MANIFEST_NUMBER']?>" value="<?= $no?>">
                        <?= $no; ?>
                    </td>
                    <td style="font-size:17px; font-weight: bold">
                        <input type="hidden" id="noman<?= $val['MANIFEST_NUMBER']?>" value="<?= $val['MANIFEST_NUMBER']?>">
                        <?= $val['MANIFEST_NUMBER']?>
                    </td>
                    <!-- <td style="font-size:17px; font-weight: bold">
                        <input type="hidden" id="nodoc<?= $val['MANIFEST_NUMBER']?>" value="<?= $val['MANIFEST_NUMBER']?>">
                        <?= $val['MANIFEST_NUMBER']?>
                    </td> -->
                    <td>
                        <?= $val['EKSPEDISI']?>
                    </td>
                   <!--  <td>
                        <?= $val['TTL_COLLY']?>
                    </td>
                    <td>
                        <?= $val['BERAT'] ?>
                    </td> -->
                    <td>
                        <?= $val['CREATION_DATE']?>
                    </td>
                    <td>
                    <?php foreach($noind as $n) {
                            if ($n['noind'] == $val['CREATED_BY']) {
                                echo $val['CREATED_BY'].'<br>'.$n['nama'];
                            }
                            else {
                                echo '';
                            }
                        }
                    ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url('KapasitasGdSparepart/Penyerahan/cetakMNF/'.$val['MANIFEST_NUMBER']) ?>" target="_blank" class="btn btn-danger btn-md"><i class="fa fa-file-pdf-o"></i></a>
                    </td>
                </tr>
            <?php $no++; $i++; } ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
  $('#tblSdhMnfst').DataTable({
    // paging: false,
    info: false,
    // searching: false
  });
</script>
