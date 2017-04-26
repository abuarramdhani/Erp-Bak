<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Transaksi Hitung Thr</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHitungThr');?>">
	            		<i class="icon-wrench icon-2x"></i>
	            		<span><br/></span>
	            	</a>
	            </div>
	          </div>
	        </div>
	      </div>
	      <br/>
	      
	    <?php
			if($this->session->userdata('failed')){ 
		?>
			<div class="alert alert-danger alert-dismissable" id="lama" style="width:100%;">
				<b> Import Gagal ! </b> Terjadi kesalahan saat melakukan import data
			</div>
		<?php
			}
		?>
		<?php
			if($this->session->userdata('success')){ 
		?>
			<div class="alert alert-success alert-dismissable" id="lama" style="width:100%;">
				<b> Import Sukses ! </b> Import data THR berhasil
			</div>
		<?php
			}
		?>
		<?php
			if($this->session->userdata('empty')){ 
		?>
			<div class="alert alert-warning alert-dismissable" id="lama" style="width:100%;">
				<b> Data Kosong ! </b> Tidak ada data pada periode tersebut
			</div>
		<?php
			}
		?>
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
                    <b>Transaksi Hitung Thr</b>
		          </div>
		          <div class="box-body">

		          <!--  <div class="table-responsive">  -->
					 <div class="row">
					  <div class="row" style="margin: 10px 0 10px 0">
						 <form class="form-inline" method="post" action="<?php echo $action; ?>">
							  <div class="col-lg-1">
									<input type="text" class="form-control" id="txtPeriodeHitung" name="txtPeriodeHitung" placeholder="<?php echo date('Y-m');?>" style="width:100px;" required>
							  </div>
							  <div class=" col-lg-1">
							    <button type="submit" style="margin-left:25px;" class="btn btn-primary">Hitung</button>
							  </div>
						</form>			             
						 <form method="post" action="<?php echo base_url('PayrollManagement/TransaksiHitungThr/upload')?>" enctype="multipart/form-data">
							  <div class="col-lg-offset-6 col-lg-3">
							    <input name="importfile" type="file" class="form-control" readonly required>
							  </div>
							  <div class=" col-lg-1">
							    <button class="btn btn-primary btn-block">Load</button>
							  </div>
						  </form>
			          </div>
					  <?php
					    if (!empty($data)) {
					  ?>
					  <form method="post" action="<?php echo base_url('PayrollManagement/TransaksiHitungThr/saveImport')?>">
					    <div class="row" style="margin: 10px 0 10px 10px">
					 	  <div class="col-lg-offset-10 col-lg-2">
						    <input type="hidden" name="txtFileName" value="<?php echo $filename; ?>">
						    <button class="btn btn-primary btn-block">Import</button>
						  </div>
						</div>
					  </form>
					  <?php
				 	    }
					  ?>
		            </div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiHitungThr" style="font-size:12px;width:100%;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th style='text-align:center'>Tanggal</th>
							<th style='text-align:center'>Periode</th>
							<th style='text-align:center'>Noind</th>
							<th style='text-align:center'>Kd Status Kerja</th>
							<th style='text-align:center'>Diangkat</th>
							<th style='text-align:center'>Lama Thn</th>
							<th style='text-align:center'>Lama Bln</th>
							<th style='text-align:center'>Gaji Pokok</th>
							<th style='text-align:center'>THR (%)</th>
							<th style='text-align:center'>THR</th>
							<th style='text-align:center'>UBTHR (%)</th>
							<th style='text-align:center'>UBTHR</th>
		                  </tr>
		                </thead>
		                <tbody>
							<?php if(!empty($transaksiHitungThr_data)){ $no = 1; foreach($transaksiHitungThr_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center'>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHitungThr/read/'.$row->id_transaksi_thr.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                               </td>
							<td align='center'><?php echo $row->tanggal ?></td>
							<td align='center'><?php echo $row->periode ?></td>
							<td align='center'><?php echo $row->noind ?></td>
							<td align='center'><?php echo $row->kd_status_kerja ?></td>
							<td align='center'><?php echo $row->diangkat ?></td>
							<td align='center'><?php echo $row->lama_thn ?></td>
							<td align='center'><?php echo $row->lama_bln ?></td>
							<td align='right'><?php echo number_format((int)$row->gaji_pokok) ?></td>
							<td align='center'><?php echo $row->persentase_thr ?></td>
							<td align='right'><?php echo number_format((int)$row->thr) ?></td>
							<td align='center'><?php echo $row->persentase_ubthr ?></td>
							<td align='right'><?php echo number_format((int)$row->ubthr) ?></td>
							</tr>
							<?php } } ?>
		                </tbody>                                      
		              </table>
					  <?php if(!empty($enc_dt)){?>
		              <a data-toggle="tooltip" id="btn-reg-person" title="Cetak Struk" href='<?php echo site_URL() ?>PayrollManagement/TransaksiHitungThr/CetakStruk/<?php echo $enc_dt; ?>' class="btn btn-success btn-md btn-refresh-db" target="blank_">Cetak Struk</a>
					  <?php } ?>
					<!-- </div>  -->
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>