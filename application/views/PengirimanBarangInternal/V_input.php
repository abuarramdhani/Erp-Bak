<!-- hello -->
<input type="hidden" id="cekapp" value="punyaPBI">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-white box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-sm-9">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="display:inline">
                <li class="nav-item active" style="background:#e7e7e7">
                  <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">INVENTORY </span> </a>
                </li>
                <li class="nav-item" style="background:#e7e7e7">
                  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">NON-INVENTORY</span></a>
                </li>
                <li class="nav-item" style="background:#e7e7e7">
                  <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">ASSET </span></a>
                </li>
                <?php
                $adm_design = ['a'=>'T0012', 'b' => 'B0444', 'c' => 'P0258', 'd' => 'P0071', 'e' => 'K2070'];
                 if (!empty(array_search($this->session->user, $adm_design))) { ?>
                   <li class="nav-item" style="background:#e7e7e7">
                     <a class="nav-link" id="pills-adm-design-tab" data-toggle="pill" href="#pills-adm-design" role="tab" aria-controls="pills-adm-design" aria-selected="false">ADMINISTRASI DESAIN </span></a>
                   </li>
                <?php } ?>
                <li></li>
              </ul>
            </div>
            <div class="col-sm-3">
              <h4 style="font-weight:bold;margin-left:auto;float:right;margin-right:10px;" class="ml-auto"><i class="fa fa-cloud-upload"></i> Input Data PBI</h4>
            </div>
          </div>
        </div>
        <div class="box-body">

            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade in active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <form action="<?php echo base_url('PengirimanBarangInternal/Input/Save') ?>" method="post">
                  <div class="col-md-2"></div>
                  <div class="col-md-8 mt-4">
                    <br>
                    <?php echo $this->session->flashdata('message_pbi') ?>
                    <div class="error_ga_ini"></div>
                    <div class="form-group">
                      <label for="seksi_pengirim">Tujuan</label>
                      <div class="row">
                        <div class="col-md-12">
                          <select class="form-control select2 desc_1" name="tujuan" required style="width:100%">
                            <option value="">Select...</option>
                            <option value="PUSAT">PUSAT</option>
                            <option value="MLATI">MLATI</option>
                            <option value="TUKSONO">TUKSONO</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tujuan">No MO</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-10">
                            <select class="form-control select2MO_PBI" style="width:100%" onchange="cek_aga_ga_monya()" multiple="multiple" name="mo" id="kki_mo" required>
                            </select>
                            <!-- <input type="text" class="form-control" id="kki_mo" name="mo" value="" autocomplete="off" required> -->
                          </div>
                          <div class="col-md-2">
                            <button type="button" style="width: 100%;font-weight:bold" onclick="submitMO()" class="btn btn-success" name="button"><i class="fa fa-caret-square-o-right"></i> Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group">
                      <label for="seksi_pengirim">Gudang Pengirim</label>
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="inv_nama_pengirim" name="nama_pengirim" value="" readonly>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control" id="inv_seksi_pengirim" name="seksi_pengirim" value="" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tujuan">Gudang Penerima</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4">
                            <input type="text" class="form-control" id="inv_employee" name="employee_seksi_tujuan" readonly>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" id="inv_seksi_tujuan" name="seksi_tujuan" value="" readonly>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <div class="form-group">
                      <label for="tujuan">Keterangan</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-12">
                            <input type="text" class="form-control" id="inv_keterangan" name="keterangan" value="" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-12 mt-4">
                    <hr>
                  </div>
                  <div class="col-lg-12 mt-4">
                    <div class="table-responsive">
                      <div class="row" style="margin: 1px;">
                        <div class="panel-body">
                          <table class="table table-bordered inv_cektable">
                            <thead class="bg-success">
                              <tr>
                                <th class="text-center" style="width:35px; !important">Line</th>
                                <th class="text-center" style="width:250px; !important">Item Code</th>
                                <th class="text-center" style="width:300px;">Description</th>
                                <th class="text-center" style="width:120px;">Quantity</th>
                                <th class="text-center" style="width:70px;">UOM</th>
                                <th class="text-center" style="width:110px;">Item Type</th>
                              </tr>
                            </thead>
                            <tbody id="inv_tambahisi">
                              <!-- <tr id="inv_teer1">
                                <td class="text-center"><input type="text" class="form-control" name="line_number[]" value="1" readonly></td>
                                <td class="text-center"><input type="text" class="form-control" id="inv_item_code_1" name="item_code[]" readonly></td>
                                <td class="text-center"><input type="text" class="form-control" id="inv_description_1" name="description[]" readonly></td>
                                <td class="text-center"><input type="number" class="form-control" name="inv_quantity[]" autocomplete="off" readonly></td>
                                <td class="text-center"><input type="text" class="form-control" id="inv_uom_1" name="uom[]" readonly></td>
                                <td class="text-center"><input type="text" class="form-control" id="inv_itemtype_1" name="item_type[]" readonly></td>
                              </tr> -->
                            </tbody>
                          </table>
                        </div>
                        <div class="panel-body pbi_check_desc_1">
                          <input type="hidden" name="type" value="1">
                          <button type="submit" style="float:right !important;font-weight:bold" onclick="summitpbiarea()" class="btn btn-success" name="button"><i class="fa fa-file"></i> Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form action="<?php echo base_url('PengirimanBarangInternal/Input/SaveNon') ?>" method="post">
                  <div class="col-md-2"></div>
                  <div class="col-md-8 mt-4">
                    <br>
                    <div class="form-group">
                      <label for="seksi_pengirim">Tujuan</label>
                      <div class="row">
                        <div class="col-md-12">
                          <select class="form-control select2 desc_2" name="tujuan" style="width:100%" required>
                            <option value="">Select...</option>
                            <option value="PUSAT">PUSAT</option>
                            <option value="MLATI">MLATI</option>
                            <option value="TUKSONO">TUKSONO</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="seksi_pengirim">Seksi Pengirim</label>
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="<?php echo $this->session->employee ?>" readonly>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control" id="seksi_pengirim" name="seksi_pengirim" value="" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tujuan">Seksi Tujuan</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4">
                            <select class="form-control select2PBI" style="width:100%" id="employee" onchange="nama()" name="employee_seksi_tujuan" required></select>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" id="seksi_tujuan" name="seksi_tujuan" value="" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tujuan">Keterangan</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-12">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-12 mt-4">
                    <hr>
                  </div>
                  <div class="col-lg-12 mt-4">
                    <div class="table-responsive">
                      <div class="row" style="margin: 1px;">
                        <div class="panel-body">
                          <table class="table table-bordered cektable">
                            <thead class="bg-success">
                              <tr>
                                <th class="text-center" style="width:35px; !important">Line</th>
                                <th class="text-center" style="width:210px; !important">Item Code</th>
                                <th class="text-center" style="width:300px;">Description</th>
                                <th class="text-center" style="width:120px;">Quantity</th>
                                <th class="text-center" style="width:70px;">UOM</th>
                                <th class="text-center" style="width:110px;">Item Type</th>
                                <th class="text-center" style="width:50px;">Add/Min</th>
                              </tr>
                            </thead>
                            <tbody id="tambahisi">
                              <tr id="teer1">
                                <td class="text-center"><input type="text" class="form-control" name="line_number[]" value="1" readonly></td>
                                <td class="text-center"><select class="form-control select2PBILine" id="item_code_1" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" onchange="autofill(1)" required>
                                  <option selected="selected"></option>
                                </select></td>
                                <td class="text-center"><input type="text" class="form-control" id="description_1" name="description[]" readonly></td>
                                <td class="text-center"><input type="number" class="form-control" id="quantity_1" name="quantity[]" autocomplete="off" required></td>
                                <td class="text-center"><input type="text" class="form-control" id="uom_1" name="uom[]" readonly></td>
                                <td class="text-center"><input type="text" class="form-control" id="itemtype_1" name="item_type[]" readonly></td>
                                <td class="text-center"><a class="btn btn-default btn-sm" onclick="btnPlusPBI()"><i class="fa fa-plus"></i></a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="panel-body pbi_check_desc_2">
                          <input type="hidden" name="type" value="2">
                          <button type="submit" style="float:right !important;font-weight:bold" onclick="summitpbiarea1()" class="btn btn-success" name="button"><i class="fa fa-file"></i> Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

              </div>
              <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <form  method="post">
                  <div class="col-md-2"></div>
                  <div class="col-md-8 mt-4">
                    <br>
                    <div class="form-group">
                      <label for="seksi_pengirim">Tujuan</label>
                      <div class="row">
                        <div class="col-md-12">
                          <select class="form-control select2 desc_3" id="pbi_tujuan" name="tujuan" style="width:100%" required>
                            <option value="">Select...</option>
                            <option value="PUSAT">PUSAT</option>
                            <option value="MLATI">MLATI</option>
                            <option value="TUKSONO">TUKSONO</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="ast_seksi_pengirim">Seksi Pengirim</label>
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="ast_nama_pengirim" name="nama_pengirim" value="<?php echo $this->session->employee ?>" readonly>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control" id="ast_seksi_pengirim" name="seksi_pengirim" value="" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Seksi Tujuan</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4">
                            <select class="form-control select2PBI" style="width:100%" id="ast_employee" onchange="ast_nama()" name="employee_seksi_tujuan" required></select>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" id="ast_seksi_tujuan" name="seksi_tujuan" value="" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Keterangan</label>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-12">
                            <input type="text" class="form-control" id="ast_keterangan" name="keterangan" value="" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">No Transfer Asset</label>
                          <div class="form-group">
                            <input type="text" class="form-control" id="ast_no_trans" name="no_trans" value="" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Atasan</label>
                          <div class="form-group">
                            <select class="form-control ast_select2PBI" style="width:100%" id="ast_atasan" name="atasan" required></select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-12 mt-4">
                    <hr>
                  </div>
                  <div class="col-lg-12 mt-4">
                    <div class="table-responsive">
                      <div class="row" style="margin: 1px;">
                        <div class="panel-body">
                          <table class="table table-bordered ast_cektable">
                            <thead class="bg-success">
                              <tr>
                                <th class="text-center" style="width:35px; !important">Line</th>
                                <th class="text-center" style="width:210px; !important">Item Code</th>
                                <th class="text-center" style="width:300px;">Description</th>
                                <th class="text-center" style="width:120px;">Quantity</th>
                                <th class="text-center" style="width:70px;">UOM</th>
                                <th class="text-center" style="width:110px;">Item Type</th>
                                <th class="text-center" style="width:50px;">Add/Min</th>
                              </tr>
                            </thead>
                            <tbody id="ast_tambahisi">
                              <tr id="ast_teer1">
                                <td class="text-center"><input type="text" class="form-control line_number" name="line_number[]" value="1" readonly></td>
                                <td class="text-center"><select class="form-control select2PBILine item_code" id="ast_item_code_1" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" onchange="ast_autofill(1)" required>
                                  <option selected="selected"></option>
                                </select></td>
                                <td class="text-center"><input type="text" class="form-control description" id="ast_description_1" name="description[]" readonly></td>
                                <td class="text-center"><input type="number" class="form-control quantity" name="quantity[]" autocomplete="off" required></td>
                                <td class="text-center"><input type="text" class="form-control uom" id="ast_uom_1" name="uom[]" readonly></td>
                                <td class="text-center"><input type="text" class="form-control item_type" id="ast_itemtype_1" name="item_type[]" readonly></td>
                                <td class="text-center"><a class="btn btn-default btn-sm" onclick="ast_btnPlusPBI()"><i class="fa fa-plus"></i></a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="panel-body pbi_check_desc_3">
                          <input type="hidden" name="type" id="pbi_type" value="3">
                          <button type="button" style="float:right !important;font-weight:bold" onclick="insert_asset()" class="btn btn-success" name="button"><i class="fa fa-file"></i> Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <?php
               if (!empty(array_search($this->session->user, $adm_design))) { ?>
                 <div class="tab-pane fade" id="pills-adm-design" role="tabpanel" aria-labelledby="pills-contact-tab">
                   <form action="<?php echo base_url('PengirimanBarangInternal/Input/SaveNon') ?>" method="post">
                     <div class="col-md-2"></div>
                     <div class="col-md-8 mt-4">
                       <br>
                       <div class="form-group">
                         <label for="seksi_pengirim">Tujuan</label>
                         <div class="row">
                           <div class="col-md-12">
                             <select class="form-control select2 desc_2_adm" name="tujuan" style="width:100%" required>
                               <option value="">Select...</option>
                               <option value="PUSAT">PUSAT</option>
                               <option value="MLATI">MLATI</option>
                               <option value="TUKSONO">TUKSONO</option>
                             </select>
                           </div>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="seksi_pengirim">Seksi Pengirim</label>
                         <div class="row">
                           <div class="col-md-4">
                             <input type="text" class="form-control" name="nama_pengirim" value="<?php echo $this->session->employee ?>" readonly>
                           </div>
                           <div class="col-md-8">
                             <input type="text" class="form-control" id="seksi_pengirim_adm" name="seksi_pengirim" value="" readonly>
                           </div>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="tujuan">Seksi Tujuan</label>
                         <div class="form-group">
                           <div class="row">
                             <div class="col-md-4">
                               <select class="form-control select2PBI" style="width:100%" id="employee_adm" onchange="adm_nama()" name="employee_seksi_tujuan" required></select>
                             </div>
                             <div class="col-md-8">
                               <input type="text" class="form-control" id="seksi_tujuan_adm" name="seksi_tujuan" value="" readonly>
                             </div>
                           </div>
                         </div>
                       </div>
                       <div class="form-group">
                         <label for="tujuan">Keterangan</label>
                         <div class="form-group">
                           <div class="row">
                             <div class="col-md-12">
                               <input type="text" class="form-control" id="keterangan_adm" name="keterangan" value="" autocomplete="off" required>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                     <div class="col-md-2"></div>
                     <div class="col-md-12 mt-4">
                       <hr>
                     </div>
                     <div class="col-lg-12 mt-4">
                       <div class="table-responsive">
                         <div class="row" style="margin: 1px;">
                           <div class="panel-body">
                             <table class="table table-bordered cektable_adm">
                               <thead class="bg-success">
                                 <tr>
                                   <th class="text-center" style="width:35px; !important">Line</th>
                                   <th class="text-center" style="width:210px; !important">Item Code</th>
                                   <th class="text-center" style="width:300px;">Description</th>
                                   <th class="text-center" style="width:120px;">Quantity</th>
                                   <th class="text-center" style="width:70px;">UOM</th>
                                   <th class="text-center" style="width:110px;">Item Type</th>
                                   <th class="text-center" style="width:50px;">Add/Min</th>
                                 </tr>
                               </thead>
                               <tbody id="adm_tambahisi">
                                 <tr>
                                   <td class="text-center"><input type="text" class="form-control" name="line_number[]" value="1" readonly></td>
                                   <td class="text-center"><select class="form-control item_code_adm" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" required>
                                     <option selected="selected"></option>
                                   </select></td>
                                   <td class="text-center"><input type="text" class="form-control description_adm" id="" name="description[]" readonly></td>
                                   <td class="text-center"><input type="number" class="form-control quantity_adm" id="" name="quantity[]" autocomplete="off" required></td>
                                   <td class="text-center"><input type="text" class="form-control uom_adm" id="" name="uom[]" readonly></td>
                                   <td class="text-center"><input type="text" class="form-control itemtype_adm" id="" name="item_type[]" readonly></td>
                                   <td class="text-center"><a class="btn btn-default btn-sm" onclick="btnPlusPBI_adm()"><i class="fa fa-plus"></i></a></td>
                                 </tr>
                               </tbody>
                             </table>
                           </div>
                           <div class="panel-body pbi_check_desc_2_adm">
                             <input type="hidden" name="type" value="2">
                             <button type="submit" style="float:right !important;font-weight:bold" class="btn btn-success" name="button"><i class="fa fa-file"></i> Save</button>
                           </div>
                         </div>
                       </div>
                     </div>
                   </form>
                 </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
