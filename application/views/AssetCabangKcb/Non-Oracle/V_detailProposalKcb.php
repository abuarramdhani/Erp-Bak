<style>
      thead.toscahead tr th {
        background-color: #9e9e9e;
      }
      thead.dua tr th {
        background-color: #00a5b0;
      }
      .itsfun1 {
        border-top-color: #00a5b0;
      }
      .buttoncute {
      	background-color: #026337;
      }
      .capital{
    text-transform: uppercase;
}

.inputfile-1 + label {
    color: white;
    background-color: #00a5b0;
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
    <section class="content-header">
      <h1>
        Detail Proposal <b><?php echo $header[0]['batch_number']?></b><input type="hidden" name="judulProposalNm" id="judulproposalhdn" value="<?php echo $header[0]['batch_number'].'.pdf'?>"/>
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
                	<b>Approve/Reject by Kacab</b><br>
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
									<select disabled id="slcKategoriAst" name="slcKategoriAst" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
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
                                    <option value="" > Pilih Jenis Asset  </option>
                                     <?php foreach ($ja as $k) { 
                                      $s='';
                                      if ($k['id_ja'] == $header[0]['id_ja']) {
                                          $s='selected';
                                          }
                                      ?>
                                    <option value="<?php echo $k['id_ja'] ?>" <?php echo $s ?>><?php echo $k['nama_ja'] ?>
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
                  <select disabled id="slcPerolehanAst" name="slcPerolehanAst" class="form-control select2 select2-hidden-accessible kendaraanTPB" style="width:300px;" required="required">
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
                  <select disabled id="slcPemakai" name="slcPemakai" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
                                    <option value="" > Pilih Seksi Pemakai</option>
                                    <?php foreach ($sp as $k) { 
                                      $s='';
                                      if ($k['id_sp'] == $header[0]['id_sp']) {
                                          $s='selected';
                                          }
                                      ?>
                                    <option value="<?php echo $k['nama_sp'] ?>" <?php echo $s ?>><?php echo $k['nama_sp'] ?>
                                    </option>
                                    <?php } ?>
                  </select>
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
                  <textarea disabled class="form-control" style="width: 300px" type="text" id="txaAlasan" name="txaAlasan" placeholder="MASUKKAN ALASAN" ><?php echo $header[0]['alasan']?></textarea>
            </tr>
					</table>
				</div>
        <!-- <div class="col-md-4"> -->
          <!-- <input style="margin-left: 150px" type="file" name=""> -->
          <!-- <input style="display: none;" type="file" name="txfPdfAC" id="file-1" class="inputfile inputfile-1" accept="application/pdf,application/jpg" /> -->
                                    <!-- data-multiple-caption="{count} files selected" -->
                                   <!--  <label data-toggle="tooltip" data-placement="top" title="Judul dokumen yang diupload harus sama dengan judul proposal" for="file-1" name="test" class="zoom">
                                      <span id="ini_span"><i id="ini_italic" class="fa fa-cloud-upload"></i> Upload Feedback&hellip;</span>
                                    </label>
        </div> -->
			</div>
            <div class="box-body">
					<table align="center" style="width: 100%;" id="tblNewPropCbg" class="table table-striped table-bordered table-hover text-center">
                  <thead>
                    <tr style="background-color: #00a5b0;" class="bg-primary">
                      <th class="text-center" style="width: 5%">No</th>
                      <th class="text-center" style="width: 20%">Kode Barang</th>
                      <th class="text-center" style="width: 20%">Nama Asset</th>
                      <th class="text-center" style="width: 35%">Spesifikasi Asset</th>
                      <th class="text-center" style="width: 10%">Jumlah</th>
                      <th class="text-center" style="width: 10%">Umur Teknis</th>
                    </tr>
                  </thead>
                 <tbody>
                  <?php $no=1; foreach ($line as $k) { ?>
                    <tr>
                      <td><?php echo $no;?></td>

                      <td><input type="hidden" name="txtKodeBarangAC[]" value="<?php echo $k['kode_barang']?>">
                          <?php echo $k['kode_barang']?>
                      </td>

                      <td><input type="hidden" name="slcNamaAsset[]" value="<?php echo $k['nama_asset']?>">
                          <?php echo $k['nama_asset']?>
                      </td>

                      <td><input type="hidden" name="txtSpesifikasiAssetAC[]" value="<?php echo $k['spesifikasi_asset']?>">
                          <?php echo $k['spesifikasi_asset']?>
                      </td>

                      <td><input type="hidden" name="txtJumlahAC[]" value="<?php echo $k['jumlah_asset']?>">
                          <?php echo $k['jumlah_asset']?>
                      </td>

                      <td><input type="hidden" name="txtUmurTeknisAC[]" value="<?php echo $k['umur_teknis']?>">
                          <?php echo $k['umur_teknis']?>
                      </td>

                    </tr>
                  <?php $no++;} ?>
                  <tr>
                  </tr>
                 </tbody>
               </table>
               <div class="col-md-6 pull-right">
                
                    <button data-toggle="tooltip" data-placement="top" title="Proses approve bersifat permanen dan akan berlanjut ke proses submit to Marketing" id="btnApprove" value="2" name="btnApproveAC" id="btnSubmitAC" type="submit" class="zoom btn btn-success btn-m pull-right" onclick="approveProposalKacab(<?php echo $header[0]['id_proposal']?>)" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px"><i class="fa fa-check"></i> Approve</button>

                    <button data-toggle="modal" title="Harap cek kembali, proses yang sudah dilakukan tidak bisa diedit kembali" id="btnReject" value="3" data-target="#MdlRejectAC" onclick="openModalRejectedAC(<?php echo $header[0]['id_proposal']?>)" name="btnRejectAC" type="button" onclick="getRejected(<?php echo $header[0]['id_proposal'];?>)" class="zoom btn btn-danger btn-m pull-right" style="margin-top: 10px; margin-bottom: 20px;margin-left: 20px;width: 100px"><i class="fa fa-times"></i> Reject</button>

                    <!-- onclick="rejectProposalKacab(<?php echo $header[0]['id_proposal']?>)" -->
                    
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


<div id="MdlRejectAC" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:800px" role="document">
    <div class="modal-content"  id="content1" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <center>
              
            </select>
            <center>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

</script>