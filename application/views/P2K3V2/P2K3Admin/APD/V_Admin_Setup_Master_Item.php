<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>Setup Master Item</b></h1>
					</div>
				</div>
				<div class="col-lg-1">
					<div class="text-right hidden-md hidden-sm hidden-xs">

					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1 "></div>
					</div>
				</div>
				<br />
				<div class="">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<button style="float: right;" class="btn btn-success" data-toggle="modal" data-target="#p2k3_add_item">Add Item</button>
										</div>
										<div class="col-md-12" style="height: 20px;"></div>
										<table class="table table-striped table-bordered table-hover text-center et_jenis_penilaian">
											<thead>
												<tr class="bg-primary">
													<th width="10%">No</th>
													<th>Kode Item</th>
													<th>Nama</th>
													<th>Satuan</th>
													<th>Umur (bulan)</th>
													<th>Image</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1; foreach ($Item as $key): ?>
												<tr>
													<td>
														<?php echo $no; ?>
														<input hidden="" value="<?php echo $key['id']; ?>">
													</td>
													<td class="et_kode"><?php echo $key['kode_item']; ?></td>
													<td class="et_item"><?php echo $key['item']; ?></td>
													<td><?php echo $key['satuan']; ?></td>
													<td class="et_exbulan"><?php echo $key['xbulan']; ?></td>
													<td>
													<?php if (strlen($key['nama_file']) < 4): ?>
														-
													<?php else: ?>
														<button class="btn p2k3_see_image" value="<?php echo $key['nama_file']; ?>" data-nama="<?php echo $key['item'] ?>" data-kode="<?php echo $key['kode_item'] ?>">
															<i class="fa fa-file-image-o" aria-hidden="true"></i>
														</button>
													<?php endif ?>
													</td>
													<td>
														<form method="post" action="<?php echo base_url('p2k3adm_V2/Admin/HapusMasterItem'); ?>" onsubmit="return confirm('Apa Anda Yakin Ingin Menghapus Item Ini?');">
															<button type="button" class="btn btn-info btn-sm et_edit_masterItem">
																<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
															</button>
															<button type="submit" name="hapus_id" value="<?php echo $key['id']; ?>" class="btn btn-danger btn-sm et_del_masterItem" data-toggle="tooltip" data-placement="top" title="Hapus">
																<i class="fa fa-trash-o" aria-hidden="true"></i>
															</button>
														</form>
													</td>
												</tr>
												<?php $no++; endforeach ?>
											</tbody>
										</table>
									</div>
									<div style="height: 50px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="p2k3_edit_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<form method="post" action="<?php echo base_url('p2k3adm_V2/Admin/EditMasterItem'); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel">Edit Item</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<label class="control-label">Kode Item</label>
						<input class="form-control" id="p2k3_kode_item" disabled="">
						<input hidden="" id="p2k3_kode_item2" name="kode_item">
						<br>
						<label class="control-label">Nama Item</label>
						<input class="form-control" id="p2k3_nama_item" disabled="">
						<br>
						<label class="control-label">Umur (bulanan)</label>
						<input required="" type="number" class="form-control" id="p2k3_bulan_item" name="et_bulan_item">
						<br>
						<label class="control-label">File</label>
						<input type="file" class="form-control" name="et_file_item">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="p2k3_add_item" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<form method="post" action="<?php echo base_url('p2k3adm_V2/Admin/AddMasterItem'); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel">Add Item</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<label>Item</label>
						<select style="width: 100%" required="" class="form-control p2k3_select2Item col-md-12" name="item">
							<option></option>
							<?php foreach ($Oracle as $key): ?>
								<option data-satuan="<?php echo $key['SATUAN']; ?>" value="<?php echo $key['ITEM'].'-'.$key['KODE_ITEM']; ?>">
								<?php echo $key['KODE_ITEM'].' - '.$key['ITEM']; ?>
								</option>
							<?php endforeach ?>
						</select>
						<br>
						<br>
						<label>Satuan</label>
						<input required="" readonly="" readonly="" class="form-control" name="setItem" id="p2k3_setItem">
						<br>
						<label>Umur (bulan)</label>
						<input min="1" required="" class="form-control" type="number" name="xbulan" placeholder="Umur (bulan)">
						<br>
						<label>File Gambar</label>
						<input type="file" name="et_file_item" class="form-control">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
	<img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
