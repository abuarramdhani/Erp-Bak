<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/gajipekerjacutoff');?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Daftar Memo Pemberitahuan Gaji Pekerja Cutoff</h3>
								<a href="<?php echo site_url('MasterPekerja/Surat/gajipekerjacutoff/create_Info/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
							</div>
							<div class="box-body">
								<table class="table table-bordered dataTable" id="MP_GajiCutoff">
									<thead>
										<tr>
											<th width="5%" class="text-center">No.</th>
											<th class="text-center">Jenis</th>
											<th class="text-center">Periode Cutoff</th>
											<th class="text-center">Tanggal Pembuatan</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no 	=	1;
											foreach ($database as $key) { ?>
										<tr>
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center"><?php if ($key['staff'] == 't') {
												$status = 'Staf';
											}elseif ($key['staff'] == 'f') {
												$status = 'Non Staf';
											}echo $status; ?></td>
											<td class="text-center"><?php echo $key['periode']; ?></td>
											<td class="text-center"><?php echo $key['update_date']; ?></td>
											<td class="text-center">
												<a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/gajipekerjacutoff/exportPDF/'.$key['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Export PDF"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                        <!-- <a style="margin-right:4px" href="<?php //echo base_url('MasterPekerja/Surat/gajipekerjacutoff/updateMemo/'.$key['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Memo"><span class="fa fa-pencil-square-o fa-2x"></span></a> -->
                        <a class="fa fa-trash fa-2x deleteMemoCutoff" data-toggle="tooltip" data-placement="bottom" title="Hapus Memo" data-value="<?php echo $key['id'] ?>"></a>
											</td>
										</tr>
										<?php
												$no++;
											} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
