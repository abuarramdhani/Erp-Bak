<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        div.message-body, div.message-body * {
            font-size: 11.5pt;
        }
        
        .message-body {
            background-color: rgb(253, 253, 253);
            font-family: 'Cambria', serif;
            padding: 10px;
        }

        .table-hoverable {
            border-collapse: collapse;
        }

        .table-hoverable th {
            text-align: center;
        }

        .table-hoverable th, .table-hoverable td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table-hoverable tr:hover {
            background-color:#f5f5f5;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="message-body">
        <h2>Kepada Yth.</h2>
        <p style="margin-top: -0.5rem"> <?= $Approver ?> </p>
        <p>Kami informasikan bahwa <?= $Requestor ?> telah mengajukan approval DOSP, dengan detail sbb: </p>
        <?= $Content ?>
        </div>
        <br>
        <p>Anda dapat melakukan "Approval" melalui : <a href="http://erp.quick.com" target="_blank">http://erp.quick.com</a> atau klik <a href="http://erp.quick.com" target="_blank">disini</a></p>
        <hr> 
    </div>
</body>

</html>