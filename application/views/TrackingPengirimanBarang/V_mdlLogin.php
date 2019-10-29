<style>
      thead.toscahead tr th {
        background-color: #9e9e9e;
      }
      thead.dua tr th {
        background-color: #026337;
      }
      .itsfun1 {
        border-top-color: #026337;
      }
      .buttoncute {
      	background-color: #026337;
      }
      .capital{
    text-transform: uppercase;
}
</style>
    <section class="content-header">
      <h1>
        Settings
      </h1>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box itsfun1">
	   		<div class="box-header with-border" style="text-align: left;">
					<h3 class="box-title" style="font-family: sans-serif;">
                	<b> Edit Kurir dan Kendaraan</b><br>
              	</h3><br>
            </div>
         <div class="box-body">
				<div class="col-md-12">
					<!----- Tabel ----->
					<table  id="filter" class="col-md-12" style="margin-bottom: 20px">
						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>ID Pekerja</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<input class="form-control capital" style="width: 300px;" type="text" id="txtIdPekerja_updte" name="txtIdPekerja_updte" placeholder="Masukkan ID pekerja" value="<?php echo $update[0]['username']?>"></input>
								</td>
									
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Nama Pekerja</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<input class="form-control capital" style="width: 300px" type="text" id="txtNamaPekerja_updte" name="txtNamaPekerja_updte" placeholder="Masukkan nama pekerja" value="<?php echo $update[0]['nama_pekerja']?>"></input>
								</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Kendaraan</b></span>
							</td>
								<td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <select onchange="onChangeJK()" id="slcKendaraan_updte" name="slcKendaraan_updte" class="form-control select2 kendaraanTPB" style="width:300px;" required="required">
                      <option value="" > Pilih </option>
                     <?php foreach ($vehicle as $k) { 
                        $s='';
                          if ($k['kendaraan']==$update[0]['kendaraan']) {
                            $s='selected';
                                    }
                        ?>
                          <option value="<?php echo $k['id_kendaraan'] ?>" <?php echo $s ?>>
                            <?php echo $k['kendaraan'] ?> - <?php echo $k['nomor_kendaraan'];?></option>
                          <?php } ?>
                  </select>
                </td>
                </td>
                  <td>
                  </td>
                    <td>
                      <button id="btnSaveSetupTPB" onclick="updateSetupSettingTPB(<?php echo $update[0]['id_login']?>)" type="button" class="btn buttoncute" style="margin-left: 150px; margin-top: 8px; color: white;" > <i class="fa fa-check"></i> Update</button>
                    </td>
						</tr>
               </center>
          </div>
        </div>
      </div>
    </div>
 </div>
 </section>