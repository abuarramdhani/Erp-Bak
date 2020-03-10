<div class="row" style="padding-top:20px;padding-left:10px;padding-right:10px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td colspan="2" style="width: 100%;font-weight:bold;font-size: 30px;text-align:center">Report Pendingan Job</td>
    </tr>
    <tr>
        <td style="width: 20%;font-weight:bold;font-size:15px;">Department</td>
        <td style="width: 80%;font-weight:bold;font-size:15px;text-align:left;">: <?= $dept?></td>
    </tr>
    <tr>
        <td style="width: 20%;font-weight:bold;font-size:15px;">Tanggal</td>
        <td style="width: 80%;font-weight:bold;font-size:15px;text-align:left;">: <?= $date?></td>
    </tr>
    <tr>
        <td style="width: 20%;font-weight:bold;font-size:15px;">Shift</td>
        <td style="width: 80%;font-weight:bold;font-size:15px;text-align:left;">: <?= $shift?></td>
    </tr>
</table>
</div>

<div class="row" style="padding-top:5px;padding-left:10px;padding-right:10px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <thead>
        <tr>
            <th style="width: 5%;border:1px solid black;">NO</th>
            <th style="width: 15%;border:1px solid black;">NO. JOB</th>
            <th style="width: 22%;border:1px solid black;">ITEM</th>
            <th style="width: 22%;border:1px solid black;">KOMPONEN</th>
            <th style="width: 35%;border:1px solid black;">DESKRIPSI</th>
            <th style="width: 13%;border:1px solid black;">SUBINV</th>
            <th style="width: 10%;border:1px solid black;">REQ</th>
            <th style="width: 10%;border:1px solid black;">STOK</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($data as $val){
    // echo "<pre>";print_r($val);exit();
        ?>
        <tr>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $no?></td>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $val['no_job']?></td>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $val['kode_assy']?></td>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $val['item']?></td>
            <td style="height:27px;border:1px solid black;"><?= $val['desc']?></td>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $val['subinv']?></td>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $val['req']?></td>
            <td style="height:27px;border:1px solid black;text-align:center;"><?= $val['stok']?></td>
        </tr>
        <?php $no++; } ?>
    </tbody>
</table>
</div>
