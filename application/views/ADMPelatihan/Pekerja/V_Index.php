<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 >Data Pekerja</h3>
        </div>
        <div class="panel-body">
        	<form method="POST" action="<?php echo base_url('ADMPelatihan/DataPekerja/viewData'); ?>">
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
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<div class="form-group" >
			
						<div class="row" style="margin-top: 0px;">
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
								<label for="PK_txt_kerjaPekerja">Pekerjaan </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_kerjaPekerja" id="PK_txt_kerjaPekerja" class="form-control">
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
								<label for="PK_txt_departemenPekerja">Departemen </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_departemenPekerja" id="PK_txt_departemenPekerja" class="form-control">
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