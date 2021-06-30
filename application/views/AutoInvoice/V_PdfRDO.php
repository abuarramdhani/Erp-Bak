<table style="width: 100%;font-family:Arial, Helvetica, sans-serif">
    <tr>
        <td style="width: 83%;font-size:9pt;padding-left:55px"><?= $RDO[0]['CF_1'] ?></td>
        <td rowspan="3" style="font-size:12pt"><?= $RDO[0]['NO_RDO'] ?></td>
    </tr>
    <tr>
        <td style="font-size:9pt;padding-left:48px"><?= $RDO[0]['ADDRESS'] ?></td>
    </tr>
    <tr>
        <td style="font-size:9pt;padding-left:48px"><?= $RDO[0]['PHONE_EMAIL'] ?></td>
    </tr>
</table>
<br>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:9pt">
    <tr>
        <td><?= $RDO[0]['INVOICE_TO_ADDRESS2'] ?></td>
        <td><?= $RDO[0]['SHIP_TO_ADDRESS2'] ?></td>

    </tr>
    <tr>
        <td><?= $RDO[0]['INVOICE_TO_ADDRESS1'] ?></td>
        <td><?= $RDO[0]['SHIP_TO_ADDRESS1'] ?></td>

    </tr>
    <tr>
        <td><?= $RDO[0]['INVOICE_TO_ADDRESS5'] ?></td>
        <td><?= $RDO[0]['SHIP_TO_ADDRESS5'] ?></td>

    </tr>
</table>
<br>
<br>
<br>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:9pt;">
    <tr>
        <td style="width:110px"><?= $RDO[0]['SO_NUM'] ?></td>
        <td style="width: 200px;"><?= $RDO[0]['SO_DATE'] ?></td>
        <td style="width: 120px;"><?= $RDO[0]['TERMS'] ?></td>
        <td><?= $RDO[0]['REQUEST_DATE'] ?></td>
    </tr>
</table>
<br><br><br>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:9pt;">
    <?php for ($i = 0; $i < sizeof($RDO); $i++) {
        if ($i == 0) { ?>

            <tr>
                <td style="width: 40px;vertical-align:top"><?= $RDO[$i]['QTY'] ?></td>
                <td style="padding-left:20px;vertical-align:top"><?= $RDO[$i]['UOM'] ?></td>
                <td style="padding-left: 30px;vertical-align:top"><?= $RDO[$i]['ITEM_CODE'] ?></td>
                <td style="padding-left: 40px;width:50px"><?= $RDO[$i]['DESCRIPTION'] ?></td>
                <td style="padding-left:25px;vertical-align:top"><?= number_format($RDO[$i]['UNIT_LIST_PRICE_PPN'], 2) ?></td>
                <td style="padding-left:20px;vertical-align:top"><?= number_format($RDO[$i]['SELL_LIST'], 2) ?></td>
                <td style="padding-left:20px;vertical-align:top"><?= number_format($RDO[$i]['UNIT_SELL_PRICE_PPN'], 2) ?></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td style="width: 40px;vertical-align:top"></td>
                <td style="padding-left:20px;vertical-align:top"></td>
                <td style="padding-left: 30px;vertical-align:top"></td>
                <td style="padding-left: 40px;width:50px"><?= $RDO[$i]['ADJ_NAME'] ?></td>
                <td style="padding-left:25px;vertical-align:top"><?= number_format($RDO[$i]['DISKON'], 2) ?></td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>
    <?php } ?>
    <tr>
        <td colspan="6" style="text-align: right;padding-right:20px">Netto</td>
        <td><?= number_format($RDO[0]['NETTO'], 2) ?></td>
    </tr>
</table>