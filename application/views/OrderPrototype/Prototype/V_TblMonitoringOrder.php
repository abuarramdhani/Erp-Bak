<table class="table table-bordered" id="mon_order">
									<thead class="bg-teal">
										<tr>
											<th class="text-center bg-teal">Status</th>
											<th class="text-center bg-teal">No Order</th>
											<th class="text-center bg-teal">Kode Komponen</th>
											<th class="text-center bg-teal">Nama Komponen</th>
											<th class="text-center">Tgl Order</th>
											<th class="text-center">D/D Order</th>
											<th class="text-center">Type</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Tgl Kirim Material</th>
											<th class="text-center">Gambar Kerja</th>
											<th class="text-center">Ket</th>
											<th class="text-center">Tgl Diterima Material</th>
											<th class="text-center">Tgl Job Turun</th>
											<th class="text-center">Progress</th>
											<th class="text-center">Last Update</th>
											<th class="text-center">PIC Fabrikasi</th>
											<th class="text-center">Qty Finish</th>
											<th class="text-center">Kirim</th>
											<th class="text-center">Terima</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $ord=1; foreach ($monitor as $mon) {
											if ($mon['kirim'] != null && $mon['terima'] == null){
												$background = 'bg-warning';
											} else if ($mon['terima']== null) {
												$background = 'bg-success';
											} else{
												$background = 'bg-danger';

											}
											?>
										<tr class="<?=$background?>">
											<?php if ($mon['terima'] == null) {?>
											<td class="text-center <?=$background?>"><input type="hidden" value="OPEN" name="">OPEN</td>
											<?php } else { ?>
											<td class="text-center <?=$background?>"><input type="hidden" value="CLOSED" name="">CLOSED</td>
											<?php } ?>
											<td class="text-center <?=$background?>"><input type="hidden" value="<?=$mon['no_order']?>" id="no_order<?=$ord?>" name=""><?=$mon['no_order']?></td>


											<td class="text-center <?=$background?>"><input type="hidden" value="<?=$mon['kode_komponen']?>" name=""><?=$mon['kode_komponen']?></td>

											<td class="text-center <?=$background?>"><input type="hidden" value="<?=$mon['nama_komponen']?>" name=""><?=$mon['nama_komponen']?></td>

											<td class="text-center"><input type="hidden" value="<?=date('d-M-Y',strtotime($mon['tgl_order']))?>" name=""><?=date('d-M-Y',strtotime($mon['tgl_order']))?></td>

											<td class="text-center"><input type="hidden" value="<?=date('d-M-Y',strtotime($mon['dd_order']))?>" name=""><?=date('d-M-Y',strtotime($mon['dd_order']))?></td>

										
											<?php if ($mon['type'] != null) { ?>
												<td class="text-center"><input type="hidden" value="<?=$mon['type']?>" name=""><?=$mon['type']?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											
											<?php if ($mon['qty'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=$mon['qty']?>" name=""><?=$mon['qty']?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											<?php if ($mon['tgl_kirim_material'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=date('d-M-Y',strtotime($mon['tgl_kirim_material']))?>" name=""><?=date('d-M-Y',strtotime($mon['tgl_kirim_material']))?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											<td class="text-center"><button onclick="lihatgambar(<?=$ord?>)" class="btn btn-info btn-xs">View</button></td>

										
											<?php if ($mon['keterangan'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=$mon['keterangan']?>" name=""><?=$mon['keterangan']?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											<?php if ($mon['tgl_terima_material'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=date('d-M-Y H:i:s',strtotime($mon['tgl_terima_material']))?>" name=""><?=date('d-M-Y H:i:s',strtotime($mon['tgl_terima_material']))?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											

											<?php if ($mon['tgl_job_turun'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=date('d-M-Y',strtotime($mon['tgl_job_turun']))?>" name=""><?=date('d-M-Y',strtotime($mon['tgl_job_turun']))?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											<td class="text-center"><button onclick="lihatprogress(<?=$ord?>)" class="btn btn-primary btn-xs">Detail</button></td>

											<?php if ($mon['last_updated_date'] != null) { ?>
												<td class="text-center"><input type="hidden" value="<?=$mon['last_updated_date']?>" name=""><?=$mon['last_updated_date']?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>


											<?php if ($mon['pic_fabrikasi'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=$mon['pic_fabrikasi']?>" name=""><?=$mon['pic_fabrikasi']?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											

											<?php if ($mon['qty_finish'] != null) { ?>
											<td class="text-center"><input type="hidden" value="<?=$mon['qty_finish']?>" name=""><?=$mon['qty_finish']?></td>
											<?php } else { ?>
											<td class="text-center">-</td>
											<?php } ?>

											
											<?php if ($mon['kirim'] == null) { ?>
											<td class="text-center"><i style="color: red" class="fa fa- fa-remove fa-2x"></i></td>
											<?php } else { ?>
											<td class="text-center"><i style="color: green" class="fa fa- fa-check fa-2x"></i><br><?=date('d-M-Y H:i:s',strtotime($mon['tgl_act_kirim']))?></td></td>
											<?php } ?>

											<?php if ($mon['kirim'] != null && $mon['terima'] == null) { ?>
											<td class="text-center"><button onclick="terima(<?=$ord?>)" style="margin-top: 2px" class="btn btn-danger btn-xs">Terima</button></td>
											<?php } else if ($mon['kirim'] == null && $mon['terima'] == null) { ?>
											<td class="text-center"><i style="color: red" class="fa fa- fa-remove fa-2x"></i></td>
											<?php } else {  ?>
											<td class="text-center"><i style="color: green" class="fa fa- fa-check fa-2x"></i><br><?=date('d-M-Y H:i:s',strtotime($mon['tgl_act_terima']))?></td></td>
											<?php }  ?>
											
											<td class="text-center"><button onclick="edit(<?=$ord?>)" class="btn btn-warning btn-xs">Edit</button></td>
										</tr>

										
										<?php $ord++; } ?>
									</tbody>
								</table>