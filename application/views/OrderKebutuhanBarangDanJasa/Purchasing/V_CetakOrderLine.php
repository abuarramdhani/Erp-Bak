<table style="border-collapse:collapse">
    <tr>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Order ID</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Order Date</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">PR (Line)</td>
        <td style="border:1px solid black; text-align:center; font-size:12px; word-wrap:break-word">Name & Section of the Order Maker</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Item Code</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Item Description</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Quantity</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">NBD</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Flag</td>
        <td style="border:1px solid black; text-align:center; font-size:12px; width:11%; word-wrap:break-word">Destination Information</td>
        <td style="border:1px solid black; text-align:center; font-size:12px; word-wrap:break-word">Reasons for Need / Reasons of Urgency</td>
        <td style="border:1px solid black; text-align:center; font-size:12px;">Note to Buyer</td>
        <td style="border:1px solid black; text-align:center; font-size:12px; width:18%">Approval</td>
    </tr>
    <?php foreach ($lines as $key => $line) { ?>
        <tr>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['ORDER_ID'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['ORDER_DATE'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['PR'].'-'.$line['LINE_NUM'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['NATIONAL_IDENTIFIER'].', '.$line['FULL_NAME'].', '.$line['ATTRIBUTE3'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['SEGMENT1'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['ITEM_DESCRIPTION'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['QUANTITY'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['NEED_BY_DATE'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;">
                <?php
                    $flagcond = $line['URGENT_FLAG'];
                    if ($flagcond == 'N') {
                        $flag = 'Normal';
                    }else if ($flagcond == 'Y') {
                        $flag = 'Urgent';
                    }else if ($line['IS_SUSULAN'] = 'Y') {
                        $flag = 'Emergency';
                    }

                    echo $flag;
                ?>
            </td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['ORGANIZATION_CODE'].' / '.$line['LOCATION_CODE'].' / '.$line['DESTINATION_SUBINVENTORY'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['ORDER_PURPOSE'].' / '.$line['URGENT_REASON'];?></td>
            <td style="text-align:center; border:1px solid black; font-size:12px;"><?= $line['NOTE_TO_BUYER']?></td>
            <td style="border:1px solid black; font-size:12px;">
                <?php $no=0; foreach ($line['APPROVER'] as $key => $approver) { $no++; 
                    echo '['.$no.']'.' '.$approver['JUDGEMENT_DATE'].' '.$approver['FULL_NAME'].'<br>';
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>