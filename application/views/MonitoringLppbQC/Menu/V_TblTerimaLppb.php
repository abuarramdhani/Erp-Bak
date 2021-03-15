<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover text-left " id="tblterimalppb" style="font-size:12px;">
        <thead>
            <tr class="bg-primary">
                <!-- <th style="width:5%"><center>No</center></th>
                <th style="width:5%"><center>ID Kirim</center></th>
                <th style="width:5%" hidden><center>Line Num</center></th>
                <th style="width:5%"><center>No Lppb</center></th>
                <th style="width:25%"><center>Nama Barang</center></th>
                <th style="width:5%"><center>Jumlah</center></th>
                <th style="width:10%"><center>Keterangan</center></th>
                <th style="width:10%"><center>Pengirim Lppb</center></th>
                <th style="width:10%"><center>Tanggal Kirim</center></th>
                <th style="width:10%"><center>Jam Kirim</center></th>
                <th style="width:10%"><center>Terima di Gd. PPB</center></th> -->
                <th style="width:5%"><center>No</center></th>
                <th style="width:5%"><center>ID Kirim</center></th>
                <th style="width:5%" hidden><center>Line Num</center></th>
                <th style="width:5%"><center>No Lppb</center></th>
                <th style="width:25%"><center>Nama Barang</center></th>
                <th style="width:5%"><center>Jumlah</center></th>
                <th style="width:5%"><center>OK</center></th>
                <th style="width:5%"><center>NOT OK</center></th>
                <th style="width:10%"><center>Keterangan</center></th>
                <th style="width:5%"><center>Pengirim Lppb</center></th>
                <th style="width:10%"><center>Tanggal Kirim</center></th>
                <th style="width:5%"><center>Jam Kirim</center></th>
                <th style="width:10%"><center>Terima di Gd. PPB</center></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($getTerima as $key => $g): ?>
            <tr>
                <td><center><?php echo $no;?></center></td>
                <td><center><?php echo $g['ID_KIRIM']?></center></td>
                <td hidden><center><?php echo $g['LINE_NUM']?></center></td>
                <td><center><?php echo $g['NO_LPPB']?></center></td>
                <td><?php echo $g['NAMA_KOMPONEN']?></td>
                <td><center><?php echo $g['JUMLAH']?></center></td>
                <td><center><?php echo $g['OK']?></center></td>
                <td><center><?php echo $g['NOT_OK']?></center></td>
                <td><?php echo $g['KETERANGAN']?></td>
                <td><center><?php echo $g['NO_INDUK_PENGIRIM']?></center></td>
                <td><center><?php echo $g['TANGGAL_KIRIM']?></center></td>
                <td><center><?php echo $g['JAM']?></center></td>
                <td>
                <center>
                    <?php if ($g['STATUS'] == 1) { ?>
                        <button title="Sudah Diterima" class="btn btn-xs btn-default" id="btn_sdhterima" onClick="btn_sdhterima('<?php echo $g['ID_KIRIM'] ?>' ,'<?php echo $g['LINE_NUM'] ?>')">
                            <i class="fa fa-check"></i>
                        </button>
                        <button title="Belum Diterima" class="btn btn-xs btn-danger" id="btn_blmterima">
                            <i class="fa fa-times"></i>
                        </button>
                    <?php } elseif ($g['STATUS'] == 2) { ?>
                        <button title="Sudah Diterima" class="btn btn-xs btn-success" id="btn_sdhterima">
                            <i class="fa fa-check"></i>
                        </button>
                        <button title="Belum Diterima" class="btn btn-xs btn-default" id="btn_blmterima">
                            <i class="fa fa-times"></i>
                        </button>
                    <?php } else {?>
                    <?php } ?>
                </center>
                </td>
            <?php $no++; endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $('#tblterimalppb').DataTable({});
</script>