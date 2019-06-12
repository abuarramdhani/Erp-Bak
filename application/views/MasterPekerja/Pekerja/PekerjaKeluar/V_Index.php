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
         	<div class="row">
				<div class="col-lg-4">
					<div class="form-group" >
						<h3>Data Pribadi</h3>
						<div style="width: 3cm; height: 4cm; background-color: grey;">
							<img src="">
						</div>
						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-4">
								<label for="PK_txt_noinduk">No Induk </label>
							</div>
							<div class="col-lg-6">
								<input type="text" name="txt_noinduk" id="PK_txt_noinduk" class="form-control" va>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_namaPekerja">Nama </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_namaPekerja" id="PK_txt_namaPekerja" class="form-control">
							</div>
						</div>	
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_kotaLahir">Tempat Lahir </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_kotaLahir" id="PK_txt_kotaLahir" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_tanggalLahir">Tanggal Lahir </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_tanggalLahir" id="PK_txt_tanggalLahir" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4">
								<label for="PK_txt_nikPekerja">NIK </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_nikPekerja" id="PK_txt_nikPekerja" class="form-control">
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
								<input type="text" name="txt_alamatPekerja" id="PK_txt_alamatPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_desaPekerja">Desa </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_desaPekerja" id="PK_txt_desaPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_kecamatanPekerja">Kecamatan </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_kecamatanPekerja" id="PK_txt_kecamatanPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_kabupatenPekerja">Kabupaten </label>
							</div>
							<div class="col-lg-4">
								<input type="text" name="txt_kabupatenPekerja" id="PK_txt_kabupatenPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_provinsiPekerja">Provinsi </label>
							</div>
							<div class="col-lg-4">
								<input type="text" name="txt_provinsiPekerja" id="PK_txt_provinsiPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_kodePosPekerja">Kode Pos </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_kodePosPekerja" id="PK_txt_kodePosPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_teleponPekerja">Telepon </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_teleponPekerja" id="PK_txt_teleponPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_nohpPekerja">No Handphone </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_nohpPekerja" id="PK_txt_nohpPekerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_ukuranbaju">Ukuran Baju </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_ukuranbaju" id="PK_txt_ukuranbaju" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_ukurancelana">Ukuran Celana </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_ukurancelana" id="PK_txt_ukurancelana" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_ukuransepatu">Ukuran Sepatu </label>
							</div>
							<div class="col-lg-5">
								<input type="text" name="txt_ukuransepatu" id="PK_txt_ukuransepatu" class="form-control">
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
								<input type="text" name="txt_tglDiangkat" id="PK_txt_tglDiangkat" class="form-control">
							</div>
							<div class="col-lg-3" >
								<label for="PK_txt_tglMasukKerja">Tgl Masuk Kerja </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_tglMasukKerja" id="PK_txt_tglMasukKerja" class="form-control">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">

							</div>
							<div class="col-lg-6">
                            <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_diangkat" value="false"> Belum Diangkat</label>
        					<label class="radio-inline"><input type="radio" name="rd_diangkat" value="true"> Sudah Diangkat</label>
							</div>

						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_lamaKontrak">Lama Kontrak </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_lamaKontrak" id="PK_txt_lamaKontrak" class="form-control">
							</div>
							<div class="col-lg-3">
								<label for="PK_txt_akhirKontrak">Berakhirnya Kontrak </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_akhirKontrak" id="PK_txt_akhirKontrak" class="form-control">
							</div>							
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_jabatanPekerja">Jabatan </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_jabatanPekerja" id="PK_txt_jabatanPekerja" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_seksiPekerja">Seksi </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_seksiPekerja" id="PK_txt_seksiPekerja" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_unitPekerja">Unit </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_unitPekerja" id="PK_txt_unitPekerja" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_bidangPekerja">Bidang </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_bidangPekerja" id="PK_txt_bidangPekerja" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_departemenPekerja">Departmen </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_departemenPekerja" id="PK_txt_departemenPekerja" class="form-control">
							</div>													
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_internalmail">Internal Mail</label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_internalmail" id="PK_txt_internalmail" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_externalmail">External Mail </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_externalmail" id="PK_txt_externalmail" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_telkomselmygroup">Telkomsel Mygroup </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_telkomselmygroup" id="PK_txt_telkomselmygroup" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_pidginaccount">Pidgin Account </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_pidginaccount" id="PK_txt_pidginaccount" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_tglkeluar">Tanggal Keluar </label>
							</div>
							<div class="col-lg-3">
								<input type="text" name="txt_tglkeluar" id="PK_txt_tglkeluar" class="form-control">
							</div>													
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-2">
								<label for="PK_txt_sebabkeluar">Sebab Keluar </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_sebabkeluar" id="PK_txt_sebabkeluar" class="form-control">
							</div>													
						</div>
					</div>
				</div>
			</div>          
        </div>        
      </div>  
    </div>      
  </section>
 </body>