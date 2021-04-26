<center><label>SPB/DOSP SUDAH DILAYANI HARI INI</label></center>
<div class="panel-body">
    <div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center tblpelayanan2" id="tblSelesai" style="width: 100%;">
            <thead class="bg-primary">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Dokumen</th>
                    <th>No Dokumen</th>
                    <th>Jumlah Item</th>
                    <th>Jumlah Pcs</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Waktu</th>
                    <th>PIC</th>
                    <th>Keterangan</th>
                    <!-- <th>Cetak</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $i= 0 ;$no=1; foreach($data as $val) { 
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
                <tr>
                    <td class="<?= $td?>" style="width: 5px">
                        <?= $no; ?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>">
                        <?= $val['TGL_DIBUAT']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jenis_doc<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>">
                        <?= $val['JENIS_DOKUMEN']?>
                    </td>
                    <td class="<?= $td?>" style="font-size:17px; font-weight: bold">
                        <input type="hidden" id="no_doc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>">
                        <?= $val['NO_DOKUMEN']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>">
                        <?= $val['JUMLAH_ITEM']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>">
                        <?= $val['JUMLAH_PCS']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="mulai_pelayanan<?= $no?>" value="<?= $val['MULAI_PELAYANAN']?>">
                        <?= $val['MULAI_PELAYANAN']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="selesai_pelayanan<?= $no?>" value="<?= $val['SELESAI_PELAYANAN']?>">
                        <?= $val['SELESAI_PELAYANAN']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="waktu_pelayanan<?= $no?>" value="<?= $val['WAKTU_PELAYANAN'] ?>">
                        <?= $val['WAKTU_PELAYANAN'] ?>
                    </td>
                    <td class="<?= $td?>">
                        <?php foreach($noind as $n) {
                                if ($n['noind'] == $val['PIC_PELAYAN']) {
                                    echo $val['PIC_PELAYAN'].'<br>'.$n['nama'];
                                }
                                else {
                                    echo '';
                                }
                            }
                        ?>
                    </td>
                    <td class="<?= $td?>">
                        <?= $val['TIPE'] ?>
                    </td>
                    <!-- <td class="<?= $td?>">
                        <input type="button" class="btn btn-md btn-danger" id="btnCetak<?= $val['NO_DOKUMEN']?>" onclick="btnCetak(<?= $val['NO_DOKUMEN']?>)" value="Cetak" disabled>
                    </td> -->
                </tr>
                <?php $no++; $i++; }?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
  $('#tblSelesai').DataTable();
</script>
