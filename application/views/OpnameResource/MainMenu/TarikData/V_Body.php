<style type="text/css">
		/*body {
			font-size: 12px;
		}*/

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
			border: 1px solid #8f8f8f;
			border-collapse: collapse;
		}

		/*.hor-center {
			text-align: center;
		}*/

		/*.hor-right {
			text-align: right;
		}*/

		./*ver-center {
			vertical-align: middle;
		}*/

		/*.ver-top {
			vertical-align: top;
		}*/
	</style>
<table class="table table-head table-bordered" style="margin-top: 30px; border: 1px solid black">
	<thead>
		<tr>
			<td width="5%"><b>No.</b></td>
			<td width="20%"><b>Tag Number</b></td>
			<td width="10%"><b>No Mesin</b></td>
			<td width="20%"><b>Resource</b></td>
			<td width="8%"><b>CC</b></td>
			<td width="10%"><b>Hasil</b></td>
			<td width=""><b>Keterangan</b></td>
		</tr>
	</thead>
	<tbody>
		<?php $i =1; foreach ($dataFilter as $key => $value) { ?>
			<tr>
				<td><?= $i++; ?></td>
				<td><?= $value['TAG_NUMBER_RO']; ?></td>
				<td><?= $value['NO_MESIN_RO']; ?></td>
				<td><?= $value['RESOURCE_RO']; ?></td>
				<td><?= $value['COST_CENTER_RO']; ?></td>
				<td><?= $value['HASIL']; ?></td>
				<td><?= $value['KET']; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>