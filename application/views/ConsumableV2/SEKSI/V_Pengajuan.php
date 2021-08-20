<style media="screen">
.modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px; /* Adjusts for spacing */
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}

.tbl_lph_mesin td{
  padding-top:10px !important;
}
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary color-palette-box">
              <div class="panel-body">
                <input type="hidden" id="consumablev2" value="1">
                <div class="nav-tabs-custom">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="nav nav-tabs" style="border-bottom:0.5px solid #e6e6e6">
                        <li class="pull-right"><h3 class="text-bold" title="klik elemen ini untuk memperbarui data" style="margin:10px 0 10px;" onclick="reloadsstblpengajuankebutuhan()"><i class="fa fa-cog"></i> Pengajuan Item Kebutuhan</h3></li>
                        <li class="pull-left"><button type="button" class="btn btncstslckeb" style="border: 1px solid #a8a8a8;
    background: white;" name="button" status="+"> <i class="fa fa-plus"></i> Ajukan Kebutuhan</button></li>
                      </ul>
                    </div>
                  </div>
                  <?php
                    $monthnow = date('m')*1;
                    if ($monthnow > 1 && $monthnow < 12) {
                      $monthnownext = $monthnow + 1;
                    }else if ($monthnow == 12) {
                      $monthnownext = 1;
                    }
                    $monthnownext = DateTime::createFromFormat('!m', $monthnownext);
                  ?>
                  <div class="tab-content">
                    <div class="tab-pane active" id="input">
                      <div class="row pt-3">
                        <div class="col-md-12">
                          <!-- <div class="form-group">
                            <label for="">Periode</label>
                            <table>
                              <tr>
                                <td>
                                  <input type="text" class="form-control periode_pengajuan" style="width:200px" id="periode_pengajuan" autocomplete="off" placeholder="Periode" />
                                </td>
                                <td class="pl-3">
                                  <button class="btn btn-primary text-bold " style="width:105px" onclick="caridatapengajuan()"><i class="fa fa-search"></i> Cari</button>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <hr> -->
                          <div class="areamkeb">
                            <i>* Untuk melihat alasan reject, arahkan Kursor ke status reject </i>
                            <div class="table-responsive mt-4">
                             <table class="table table-bordered tblcsmpengajuankeb" style="width:140%;text-align:center">
                               <thead class="bg-primary">
                                 <tr>
                                   <th class="text-center" style="width:4%">No</th>
                                   <th class="text-center" style="width:11%">Item</th>
                                   <th class="text-center" style="width:23%">Desc</th>
                                   <th class="text-center">Quantity</th>
                                   <th class="text-center">UOM</th>
                                   <th class="text-center">Status</th>
                                   <th class="text-center">Req Bulan <?php echo date('F') ?></th>
                                   <th class="text-center">Consumed</th>
                                   <th class="text-center">Sisa Jatah</th>
                                   <th class="text-center">Req Bulan <?php echo $monthnownext->format('F') ?></th>
                                   <th class="text-center" style="width:10%">Created By</th>
                                   <th class="text-center">Created Date</th>
                                   <th class="text-center">Aksi</th>
                                 </tr>
                               </thead>
                               <tbody>

                               </tbody>
                             </table>
                           </div>
                          </div>
                          <div class="areapkeb" style="display:none">
                            <div class="row">
                              <div class="col-md-12">
                                <form class="savepengajuankeb" action="" method="post">
                                <table class="table table-bordered" style="width:100%">
                                  <thead class="bg-primary">
                                    <tr>
                                      <th class="text-center" style="width:4%">No</th>
                                      <th class="text-center" style="width:17%">Description</th>
                                      <th class="text-center" style="width:23%">Item Code</th>
                                      <th class="text-center">Quantity</th>
                                      <th class="text-center">UOM</th>
                                      <th class="text-center">Creation Date</th>
                                      <th class="text-center" style="width:4%"> <button class="btn btn-default btn-sm" onclick="btnPlusKCIS()"><i class="fa fa-plus"></i></button> </th>
                                    </tr>
                                  </thead>
                                  <tbody id="addrow_pengajuankeb">
                                    <tr>
                                      <td class="text-center">1</td>
                                      <td class="text-center">
                                        <input type="hidden" name="item_id[]" class="item_id" value="">
                                        <select class="slccsmkeb" required style="width:300px" name="description[]">
                                          <option value="" selected></option>
                                        </select>
                                      </td>
                                      <td class="text-center"><input type="text" class="form-control item-code" name="item_code[]" readonly="readonly"></td>
                                      <td class="text-center"><input type="number" required class="form-control" name="qty_kebutuhan[]" required="required"></td>
                                      <td class="text-center"><input type="text" class="form-control uom" readonly="readonly"></td>
                                      <td class="text-center"><input type="text" class="form-control tglpengajuan" readonly="readonly"></td>
                                      <td class="text-center">
                                        <button class="btn btn-default btn-sm" onclick="btnMinKCIS(this)">
                                          <i class="fa fa-minus"></i>
                                        </button>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <center> <button type="submit" class="btn btn-primary text-bold " name="button" style="width:130px"> <i class="fa fa-save"></i> Ajukan</button> </center>
                              </form>
                              </div>
                            </div>
                          </div>

                        <!--  <center> <button type="submit" class="btn btn-lg btn-primary text-bold" id="pengajuanCST" disabled name="button"> <i class="fa fa-upload"></i> Ajukan</button> </center> -->
                        </div>
                      </div>
                      <br>

                    </div>


                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</section>

<!-- 210515171 -->
