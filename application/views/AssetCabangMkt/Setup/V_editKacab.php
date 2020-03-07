<style>
    tr.danger td{
      background-color: #eb3d34;
}
</style>
    <section class="content-header">
      <span style="margin-top: 50px;">
        <h3>
          Edit Data (<?php echo $su[0]['no_induk']?> - <?php echo $su[0]['nama_kacab']?>)
        </h3>
      </span>
    </section>
    <!-- Main content -->
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
				<div class="col-md-12 pull-right">
    					<table id="filter" class="tblResponsive" style="margin-bottom: 10px;margin-top: 60px">
    						<tr>
    							<td style="padding-left:10px" >
    								<span><b>Ubah Kode</b></span>
    							</td>

    						  <td style="width:15%;padding: 5px 5px  5px 10px;">
                          <select id="slccabangKACAB" name="slccabangKACAB" class="form-control select2 " style="width:300px;" required="required">
                              <option value="" > Pilih Asal Cabang </option>
                              <?php foreach ($cbg as $k) { 
                                      $s='';
                                      if ($k['branch_code'] == $su[0]['kode_cabang']) {
                                          $s='selected';
                                          }
                                      ?>
                              <option value="<?php echo $k['branch_code'] ?>" <?php echo $s ?>><?php echo $k['nama_cabang'] ?></option>
                              <?php } ?>
                          </select>
    							</td>
                  <td>
                    <button type="button" class="btn btn-success btn-sm pull-right" style="width: 80px;margin-left: 10px" onclick="btnEditKCB(<?php echo $su[0]['id_kacab']?>)" id="btnUpdate"><i class="fa fa-check"></i> Update</button>
                  </td>
    						</tr>
    					</table>
			</div>
    </div>
	</div>
 </section>
