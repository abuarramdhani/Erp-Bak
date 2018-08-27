<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body {
				font-size: 12px;
			}

			.table {
				width: 100%;
			}

			.table td {
				padding: 3px 3px;
			}

			.table-bordered, .table-bordered td {
				border: 1px solid #000;
				border-collapse: collapse;
			}

			.table-head-bordered, .table-head-bordered td {
				border: 1px solid #d3d3d3;
				border-collapse: collapse;
			}

			.center-hor, .center-hor td {
				text-align: center;
			}

			.right-hor, .right-hor td {
				text-align: right;
			}

			.center-ver, .center-ver td {
				vertical-align: middle;
			}

			.text-bold , .text-bold td {
				font-weight: bold;
			}

			.top-ver {
				vertical-align: top;
			}
        </style>
    </head>
    <body>
    	<?php $no=1; foreach ($list as $ls) {
    		if ($no>1) {
    			echo "<pagebreak>";
    		}
    	?>
	        <table class="table table-bordered">
	            <tr>
	                <td width="25%">
	                    No SPB/DOSP : <strong><?php echo $spbNumber; ?></strong>
	                </td>
	                <td width="50%">
	                    No Peti/Coly : <strong><?php echo $ls['PACKING_CODE']; ?></strong>
	                </td>
	                <td style="width:25%">
	                    Total Peti/Coly :
	                    <strong>
	                        <span style="font-size: 13pt">
	                            <?php echo $ls['TOTAL']; ?>
	                        </span>
	                    </strong>
	                </td>
	            </tr>
	        </table>
	        <table class="table table-bordered">
	        	<tr class="text-bold">
	        		<td>NO</td>
	        		<td width="5%">QTY</td>
	        		<td width="8%">SATUAN</td>
	        		<td width="17%">KODE BARANG</td>
	        		<td width="45%">NAMA BARANG</td>
	        		<td width="15%">TIPE/NOMOR BARANG</td>
	        	</tr>
	        	<?php $i = 1; foreach($ls['list'] as $line) { ?>
	        		<tr>
	        			<td><?php echo $i++; ?></td>
	        			<td><?php echo $line['PACKING_QTY'];?></td>
	        			<td><?php echo $line['PRIMARY_UOM_CODE'];?></td>
	        			<td><?php echo $line['SEGMENT1'];?></td>
	        			<td><?php echo $line['DESCRIPTION'];?></td>
	        			<td></td>
	        		</tr>
	        	<?php } ?>
	        </table>
	    <?php $no++; } ?>
    </body>
</html>