<table style="font-size:8pt;font-family:Arial;border: 1px solid black;border-collapse:collapse;width:100%;border-left:none">
    <tr>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:5%">NO</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:5%">QTY</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">SATUAN</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:34%">NAMA BARANG</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">NO LPPB</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">NO PO</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">NO SHIPMENT</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">TGL SP</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">HARGA SATUAN</th>
        <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">JUMLAH</th>
    </tr>
    <?php $i = 0;
    $totalsemua = array();
    for ($g = 0; $g < sizeof($list_tagihan); $g++) {
        array_push($totalsemua, $list_tagihan[$g]['total_price']);
        $desc = strlen($list_tagihan[$g]['item_description_job']);
        if ($desc > 40) {
            $font = '7pt';
        } else {
            $font = '8pt';
        }
        $i = $i + 1; ?>
        <tr>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $i ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $list_tagihan[$g]['quantity_bersih'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $list_tagihan[$g]['uom_code'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;padding-left:5px;font-size:<?= $font ?>"><?= $list_tagihan[$g]['item_description_job'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $list_tagihan[$g]['receipt_num'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $list_tagihan[$g]['po_num'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $list_tagihan[$g]['shipment_num'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><?= $list_tagihan[$g]['transaction_date'] ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center">Rp. <?= number_format($list_tagihan[$g]['po_unit_price'], 0) ?></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center">Rp. <?= number_format($list_tagihan[$g]['total_price'], 0) ?></td>

        </tr>

        <?php if ($i > 10) {
            $i = 1; ?>
</table>
<pagebreak>
    <table style="font-size:8pt;font-family:Arial;border: 1px solid black;border-collapse:collapse;width:100%;border-left:none">
        <tr>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:5%">NO</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:5%">QTY</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">SATUAN</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:34%">NAMA BARANG</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">NO LPPB</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">NO PO</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">NO SHIPMENT</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">TGL SP</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">HARGA SATUAN</th>
            <th style="border-right:none;border: 1px solid black;border-collapse:collapse;width:8%">JUMLAH</th>
        </tr>
    <?php } else { ?>

    <?php }
    }
    if ($i < 10) {
        for ($o = 0; $o < (10 - $i); $o++) { ?>
        <tr>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
            <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px"></td>
        </tr>

<?php }
    } ?>
<tr>
    <td colspan="9" style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px;text-align:center"><b>TOTAL</b></td>
    <td style="border: 1px solid black;border-collapse:collapse;border-bottom:none;border-right:none;height:25px">Rp. <?= number_format(array_sum($totalsemua), 0) ?></td>
</tr>
    </table>