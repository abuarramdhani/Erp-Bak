<style>
    tr.danger td{
      background-color: #eb3d34;
}
</style>
    <section class="content-header">
      <h1>
        Detail User
      </h1>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box box-primary">
         <div class="box-body">
				<div class="col-md-12 pull-right">
					<!----- Tabel ----->
          <!-- <div class="col-md-2"></div> -->
          <div class="col-md-10 pull-left">
  					<table id="filter" class="tblResponsive" style="margin-bottom: 10px;margin-top: 10px">
  						<tr>
  							<td style="padding-left:100px" >
  								<span><b>Nomor Induk</b></span>
  							</td>
  						     <td style="width:15%;padding: 5px 5px  5px 10px;">
  								<input class="form-control capital" style="width: 300px;" type="text" id="txtNomorIndukEd" name="txtNomorIndukEd" value="<?php echo $detail[0]['username']?>" readonly></input>
  							</td>
                <td></td>
  						</tr>

  						<tr>
  							<td style="padding-left:100px">
  								<span><b>Nama Kacab</b></span>
  							</td>
  							<td style="padding: 5px 5px  5px 10px;">
  								<input class="form-control capital" style="width: 300px" type="text" id="txtNamaKacabEd" name="txtNamaKacabEd" value="<?php echo $detail[0]['nama_pekerja']?>" readonly></input>
  							</td>
                <td></td>
  						</tr>

  						<tr>
  							<td style="padding-left:100px">
  								<span><b>Section Name</b></span>
  							</td>
  							<td style="padding: 5px 5px  5px 10px;">
  								<input class="form-control capital" style="width: 300px" type="text" id="txtSectionNameEd" name="txtSectionNameEd" value="<?php echo $detail[0]['section_name']?>" readonly></input>
  							</td>
                <td></td>
  						</tr>

              <tr>
                <td style="padding-left:100px">
                  <span><b>Status</b></span>
                </td>
                <td style="padding: 5px 5px  5px 10px;">
                  <select id="slcStatusKacabEd" name="slcStatusKacabEd" class="form-control select2 " style="width:300px;" required="required" disabled>
                    <?php if ($detail[0]['kacab'] == 'Y') {?>
                      <option value="Y" selected > AKTIF  </option>
                      <option value="N" > TIDAK AKTIF  </option>
                    <?php }else if ($detail[0]['kacab'] == 'N') {?>
                      <option value="N" selected> TIDAK AKTIF  </option>
                      <option value="Y"  > AKTIF  </option>
                    <?php } ?>       
                                    
                  </select>
                </td>
                <td></td>
              </tr>

              <tr>
                <td style="padding-left:100px">
                  <span><b>Alamat Cabang</b></span>
                </td>
                <td style="padding: 5px 5px  5px 10px;">
                  <textarea class="form-control capital note" style="width: 300px" type="text" id="txaAlamatCabangEd" name="txaAlamatCabangEd"><?php echo $detail[0]['alamat_cabang']?></textarea>
                </td>
                <td>
                  <button type="button" class="btn btn-success btn-sm pull-right" style="width: 80px;margin-top: 10px" onclick="btnEditKacab(<?php echo $detail[0]['id_login']?>)" id="btnUpdate"><i class="fa fa-check"></i> Update</button>
                </td>
              </tr>
  					</table>
          </div>
          <div class="col-md-2"></div>
			</div>
    </div>
	</div>
 </section>
