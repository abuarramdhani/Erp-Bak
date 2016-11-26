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

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-masterPekerja" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center; width:240px'>ACTION</th>
							<th>No Induk</th>
							<th>Kd Hubungan Kerja</th>
							<th>Kd Status Kerja</th>
							<th>Nik</th>
							<th>No Kk</th>
							<th>Nama</th>
							<th>Id Kantor Asal</th>
							<th>Id Lokasi Kerja</th>
							<th>Jns Kelamin</th>
							<th>Tempat Lahir</th>
							<th>Tgl Lahir</th>
							<th>Alamat</th>
							<th>Desa</th>
							<th>Kecamatan</th>
							<th>Kabupaten</th>
							<th>Provinsi</th>
							<th>Kode Pos</th>
							<th>No Hp</th>
							<th>Gelar D</th>
							<th>Gelar B</th>
							<th>Pendidikan</th>
							<th>Jurusan</th>
							<th>Sekolah</th>
							<th>Stat Nikah</th>
							<th>Tgl Nikah</th>
							<th>Jml Anak</th>
							<th>Jml Sdr</th>
							<th>Diangkat</th>
							<th>Masuk Kerja</th>
							<th>Kodesie</th>
							<th>Gol Kerja</th>
							<th>Kd Asal Outsourcing</th>
							<th>Kd Jabatan</th>
							<th>Jabatan</th>
							<th>Npwp</th>
							<th>No Kpj</th>
							<th>Lm Kontrak</th>
							<th>Akh Kontrak</th>
							<th>Stat Pajak</th>
							<th>Jt Anak</th>
							<th>Jt Bkn Anak</th>
							<th>Tgl Spsi</th>
							<th>No Spsi</th>
							<th>Tgl Kop</th>
							<th>No Koperasi</th>
							<th>Keluar</th>
							<th>Tgl Keluar</th>
							<th>Kd Pkj</th>
							<th>Angg Jkn</th>

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