<center><label>SPB/DOSP SUDAH CETAK HARI INI</label></center>
<div class="table-responsive">
  <div class="panel-body">
    <div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center tblcetak" id="tblSelesaiCetakDO" style="width: 100%;table-layout:fixed">
        <thead class="bg-primary">
            <tr>
                <th style="width:5%">No</th>
                <th>Tanggal</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Jumlah Item</th>
                <th>Jumlah Pcs</th>
                <th>PIC Packing</th>
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
                    <?php foreach($noind as $n) {
                            if ($n['noind'] == $val['PIC_PACKING']) {
                                echo $val['PIC_PACKING'].'<br>'.$n['nama'];
                            }
                            else {
                                echo '';
                            }
                        }
                    ?>
                    </td>
                    <td class="<?= $td?>">
                        <a href="<?php echo base_url('KapasitasGdSparepart/Cetak/cetakDOSP/'.$val['NO_DOKUMEN']) ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"> Cetak</i></a><br>
                        <?php if ($val['JENIS_DOKUMEN'] == 'SPB'){ ?>
                          <a href="<?php echo base_url('KapasitasGdSparepart/Cetak/cetakSPB3/'.$val['NO_DOKUMEN'].'_n') ?>" style="margin-top:5px;width:130px;" target="_blank" class="btn btn-danger" ><i class="fa fa-file-pdf-o"> SPB No Border</i></a>
                        <?php }elseif ($val['JENIS_DOKUMEN'] == 'DOSP') { ?>
                          <a href="<?php echo base_url('KapasitasGdSparepart/Cetak/cetakDOSP2/'.$val['NO_DOKUMEN'].'_n') ?>" style="margin-top:5px;width:130px;" target="_blank" class="btn btn-danger" ><i class="fa fa-file-pdf-o"> DOSP No Border</i></a> <br>
                        <?php } ?>
                    </td>
                </tr>
            <?php $no++; $i++; } ?>
        </tbody>
    </table>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#tblSelesaiCetakDO').DataTable({
    drawCallback: function(dt) {}
  });
</script>
