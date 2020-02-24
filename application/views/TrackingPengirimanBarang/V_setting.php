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
        Setting Kurir dan Kendaraan
      </h1>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box itsfun1">
	   		<div class="box-header with-border" style="text-align: left;">
					<h3 class="box-title" style="font-family: sans-serif;">
                	<b> Tambahkan Kurir dan Kendaraan</b><br>
              	</h3><br>
            </div>
         <div class="box-body">
				<div class="col-md-12">
					<!----- Tabel ----->
					<table  id="filter" class="col-md-12 tblResponsive" style="margin-bottom: 20px">
						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>ID Pekerja</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<input class="form-control capital" style="width: 300px;" type="text" id="txtIdPekerja" name="txtIdPekerja" placeholder="Masukkan ID pekerja"></input>
								</td>
									<td style="width:20%">
                      <button id="btnHanyaKendaraan" onclick="hanyaKendaraan($(this))" type="button" class="btn btn-warning" style="margin-left: 100px; margin-right:5px; margin-top: 8px; color: white;" > <i class="fa fa-plus"></i> Tambah Kendaraan Saja</button>
                  </td>
                  <td>
                      <button id="btnReload" onclick="reload($(this))" type="button" class="btn btn-danger" style="margin-left: 0px; margin-top: 8px; color: white;" > <i class="fa fa-refresh"></i></button>
                  </td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Nama Pekerja</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<input class="form-control capital" style="width: 300px" type="text" id="txtNamaPekerja" name="txtNamaPekerja" placeholder="Masukkan nama pekerja" ></input>
								</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Kendaraan</b></span>
							</td>
								<td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <select onchange="onChangeJK()" id="slcKendaraan" name="slcKendaraan" class="form-control select2 select2-hidden-accessible kendaraanTPB" style="width:300px;" required="required">
                                    <option value="" > Pilih  </option>
                                    <option value="" > TAMBAH KENDARAAN  </option>
                                    <?php foreach ($vehicle as $k) { ?>
                                    <option value="<?php echo $k['id_kendaraan'] ?>"><?php echo $k['kendaraan'] ?> - <?php echo $k['nomor_kendaraan']?>
                                    </option>
                                    <?php } ?>
                  </select>
						</tr>
            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Tambah Kendaraan</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <input class="form-control capital kendaraanTPB" style="width: 300px" type="text" id="txtKendaraan" name="txtKendaraan" placeholder="Masukkan kendaraan" readonly></input>
            </tr>
            <tr>
              <td style="width: 25%;padding-left: 235px;">
                    <span><b>No. Kendaraan</b></span>
                  </td>
                    <td style="width:25%; padding: 5px 5px 5px 50px;">
                      <input class="form-control capital txtNoKendaraan" style="width: 300px;" type="text" id="txtNoKendaraan" name="txtNoKendaraan" placeholder="Masukkan nomor kendaraan" readonly></input>
                    </td>
                    </td>
                    <td>
                      <button id="btnSaveSetupTPB" onclick="saveSetupSettingTPB($(this))" type="button" class="btn buttoncute" style="margin-left: 100px; margin-top: 8px; color: white;" > <i class="fa fa-check"></i> Save</button>
                    </td>
                     
            </tr>
					</table>
				</div>
			</div>
            <div class="box-body">
					<table align="center" style="width: 100%;" id="tblTPB" class="tb_dash_unit table table-striped table-bordered table-hover text-center">
                  <thead class="dua">
                    <tr class="bg-primary">
                      <th class="text-center" style="width: 5%">No</th>
                      <th class="text-center" style="width: 20%">Nama Pekerja</th>
                      <th class="text-center" style="width: 20%">Kendaraan</th>
                      <th class="text-center" style="width: 15%">Action</th>
                    </tr>
                  </thead>
                 <tbody>
                  <?php $no=1; foreach($tabel as $k) { ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <td><?php echo $k['nama_pekerja'] ?></td>
                      <td><?php echo $k['kendaraan'] ?></td>
                      <td><a title="edit ..." class="btn btn-warning btn-sm" data-target="mdlSetupTPB" data-toggle="modal" onclick="MdlEditSetup(<?php echo $k['id_login'] ?>)"><i class="fa fa-hand-pointer-o"></i></a>
                        <a title="delete ..." class="btn btn-danger btn-sm" onclick="deleteLogin(<?php echo $k['id_login'] ?>)"><i class="fa fa-trash"></i></a><input type="hidden" id="hdnTxt<?php echo $k['id_login'] ?>" value="<?php echo $k['nama_pekerja'] ?>"></input>
                      </td>
                  <?php $no++; } ?>
                 </tbody>
               </table>
               </center>
          </div>
        </div>
      </div>
    </div>
 </div>
 </section>


<div class="modal fade mdlSetupTPB"  id="mdlSetupTPB" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="width: 100%;">
                  <div class="modal-tabel" >
          </div>
                   
                      <div class="modal-footer">
                        <div class="col-md-2 pull-left">
                        </div>
                      </div>
                </div>
            </form>
        </div>
    </div>
</div>
