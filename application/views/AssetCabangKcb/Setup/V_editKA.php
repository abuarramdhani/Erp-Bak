<style>
    tr.danger td{
      background-color: #eb3d34;
}
</style>
    <section class="content-header">
      <span style="margin-top: 50px;">
        <h3>
          Edit Data Kategori Asset
        </h3>
      </span>
    </section>
    <!-- Main content -->
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- <div class="box box-primary"> -->
         <!-- <div class="box-body"> -->
        <div class="col-md-12 pull-right">
          <!----- Tabel ----->
          <!-- <div class="col-md-2"></div> -->
          <!-- <div class= "box box-body"> -->
              <table id="filter" class="tblResponsive" style="margin-bottom: 10px;margin-top: 70px">
                <tr>
                  <td style="padding-left:10px" >
                    <span><b>Kategori Asset</b></span>
                  </td>

                  <td style="width:15%;padding: 5px 5px  5px 10px;">
                    <input class="form-control capital" style="width: 300px;" type="text" id="txtKategoriAssetEdit" name="txtKategoriAssetEdit" value="<?php echo $ka[0]['nama_ka']?>" ></input>
                  </td>

                  <td>
                    <button type="button" class="btn btn-success btn-sm pull-right" style="width: 80px;" onclick="btnEditKA(<?php echo $ka[0]['id_ka']?>)" id="btnUpdate"><i class="fa fa-check"></i> Update</button>
                  </td>

                </tr>
              </table>
            <!-- </div> -->
            
      </div>
    </div>
  </div>
 </section>
