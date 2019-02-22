<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Browse Transaksi Penggajian</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHutang');?>">
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
                    <b>Transaksi Penggajian</b>
		          </div>
		          <div class="box-body">
		         <!--  <div class="table-responsive">  -->
				    <div class="row">
			              <form method="post" action="<?php echo base_url('PayrollManagement/BrowseTransaksiPenggajian/Check')?>" enctype="multipart/form-data">
						    <div class="row" style="margin: 10px 0 10px 0px">
							  <div class="col-lg-2">
									<input type="text" name="txtPeriodeHitung" id="txtPeriodeHitung" class="form-control" placeholder="[ Periode Hitung ]"></input>
							  </div>
							  <div class=" col-lg-2">
							    <button class="btn btn-primary btn-block">Proses Gaji</button>
							  </div>
							  <div class=" col-lg-6">
							  </div>
							  <div class=" col-lg-2">
							    <a data-toggle="tooltip" id="btn-reg-person" title="Cetak Struk" href='<?php echo site_URL() ?>PayrollManagement/BrowseTransaksiPenggajian/CetakStruk/<?php echo $encDate; ?>' class="btn btn-success btn-md btn-refresh-db" style="float:right;" target="blank_">Cetak Struk</a>
							  </div>
						  </form>
			          </div>
		            </div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiPenggajian" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>Act</th>
                            <th style='text-align:center'><div style="width:100px"></div>Tanggal</th>
							<th style='text-align:center;'><div style="width:100px"></div>Noind</th>
							<th style='text-align:center;'><div style="width:100px"></div>Nama</th>
							<th style='text-align:center;'><div style="width:100px">Jabatan</div></th>
							<th style='text-align:center;'><div style="width:100px"></div>Jabatan Upah</th>
							<th style='text-align:center;'><div style="width:100px"></div>Kodesie</th>
							<th style='text-align:center;'><div style="width:100px"></div>Bank</th>
							<th style='text-align:center;'><div style="width:100px"></div>Gaji Pokok</th>
							<th style='text-align:center;'><div style="width:100px"></div>Gaji Asuransi</th>
							<th style='text-align:center;'><div style="width:100px"></div>Gaji Bln ini</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IF</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IF</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IKR</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IKR</th>
							<th style='text-align:center;'><div style="width:100px"></div>T IKR</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IKMHL</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IKMHL</th>
							<th style='text-align:center;'><div style="width:100px"></div>T IKMHL</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IP</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IP</th>
							<th style='text-align:center;'><div style="width:100px"></div>T IP</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IK</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IK</th>
							<th style='text-align:center;'><div style="width:100px"></div>T IK</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IMS</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IMS</th>
							<th style='text-align:center;'><div style="width:100px"></div>T IMS</th>
							<th style='text-align:center;'><div style="width:100px"></div>P IMM</th>
							<th style='text-align:center;'><div style="width:100px"></div>N IMM</th>
							<th style='text-align:center;'><div style="width:100px"></div>T IMM</th>
							<th style='text-align:center;'><div style="width:100px"></div>P Lembur</th>
							<th style='text-align:center;'><div style="width:100px"></div>N Lembur</th>
							<th style='text-align:center;'><div style="width:100px"></div>T Lembur</th>
							<th style='text-align:center;'><div style="width:100px"></div>P UBT</th>
							<th style='text-align:center;'><div style="width:100px"></div>N UBT</th>
							<th style='text-align:center;'><div style="width:100px"></div>T UBT</th>
							<th style='text-align:center;'><div style="width:100px"></div>P UPAMK</th>
							<th style='text-align:center;'><div style="width:100px"></div>N UPAMK</th>
							<th style='text-align:center;'><div style="width:100px"></div>T UPAMK</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Bln Lalu</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Angkat</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Sisa Cuti</th>
							<th style='text-align:center;'><div style="width:100px"></div>TK Pajak</th>
							<th style='text-align:center;'><div style="width:100px"></div>Komp. Lembur</th>
							<th style='text-align:center;'><div style="width:100px"></div>Rapel Gaji</th>
							<th style='text-align:center;'><div style="width:100px"></div>HTM</th>
							<th style='text-align:center;'><div style="width:100px"></div>Ijin</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. HTM</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Sakit</th>
							<th style='text-align:center;'><div style="width:100px;font:red;"></div>Sub. Dibayarkan</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim DL</th>
							<th style='text-align:center;'><div style="width:100px"></div>THR</th>
							<th style='text-align:center;'><div style="width:100px"></div>UBTH</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Sdh Bayar</th>
							<th style='text-align:center;'><div style="width:100px"></div>Tamb Subs Pajak</th>
							<th style='text-align:center;'><div style="width:100px;font:red;"></div>Subtotal 1</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Klaim DL</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. THR</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. UBTHR</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Klaim Sdh Byr</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Subs Pajak</th>
		                    <th style='text-align:center;'><div style="width:100px;font:red;"></div>Subtotal 2</th>
							<th style='text-align:center;'><div style="width:100px"></div>Kor. Pot. Bln Lalu</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. JHT</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. JKN</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. JPN</th>
							<th style='text-align:center;'><div style="width:100px"></div>Putkop</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pikop</th>
							<th style='text-align:center;'><div style="width:100px"></div>Potkop</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Hutang</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Duka</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. SPSI</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Dana Pensiun</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Lain-lain</th>
							<th style='text-align:center;'><div style="width:100px"></div>B. Transfer</th>
							<th style='text-align:center;'><div style="width:100px;font:red;"></div>Subtotal 3</th>
							<th style='text-align:center;'><div style="width:100px;"></div>Jns Traksaksi</th>
						  </tr>
		                </thead>
		                <tbody>
						<?php 
							if(!empty($getDataPenggajian_data)){ 
							$no= 0;
							foreach($getDataPenggajian_data as $row){
							$no++;
							$enc_id = $this->encrypt->encode($row->id_pembayaran_gaji);
							$enc_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_id);
						?>
						<tr>
							<td align="center"><?php echo $no; ?></td>
							<td align='center'>
								<a href="<?php echo base_url('PayrollManagement/BrowseTransaksiPenggajian/read/'.$enc_id.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data" target="blank_"><span class="fa fa-eye"></span></a>
							</td>
							<td align="center"><?php echo $row->tanggal ?></td>
							<td align="center"><?php echo $row->noind ?></td>
							<td align="left"><?php echo $row->nama ?></td>
							<td align="center"><?php echo $row->kd_jabatan; ?></div></td>
							<td align="center">-</td>
							<td align="center"><?php echo $row->kodesie; ?></td>
							<td align="center"><?php echo $row->kd_bank; ?></td>
							<td align="center"><?php echo number_format((int)$row->gaji_pokok); ?></td>
							<td align="center"><?php echo number_format((int)$row->gaji_asuransi); ?></td>
							<td align="center"><?php echo number_format((int)$row->gaji_bln_ini); ?></td>
							<td align="center"><?php echo number_format((int)$row->p_if); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_if); ?></td>
							<td align="center"><?php echo number_format((int)$row->p_ikr); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_ikr); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_ikmhl); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_ikmhl); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_ip); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_ip); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_ik); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_ik); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_ims); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_ims); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_imm); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_imm); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_lembur); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_lembur); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->p_ubt); ?></td>
							<td align="center"><?php echo number_format((int)$row->n_ubt); ?></td>
							<td align="center"><?php echo number_format((int)$row->t_ubt); ?></td>
							<td align="center"><?php echo number_format((int)$row->p_upamk); ?></td>
							<td align="center">0</td>
							<td align="center"><?php echo number_format((int)$row->t_upamk); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_bln_lalu); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_pengangkatan); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_sisa_cuti); ?></td>
							<td align="center"><?php echo number_format((int)$row->tkena_pajak); ?></td>
							<td align="center"><?php echo number_format((int)$row->konpensasi_lembur); ?></td>
							<td align="center"><?php echo number_format((int)$row->rapel_gaji); ?></td>
							<td align="center"><?php echo number_format((int)$row->htm); ?></td>
							<td align="center"><?php echo number_format((int)$row->ijin); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_htm); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_sakit_berkepanjangan); ?></td>
							<td align="center"><div style="width:100px);font:red);"></div><?php echo number_format((int)$row->subtotal_dibayarkan); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_dl); ?></td>
							<td align="center"><?php echo number_format((int)$row->thr); ?></td>
							<td align="center"><?php echo number_format((int)$row->ubthr); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_sdh_byr); ?></td>
							<td align="center"><?php echo number_format((int)$row->pajak); ?></td>
							<td align="center"><div style="width:100px);font:red);"></div><?php echo number_format((int)$row->subtotal1); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_dl); ?></td>
							<td align="center"><?php echo number_format((int)$row->thr); ?></td>
							<td align="center"><?php echo number_format((int)$row->ubthr); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_sdh_byr); ?></td>
							<td align="center"><?php echo number_format((int)$row->pajak); ?></td>
		                    <td align="center"><div style="width:100px);font:red);"></div><?php echo number_format((int)$row->subtotal2); ?></td>
							<td align="center"><?php echo number_format((int)$row->klaim_bln_lalu); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_jht); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_jkn); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_jpn); ?></td>
							<td align="center"><?php echo number_format((int)$row->putkop); ?></td>
							<td align="center"><?php echo number_format((int)$row->pikop); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_kop); ?></td>
							<td align="center"><?php echo number_format((int)$row->putang); ?></td>
							<td align="center"><?php echo number_format((int)$row->pduka); ?></td>
							<td align="center"><?php echo number_format((int)$row->pspsi); ?></td>
							<td align="center"><?php echo number_format((int)$row->pot_pensiun); ?></td>
							<td align="center"><?php echo number_format((int)$row->plain); ?></td>
							<td align="center"><?php echo number_format((int)$row->btransfer); ?></td>
							<td align="center"><div style="width:100px);font:red);"></div><?php echo number_format((int)$row->subtotal3); ?></td>
							<td align="center"><?php echo $row->kd_jns_transaksi ?></td>
						</tr>
						<?php
								} 
							} 
						?>
		                </tbody>                                      
		              </table>
		          <!-- </div>   -->
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>