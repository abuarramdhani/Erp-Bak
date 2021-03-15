<div class="table-responsive" style="margin-top:20px;">
    <table class="table table-striped table-bordered table-hover text-left" id="tblmonlppb" style="font-size:12px;">
        <thead>
            <tr class="bg-primary">
                <!-- <th><center>No</center></th>
                <th><center>Tanggal</center></th>
                <th><center>Jam</center></th>
                <th><center>No Lppb</center></th>
                <th><center>Nama Vendor</center></th>
                <th><center>Nama Barang</center></th>
                <th><center>Tanggal SP</center></th>
                <th><center>Jumlah</center></th>
                <th><center>Keterangan</center></th> -->
                <th><center>No</center></th>
                <th><center>Tanggal Transfer</center></th>
                <th><center>Jam Transfer</center></th>
                <th><center>No Lppb</center></th>
                <th><center>Nama Vendor</center></th>
                <th><center>Nama Barang</center></th>
                <th><center>Tanggal SP</center></th>
                <th><center>Jumlah</center></th>
                <th><center>Tanggal Inspeksi</center></th>
                <th><center>OK</center></th>
                <th><center>NOT OK</center></th>
                <th><center>Keterangan</center></th>
                <th><center>Inspektor</center></th>
                <th><center>Tanggal Kirim</center></th>
                <th><center>Jam Kirim</center></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($getMonLppb as $val) { ?>
            <tr>
                <!-- <td><center><?php echo $no?></center></td>
                <td><center><?php echo $val['TANGGAL']?></center></td>
                <td><center><?php echo $val['JAM']?></center></td>
                <td><center><?php echo $val['NO_LPPB']?></center></td>
                <td><?php echo $val['VENDOR_NAME']?></td>
                <td><?php echo $val['ITEM_DESCRIPTION']?></td>
                <td><center><?php echo $val['TGL_SP']?></center></td>
                <td><center><?php echo $val['QUANTITY']?></center></td>
                <td><?php echo $val['KETERANGAN']?></td> -->
                <td><center><?php echo $no?></center></td>
                <td><center><?php echo $val['TGL_TRANSFER']?></center></td>
                <td><center><?php echo $val['JAM_TRANSFER']?></center></td>
                <td><center><?php echo $val['NO_LPPB']?></center></td>
                <td><?php echo $val['VENDOR_NAME']?></td>
                <td><?php echo $val['ITEM_DESCRIPTION']?></td>
                <td><center><?php echo $val['TGL_SP']?></center></td>
                <td><center><?php echo $val['JUMLAH']?></center></td>
                <td><center><?php echo $val['TGL_INSPEKSI']?></center></td>
                <td><center><?php echo $val['OK']?></center></td>
                <td><center><?php echo $val['NOT_OK']?></center></td>
                <td><?php echo $val['KETERANGAN']?></td>
                <td><center><?php echo $val['INSPEKTOR']?></center></td>
                <td><center><?php echo $val['TGL_KIRIM']?></center></td>
                <td><center><?php echo $val['JAM_KIRIM']?></center></td>
            <?php $no++; } ?>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $('#tblmonlppb').DataTable({
        // "pageLength": 10,
    });
</script>