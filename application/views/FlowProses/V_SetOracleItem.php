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
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <input type="hidden" id="cek_flow_ald" value="1">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <ul class="list-inline">
            <li>
              <h4 style="margin: 5px 0 0 0;font-weight:bold;">Setting Oracle Item</h4>
            </li>
          </ul>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin:15px 0 15px 0;">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-data">
                            <label for="" style="margin-top:10px;">Organization</label>
                            <select class="form-control select2FP_ORG" style="width:100%" required>
                              <!-- <option value="102" selected>ODM</option> -->
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12" onclick="cek_org()">
                          <div class="form-data">
                            <label for="" style="margin-top:10px;">Component Code</label>
                            <select class="form-control select2FP_Oracle" style="width:100%" required></select>
                          </div>
                        </div>
                      <div class="col-md-12">
                        <br>
                        <center>
                          <button type="button" class="btn btn-success" onclick="save_oracle_item()" style="width:30%;margin-bottom:10px" name="button"> <i class="fa fa-file"></i> <b>Save</b> </button>
                        </center>
                        <br>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <b>*NB :</b> Form Input Code Componen dapat dicari berdasarkan code component atau description item.
                  </div>
                  <div class="col-md-2"></div>
                </div>
              </div>
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin:15px 0 15px 0;">
                <div class="row">
                  <div class="col-md-12">
                    <div id="table-fp-area-oracle-item">

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
</div>
