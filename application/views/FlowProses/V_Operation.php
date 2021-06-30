<style media="screen">
.modal {
text-align: center;
padding: 0!important;
overflow-y: auto !important;
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
body{
  padding-right: 0px!important;
}
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <ul class="list-inline">
            <li>
              <input type="hidden" id="fpsimpanidsementara">
              <input type="hidden" id="fp_tipe_search">
              <input type="hidden" id="fpsimpanidsementara_desc">
              <button type="button" class="btn btn-success fpselectproduct" onclick="fpselectproduct()" style="font-weight:bold;border-radius:7px;margin-top:5px;" name="button"><i class="fa fa-cog"></i> Operation </button>
              <button type="button" class="btn btn-success fpselectcomponent" onclick="fpselectcomponent()" style="font-weight:bold;border-radius:7px;margin-top:5px;display:none" name="button"> <i class="fa fa-chevron-right"></i> Component (<span id="type_produk"></span>)</a></button>
              <button type="button" class="btn btn-success fpselectproses" onclick="fpselectproses()" style="font-weight:bold;border-radius:7px;margin-top:5px;display:none" name="button"> <i class="fa fa-chevron-right"></i> Operation <span id="code_product"></span> (<span id="fp_jenis_produk_ok"></span>)</a></button>

              <button type="button" class="btn btn-danger fpselectcheckoperation" onclick="fpselectcheckoperation()" style="font-weight:bold;border-radius:7px;margin-top:5px;display:none" name="button"> <i class="fa fa-chevron-right"></i> Check Operation (<span id="type_produk_check_operation"></span>)</a></button>
              <button type="button" class="btn btn-danger fpselectprosescheckoperation" onclick="fpselectproses()" style="font-weight:bold;border-radius:7px;margin-top:5px;display:none" name="button"> <i class="fa fa-chevron-right"></i> Operation (<span id="code_product_check_operation"></span>)</a></button>
            </li>
            <li style="float:right;margin-top:5px;">
              <button type="button" style="border-radius:7px;font-weight:bold;" class="btn btn-success btn_fp_operation" onclick="fp_set_pro()" disabled name="button"> <i class="fa fa-cogs"></i> View Operation </button>
            </li>
          </ul>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin:15px 0 15px 0;">
                  <div class="row">
                  <div class="fp_search_area">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div style="padding-top:100px;padding-bottom:100px;">
                        <div class="fp_work_space">
                        <label for="">Choose Product</label>
                        <br>
                        <select class="select2FP200121" id="fp_selected_product" style="width:100%">
                          <option value="">Choose Product...</option>
                          <?php foreach ($product as $key => $p): ?>
                            <option value="<?php echo $p['product_id'] ?>"><?php echo $p['product_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                        <!-- <div style="margin-top:15px;">
                          <label for="">Choose Product Status</label>
                          <br>
                          <input type="radio" value="product" id="fp_status1" name="slcDrawingStatus">
                     			<span for="status1" class="label-radio" >Mass Production</span>
                     		  <input style="margin-left:10px" type="radio" value="prototype" id="fp_status2" name="slcDrawingStatus">
                     			<span for="status2" class="label-radio" >Prototype</span>
                        </div> -->
                        <div style="margin-top:15px;">
                          <center><button type="button" class="btn btn-primary" onclick="fp_search()" style="width:79.4%;font-weight:bold" name="button"> <i class="fa fa-search"></i> Search</button>
                          <!-- <a type="button" class="btn btn-danger" onclick="fp_check_operation()" style="width:28%;font-weight:bold" name="button"> <i class="fa fa-cube"></i> Check Operation</a> -->
                          <a onclick="report()" type="button" class="btn btn-success" style="width:20%;font-weight:bold" name="button"> <i class="fa fa-file-excel-o"></i> Report</a></center>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3"></div>
                  </div>
                  <div class="col-md-12">
                    <div class="fp-table-area">

                    </div>
                    <br>
                    <!-- <button type="button" class="btn btn-success" name="button"> <i class="fa fa-cog"></i> Operation </button> -->
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

<div class="modal fade bd-example-modal-lg" id="modalfp1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="row">
    <div class="col-md-12" style="padding:0;z-index:99">
      <div class="fp_area_gambar_kerja_3">

      </div>
    </div>
    <div class="col-md-12 fp_set_height" style="padding:0;top:0">
      <div class="modal-dialog modal-lg" role="document" style="margin-top:-15px">
    		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12" style="padding:0">
                <div class="box box-primary box-solid">
                  <div class="box-header with-border">
                    <div style="float:left;margin-top:6px;">
                      <h4 style="font-weight:bold;display:inline;"> <i class="fa fa-briefcase"></i> <span id="fp_judul_form_proses">Add Operation</span> (<span id="code_comp_sem"></span>)</h4>
                    </div>
                    <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
                  </div>
                  <div class="box-body fp0012">
                    <form class="" action="" id="reset_fp" method="post">

                    <div class="row">
                      <div class="col-md-12">
                        <h6> <b>NB :</b> <br>
                          <ul style="margin-top: 5px;margin-left: -23px;">
                            <li>Jika anda menutup modal form inputan ini, data yang anda isi akan ter-reset.</li>
                            <li><b>Form Input Resource</b> akan bekerja jika <b>machine_req</b> dan <b>destination</b> telah diisi.</li>
                            <li><b>Form Input Mechine Num</b> akan terisi manual jika resource telah terisi, dan ada kemungkinan juga jika data kosong/tidak ada</li>
                          </ul>
                        </h6>
                        <input type="hidden" id="id_pd" value="">
                        <label for="" style="margin-top:10px;">Component</label>
                        <input required type="text" id="component_code" readonly value="" class="form-control" placeholder="Operation Code">
                      </div>
                      <div class="col-md-6">
                        <label for="" style="margin-top:10px;">Operation Process</label>
                        <select required class="form-control select2" style="width:100%;" id="operation_proses">
                          <option value="">Select...</option>
                          <?php foreach ($proses as $key => $value): ?>
                            <option value="<?php echo $value['id'] ?>"><?php echo $value['operation_std'] ?> - <?php echo $value['operation_desc'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="" style="margin-top:10px;">Detail Proses</label>
                        <input type="hidden" id="fp_id_proses" value="">
                        <input required type="text" id="detail_proses" value="" class="form-control" placeholder="Detail Proses">
                      </div>
                      <div class="col-md-6">
                        <label for="" style="margin-top:10px;">Operation Code</label>
                        <input required type="text" id="opetation_code" value="" class="form-control" placeholder="Operation Code">
                      </div>
                    <div class="col-md-6">
                      <label for="" style="margin-top:10px;">Operation Description</label>
                      <input required type="text" id="opetaion_desc" value="" class="form-control" placeholder="Operation Description">
                    </div>
                    <div class="col-md-12" id="fp_1">
                      <label for="" style="margin-top:10px;">Jenis Proses</label>
                      <select required class="form-control select2" style="width:100%;" id="jenis_proses">
                        <option value="">Select...</option>
                        <option value="ALT">ALT</option>
                        <option value="ECR">ECR</option>
                        <option value="PCR">PCR</option>
                        <option value="STD">STD</option>
                      </select>
                    </div>
                    <div class="col-md-6 fp_2" style="display:none">
                      <label for="" style="margin-top:10px;">Nomor Jenis Proses (<span id="fp_njpnya"></span>)</label>
                      <input type="text" id="nomor_jenis_proses" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label for="" style="margin-top:10px;">INV-Flag</label>
                      <select required class="form-control select2" style="width:100%;" id="flag">
                        <option value="">Select...</option>
                        <option value="Y">Y</option>
                        <option value="N">N</option>
                      </select>
                      <label for="" style="margin-top:10px;">Machine Req</label>
                      <select required class="form-control select2_fp_machine_req" onchange="fp_cek_destinasi()" style="width:100%;" id="machine_req">
                        <option value="" selected>Select...</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="" style="margin-top:10px;">Make Buy</label>
                      <select required class="form-control select2" style="width:100%;" id="make_buy">
                        <option value="">Select...</option>
                        <option value="MAKE">MAKE</option>
                        <option value="BUY">BUY</option>
                      </select>
                      <label for="" style="margin-top:10px;">Resource</label>
                      <input type="hidden" id="fp_tampung_resource_sementara" value="">
                      <div class="resource_loading_area">

                      </div>
                      <div id="foresource" onclick="fp_cek_resource()">
                        <select required class="form-control select2" style="width:100%;" id="resource" onchange="fp_isi_machine_num()">
                          <!-- <option value="">Select...</option> -->
                        </select>
                      </div>
                      <!-- <select required class="form-control fp_proses_resource" name="" id="resource" style="width:100%;"></select> -->
                    </div>

                    <div class="col-md-6">
                    <label for="" style="margin-top:10px;">Destination</label>
                     <div class="destination_loading_area">

                     </div>
                     <div id="fp_destinasi_view">
                       <select required class="form-control select2FP1" onchange="fp_cek_destinasi()" name="" id="destination" style="width:100%;">
                       </select>
                     </div>
                    </div>
                    <div class="col-md-6">
                      <label for="" style="margin-top:10px;">Machine Num</label>
                      <input required type="text" id="machine_num" value="" class="form-control" placeholder="Machine Num">
                      <!-- <select class=" form-control select2FP21" id="machine_num" style="width:100%;"></select> -->
                    </div>
                    <div class="col-md-12">
                     <label for="" style="margin-top:10px;">Qty Machine</label>
                     <input required type="number" id="qty_machine" value="" class="form-control" placeholder="Qty Machine">
                    </div>

                    <div class="col-md-6">
                      <label for="" style="margin-top:10px;">Tool</label><br>
                      <select required class="form-control select2FP1 fp_check_tool" name="" id="tool" style="width:100%;">
                        <option value="">Select...</option>
                        <option value="1">New</option>
                        <option value="2">Exiting</option>
                        <option value="3">Modif</option>
                      </select>
                      <div class="fp_ilang" style="display:none;margin-top:10px;">
                        <label for="">Select Tool Exiting</label>
                        <select required class="form-control select2 select2FP_Tool" name="" id="tool_exiting" style="width:100%;"></select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="" style="margin-top:10px;">Inspectool</label><br>
                      <select required class="form-control select2FP1 fp_check_inspectool" style="width:100%;" id="inspectool">
                        <option value="">Select...</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                      </select>
                      <div class="fp_ilang_2" style="display:none;margin-top:10px;">
                        <label for="">Select Measurement Tool:</label>
                        <select required class="form-control select2 select2FP_Tool_2" name="" id="tool_measurement" style="width:100%;">
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12 fp_cek_hidden_untuk_update">
                      <!-- <div class="form-group"> -->
                        <label for="" style="margin-top:10px;">Bahan Penolong</label>
                        <table class="table table-bordered fp_tbl_penolong">
                          <thead style="font-weight:bold">
                            <tr>
                              <td style="text-align:center;vertical-align:middle;width:5%">No</td>
                              <td style="width:70%;vertical-align:middle">
                                Component Code
                              </td>
                              <td style="width:15%;vertical-align:middle">
                                Quantity
                              </td>
                              <td style="width:25%;vertical-align:middle">
                                UOM
                              </td>
                              <td style="vertical-align:middle">
                                <center><button type="button" name="button" class="btn btn-sm" onclick="fp_bp_plus_proses()"><i class="fa fa-plus-square"></i></button></center>
                              </td>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <br>
                      <center>
                        <button type="button" class="btn btn-success fp_save_operation" style="width:30%;margin-bottom:10px;" onclick="saveOperation_fp()" name="button"> <i class="fa fa-file"></i> <b id="fp_tempat_save_operation">Save</b> </button>
                      </center>
                    </div>
                  </div>

                </form>

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

<div class="modal fade bd-example-modal-lg" id="modalfpItem" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;">Setting Oracle Item (<span id="code_comp_item_orecle"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                    <div class="row">
                        <!-- <div class="col-md-12">
                          <div class="form-data">
                            <label for="" style="margin-top:10px;">Organization</label>
                            <select class="form-control select2FP_ORG" style="width:100%" required>

                            </select>
                          </div>
                        </div> -->
                        <div class="col-md-12" onclick="cek_org()">
                          <div class="form-data">
                            <label for="" style="margin-top:10px;">Component Code</label>
                            <select class="form-control select2FP_Oracle" style="width:100%" required></select>
                          </div>
                        </div>
                      <div class="col-md-12">
                        <br>
                        <center>
                          <input type="hidden" id="hdnFPIdProductComponent">
                          <button type="button" class="btn btn-success" onclick="save_oracle_item()" style="width:30%;margin-bottom:10px" name="button"> <i class="fa fa-file"></i> <b>Save</b> </button>
                        </center>
                        <br>
                        <b>*NB :</b> Form Input Code Componen dapat dicari berdasarkan code component atau description item.
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </div>
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg"  id="modalfpgambar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:90%" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;">Gambar Kerja (<span id="fp_code_component"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="area-gambar-kerja">

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
