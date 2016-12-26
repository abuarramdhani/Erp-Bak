<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Data Gajian Personalia</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/DataGajianPersonalia');?>">
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
					<b>Data Gajian Personalia</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<form method="post" action="<?php echo base_url('PayrollManagement/DataGajianPersonalia/import')?>" enctype="multipart/form-data">
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
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-dataGajianPersonalia" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
							<th><div style="width:100px"></div>Tanggal</th>
							<th><div style="width:100px"></div>Noind</th>
							<th><div style="width:100px"></div>Kd Hubungan Kerja</th>
							<th><div style="width:100px"></div>Kd Status Kerja</th>
							<th><div style="width:100px"></div>Kd Jabatan</th>
							<th><div style="width:100px"></div>Kodesie</th>
							<th><div style="width:100px"></div>Ip</th>
							<th><div style="width:100px"></div>Ik</th>
							<th><div style="width:100px"></div>I F</th>
							<th><div style="width:100px"></div>If Htg Bln Lalu</th>
							<th><div style="width:100px"></div>Ubt</th>
							<th><div style="width:100px"></div>Upamk</th>
							<th><div style="width:100px"></div>Um</th>
							<th><div style="width:100px"></div>Ims</th>
							<th><div style="width:100px"></div>Imm</th>
							<th><div style="width:100px"></div>Lembur</th>
							<th><div style="width:100px"></div>Htm</th>
							<th><div style="width:100px"></div>Ijin</th>
							<th><div style="width:100px"></div>Htm Htg Bln Lalu</th>
							<th><div style="width:100px"></div>Ijin Htg Bln Lalu</th>
							<th><div style="width:100px"></div>Pot</th>
							<th><div style="width:100px"></div>Tamb Gaji</th>
							<th><div style="width:100px"></div>Hl</th>
							<th><div style="width:100px"></div>Ct</th>
							<th><div style="width:100px"></div>Putkop</th>
							<th><div style="width:100px"></div>Plain</th>
							<th><div style="width:100px"></div>Pikop</th>
							<th><div style="width:100px"></div>Pspsi</th>
							<th><div style="width:100px"></div>Putang</th>
							<th><div style="width:100px"></div>Dl</th>
							<th><div style="width:100px"></div>Tkpajak</th>
							<th><div style="width:100px"></div>Ttpajak</th>
							<th><div style="width:100px"></div>Pduka</th>
							<th><div style="width:100px"></div>Utambahan</th>
							<th><div style="width:100px"></div>Btransfer</th>
							<th><div style="width:100px"></div>Denda Ik</th>
							<th><div style="width:100px"></div>P Lebih Bayar</th>
							<th><div style="width:100px"></div>Pgp</th>
							<th><div style="width:100px"></div>Tlain</th>
							<th><div style="width:100px"></div>Xduka</th>
							<th><div style="width:100px"></div>Ket</th>
							<th><div style="width:100px"></div>Cicil</th>
							<th><div style="width:100px"></div>Ubs</th>
							<th><div style="width:100px"></div>Ubs Rp</th>
							<th><div style="width:100px"></div>P Um Puasa</th>
							<th><div style="width:100px"></div>Kd Jns Transaksi</th>
							<th><div style="width:100px"></div>Kode Petugas</th>
							<th><div style="width:100px"></div>Tgl Jam Record</th>
							<th><div style="width:100px"></div>Kd Log Trans</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($dataGajianPersonalia_data as $row) { ?>
							<tr>
							<td align='center'><?php echo $no++;?></td>
							<td><?php echo $row->tanggal ?></td>
							<td><?php echo $row->noind ?></td>
							<td><?php echo $row->kd_hubungan_kerja ?></td>
							<td><?php echo $row->kd_status_kerja ?></td>
							<td><?php echo $row->kd_jabatan ?></td>
							<td><?php echo $row->kodesie ?></td>
							<td><?php echo $row->ip ?></td>
							<td><?php echo $row->ik ?></td>
							<td><?php echo $row->i_f ?></td>
							<td><?php echo $row->if_htg_bln_lalu ?></td>
							<td><?php echo $row->ubt ?></td>
							<td><?php echo $row->upamk ?></td>
							<td><?php echo $row->um ?></td>
							<td><?php echo $row->ims ?></td>
							<td><?php echo $row->imm ?></td>
							<td><?php echo $row->lembur ?></td>
							<td><?php echo $row->htm ?></td>
							<td><?php echo $row->ijin ?></td>
							<td><?php echo $row->htm_htg_bln_lalu ?></td>
							<td><?php echo $row->ijin_htg_bln_lalu ?></td>
							<td><?php echo $row->pot ?></td>
							<td><?php echo $row->tamb_gaji ?></td>
							<td><?php echo $row->hl ?></td>
							<td><?php echo $row->ct ?></td>
							<td><?php echo $row->putkop ?></td>
							<td><?php echo $row->plain ?></td>
							<td><?php echo $row->pikop ?></td>
							<td><?php echo $row->pspsi ?></td>
							<td><?php echo $row->putang ?></td>
							<td><?php echo $row->dl ?></td>
							<td><?php echo $row->tkpajak ?></td>
							<td><?php echo $row->ttpajak ?></td>
							<td><?php echo $row->pduka ?></td>
							<td><?php echo $row->utambahan ?></td>
							<td><?php echo $row->btransfer ?></td>
							<td><?php echo $row->denda_ik ?></td>
							<td><?php echo $row->p_lebih_bayar ?></td>
							<td><?php echo $row->pgp ?></td>
							<td><?php echo $row->tlain ?></td>
							<td><?php echo $row->xduka ?></td>
							<td><?php echo $row->ket ?></td>
							<td><?php echo $row->cicil ?></td>
							<td><?php echo $row->ubs ?></td>
							<td><?php echo $row->ubs_rp ?></td>
							<td><?php echo $row->p_um_puasa ?></td>
							<td><?php echo $row->kd_jns_transaksi ?></td>
							<td><?php echo $row->kode_petugas ?></td>
							<td><?php echo $row->tgl_jam_record ?></td>
							<td><?php echo $row->kd_log_trans ?></td>

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