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
        Compose and Generate New Proposal
      </h1>
    </section>
    <!-- Main content -->
<form target="_blank" action="<?php echo base_url('AssetCabang/Cabang/generatePdf') ?>" method="post"> 
<section class="content">
  	<div class="row">
    	<div class="col-md-12">
      	<div class="box itsfun1">
	   		<div class="box-header with-border" style="text-align: left;">
					<h3 class="box-title" style="font-family: sans-serif;">
                	<b> New Proposal</b><br>
              	</h3><br>
            </div>
         <div class="box-body">
					<!----- Tabel ----->
          <div class="col-md-8 pull-left">
					<table  id="filter" class="col-md-12 tblResponsive" style="margin-bottom: 20px">

						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Kategori Asset</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<select onchange="onChangeJK()" id="slcKategoriAst" name="slcKategoriAst" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option value="" > Pilih Kategori Asset  </option>
                                    <?php foreach ($ka as $k) { ?>
                                    <option value="<?php echo $k['id_ka'] ?>"><?php echo $k['nama_ka'] ?>
                                    </option>
                                    <?php } ?>
                  </select>
								</td>
						</tr>

						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Jenis Asset</b></span>
							</td>
								<td style="width:25%; padding: 5px 5px 5px 50px;">
									<select onchange="onChangeJK()" id="slcJenisAst" name="slcJenisAst" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option value="" > Pilih Jenis Asset  </option>
                                    <?php foreach ($ja as $k) { ?>
                                    <option value="<?php echo $k['id_ja'] ?>"><?php echo $k['nama_ja'] ?>
                                    </option>
                                    <?php } ?>
                  </select>
								</td>
						</tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Perolehan Asset</b></span>
              </td>
                <td style="width:25%; padding: 5px 5px 5px 50px;">
                  <select onchange="onChangeJK()" id="slcPerolehanAst" name="slcPerolehanAst" class="form-control select2 select2-hidden-accessible kendaraanTPB" style="width:300px;" required="required">
                                    <option value="" > Pilih Perolehan Asset  </option>
                                    <?php foreach ($pa as $k) { ?>
                                    <option value="<?php echo $k['id_pa'] ?>"><?php echo $k['nama_pa'] ?>
                                    </option>
                                    <?php } ?>
                  </select>
                </td>
            </tr>

						<tr>
							<td style="width: 25%;padding-left: 235px;">
								<span><b>Seksi Pemakai</b></span>
							</td>
								<td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <select onchange="onChangeJK()" id="slcPemakai" name="slcPemakai" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option value="" > Pilih Seksi Pemakai</option>
                                    <?php foreach ($sp as $k) { ?>
                                    <option value="<?php echo $k['nama_sp'] ?>"><?php echo $k['nama_sp'] ?>
                                    </option>
                                    <?php } ?>
                  </select>
						</tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Asal Cabang</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <select id="slcAsalCabang" name="slcAsalCabang" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option value="" > Pilih Asal Cabang </option>
                                    <option value="TJK" > TANJUNG KARANG </option>
                                    <option value="TKS" > TUKSONO</option>
                                    <option value="PKU" > PEKANBARU</option>
                                    <option value="MDN" > MEDAN</option>
                                    <option value="SBY" > SURABAYA</option>
                                    <option value="JKT" > JAKARTA</option>
                                    <option value="PDG" > PADANG</option>
                                    <option value="PST" > PUSAT</option>
                                    <option value="NGK" > NGANJUK</option>
                                    <option value="BJM" > BANJARMASIN</option>
                                    <option value="DJB" > JAMBI</option>
                                    <option value="MKS" > MAKASSAR</option>
                                    <option value="SDP" > SIDRAP</option>
                                    <option value="TGM" > TUGUMULYO</option>
                                    <option value="PNK" > PONTIANAK</option>
                                    <option value="PLU" > PALU</option>
                  </select>
            </tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Alasan</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <textarea class="form-control" style="width: 300px" type="text" id="txaAlasan" name="txaAlasan" placeholder="MASUKKAN ALASAN" ></textarea>
            </tr>

					</table>
				</div>
        <div class="col-md-2"></div>
			</div>
      <div class="col-md-12 pull-left">
                    <button id="btnAddRowAC" onclick="addRowAC(this);" type="button" class="zoom btn btn-warning btn-lg pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px" disabled="disabled"><i class="fa fa-plus "></i></button>
                  </div>
            <div class="box-body">
					<table align="center" style="width: 100%;" id="tblNewPropCbg" class="table table-striped table-bordered table-hover text-center">
                  <thead>
                    <tr style="background-color: #026337;" class="bg-primary">
                      <th class="text-center" style="width: 5%">No</th>
                      <th class="text-center" style="width: 20%">Kode Barang</th>
                      <th class="text-center" style="width: 20%">Nama Asset</th>
                      <th class="text-center" style="width: 35%">Spesifikasi Asset</th>
                      <th class="text-center" style="width: 10%">Jumlah</th>
                      <th class="text-center" style="width: 10%">Umur Teknis</th>
                      <th class="text-center" style="width: 10%">Action</th>
                    </tr>
                  </thead>
                 <tbody>
                 <td>1</td>
                 <td><input type="text" required="required" class="form-control" name="txtKodeBarangAC[]" id="txtKodeBarangAC"></td>
                 <td><input type="text" required="required" class="form-control" name="txtNamaAssetAC[]" id="txtNamaAssetAC"></td>
                 <td><input type="text" required="required" class="form-control" name="txtSpesifikasiAssetAC[]" id="txtSpesifikasiAssetAC"></td>
                 <td><input type="text" required="required" class="form-control" name="txtJumlahAC[]" id="txtJumlahAC"></td>
                 <td><input type="text" required="required" class="form-control" name="txtUmurTeknisAC[]" id="txtUmurTeknisAC"></td>
                 <td><button disabled type="button" class="btn btn-danger btn-m" id="btnDeleteRowAC"><i class="fa fa-trash"></i></button></td>
                 </tbody>
               </table>
               <div class="col-md-12 pull-left">
                
                    <button id="btnGenerate" type="submit" class="zoom btn btn-primary btn-m pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px"><i class="fa fa-pencil"></i> Generate</button>
             </form>

                    <button id="btnSubmitAC" onclick="submitToMarketing(this);" type="button" class="zoom btn btn-success btn-m pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px"><i class="fa fa-check"></i> Submit</button>
                    
                  </div>
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


<script type="text/javascript">
  $(document).ready(function(){
    $("#btnAddRowAC").prop('disabled',false).trigger('change');
  });
</script>