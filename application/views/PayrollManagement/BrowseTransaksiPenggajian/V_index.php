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
		           <div class="table-responsive"> 
				   
				    <div class="row">
			              <form method="post" action="<?php echo base_url('PayrollManagement/BrowseTransaksiPenggajian/Hitung')?>" enctype="multipart/form-data">
						    <div class="row" style="margin: 10px 0 10px 0px">
							  <div class="col-lg-2">
									<input type="text" name="txtPeriodeHitung" id="txtPeriodeHitung" class="form-control" placeholder="[ Periode Hitung ]"></input>
							  </div>
							  <div class=" col-lg-2">
							    <button class="btn btn-primary btn-block">Hitung</button>
							  </div>
						  </form>
			          </div>
		            </div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiPenggajian" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
                            <th style='text-align:center'><div style="width:100px"></div>Tanggal</th>
							<th style='text-align:center;'><div style="width:100px"></div>Nama</th>
							<th style='text-align:center;'><div style="width:100px">Jabatan</div></th>
							<th style='text-align:center;'><div style="width:100px"></div>Jabatan Upah</th>
							<th style='text-align:center;'><div style="width:100px"></div>Seksi</th>
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
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Pengangkatan</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Sisa Cuti</th>
							<th style='text-align:center;'><div style="width:100px"></div>TK Pajak</th>
							<th style='text-align:center;'><div style="width:100px"></div>Kompensasi Lembur</th>
							<th style='text-align:center;'><div style="width:100px"></div>Rapel Gaji</th>
							<th style='text-align:center;'><div style="width:100px"></div>HTM</th>
							<th style='text-align:center;'><div style="width:100px"></div>Ijin</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. HTM</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Sakit Kepanjangan</th>
							<th style='text-align:center;'><div style="width:100px;font:red;"></div>Subtotal Dibayarkan</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim DL</th>
							<th style='text-align:center;'><div style="width:100px"></div>THR</th>
							<th style='text-align:center;'><div style="width:100px"></div>UBTH</th>
							<th style='text-align:center;'><div style="width:100px"></div>Klaim Sdh Bayar</th>
							<th style='text-align:center;'><div style="width:100px"></div>Tamb Subs Pajak</th>
							<th style='text-align:center;'><div style="width:100px;font:red;">"></div>Subtotal 1</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Klaim DL</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. THR</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. UBTHR</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Klaim Sdh Bayar</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. Subs Pajak</th>
		                    <th style='text-align:center;'><div style="width:100px;font:red;">"></div>Subtotal 2</th>
							<th style='text-align:center;'><div style="width:100px"></div>Koreksi Pot. Bln Lalu</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. JHT</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. JKN</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pot. JPN</th>
							<th style='text-align:center;'><div style="width:100px"></div>Putkop</th>
							<th style='text-align:center;'><div style="width:100px"></div>Pikop</th>
							<th style='text-align:center;'><div style="width:100px"></div>Potkop</th>
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