<table style="width:100%;border: 1px solid black; padding: 0px">
    <tr>
        <td height="30px" width="20%" style="border-bottom: 1px solid black;font-size: 12px;padding-left: 10px">No Order</td>
        <td height="30px" width="2%" style="border-bottom: 1px solid black;font-size: 12px">:</td>
        <td height="30px" width="53%" style="border-bottom: 1px solid black;font-size: 12px"><?php echo $show[0]['no_order']; ?></td>
        <td rowspan="6" width="25%" style="border-left: 1px solid black;font-size: 12px">
            <?php foreach ($show as $a) {
                $order = $a[0]['no_order'];
              ?>
            <center>
                <img style="height: 100px; width: 100px" src="<?php echo base_url('img/'.$order.'.png'); ?>" />
            </center>
            <?php  } ?>
        </td>
    </tr>
    <tr>
        <td height="30px" width="20%" style="border-bottom: 1px solid black;font-size: 12px;padding-left: 10px">Kode Barang</td>
        <td height="30px" width="2%" style="border-bottom: 1px solid black;font-size: 12px">:</td>
        <td height="30px" width="53%" style="border-bottom: 1px solid black;font-size: 12px"><?php echo $show[0]['kode_barang']; ?></td>
    </tr>
    <tr>
        <td height="30px" width="20%" style="border-bottom: 1px solid black;font-size: 12px;padding-left: 10px">Deskripsi Barang</td>
        <td height="30px" width="2%" style="border-bottom: 1px solid black;font-size: 12px">:</td>
        <td height="30px" width="53%" style="border-bottom: 1px solid black;font-size: 12px"><?php echo $show[0]['deskripsi_barang']; ?></td>
    </tr>
    <tr>
        <td height="30px" width="20%" style="border-bottom: 1px solid black;font-size: 12px;padding-left: 10px">Quantity</td>
        <td height="30px" width="2%" style="border-bottom: 1px solid black;font-size: 12px">:</td>
        <td height="30px" width="53%" style="border-bottom: 1px solid black;font-size: 12px"><?php echo $show[0]['qty']; ?></td>
    </tr>
    <tr>
        <td height="30px" width="20%" style="border-bottom: 1px solid black;font-size: 12px;padding-left: 10px">Tanggal Order</td>
        <td height="30px" width="2%" style="border-bottom: 1px solid black;font-size: 12px">:</td>
        <td height="30px" width="53%" style="border-bottom: 1px solid black;font-size: 12px"><?php echo $show[0]['tgl_order']; ?></td>
    </tr>
    <tr>
        <td height="30px" width="20%" style="font-size: 12px;padding-left: 10px">Tanggal Selesai</td>
        <td height="30px" width="2%" style="font-size: 12px">:</td>
        <td height="30px" width="53%" style="font-size: 12px"><?php echo $show[0]['tgl_selesai']; ?></td>
    </tr>
</table>