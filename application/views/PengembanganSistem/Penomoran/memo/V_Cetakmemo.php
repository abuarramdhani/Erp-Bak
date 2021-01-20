<style>
    div{
        /* padding-top: 6px; */
        font-size: 12px;
    }
    p{
        font-family: Arial, Verdana, Helvetica, Sans-Serif ;
        font-size: 12px;
        margin-top: 2px;
        margin-bottom:2px;
        /* padding-top: 1px; */
    }
    br{
        font-size: 12px;
    }
    table{
        border-collapse: collapse;
        border: none;
        color: #000;
        width: 100%;
        font-size: 13px;
    }
    td{
        border: thin solid black;
        vertical-align: center;
        box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,1);
        /* width: 1%; */
        white-space: wrap;
    }
</style>
<div style="padding-left: 15px; padding-right: 15px;">
    <div>
        <p>No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b><?= $record[0]['number_surat']?></b><br>
        Hal. &nbsp;&nbsp;&nbsp;&nbsp;: <b><?= $record[0]['perihal']?></b><br>
        </p>
        <p>Lamp. &nbsp;: <?php if ($record[0]['lamp'] == null) {
            echo "-";
        } else {
            $record[0]['lamp'];
        }
        ?>&nbsp;Lembar</p>
        <p>Kepada Yth.</p>
            <b><?= $record[0]['yth']?></b>
        <p>Di Tempat</p>
        <p>&nbsp;&nbsp;&nbsp;Dengan Hormat,</p>
        <?= $record[0]['body_surat']?>
    </div>
</div>