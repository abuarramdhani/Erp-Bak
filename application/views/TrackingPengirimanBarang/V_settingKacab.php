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
        Setting Kepala Cabang
      </h1>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box itsfun1">
	   		<div class="box-header with-border" style="text-align: left;">
					<h3 class="box-title" style="font-family: sans-serif;">
                	<b> Tambahkan Akun Android Kepala Cabang</b><br>
              	</h3><br>
            </div>
         <div class="box-body">
          <div class="col-md-2"></div>
				<div class="col-md-7" style="margin-top: 10px;">
					<!----- Tabel ----->
					<table  id="filter" class="col-md-12 tblResponsive" style="margin-bottom: 20px">
						<tr>
							<td style="width: 25%;padding-left: 25px;">
								<span><b>Nomor Induk Kacab</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<input class="form-control capital" style="width: 300px;" type="text" id="txtIdPekerja" name="txtIdPekerja" placeholder="Masukkan ID pekerja"></input>
								</td>
                <td style="padding-left: 100px"><button onclick="cekKacab(this)" class="btn btn-default btn-m" style="width:80px" id="btnSubmitKacab" name="btnSubmitKcb" type="button"><i class="fa fa-check"></i> Cek</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 25px;">
								<span><b>Nama Kacab</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<input class="form-control capital" style="width: 300px" type="text" id="txtNamaPekerja" name="txtNamaPekerja" placeholder="Auto Input Nama Kacab" readonly></input>
								</td>
						</tr>
						<tr>
							<td style="width: 25%;padding-left: 25px;">
								<span><b>Section Name</b></span>
							</td>
								<td style="width: 25%;padding: 5px 5px 5px 50px;">
          <input class="form-control capital" style="width: 300px" type="text" id="txtSectionName" name="txtSectionName" placeholder="Auto Input Section Name" readonly></input>        
                </td>
						</tr>
            <tr>
              <td style="width: 25%;padding-left: 25px;">
                <span><b>Status</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <select onchange="onChangeJK()" id="slcStatusKacab" name="slcStatusKacab" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option id="pilih" value="" > PILIH  </option>
                                    <option value="Y" > AKTIF  </option>
                                    <option value="N" > TIDAK AKTIF  </option>
                  </select>
                </td>
            </tr>
            <tr>
              <td style="width: 25%;padding-left: 25px;">
                <span><b>Alamat Cabang</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <textarea id="txaAlamatCabang" class="form-control capital" style="width:300px" placeholder="Masukkan Alamat Cabang"></textarea>
                </td>
                <td style="padding-left: 100px"><button style="width:80px" class="btn btn-success" onclick="addKacab(this)" id="btnSubmitKacab" name="btnSubmitKcb" type="button"><i class="fa fa-plus"></i> Add</td>
            </tr>
					</table>
				</div>
        <div class="col-md-4"></div>
      </div>
      <div class="box-body">
					<table align="center" style="width: 100%;" id="tblTPB" class="tb_dash_unit table table-striped table-bordered table-hover text-center">
                  <thead class="dua">
                    <tr class="bg-primary">
                      <th class="text-center" style="width: 5%">No</th>
                      <th class="text-center" style="width: 10%">Username</th>
                      <th class="text-center" style="width: 20%">Nama Kepala Cabang</th>
                      <th class="text-center" style="width: 15%">Seksi</th>
                      <th class="text-center" style="width: 20%">Alamat Cabang</th>
                      <th class="text-center" style="width: 15%">Status</th>
                      <th class="text-center" style="width: 15%">Action</th>
                    </tr>
                  </thead>
                 <tbody>
                  <?php $no=1; foreach ($kcb as $k) { ?>
                   <tr class="<?php echo $k['id_login']?>">
                    <td><?php echo $no; ?></td>
                    <td><?php echo $k['username'] ?></td>
                    <td><?php echo $k['nama_pekerja'] ?></td>
                    <td><?php echo $k['section_name'] ?></td>
                    <td><?php echo $k['alamat_cabang'] ?></td>
                    <?php if ($k['kacab'] == 'Y') { ?>
                    <td>
                      <div class="status<?php echo $k['id_login'];?>">
                      <span>
                        <label class="label label-primary" style="width:80px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aktif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                      </span>
                    </div>
                    </td>
                    <?php }else{ ?>
                    <td>
                      <div class="status<?php echo $k['id_login'];?>">
                      <span>
                        <label class="label label-danger" style="width: 80px">Tidak Aktif</label>
                      </span>
                      </div>
                    </td>
                    <?php }?>
                    <td>
                    <button id="btnDelete" onclick="deleteKacab(<?php echo $k['id_login'];?>)" class="btn btn-danger btn-sm" style="width:100px"><i class="fa fa-trash"></i> Delete</button>

                    <button id="btnEdit" onclick="editKacab(<?php echo $k['id_login'];?>)" data-target="mdlKacab" data-toggle="modal" class="btn btn-warning btn-sm" style="width:100px;margin-top: 5px;margin-bottom: 5px"><i class="fa fa-external-link"></i> Edit</button>

                    <?php if ($k['kacab'] == 'Y') { ?>

                    <div class="btnActivating<?php echo $k['id_login'];?>"><button id="btnDiactivated" onclick="DiactivatedUser(<?php echo $k['id_login'];?>)" class="btn btn-primary btn-sm" style="width: 100px"><i class="fa fa-times"></i> Non-Aktifkan</button></div>

                    <?php }else { ?>

                    <div class="btnActivating<?php echo $k['id_login'];?>"><button id="btnDiactivated" onclick="activatedUser(<?php echo $k['id_login'];?>)" class="btn btn-primary btn-sm" style="width: 100px"><i class="fa fa-check"></i> Aktifkan</button></div>

                    <?php } ?>
                    </td>
                  <?php $no++;} ?>
                 </tbody>
               </table>
               </center>
          </div>
        </div>
      </div>
    </div>
 </div>
 </section>


<div class="modal fade mdlKacab"  id="mdlKacab" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1000px;" role="document">
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
