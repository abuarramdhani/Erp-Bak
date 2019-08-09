
<style>
th, td{
	text-align: center;
	vertical-align: middle;
	font-size: 12px;
}
.des{
	text-align: justify;
}
</style>
<div class="box box-primary box-solid">
	<div class="box-header with-border"><b>Hasil</b></div>
	<h4 align="center" > LPPB KHUSUS </h4>
    <div class="box-body">
        <div class="panel-body">
		<!-- <div id="filterKhusus"></div> <br /> -->
            <div class="table-responsive text-nowrap">
				<table id="tbl_khususDt" class="datatable table table-striped table-bordered table-hover">
				<thead class="bg-primary">
                    <tr>
						<th style="background-color: #337ab7;" >NO</td>
                        <th style="background-color: #337ab7;" >RECEIPT_NUM</th>
						<th>IO</th>
						<th>NO_LPPB</th>
                        <th>PO</th>
						<th>ORDER_NUM</th>
						<th>ITEM</th>
						<th>DESCRIPTION</th>
                        <th>TRANSFER_QTY</th>
						<th>TRANSFER_DATE</th>
						<th>DELIVER_QTY</th>
						<th>DELIVER_DATE</th>
						<th>ACCEPT_QTY</th>
						<th>ACCEPT_DATE</th>
						<th>REJECT_QTY</th>
						<th>REJECT_DATE</th>
						<th>RECEIVE_QTY</th>
						<th>RECEIVE_DATE</th>
						<th>RECEIPT_DATE</th>
						<th>TRANSACTION_DATE</th>
						<th>SHIPMENT_LINE_ID</th>
						<th>TRANSACTION_ID</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach ($value as $row) { ?>
					<tr>
						<td><?= $no++; ?></td>
                        <td><?= $row['RECEIPT_NUM'] ?></td>
						<td><?= $row['IO'] ?></td>
						<td><?= $row['NOLPPB'] ?></td>
                        <td><?= $row['PO'] ?></td>
						<td><?= $row['ORDER_NUM'] ?></td>
						<td><?= $row['ITEM'] ?></td>
						<td class="des"><?= $row['DESCRIPTION'] ?></td>
                        <td><?= $row['TRANSFER_QTY'] ?></td>
						<td><?= $row['TRANSFER_DATE'] ?></td>
						<td><?= $row['DELIVER_QTY'] ?></td>
						<td><?= $row['DELIVER_DATE'] ?></td>
						<td><?= $row['ACCEPT_QTY'] ?></td>
						<td><?= $row['ACCEPT_DATE'] ?></td>
						<td><?= $row['REJECT_QTY'] ?></td>
						<td><?= $row['REJECT_DATE'] ?></td>	
						<td><?= $row['RECEIVE_QTY'] ?></td>
						<td><?= $row['RECEIVE_DATE'] ?></td>
						<td><?= $row['RECEIPT_DATE'] ?></td>
						<td><?= $row['TRANSACTION_DATE'] ?></td>
						<td><?= $row['SHIPMENT_LINE_ID'] ?></td>
						<td><?= $row['TRANSACTION_ID'] ?></td>
					</tr>
					<?php } ?>
				</tbody>
                </table>
			</div>
		</div>
	</div>



	
</div>