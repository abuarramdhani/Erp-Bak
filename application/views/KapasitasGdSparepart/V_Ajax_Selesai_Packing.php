<center><label>SPB/DOSP SUDAH DIPACKING HARI INI</label></center>
<div class="panel-body">
    <div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center tblpakcing2" id="tblSelesaiPacking" style="width: 100%;">
            <thead style="background-color: #ffbd73; color: black;">
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
                </tr>
            </thead>
            <tbody>
                <?php $i=0; $no=1; foreach($data as $val){ 
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
                    <td class="<?= $td?>" width="20px">
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
                        <input type="hidden" id="mulai_packing<?= $no?>" value="<?= $val['MULAI_PACKING']?>"><?= $val['MULAI_PACKING']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="selesai_packing<?= $no?>" value="<?= $val['SELESAI_PACKING']?>">
                        <?= $val['SELESAI_PACKING']?>
                    </td>
                    <td class="<?= $td?>">
                        <input type="hidden" id="waktu_packing<?= $no?>" value="<?= $val['WAKTU_PACKING'] ?>">
                        <?= $val['WAKTU_PACKING'] ?>
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
                        <?= $val['TIPE']?>
                    </td>
                </tr>
                <?php $no++; $i++; } ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
  $('#tblSelesaiPacking').DataTable();
</script>