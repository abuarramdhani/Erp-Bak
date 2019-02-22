    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/buttons.dataTables.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css');?>" />
    
	<script src="<?php echo base_url('assets/js/customICT.js');?>" type="text/javascript"></script>	

<table class="table table-striped table-bordered table-hover text-left" id="tblHasilMnt" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Tanggal Monitoring</center></th>
												<th width="30%"><center>Aspek</center></th>
												<th width="10%"><center>No. Order</center></th>
												<th width="20%"><center>info</center></th>
												<th width="15%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
										<?php $no=1; foreach ($DataHasil as $DHasil) { ?>
											<tr >
												<td><center><?= $no++; ?></center></td>	
												<td><?= date('d M Y',strtotime($DHasil['tgl_monitoring']) ) ?> </td>
												<td><?php 
														foreach ($DHasil['aspek_hasil'] as $asp) {
															if ($asp['jenis_standar'] =='nn') {
																$hasil = $asp['hasil_pengecekan'] == '1' ? 'Y' : 'T';
															}else{
																$hasil = $asp['hasil_pengecekan'].' %';
															}

															echo ' - '.$asp['aspek']. '<b>['.$hasil.']</b><br>';
														}
													?>
												</td>
												<td>
													<center>
													<?php 
														if ($DHasil['nomor_order'] != null) {
															if (isset($DHasil['status_order'])) {
															 echo $DHasil['status_order'] == 'closed' 
															 ?'<a target="_blank"  
															 	href="http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id='.$DHasil['ticket_id'].'">
															 	<span class="badge bg-green ">'.$DHasil['nomor_order'].' (CLOSED)</span></a>'
															 :'<a target="_blank"  
															 	href="http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id='.$DHasil['ticket_id'].'">
															 	<span class="badge bg-red faa-flash faa-slow animated">'.$DHasil['nomor_order'].'</span></a>';
															}else{
															 echo '<a target="_blank"  
															 	href="http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id='.$DHasil['ticket_id'].'">
															 	<span class="badge bg-red faa-flash faa-slow animated">'.$DHasil['nomor_order'].'</span> </a>';
															}
														}else{
															echo '<span class="badge bg-green "> - </span>';
														}
													?>
													</center>
												</td>
												<td><?= $DHasil['info']; ?></td>
												<td><center>
													<a title="<?= 'Edit '.date('d M Y',strtotime($DHasil['tgl_monitoring']) ) ?>" href="<?= base_url("MonitoringICT/JobListMonitoring/Edit/$DHasil[hasil_monitoring_id]") ?>">
													<button  class="btn btn-sm btn-warning "> Edit </button>
													</a>
													<button data-toggle="modal" data-target="#confirmDel_<?= $DHasil['hasil_monitoring_id'] ?>" class="btn btn-sm btn-danger "> Delete </button>
													</center>
												</td>
											</tr>
										<?php } ?>
										</tbody>
									</table>