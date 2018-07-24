<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 >Edit Data Pekerja</h3>
        </div>        
        <div class="panel-body">
        	<form method="POST" action="<?php echo base_url('MasterPekerja/DataPekerjaKeluar/viewEdit'); ?>">
        		<div class="row">
        			<div class="col-lg-4">
        				<div class="form-group">
        					<label>Cari Pekerja</label>
        					<label class="radio-inline"><input type="radio" name="rd_keluar" value="false"> aktif</label>
        					<label class="radio-inline"><input type="radio" name="rd_keluar" value="true"> keluar</label>
        				</div>
        			</div>
        			<div class="col-lg-4">
        				<div class="form-group">
        					<select name="slc_Pekerja" id="PK_slc_Pekerja" class="form-control"></select>
        				</div>
        			</div>
        			<div class="col-lg-2">
        				<button type="submit" class="btn btn-default" id="btn_cari">Tampil</button>
        			</div>
        		</div>
        	</form>
        	<form method="POST" action="<?php echo base_url('MasterPekerja/DataPekerjaKeluar/updateData') ?>">
         	<div class="row">
         		<input type="hidden" name="txt_noindukLama" value="<?php echo $data['noind'] ?>">
				<div class="col-lg-4">
					<div class="form-group" >
						<h3>Data Pribadi</h3>
						<div style="width: 123px; height: 161px; background-color: grey;">
							<center><img style="margin-top: 5px" name="img_pekerja" width="113" height="151" src="<?php echo $data['photo'] ?>"></center>
						</div>
						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-4">
								<label for="PK_txt_noinduk">No Induk </label>
							</div>
							<div class="col-lg-6">
								<input type="text" name="txt_noinduk" id="PK_txt_noinduk" class="form-control" value="<?php echo $data['noind'] ?>">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4"> 
								<label for="PK_txt_namaPekerja">Nama </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_namaPekerja" id="PK_txt_namaPekerja" class="form-control" value="<?php echo $data['nama'] ?>">
							</div>
						</div>	
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_kotaLahir">Tempat Lahir </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_kotaLahir" id="PK_txt_kotaLahir" class="form-control" value="<?php echo $data['templahir'] ?>">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_tanggalLahir">Tanggal Lahir </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_tanggalLahir" id="PK_txt_tanggalLahir" class="form-control PK-daterangepickersingledate" value="<?php echo $data['tgllahir']?>">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_nikPekerja">NIK </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_nikPekerja" id="PK_txt_nikPekerja" class="form-control" value="<?php echo $data['nik'] ?>">
							</div>
						</div>						
					</div>
				</div>
				<div class="col-lg-8">
					<div class="form-group">
						<h3>Alamat Pekerja</h3>
						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-2">
								<label for="PK_txt_alamatPekerja">Alamat </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_alamatPekerja" id="PK_txt_alamatPekerja" class="form-control" value="<?php echo $data['alamat'] ?>">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_provinsiPekerja">Provinsi </label>
							</div>
							<div class="col-lg-4">
								<select name="slc_provinsi_pekerja" id="PK-slc_provinsi_pekerja" class="form-control"></select>
								<!-- <input type="text" name="txt_provinsiPekerja" id="PK_txt_provinsiPekerja" class="form-control" value="<?php echo $data['prop'] ?>"> -->
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_kabupatenPekerja">Kabupaten </label>
							</div>
							<div class="col-lg-4">
								<select name="slc_kabupaten_pekerja" id="PK-slc_kabupaten_pekerja" class="form-control"></select>
								<!-- <input type="text" name="txt_kabupatenPekerja" id="PK_txt_kabupatenPekerja" class="form-control" value="<?php echo $data['kab'] ?>"> -->
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_kecamatanPekerja">Kecamatan </label>
							</div>
							<div class="col-lg-5">
								<select name="slc_kecamatan_pekerja" id="PK-slc_kecamatan_pekerja" class="form-control"></select>
								<!-- <input type="text" name="txt_kecamatanPekerja" id="PK_txt_kecamatanPekerja" class="form-control" value="<?php echo $data['kec'] ?>"> -->
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_desaPekerja">Desa </label>
							</div>
							<div class="col-lg-5">
								<select name="slc_desa_pekerja" id="PK-slc_desa_pekerja" class="form-control"></select>
								<!-- <input type="text" name="txt_desaPekerja" id="PK_txt_desaPekerja" class="form-control" value="<?php echo $data['desa'] ?>"> -->
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_kodePosPekerja">Kode Pos </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_kodePosPekerja" id="PK_txt_kodePosPekerja" class="form-control" value="<?php echo $data['kodepos'] ?>">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_teleponPekerja">Telepon </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_teleponPekerja" id="PK_txt_teleponPekerja" class="form-control" value="<?php echo $data['telepon'] ?>">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_nohpPekerja">No Handphone </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_nohpPekerja" id="PK_txt_nohpPekerja" class="form-control" value="<?php echo $data['nohp'] ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="form-group" >
						<h3>Lain-lain</h3>
						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-2">
								<label for="PK_txt_tglDiangkat">Tgl diangkat </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_tglDiangkat" id="PK_txt_tglDiangkat" class="form-control PK-daterangepickersingledate" value="<?php echo $data['diangkat'] ?>" disabled="disabled">
							</div>
							<div class="col-lg-3" >
								<label for="PK_txt_tglMasukKerja">Tgl Masuk Kerja </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_tglMasukKerja" id="PK_txt_tglMasukKerja" class="form-control PK-daterangepickersingledate" value="<?php echo $data['masukkerja'] ?>" disabled="disabled">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_lamaKontrak">Lama Kontrak </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_lamaKontrak" id="PK_txt_lamaKontrak" class="form-control" value="<?php echo $data['lmkontrak'] ?>" readonly="">
							</div>
							<div class="col-lg-3">
								<label for="PK_txt_akhirKontrak">Berakhirnya Kontrak </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_akhirKontrak" id="PK_txt_akhirKontrak" class="form-control PK-daterangepickersingledate" value="<?php echo $data['akhkontrak'] ?>" disabled="disabled">
							</div>							
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_jabatanPekerja">Jabatan </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_jabatanPekerja" id="PK_txt_jabatanPekerja" class="form-control" value="<?php echo $data['jabatan'] ?>" readonly="">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_seksiPekerja">Seksi </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_seksiPekerja" id="PK_txt_seksiPekerja" class="form-control" value="<?php echo $data['seksi'] ?>" readonly="">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_unitPekerja">Unit </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_unitPekerja" id="PK_txt_unitPekerja" class="form-control" value="<?php echo $data['unit'] ?>" readonly="">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_bidangPekerja">Bidang </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_bidangPekerja" id="PK_txt_bidangPekerja" class="form-control" value="<?php echo $data['bidang'] ?>" readonly="">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_departemenPekerja">Departmen </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_departemenPekerja" id="PK_txt_departemenPekerja" class="form-control" value="<?php echo $data['dept'] ?>" readonly="">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_tglkeluar">Tanggal Keluar </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_tglkeluar" id="PK_txt_tglkeluar" class="form-control PK-daterangepickersingledate" value="<?php echo $data['tglkeluar'] ?>" disabled="disabled">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_sebabkeluar">Sebab Keluar </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_sebabkeluar" id="PK_txt_sebabkeluar" class="form-control" value="<?php echo $data['sebabklr'] ?>" readonly="">
							</div>													
						</div>
					</div>
				</div>
			</div>
			<div>
				<button type="submit" class="btn btn-primary" id="btn_submit">Simpan Perubahan</button>
			</div>
			</form>          
        </div>        
      </div>  
    </div>      
  </section>
 </body>