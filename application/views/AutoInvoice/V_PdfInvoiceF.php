<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:8pt">
    <tr>
        <td style="width: 70px;">NO. PO CUST</td>
        <td>-</td>
        <td></td>
        <td style="text-align: right;width:200px"><?= number_format($Invoice[0]['CS_TOTAL'], 0) ?></td>
    </tr>
    <tr>
        <td style="width: 70px;">NO. PO</td>
        <td><?= $Invoice[0]['PO_NUM'] ?></td>
        <td></td>
        <td style="text-align: right;"></td>
    </tr>
    <tr>
        <td style="width: 70px;">NO. DO</td>
        <td><?= $Invoice[0]['DO_NUM'] ?></td>
        <td></td>
        <td style="text-align: right;"></td>
    </tr>
    <tr>
        <td colspan="2"><?= $Invoice[0]['SHIPPING_INSTRUCTIONS'] ?></td>
        <td rowspan="3" style="text-align: right;font-size:8pt"><i>Approved By, <br><?= $Invoice[0]['APPROVER'] ?></i></td>
        <td style="text-align: right;"></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td style="text-align: right;"><?= number_format($Invoice[0]['CS_TOTAL'], 0) ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td style="text-align: right;"><?= number_format($Invoice[0]['CF_SUB_TOTAL'], 0) ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td style="text-align: right;"><?= $Invoice[0]['APPROVER'] ?></td>
        <td style="text-align: right;"><?= number_format($Invoice[0]['CF_PPN'], 0) ?></td>
    </tr>
</table>