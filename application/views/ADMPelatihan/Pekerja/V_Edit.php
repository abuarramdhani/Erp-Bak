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
								<input type="text" name="txt_noinduk" id="PK_txt_noinduk" class="form-control" value="<?php echo $data['noind'] ?>" readonly="">
							</div>
						</div>
						
							
							<div class="col-lg-6">
								<input   type="hidden" name="txt_keluar" id="PK_txt_keluar" class="form-control"   value="<?php echo $keluar ?>" readonly="" >
							</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-4"> 
								<label for="PK_txt_namaPekerja">Nama </label>
							</div>
							<div class="col-lg-8">
								<input type="text" name="txt_namaPekerja" id="PK_txt_namaPekerja" class="form-control" value="<?php echo $data['nama'] ?>" readonly="">
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
								<label for="PK_txt_pekerjaanPekerja">Pekerjaan </label>
							</div>
							<div class="col-lg-10">
								<input type="text" hidden="" value="<?php echo $data['kd_pekerjaan'] ?>" id="txt_kdPekerjaan">
								 <input type="text" name="txt_pekerjaanPekerja" class="form-control" value="<?php echo $data['kerja'] ?>" readonly="">
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
								<label for="PK_txt_departemenPekerja">Departemen </label>
							</div>
							<div class="col-lg-10">
								<input type="text" name="txt_departemenPekerja" id="PK_txt_departemenPekerja" class="form-control" value="<?php echo $data['dept'] ?>" readonly="">
							</div>													
						</div>
                    </div>
                 </div>
             </div>          

						 <?php if (isset($training) && !empty($training)) { ?>
						 <br>
						 <div class="box-header with-border">
								<div class="row">
									<div class="col-lg-12">
										<table  border="1" style="width:100%;font-size: 14px;padding-left: 20px;">
											<thead class="bg-primary">
												<tr>
	                                               <th style="text-align: center; width: 5%">No</th>
                                                    <th style="text-align: center;width: 30%">Pelatihan Yang Sudah Diikuti</th>
                                                    <th style="text-align: center;width: 15%">Tanggal</th>
                                                    <th style="text-align: center;width: 22%">Waktu</th>
                                                    <th style="text-align: center;width: 13%">Ruangan</th>
                                                    <th style="text-align: center;width: 15%">Trainer</th>
												</tr>
											</thead>
											<tbody>
                                            <?php
                                                    $no=1;
                                                    foreach ($training as $key) {
                                                        ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $no; ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo ucwords(strtolower($key['training_name'])); ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo date('d-m-Y', strtotime($key['date'])) ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo $key['waktu']; ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo ucwords(strtolower($key['room'])); ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo ucwords(strtolower($key['trainer_name'])); ?></td>
           

                                                                </tr>
                                                                <?php
                                                                $no++;

                                                        }
                                                        ?>

                                                        <?php
                                                    
                                            ?>
                                            </tbody>
										</table>
									</div>
								</div>
							</div>
						 
                   
                        <?php } ?>

			<div>
			    <a href="<?php echo site_url("ADMPelatihan/DataPekerja/excel?noind=".$data['noind']."&keluar=".$keluar) ?>" target="_blank" class="btn btn-primary">EXCEL</a>
				<a href="<?php echo site_url("ADMPelatihan/DataPekerja/pdf?noind=".$data['noind']."&keluar=".$keluar) ?>" target="_blank" class="btn btn-warning">PDF</a>
			</div>	   
        </div>        
      </div>  
    </div>      
  </section>
 </body>