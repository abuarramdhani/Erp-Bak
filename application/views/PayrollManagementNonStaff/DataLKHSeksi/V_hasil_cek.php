<?php
	if(!empty($data_table)){
		$no = 1;
		foreach($data_table as $dt){
?>

<tr>
	<td><?php echo $no ?></td>
	<td><?php  if($jenis!='01'){ echo $dt['noind_'];}else{ echo $dt['noind'];} ?></td>
	<td><?php echo $dt['employee_name']; ?></td>
	<td><?php echo $dt['section_name']; ?></td>
	<td><?php echo $dt['tgl_']; ?></td>
	<td><?php echo $dt['shift']; ?></td>
	<td><?php echo "-"; ?></td>
</tr>

<?php
		$no++;
		}
	}
?>