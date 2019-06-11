<table class="table1" style="width:100%;border: 1px solid black; padding: 0px; border-collapse: collapse;">
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;size: 12px" rowspan="3">ALAMAT TUJUAN</td>
        <td style="border: 1px solid black;size: 12px" rowspan="3">PROSES<br>dari gudang</td>
        <td style="border: 1px solid black;size: 12px" rowspan="3">
            <?php foreach ($show as $a) {
                $order = $a[0]['no_order'];
              ?>
            <center>
                <img style="height: 100px; width: 100px" src="<?php echo base_url('img/'.$order.'.png'); ?>" />
            </center>
            <?php  } ?>
        </td>
        <td style="border: 1px solid black;size: 12px; text-align: right"><strong>Nomor Move Order</strong></td>
    </tr>
    <tr style="border: 1px solid black;"><td style="border: 1px solid black;size: 12px;padding-left: 30px;">Nomor PO</td></tr>
    <tr style="border: 1px solid black;"><td style="border: 1px solid black;size: 12px;padding-left: 20px;">Tanggal dan Jam</td></tr>
</table>

<table class="table1" style="width:100%;border: 1px solid black; padding: 0px; border-collapse: collapse;margin-top: 10px;">
         <tr>
            <td style="height: 10px;padding: 0px;">No</td>
            <td>Jml</td>
            <td>...</td>
            <td>PCS</td>
            <td>SEGEMENT</td>
            <td>DESCRIPTION</td>
            <td>K</td>    
        </tr>
</table>

<table class ="tableBottom" align="bottom"  style="vertical-align: bottom;width:100%;border: 1px solid black; margin-top: 240px; border-collapse: collapse; position: absolute; bottom: 0px;">
    <tr style="border: 1px solid black;">
       <td style="border: 1px solid black;" colspan="3" style="text-align: right;">TANGGAL</td>     
    </tr>
    <tr style="border: 1px solid black;">
        <td width="70%" style="border: 1px solid black;height:50px">DESCRIPTION</td>
       <td style="border: 1px solid black;" colspan="2"></td>
    </tr><tr style="border: 1px solid black;">
        <td style="border: 1px solid black; height:50px; vertical-align: top">(NO JOB)</td>
       <td style="border: 1px solid black;" colspan="2"></td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black; text-align: center;">FAJAR EKA</td>
        <td style="border: 1px solid black; text-align: center;">SUPRIYANTO</td>
    </tr>
</table>
