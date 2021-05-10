<input type="hidden" id="punyaeSP" value="1">
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('KapasitasGdSparepart/Pelayanan/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item active" style="background:#e7e7e7">
                                  <a class="nav-link" onclick="normal()" id="pills-normal-tab" data-toggle="pill" href="#pills-normal" role="tab" aria-controls="pills-home" aria-selected="true">
                                    NORMAL 
                                    <span id="lblNormal" class="label label-danger" style="margin-left: 5px; vertical-align: top;"></span>
                                  </a>
                                </li>
                                <li class="nav-item" style="background:#e7e7e7">
                                  <a class="nav-link" onclick="urgent()" id="pills-urgent-tab" data-toggle="pill" href="#pills-urgent" role="tab" aria-controls="pills-profile" aria-selected="false">
                                    URGENT 
                                    <span id="lblUrgent" class="label label-danger" style="margin-left: 5px; vertical-align: top;"></span>
                                  </a>
                                </li>
                                <li class="nav-item" style="background:#e7e7e7">
                                  <a class="nav-link" onclick="eceran()" id="pills-eceran-tab" data-toggle="pill" href="#pills-eceran" role="tab" aria-controls="pills-home" aria-selected="true">
                                    ECERAN 
                                    <span id="lblEceran" class="label label-danger" style="margin-left: 5px; vertical-align: top;"></span>
                                  </a>
                                </li>
                                <li class="nav-item" style="background:#e7e7e7">
                                  <a class="nav-link" onclick="best()" id="pills-best-tab" data-toggle="pill" href="#pills-best" role="tab" aria-controls="pills-home" aria-selected="true">
                                    BEST AGRO 
                                    <span id="lblBest" class="label label-danger" style="margin-left: 5px; vertical-align: top;"></span>
                                  </a>
                                </li>
                                <li class="nav-item" style="background:#e7e7e7">
                                  <a class="nav-link" onclick="ecom()" id="pills-ecom-tab" data-toggle="pill" href="#pills-ecom" role="tab" aria-controls="pills-home" aria-selected="true">
                                    E-COMMERCE 
                                    <span id="lblEcom" class="label label-danger" style="margin-left: 5px; vertical-align: top;"></span>
                                  </a>
                                </li>
                                <li class="nav-item" style="background:#e7e7e7">
                                  <a class="nav-link" onclick="cetak()" id="pills-cetak-tab" data-toggle="pill" href="#pills-cetak" role="tab" aria-controls="pills-home" aria-selected="true">CETAK PACKING LIST</a>
                                </li>
                                <!-- <li>
                                  <h5 style="margin-top:15px;font-weight:bold;margin-left:10px;"> Sub Inventory : <?php echo $this->session->datasubinven ?></h5>
                                </li> -->
                              </ul>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <!-- <center><label>DAFTAR KERJAAN BELUM RAMPUNG</label></center> -->
                                <input type="hidden" name="tipe" id="tipe">
                                <div class="tab-content" id="pills-tabContent" >
                                    <div class="tab-pane fade in active" id="pills-normal" role="tabpanel" aria-labelledby="pills-home-tab">
                                      <div id="loadingArea1" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                      </div>
                                      <div class="table_area_1">

                                      </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-urgent" role="tabpanel" aria-labelledby="pills-profile-tab">
                                      <div id="loadingArea2" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                      </div>
                                      <div class="table_area_2">

                                      </div>
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" id="pills-eceran" >
                                      <div id="loadingArea3" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                      </div>
                                      <div class="table_area_3">

                                      </div>
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" id="pills-best" >
                                      <div id="loadingArea4" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                      </div>
                                      <div class="table_area_4">

                                      </div>
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" id="pills-ecom" >
                                      <div id="loadingArea6" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                      </div>
                                      <div class="table_area_6">

                                      </div>
                                    </div>
                                    <div class="tab-pane fade" role="tabpanel" id="pills-cetak" >
                                      <div id="loadingArea5" style="display:none;">
                                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                      </div>
                                      <div class="table_area_5">

                                      </div>
                                    </div>
                                </div>

                                <!-- TABEL SELESAI -->
                                <br>
                                <br>

                                <!-- <center><label>KERJAAN YANG SUDAH DILAYANI HARI INI</label></center> -->
                                <div id="loadingArea5" style="display: none;">
                                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div class="table_area_selesai">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="mdlfinishplyn" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="padding-top: 200px; width: 40%">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body">
            <h3 class="modal-title" style="text-align:center;"><b>Masukan PIC Finish</b></h3>
            <select id="picfinish" name="picfinish" class="form-control select2" style="width:100%;">
                <option></option>
            </select>
            <br>
            <br>
                <center><button class="btn btn-danger" onclick="savefinish()">FINISH</button></center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalDetailDOSP" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
  <div class="modal-dialog" role="document" style="width: 70%">
    <div class="modal-content">
      <div class="modal-header">
        <b>
          <span style="font-size: large;">DETAIL  </span>
          <span style="font-size: large;" id="nospbdetail"></span>
        </b>
      </div>
      <div class="modal-body">
          <div id="loadingAreaDetail" style="display: none;">
              <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
          </div>
          <div class="table_detail">
              
          </div>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        $('.tblpelayanan').dataTable({
            "scrollX": true,
            scrollY: 500,
            ordering: false,
            paging:false,
        });

        $('.tblpelayanan2').dataTable({
            "scrollX": true,
            ordering: false
        });
    });
</script>