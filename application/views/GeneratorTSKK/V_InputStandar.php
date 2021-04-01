<style type="text/css">

#inputElemen {
    border-radius: 25px;
}

#save {
    border-radius: 25px;
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
                        <div class="col-lg-11">
                            <div class="text-center"><h1><b>STANDARDISASI ELEMEN KERJA</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br/>

                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                              <ul class="nav nav-tabs pull-right">
                              </ul>
                              <div class="tab-content">

                              <!--INPUT ELEMEN-->
                              <div id="input-elemen" class="tab-pane fade in active">
                              <form method="POST" class="form-horizontal" action="<?php echo base_url('GeneratorTSKK/C_GenTSKK/insertData') ?>">

                               <div class="box-body">
                               <div style="width: 100%">
                               <div class="row">
                                <!-- <div class="col-md-3" style="padding-left: 20px; text-align: right;">
                                </div> -->
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                  <div class="form-group">
                                    <input type="text" style="width:100%;" name="txtInputElemen" id=inputElemen class="form-control" placeholder="Input Elemen Kerja">
                                  </div>
                                </div>
                                <div class="col-md-1"></div>
                              </div>
                              <div class="row">
                                  <div id="btnSaveStandar">
                                    <center>
                                      <button class="btn btn-primary" type="submit" name="slcData" id="save" onclick="//tour(this)">SAVE</button>
                                      <!-- <button class="btn btn-primary" type="button" name="tour" id="tour" onclick="tour(this)">TOUR</button> -->
                                    </center>
                                  </div>
                              </div>
                            </div>
                            </div>
                            <br>
                            <div class="panel panel-default">
                            <div class="panel-heading text-right">
													  </div>
                            <div class="panel-body">
                              <table class="datatable table table-striped table-bordered table-hover tabel_elemen" style="width: 100%">
                                <thead class="bg-primary">
                                  <tr>
                                    <th width="5%" class="text-center">NO</th>
                                    <!-- <th class="text-center">ID</th>                                                                                                                                                                                       -->
                                    <th width="85%" class="text-center">ELEMEN KERJA</th>
                                    <th width="10%" class="text-center">DELETE</th>
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
                                // echo"<pre>";print_r($id);
                                      $elemen = $key['elemen_kerja'];
                                  ?>
                                    <tr class="nomor_".$no>
                                      <td style="width: 5%; text-align:center;"><?php echo $no; ?></td>
                                      <!-- <td> <input type="text" class="form-control idStandard" value="<?php echo $id ?>"></td> -->
                                      <td> <?php echo $elemen; ?></td>
                                      <td>
                                      <div style="text-align: center;">
                                      <!-- onclick="onClickDeleteStandard(this)" -->
                                        <a class="fa fa-times fa-2x" style="color:red" title="Hapus Elemen" href="<?php echo base_url('GeneratorTSKK/C_GenTSKK/deleteElemenKerja/'.$id)?>"></a>
                                      </div>
                                      </td>
																		<!-- <td><input type="text" class="form-control idStandard" value="<?php echo $id ?>"></td> -->


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
