<table id="dataTableExportFilter" class="table table-striped table-bordered table-hover text-center rowTable">
    <thead>
        <tr class="bg-primary">
            <th class="text-center">No</th>
            <th class="text-center" width="100px">Nomor Order</th>
            <th class="text-center">Tgl Pemesanan</th>
            <th class="text-center">Status Order</th>
            <th class="text-center" width="150px">Nama Pelanggan</th>
            <th class="text-center">Email</th>
            <th class="text-center">Customer Category</th>
            <th class="text-center">Registration Date</th>
            <th class="text-center" width="150px">No.Telp</th>
            <th class="text-center" width="300px">Alamat</th>
            <th class="text-center" width="100px">Kecamatan</th>
            <th class="text-center" width="120px">Kota/Kabupaten</th>
            <th class="text-center">Provinsi</th>
            <th class="text-center" width="80px">Kode Pos</th>
            <th class="text-center">Order Item Code</th>
            <th class="text-center" width="150px">Order Item Name</th>
            <th class="text-center" width="200px">Category</th>
            <th class="text-center" width="100px">Harga Per Pcs</th>
            <th class="text-center">Qty Beli</th>
            <th class="text-center" width="100px">Berat Per Item</th>
            <th class="text-center">Ekspedisi Pengiriman</th>
            <th class="text-center" width="100px">Biaya Kirim</th>
            <th class="text-center">Metode Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($tableExport as $row) {?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['tgl_pesanan']; ?></td>
            <td><?php echo $row['post_status']; ?></td>
            <td><?php echo $row['display_name']; ?></td>
            <td><?php echo $row['user_email']; ?></td>
            <td><?php echo $row['customer_category']; ?></td>
            <td><?php echo $row['user_registered']; ?></td>
            <td><?php echo $row['phone_number']; ?></td>
            <td><?php echo $row['shipping_addreas_1']; ?></td>
            <td><?php echo $row['shipping_addreas_2']; ?></td>
            <td><?php echo $row['shipping_city']; ?></td>
            <td><?php echo $row['shipping_state']; ?></td>
            <td><?php echo $row['shipping_postcode']; ?></td>
            <td><?php echo $row['sku']; ?></td>
            <td><?php echo $row['item']; ?></td>
            <td><?php echo $row['cat_name']; ?></td>
            <td>Rp <?php echo number_format($row['harsat'], 2, ",", "."); ?></td>
            <td><?php echo $row['qty']; ?></td>
            <td><?php echo $row['berat']; ?></td>
            <td><?php echo $row['ekspedisi']; ?></td>
            <td>Rp <?php echo number_format($row['biaya_kirim'], 2, ",", "."); ?></td>
            <td><?php echo $row['metode_bayar']; ?></td>
        </tr>
        <?php
        ++$i;
        }
        ?>
    </tbody>
</table>