<style>
    tr.danger td{
      background-color: #eb3d34;
}
</style>
    <section class="content-header">
      <h1>
        Edit Data Perolehan Asset
      </h1>
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

    					<table id="filter" class="tblResponsive" style="margin-bottom: 10px;margin-top: 70px">
    						<tr>
    							<td style="padding-left:10px" >
    								<span><b>Perolehan Asset</b></span>
    							</td>

    						  <td style="width:15%;padding: 5px 5px  5px 10px;">
    								<input class="form-control capital" style="width: 300px;" type="text" id="txtPerolehanAssetEdit" name="txtPerolehanAssetEdit" value="<?php echo $pa[0]['nama_pa']?>" ></input>
    							</td>

                  <td>
                    <button type="button" class="btn btn-success btn-sm pull-right" style="width: 80px;" onclick="btnEditPA(<?php echo $pa[0]['id_pa']?>)" id="btnUpdate"><i class="fa fa-check"></i> Update</button>
                  </td>

    						</tr>
    					</table>
            
			</div>
    </div>
	</div>
 </section>
