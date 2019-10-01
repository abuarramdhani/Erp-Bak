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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MemoPindahMakan');?>">
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
								<h3 class="box-title">Daftar Memo Pindah Lokasi Makan</h3>
								<a href="<?php echo site_url('OnJobTraining/MemoPindahMakan/create_MemoPindahMakan/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
							</div>
							<div class="box-body">
								<table class="table table-bordered" id="MonitoringOJT-memoPindahMakan">
									<thead>
										<tr>
											<th width="5%" class="text-center">No.</th>
											<th class="text-center">Jenis Training</th>
											<th class="text-center">Periode</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no 	=	1;
											foreach ($tampil_memo as $key)
											{
												$encrypted_string 	=	$this->general->enkripsi($key['id_pindah']);
										?>
										<tr>
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center"><?php echo $key['jenis_memo']; ?></td>
											<td class="text-center"><?php echo $key['periode_memo']; ?></td>
											<td class="text-center">
												<a target="_blank" style="margin-right:4px" href="<?php echo base_url('OnJobTraining/MemoPindahMakan/export_pdf_memo_makan/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Export PDF"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                        <a style="margin-right:4px" href="<?php echo base_url('OnJobTraining/MemoPindahMakan/updatePindahMakan/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Memo"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                        <a class="fa fa-trash fa-2x deleteMemoMakan" data-toggle="tooltip" data-placement="bottom" title="Hapus Memo" data-value="<?php echo $encrypted_string; ?>"></a>
											</td>
										</tr>
										<?php
												$no++;
											}
										?>
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
