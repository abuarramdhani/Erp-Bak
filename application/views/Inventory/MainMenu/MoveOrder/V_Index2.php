    <style type="text/css">
        body {
            font-size: 12px;
        }

        .table {
            width: 100%;
        }

        .table-head td {
            padding: 1px 3px;
        }

        .table-line td {
            padding: 4px 3px;
        }

        .table-bordered, .table-bordered td {
            
            border-collapse: collapse;
        }

        .hor-center {
            text-align: center;
        }

        .hor-right {
            text-align: right;
        }

        .ver-center {
            vertical-align: middle;
        }

        .ver-top {
            vertical-align: top;
        }
    </style>

<body>
    
<?= $urut != '0' ? '<pagebreak resetpagenum="1" />' : '' ?>
<br>
    <table class="table table-bordered hor-center ver-top" style="" >
    <?php 
    $no=1;
    foreach ($dataall['line'] as $k => $ln) {
        ?>
                        <tr class="table-line" style="padding-top: 5px;">
                            <td style="" width="4%" ><?php echo $no++; ?></td>
                            <td style="" width="7%"><?php echo $ln['QTY_MINTA']; ?></td>
                            <td style="" width="7%">....</td>
                            <td style="" width="5%"><?php echo $ln['UOM']; ?></td>
                            <td style="text-align: left;" width="15%"><?php echo $ln['KODE_KOMPONEN']; ?></td>
                            <td style="text-align: left;" width="30%"><?php echo $ln['KODE_DESC']; ?></td>
                            <td style="text-align: left;" width="5%">K</td>
                            <td style=""></td>
                        </tr> 

    <?php } ?>
            </table>
</div>
</body>