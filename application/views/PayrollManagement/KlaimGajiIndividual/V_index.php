<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Klaim Gaji Individual</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/KlaimGajiIndividual');?>">
	            		<i class="icon-wrench icon-2x"></i>
	            		<span><br/></span>
	            	</a>
	            </div>
	          </div>
	        </div>
	      </div>
	      <br/>
	      <?php
			$this->load->view('PayrollManagement/V_alert');
		  ?>
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
					<b>Data Klaim Gaji Individual / Pekerja Keluar</b>
		          </div>
		          <div class="box-body">
					<div class="row">
								<div class="row" style="margin: 10px 0px">
									<form method="post" action="<?php echo base_url('PayrollManagement/KlaimGajiIndividual/search')?>" enctype="multipart/form-data">
										<div class="col-lg-2">
											<input name="txtPeriodeHitung" id="txtPeriodeHitung" type="text" class="form-control">
										</div>
										<div class="col-lg-2">
											<button class="btn btn-warning btn-block">Search</button>
										</div>
									</form>
									<div class="col-lg-3">
									</div>
									<form method="post" action="<?php echo base_url('PayrollManagement/KlaimGajiIndividual/import')?>" enctype="multipart/form-data">
										<div class="col-lg-3">
											<input name="importfile" type="file" class="form-control" readonly required>
										</div>
										<div class="col-lg-2">
											<button class="btn btn-info btn-block">Import</button>
										</div>
									</form>
								</div>
					</div>
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-KlaimGajiIndividual" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
							<th style="text-align:center"><div style="width:100px"></div>Tanggal</th>
							<th style="text-align:center"><div style="width:100px"></div>Noind</th>
							<th style="text-align:center"><div style="width:100px"></div>Kd Hubungan Kerja</th>
							<th style="text-align:center"><div style="width:100px"></div>Kd Status Kerja</th>
							<th style="text-align:center"><div style="width:100px"></div>Kd Jabatan</th>
							<th style="text-align:center"><div style="width:100px"></div>Kodesie</th>
							<th style="text-align:center"><div style="width:100px"></div>Ip</th>
							<th style="text-align:center"><div style="width:100px"></div>Ik</th>
							<th style="text-align:center"><div style="width:100px"></div>I F</th>
							<th style="text-align:center"><div style="width:100px"></div>Ubt</th>
							<th style="text-align:center"><div style="width:100px"></div>Upamk</th>
							<th style="text-align:center"><div style="width:100px"></div>Um</th>
							<th style="text-align:center"><div style="width:100px"></div>Ims</th>
							<th style="text-align:center"><div style="width:100px"></div>Imm</th>
							<th style="text-align:center"><div style="width:100px"></div>Lembur</th>
							<th style="text-align:center"><div style="width:100px"></div>Htm</th>
							<th style="text-align:center"><div style="width:100px"></div>Ijin</th>
							<th style="text-align:center"><div style="width:100px"></div>Pot</th>
							<th style="text-align:center"><div style="width:100px"></div>Tamb Gaji</th>
							<th style="text-align:center"><div style="width:100px"></div>Hl</th>
							<th style="text-align:center"><div style="width:100px"></div>Ct</th>
							<th style="text-align:center"><div style="width:100px"></div>Putkop</th>
							<th style="text-align:center"><div style="width:100px"></div>Plain</th>
							<th style="text-align:center"><div style="width:100px"></div>Pikop</th>
							<th style="text-align:center"><div style="width:100px"></div>Pspsi</th>
							<th style="text-align:center"><div style="width:100px"></div>Putang</th>
							<th style="text-align:center"><div style="width:100px"></div>Dl</th>
							<th style="text-align:center"><div style="width:100px"></div>Tkpajak</th>
							<th style="text-align:center"><div style="width:100px"></div>Ttpajak</th>
							<th style="text-align:center"><div style="width:100px"></div>Pduka</th>
							<th style="text-align:center"><div style="width:100px"></div>Utambahan</th>
							<th style="text-align:center"><div style="width:100px"></div>Btransfer</th>
							<th style="text-align:center"><div style="width:100px"></div>Denda Ik</th>
							<th style="text-align:center"><div style="width:100px"></div>P Lebih Bayar</th>
							<th style="text-align:center"><div style="width:100px"></div>Pgp</th>
							<th style="text-align:center"><div style="width:100px"></div>Tlain</th>
							<th style="text-align:center"><div style="width:100px"></div>Xduka</th>
							<th style="text-align:center"><div style="width:100px"></div>Ket</th>
							<th style="text-align:center"><div style="width:100px"></div>Cicil</th>
							<th style="text-align:center"><div style="width:100px"></div>Ubs</th>
							<th style="text-align:center"><div style="width:100px"></div>Ubs Rp</th>
							<th style="text-align:center"><div style="width:100px"></div>P Um Puasa</th>
							<th style="text-align:center"><div style="width:100px"></div>Kd Jns Transaksi</th>
							<th style="text-align:center"><div style="width:100px"></div>Kd Log Trans</th>
		                  </tr>
		                </thead>   
  <tbody>
							<?php $no = 1; 
							if(!empty($KlaimGajiIndividual_data)){
								foreach($KlaimGajiIndividual_data as $row) { ?>
								<tr>
								<td align='center'><?php echo $no++;?></td>
								<td align='center'><?php echo $row->tanggal ?></td>
								<td align='center'><?php echo $row->noind ?></td>
								<td align='center'><?php echo $row->kd_hubungan_kerja ?></td>
								<td align='center'><?php echo $row->kd_status_kerja ?></td>
								<td align='center'><?php echo $row->kd_jabatan ?></td>
								<td align='center'><?php echo $row->kodesie ?></td>
								<td align='center'><?php echo $row->ip ?></td>
								<td align='center'><?php echo $row->ik ?></td>
								<td align='center'><?php echo $row->i_f ?></td>
								<td align='center'><?php echo $row->ubt ?></td>
								<td align='center'><?php echo $row->upamk ?></td>
								<td align='center'><?php echo $row->um ?></td>
								<td align='center'><?php echo $row->ims ?></td>
								<td align='center'><?php echo $row->imm ?></td>
								<td align='center'><?php echo $row->lembur ?></td>
								<td align='center'><?php echo $row->htm ?></td>
								<td align='center'><?php echo $row->ijin ?></td>
								<td align='center'><?php echo $row->pot ?></td>
								<td align='center'><?php echo $row->tamb_gaji ?></td>
								<td align='center'><?php echo $row->hl ?></td>
								<td align='center'><?php echo $row->ct ?></td>
								<td align='center'><?php echo $row->putkop ?></td>
								<td align='center'><?php echo $row->plain ?></td>
								<td align='center'><?php echo $row->pikop ?></td>
								<td align='center'><?php echo $row->pspsi ?></td>
								<td align='center'><?php echo $row->putang ?></td>
								<td align='center'><?php echo $row->dl ?></td>
								<td align='center'><?php echo $row->tkpajak ?></td>
								<td align='center'><?php echo $row->ttpajak ?></td>
								<td align='center'><?php echo $row->pduka ?></td>
								<td align='center'><?php echo $row->utambahan ?></td>
								<td align='center'><?php echo $row->btransfer ?></td>
								<td align='center'><?php echo $row->denda_ik ?></td>
								<td align='center'><?php echo $row->p_lebih_bayar ?></td>
								<td align='center'><?php echo $row->pgp ?></td>
								<td align='center'><?php echo $row->tlain ?></td>
								<td align='center'><?php echo $row->xduka ?></td>
								<td align='center'><?php echo $row->ket ?></td>
								<td align='center'><?php echo $row->cicil ?></td>
								<td align='center'><?php echo $row->ubs ?></td>
								<td align='center'><?php echo $row->ubs_rp ?></td>
								<td align='center'><?php echo $row->p_um_puasa ?></td>
								<td align='center'><?php echo $row->kd_jns_transaksi ?></td>
								<td align='center'><?php echo $row->kd_log_trans ?></td>
								</tr>
								<?php }
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
	</div>
</section>