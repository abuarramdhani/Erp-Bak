<style>
      thead.toscahead tr th {
        background-color: #9e9e9e;
      }
      thead.dua tr th {
        background-color: #00a5b0;
      }
      .itsfun1 {
        border-top-color: #f39c12;
      }
      .buttoncute {
        background-color: #026337;
      }
      .capital{
    text-transform: uppercase;
}

.inputfile-1 + label {
    color: white;
    background-color: #f39c12;
}
.inputfile + label {
    max-width: 200%;
    font-size: 1.25rem;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    padding: 0.625rem 1.25rem;
    font-family: sans-serif;
    border-radius: 5px;
}
</style>
  <form target="_blank" action="<?php echo base_url('AssetCabang/generatePdfEdit/'.$header[0]['batch_number']) ?>" method="post"> 
    <section class="content-header">
      <h1>
       Edit Proposal <b><?php echo $header[0]['batch_number']?></b><input type="hidden" name="judulProposalNm" id="judulproposalhdn" value="<?php echo $header[0]['batch_number'].'.pdf'?>"/>
        <input type="hidden" name="batch_number" id="batch_number" value="<?php echo $header[0]['batch_number'] ?>"/>
      </h1>
    </section>
    <!-- Main content -->
<!-- <form form_open_multipart('AssetCabangMarketing/ApproveReject/'.$header[0]['id_proposal']')>  -->
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box itsfun1">
        <div class="box-header with-border" style="text-align: left;">
          <h3 class="box-title" style="font-family: sans-serif;">
                  <b>Re-forward Proposal ke Kacab</b><br>
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
                  <select id="slcKategoriAst" name="slcKategoriAst" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                    <option value="" > Pilih Kategori Asset  </option>
                      <?php foreach ($ka as $k) { 
                      $s='';
                      if ($k['id_ka'] == $header[0]['id_ka']) {
                          $s='selected';
                          }
                      ?>
                    <option value="<?php echo $k['id_ka'] ?>" <?php echo $s ?>><?php echo $k['nama_ka'] ?>
                  <?php } ?>
                    </option>
                  </select>
                </td>
            </tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Jenis Asset</b></span>
              </td>
                <td style="width:25%; padding: 5px 5px 5px 50px;">
                  <select disabled id="slcJenisAst" name="slcJenisAst" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option value="" > ---- Diisi oleh Marketing ----  </option>
                  </select>
                </td>
            </tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Perolehan Asset</b></span>
              </td>
                <td style="width:25%; padding: 5px 5px 5px 50px;">
                  <select id="slcPerolehanAst" name="slcPerolehanAst" class="form-control select2 select2-hidden-accessible kendaraanTPB" style="width:300px;" required="required">
                                    <option value="" > Pilih Perolehan Asset  </option>
                                    <?php foreach ($pa as $k) { 
                                      $s='';
                                      if ($k['id_pa'] == $header[0]['id_pa']) {
                                          $s='selected';
                                          }
                                      ?>
                                    <option value="<?php echo $k['id_pa'] ?>" <?php echo $s ?>><?php echo $k['nama_pa'] ?>
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
                  <input type="text" class="form-control" id="slcPemakai" name="slcPemakai" style="width: 300px" readonly value="<?php echo $spo[0]['section_name']?>">
            </tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Asal Cabang</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <select disabled id="slcAsalCabang" name="slcAsalCabang" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                   <option value="" > Pilih Cabang</option>
                                    <?php foreach ($cabang as $k) { 
                                      $s='';
                                      if ($k['branch_code'] == $header[0]['kode_cabang']) {
                                          $s='selected';
                                          }
                                      ?>
                                    <option value="<?php echo $k['branch_code'] ?>" <?php echo $s ?>><?php echo $k['nama_cabang'] ?>
                                    </option>
                                    <?php } ?>
                  </select>
            </tr>

            <tr>
              <td style="width: 25%;padding-left: 235px;">
                <span><b>Alasan</b></span>
              </td>
                <td style="width: 25%;padding: 5px 5px 5px 50px;">
                  <textarea class="form-control" style="width: 300px" type="text" id="txaAlasan" name="txaAlasan" placeholder="MASUKKAN ALASAN" ><?php echo $header[0]['alasan']?></textarea>
                  <input type="hidden" name="batch_number_name" id="batch_number" value="<?php echo $header[0]['batch_number'] ?>"/>
            </tr>
          </table>
        </div>
      </div>
              <div class="col-md-12 pull-left">
                    <button id="btnAddRowAC" onclick="addRowAC(this);" type="button" class="zoom btn btn-warning btn-lg pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px"><i class="fa fa-plus "></i></button>
              </div>
            <div class="box-body">
          <table align="center" style="width: 100%;" id="tblNewPropCbg" class="table table-striped table-bordered table-hover text-center">
                  <thead>
                    <tr style="background-color: #f39c12;" class="bg-primary">
                      <th class="text-center" style="width: 5%">No</th>
                      <th class="text-center" style="width: 20%">Nama Asset</th>
                      <th class="text-center" style="width: 20%">Kode Barang</th>
                      <th class="text-center" style="width: 35%">Spesifikasi Asset</th>
                      <th class="text-center" style="width: 10%">Jumlah</th>
                      <th class="text-center" style="width: 10%">Umur Teknis</th>
                      <th class="text-center" style="width: 10%">Action</th>
                    </tr>
                  </thead>
                 <tbody>
                  <?php $no=1; foreach ($line as $k) { ?>
                    <tr>
                      <td class="text-center" ><?php echo $no;?></td>
                      <td class="text-center"><select id="slcNamaAsset" onchange="namaAsset(this)" name="slcNamaAsset[]" class="form-control select2 selectAC" style="width:370px;" required="required">
                              <option value="<?php echo $k['nama_asset']?>"><?php echo $k['nama_asset']?></option>
                          </select>
                      </td>
                      <td class="text-center"><input type="text" required="required" class="form-control txtKodeBarangAC" value="<?php echo $k['kode_barang']?>" name="txtKodeBarangAC[]" id="txtKodeBarang"></td>
                      <td class="text-center"><input type="text" class="form-control" value="<?php echo $k['spesifikasi_asset']?>" name="txtSpesifikasiAssetAC[]" id="txtSpesifikasiAssetAC"></td>
                      <td class="text-center"><input type="text" class="form-control" value="<?php echo $k['jumlah_asset']?>" name="txtJumlahAC[]" id="txtJumlahAC"></td>
                      <td class="text-center"><input readonly type="text" class="form-control" value="<?php echo $k['umur_teknis']?>" name="txtUmurTeknisAC[]" id="txtUmurTeknisAC"></td>
                      <td><button disabled type="button" class="btn btn-danger btn-m" id="btnDeleteRowAC"><i class="fa fa-trash"></i></button></td>
                    </tr>
                  <?php $no++;} ?>
                  <tr>
                  </tr>
                 </tbody>
               </table>
               <div class="col-md-6 pull-right">
                
                    <button id="btnGenerate" type="submit" class="zoom btn btn-primary btn-m pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px;transition: transform .2s;"><i class="fa fa-pencil"></i> Generate</button>
                     </form>
                    <button id="btnSubmitAC" onclick="submitToMarketingEdit(<?php echo $header[0]['id_proposal']?>);" type="button" class=" btn btn-success btn-m pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px;transition: transform .2s;"><i class="fa fa-check"></i> Submit</button>
                    
                  </div>
                  <div class="col-md-6 pull-left">
                    <button onclick="window.location.replace(baseurl+'AssetCabangKacab/Draft')" id="btnGenerate" type="button" class="zoom btn btn-primary btn-m pull-left" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px"><i class="fa fa-home"></i> Back</button>
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

</script>