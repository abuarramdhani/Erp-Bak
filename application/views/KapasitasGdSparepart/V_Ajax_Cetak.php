<center><label>SPB/DOSP SIAP CETAK PACKING LIST</label></center>
<div class="table-responsive">
  <div class="panel-body">
    <div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center tblpelayanan" id="tblCetak" style="width: 100%;table-layout:fixed">
        <thead class="bg-primary">
            <tr>
                <th style="width:5%">No</th>
                <th>Tanggal</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Jumlah Item</th>
                <th>Jumlah Pcs</th>
                <th style="width: 200px;">PIC</th>
                <th>Cetak</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; $no=1; foreach($value as $val) {
                if ($val['TIPE'] == 'URGENT') {
                    $td = 'bg-danger';
                } elseif ($val['TIPE'] == 'ECERAN') {
                    $td = 'bg-info';
                } elseif ($val['TIPE'] == 'BEST AGRO') {
                    $td = 'bg-success';
                } elseif ($val['TIPE'] == 'E-COMMERCE') {
                    $td = 'bg-warning';
                } else {
                    $td = '';
                }
            ?>
                <tr id="baris<?= $val['NO_DOKUMEN']?>">
                    <td class="<?= $td?>" width="20px">
                        <input type="hidden" id="no<?= $val['NO_DOKUMEN']?>" value="<?= $no?>">
                        <?= $no; ?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jam<?= $val['NO_DOKUMEN']?>" value="<?= $val['TGL_DIBUAT']?>">
                        <?= $val['TGL_DIBUAT']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jenis<?= $val['NO_DOKUMEN']?>" value="<?= $val['JENIS_DOKUMEN']?>">
                        <?= $val['JENIS_DOKUMEN']?>
                    </td>
                    <td class="<?= $td?>" style="font-size:17px; font-weight: bold">
                        <input type="hidden" id="nodoc<?= $val['NO_DOKUMEN']?>" value="<?= $val['NO_DOKUMEN']?>">
                        <?= $val['NO_DOKUMEN']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jml_item<?= $val['NO_DOKUMEN']?>" value="<?= $val['JUMLAH_ITEM']?>">
                        <?= $val['JUMLAH_ITEM']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jml_pcs<?= $val['NO_DOKUMEN']?>" value="<?= $val['JUMLAH_PCS']?>">
                        <?= $val['JUMLAH_PCS']?>
                    </td>
                    <td class="<?= $td?>">
                    <?php 
                        foreach($noind as $n) {
                            if ($n['noind'] == $val['PIC_PELAYAN']) {
                                $nama = $n['nama'];
                            }
                        }
                    ?>
                        <input type="hidden" id="pic<?= $val['NO_DOKUMEN']?>" name="picspb" class="form-control text-center" style="width:100%" value="<?= $val['PIC_PELAYAN']?>" readonly>
                        <?= $val['PIC_PELAYAN'] ?><br><?= $nama ?>
                    </td>
                    <td class="<?= $td?>">
                        <a href="<?php echo base_url('KapasitasGdSparepart/Pelayanan/cetakPL/'.$val['NO_DOKUMEN']) ?>" target="_blank" class="btn btn-danger btn-md"><i class="fa fa-file-pdf-o"> PL</i></a>
                        <a href="<?php echo base_url('KapasitasGdSparepart/Pelayanan/cetakSM/'.$val['NO_DOKUMEN']) ?>" target="_blank" class="btn btn-info btn-md"><i class="fa fa-file-pdf-o"> SM</i></a>
                    </td>
                </tr>
            <?php $no++; $i++; } ?>
        </tbody>
    </table>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#tblCetak').DataTable({
    drawCallback: function(dt) { }
  });  
</script>