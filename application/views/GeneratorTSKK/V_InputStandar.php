<style type="text/css">
  .modal {
    text-align: center;
    padding: 0 !important;
  }

  .modal:before {
    content: '';
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    margin-right: -4px;
    /* Adjusts for spacing */
  }

  .modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
  }

  body {
    padding-right: 0px !important;
  }

  input[type="text"]::placeholder {
    /* Firefox, Chrome, Opera */
    text-align: center;
  }
</style>

<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                      <div class="text-center"><h1><b>STANDARDISASI ELEMEN KERJA</b></h1></div>
                    </div>
                </div>
                <br/>

                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary color-palette-box">
                            <div class="box-body">
                              <ul class="nav nav-tabs pull-right">
                              </ul>
                              <div class="tab-content">

                              <!--INPUT ELEMEN-->
                              <div id="input-elemen" class="tab-pane fade in active">
                              <form method="POST" class="form-horizontal" action="<?php echo base_url('GeneratorTSKK/C_GenTSKK/insertData') ?>">
                               <div class="row">
                                <div class="col-md-7">
                                  <label for="">Elemen Kerja</label>
                                  <input type="text" name="txtInputElemen" id=inputElemen class="form-control" autocomplete="off" required placeholder="Input Elemen Kerja">
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label for="">Jenis Proses</label>
                                    <select class="select2" name="txtJenis" style="width:100%" required autocomplete="off">
                                      <option value=""></option>
                                      <option value="MANUAL">MANUAL</option>
                                      <option value="AUTO">AUTO</option>
                                      <option value="WALK">WALK</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div id="btnSaveStandar">
                                      <button class="btn btn-primary" type="submit" name="slcData" id="save" onclick="//tour(this)" style="width:100%;margin-top:24px"> <i class="fa fa-save"></i> SAVE</button>
                                      <!-- <button class="btn btn-primary" type="button" name="tour" id="tour" onclick="tour(this)">TOUR</button> -->
                                  </div>
                                </div>
                              </div>
                              </form>
                            <br>
                            <div class="row">
                              <div class="col-md-12">
                                  <table class="datatable table table-striped table-bordered table-hover tabel_elemen" style="width: 100%">
                                    <thead class="bg-primary">
                                      <tr>
                                        <th width="5%" class="text-center">NO</th>
                                        <!-- <th class="text-center">ID</th>                                                                                                                                                                                       -->
                                        <th width="65%" class="text-center">ELEMEN KERJA</th>
                                        <th width="20%" class="text-center">JENIS</th>
                                        <th width="10%" class="text-center">ACTION</th>
                                        <!-- <th style="display:none">ID</th> -->
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php $no = 1; ?>
                                    <?php
                                      if (empty($lihat_elemen)) {
                                      }else{
                                        $no=1;
                                        foreach ($lihat_elemen as $key) {
                                          $id = $key['id'];
                                          $elemen = $key['elemen_kerja'];
                                      ?>
                                        <tr class="nomor_".$no>
                                          <td style="width: 5%; text-align:center;"><?php echo $no; ?></td>
                                          <td> <?php echo $elemen; ?></td>
                                          <td> <?php echo $key['jenis'] ?> </td>
                                          <td>
                                          <div style="text-align: center;">
                                          <!-- onclick="onClickDeleteStandard(this)" -->
                                            <a class="btn btn-sm btn-danger"title="Hapus Elemen" style="border-radius:7px;" href="<?php echo base_url('GeneratorTSKK/C_GenTSKK/deleteElemenKerja/'.$id)?>"> <i class="fa fa-trash"></i> </a>
                                            <button type="button" data-toggle="modal" data-target="#modalgtskk_u2" class="btn btn-sm btn-success" style="border-radius:7px;" onclick="ambildataelemenby('<?php echo $id ?>', '<?php echo $elemen ?>', '<?php echo $key['jenis'] ?>')" name="button">
                                             <i class="fa fa-pencil"></i>
                                            </button>
                                          </div>
                                          </td>
                                        </tr>
                                        <?php
                                        $no++;
                                      }
                                    }
                                      ?>
                                    </tbody>
                                  </table>

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
</section>


<!-- update -->
<div class="modal fade bd-example-modal-lg" id="modalgtskk_u2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;"> <i class="fa fa-cube"></i> Update Elemen Kerja</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <form class="" action="<?php echo base_url('GeneratorTSKK/C_GenTSKK/updateDataElemen') ?>" method="post">
                    <div class="row p-3">
                      <div class="col-md-8">
                        <div class="form-data">
                          <input type="hidden" id="id_elemen_kerja" name="id" value="">
                          <label for="" style="margin-top:10px;">Nama Elemen Kerja</label>
                          <input type="text" class="form-control" id="gtskk_upd_nama" name="elemen_kerja" value="" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-data">
                          <label for="" style="margin-top:10px;">Jenis</label>
                          <select class="select2" id="gtskk_upd_jenis" name="jenis" style="width:100%">
                            <option value=""></option>
                            <option value="MANUAL">MANUAL</option>
                            <option value="AUTO">AUTO</option>
                            <option value="WALK">WALK</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                      <br>
                      <center>
                        <button type="submit" class="btn btn-success mt-2" style="width:30%" name="button"> <i class="fa fa-pencil"></i> <b>Update</b> </button>
                      </center>
                      <br>
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
