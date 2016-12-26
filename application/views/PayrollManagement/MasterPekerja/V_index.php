<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Master Pekerja</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterPekerja');?>">
	            		<i class="icon-wrench icon-2x"></i>
	            		<span><br/></span>
	            	</a>
	            </div>
	          </div>
	        </div>
	      </div>
	      <br/>
	      
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
                  <a href="<?php echo site_url('PayrollManagement/MasterPekerja/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Master Pekerja</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<form method="post" action="<?php echo base_url('PayrollManagement/MasterPekerja/import')?>" enctype="multipart/form-data">
							<div class="row" style="margin: 10px 10px">
									<div class="col-lg-offset-7 col-lg-3">
										<input name="importfile" type="file" class="form-control" readonly required>
									</div>
									<div class="col-lg-2">
										<button class="btn btn-info btn-block">Import</button>
									</div>
								</div>
						</form>
					</div>
		            <div class="table-responsive">
					  <table class="table table-striped table-bordered table-hover text-left" id="dataTables-masterPekerja" style="font-size:12px;">
						<thead class="bg-primary">
							<tr>
								<th style="text-align:center"><div style="width:40px"></div>NO</th>
								<th style='text-align:center'><div style="width:120px"></div>ACTION</th>
								<th><div style="width:80px"></div>No Induk</th>
								<th><div style="width:50px"></div>Kode Hub Kerja</th>
								<th><div style="width:50px"></div>Kode Status Kerja</th>
								<th><div style="width:120px"></div>NIK</th>
								<th><div style="width:120px"></div>No KK</th>
								<th><div style="width:200px"></div>Nama</th>
								<th><div style="width:40px"></div>Id Kantor Asal</th>
								<th><div style="width:40px"></div>Id Lokasi Kerja</th>
								<th><div style="width:40px"></div>Jenis Kelamin</th>
								<th><div style="width:100px"></div>Tempat Lahir</th>
								<th><div style="width:120px"></div>Tanggal Lahir</th>
								<th><div style="width:350px"></div>Alamat</th>
								<th><div style="width:150px"></div>Desa</th>
								<th><div style="width:150px"></div>Kecamatan</th>
								<th><div style="width:150px"></div>Kabupaten</th>
								<th><div style="width:150px"></div>Provinsi</th>
								<th><div style="width:60px"></div>Kode Pos</th>
								<th><div style="width:120px"></div>No Hp</th>
								<th><div style="width:50px"></div>Gelar D</th>
								<th><div style="width:50px"></div>Gelar B</th>
								<th><div style="width:40px"></div>Pendidikan</th>
								<th><div style="width:200px"></div>Jurusan</th>
								<th><div style="width:300px"></div>Sekolah</th>
								<th><div style="width:50px"></div>Stat Nikah</th>
								<th><div style="width:120px"></div>Tanggal Nikah</th>
								<th><div style="width:50px"></div>Jumlah Anak</th>
								<th><div style="width:50px"></div>Jumlah Saudara</th>
								<th><div style="width:120px"></div>Diangkat</th>
								<th><div style="width:120px"></div>Masuk Kerja</th>
								<th><div style="width:50px"></div>Kodesie</th>
								<th><div style="width:50px"></div>Gol Kerja</th>
								<th><div style="width:50px"></div>Kode Asal Outsourcing</th>
								<th><div style="width:50px"></div>Kode Jabatan</th>
								<th><div style="width:500px"></div>Jabatan</th>
								<th><div style="width:200px"></div>NPWP</th>
								<th><div style="width:200px"></div>No KPJ</th>
								<th><div style="width:50px"></div>Lama Kontrak</th>
								<th><div style="width:120px"></div>Akhir Kontrak</th>
								<th><div style="width:100px"></div>Stat Pajak</th>
								<th><div style="width:50px"></div>Jt Anak</th>
								<th><div style="width:50px"></div>Jt Bukan Anak</th>
								<th><div style="width:120px"></div>Tanggal Spsi</th>
								<th><div style="width:200px"></div>No Spsi</th>
								<th><div style="width:120px"></div>Tanggal Kop</th>
								<th><div style="width:100px"></div>No Koperasi</th>
								<th><div style="width:40px"></div>Keluar</th>
								<th><div style="width:120px"></div>Tanggal Keluar</th>
								<th><div style="width:100px"></div>Kode Pkj</th>
								<th><div style="width:50px"></div>Angg Jkn</th>
							</tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($masterPekerja_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/MasterPekerja/read/'.$row->noind.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/MasterPekerja/update/'.$row->noind.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/MasterPekerja/delete/'.$row->noind.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->noind ?></td>
							<td><?php echo $row->kd_hubungan_kerja ?></td>
							<td><?php echo $row->kd_status_kerja ?></td>
							<td><?php echo $row->nik ?></td>
							<td><?php echo $row->no_kk ?></td>
							<td><?php echo $row->nama ?></td>
							<td><?php echo $row->id_kantor_asal ?></td>
							<td><?php echo $row->id_lokasi_kerja ?></td>
							<td><?php echo $row->jns_kelamin ?></td>
							<td><?php echo $row->tempat_lahir ?></td>
							<td><?php echo $row->tgl_lahir ?></td>
							<td><?php echo $row->alamat ?></td>
							<td><?php echo $row->desa ?></td>
							<td><?php echo $row->kecamatan ?></td>
							<td><?php echo $row->kabupaten ?></td>
							<td><?php echo $row->provinsi ?></td>
							<td><?php echo $row->kode_pos ?></td>
							<td><?php echo $row->no_hp ?></td>
							<td><?php echo $row->gelar_d ?></td>
							<td><?php echo $row->gelar_b ?></td>
							<td><?php echo $row->pendidikan ?></td>
							<td><?php echo $row->jurusan ?></td>
							<td><?php echo $row->sekolah ?></td>
							<td><?php echo $row->stat_nikah ?></td>
							<td><?php echo $row->tgl_nikah ?></td>
							<td><?php echo $row->jml_anak ?></td>
							<td><?php echo $row->jml_sdr ?></td>
							<td><?php echo $row->diangkat ?></td>
							<td><?php echo $row->masuk_kerja ?></td>
							<td><?php echo $row->kodesie ?></td>
							<td><?php echo $row->gol_kerja ?></td>
							<td><?php echo $row->kd_asal_outsourcing ?></td>
							<td><?php echo $row->kd_jabatan ?></td>
							<td><?php echo $row->jabatan ?></td>
							<td><?php echo $row->npwp ?></td>
							<td><?php echo $row->no_kpj ?></td>
							<td><?php echo $row->lm_kontrak ?></td>
							<td><?php echo $row->akh_kontrak ?></td>
							<td><?php echo $row->stat_pajak ?></td>
							<td><?php echo $row->jt_anak ?></td>
							<td><?php echo $row->jt_bkn_anak ?></td>
							<td><?php echo $row->tgl_spsi ?></td>
							<td><?php echo $row->no_spsi ?></td>
							<td><?php echo $row->tgl_kop ?></td>
							<td><?php echo $row->no_koperasi ?></td>
							<td><?php echo $row->keluar ?></td>
							<td><?php echo $row->tgl_keluar ?></td>
							<td><?php echo $row->kd_pkj ?></td>
							<td><?php echo $row->angg_jkn ?></td>

							</tr>
							<?php } ?>
		                </tbody>                                      
		              </table>
		            </div>
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>