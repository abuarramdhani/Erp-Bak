<section class="content">
  <div class="inner">
    <div class="row">
      <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="<?php echo site_url('MenjawabTemuanAudite/Handling/insert/'.$id); ?>" method="post">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-12">
                <div class="col-lg-11">
                  <div class="text-right">
                    <h2><b><?php echo $title ?></b></h2>
                  </div>
                </div>
                <div class="col-lg-1">
                  <div class="text-right hidden-md hidden-xs">
                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MenjawabTemuanAudite/Handling'); ?>">
                      <i class="icon-wrench icon-2x"></i><br>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-lg-12">
                <div class="box box-primary box-solid">
                  <div class="box-header with-border">
                    <h4 style="font-weight:bold"><i class="fa fa-edit fa-lg"></i> Menjawab Temuan</h4>
                  </div>
                  <div class="box-body" style="background:#f0f0f0 !important">
                    <div class="box-body" style="background:#ffffff !important;border-radius:7px;margin-bottom:10px">
                      <div class="row">
                        <h3 style="text-align:center"><b>MENJAWAB TEMUAN AUDITE</b></h3><hr>
                      </div>
                      <div class="panel-body" style="margin-top:0px">
                        <input type="hidden" name="id_audit" value="<?php echo $getAudit[0]['id']?>">
                        <input type="hidden" name="id_temuan" value="<?php echo $getAudit[0]['id_temuan'] ?>">
                        <div class="form-group">
                          <div class="col-lg-4">
                            <label>Tanggal Audite</label>
                            <input type="text" class="form-control" value="<?php echo $getAudit[0]['tanggal_audit'] ?>" readonly>
                          </div>
                          <div class="col-lg-8"></div>
                        </div>
                        <div class="form-group" hidden>
                          <div class="col-lg-4">
                            <label for="">Tanggal Verifikasi</label>
                            <input type="text" class="form-control tanggal-MTA" name="tanggal_verif" placeholder="Select Current Date">
                          </div>
                          <div class="col-lg-8"></div>
                        </div>
                      </div>
                      <div class="panel-body" style="margin-top:-25px">
                        <div class="form-group">
                          <div class="col-lg-7">
                            <label for="">Poin Penyimpangan</label>
                            <textarea style="width:100%;resize:none;padding:10px" id="poin-penyimpangan" name="poin_penyimpangan" rows="3" cols="80" readonly disabled><?php echo $getAudit[0]['poin_penyimpangan'] ?></textarea>
                          </div>
                          <div class="col-lg-5"></div>
                        </div>
                      </div>
                      <div class="panel-body" style="margin-top:-25px">
                        <div class="form-group" style="margin-bottom:-7px">
                          <div class="col-lg-12">
                              <label for="">Foto Before</label>
                          </div>
                        </div>
                        <!-- <?php
                          $foto_before = explode(", ", $getAudit[0]['foto_before']);
                          foreach ($foto_before as $key => $value): ?>
                        <div class="form-group">
                          <div class="col-lg-12">
                                <div class="imgWrap">
                                  <img src="http://192.168.18.137/api-audit-dev/assets/img/photo_before/<?php echo $value?>" style="width:20%" class="img-fluid img-thumbnail rounded" alt="<?php echo $value?>">
                                </div>
                                <small class="last_update_before">Last Update <?php echo $getAudit[0]['last_update_date_temuan'] ?> By <?php echo $getAudit[0]['last_update_by_temuan'] ?></small>
                              </div>
                        </div>
                        <?php endforeach; ?> -->
                      </div>
                      <div class="panel-body" style="margin-top:-25px">
                        <div class="form-group" style="border:1px solid black;padding-bottom:5px;margin-left:0px;margin-right:0px">
                          <label class="col-lg-12" style="background-color:#88cbf1"><span>Foto Before</span></label>
                          <div class="col-lg-12" style="overflow:auto;height:310px">
                            <?php //foreach ($getAudit as $key => $value): ?>
                              <?php $foto_before = explode(", ", $getAudit[0]['foto_before']);
                              foreach ($foto_before as $key => $value) {
                                echo '<img src="http://produksi.quick.com/api-audit/assets/img/photo_before/'.$value.'" class="img-fluid img-thumbnail" alt="'.$value.'" style="margin-top:7px;width:35%;border-radius:10px">
                                <span style="font-weight:bold;font-size:14px;margin-left:7px">Last Update '.$getAudit[0]['last_update_date_temuan'].' By '.$getAudit[0]['last_update_by_temuan'].'</span><br>';
                              }?>
                            <?php //endforeach; ?>
                          </div>
                        </div>
                      </div>
                      <div class="panel-body" style="margin-top:-25px">
                        <div class="form-group">
                          <div class="col-lg-12">
                            <label for="">Action Plan <span style="color:red">*</span></label>
                            <textarea style="width:100%;resize:none;padding:10px;" name="action_plan" rows="3" cols="180" required><?php //echo $getAudit[0]['action_plan'] ?></textarea>
                            <!-- <small>Last Update <?php echo $getAudit[0]['last_update_date_jawaban'] ?> By <?php echo $getAudit[0]['last_update_by_jawaban']?></small> -->
                          </div>
                        </div>
                      </div>
                      <?php if (!empty($getAuditY)): ?>
                      <div class="panel-body" style="margin-top:-40px">
                        <div class="form-group" style="border:1px solid black;padding-bottom:5px;margin-left:0px;margin-right:0px">
                            <label class="col-lg-12" style="background-color:#88cbf1">Action Plan Log</label>
                            <div class="col-lg-12" style="overflow:auto;height:65px">
                                <?php foreach ($getAuditY as $key => $valueY) {
                                  echo '<em>[ '.$valueY['last_update_date_jawaban'].' ] - ( '.$valueY['last_update_by_jawaban'].' ) -  '.$valueY['action_plan'].'</em><br>';
                                 } ?>
                            </div>
                        </div>
                      </div>
                      <?php endif; ?>
                      <!-- Title Foto After -->
                      <div class="row" style="margin-left:15px;margin-top:-7px">
                        <div class="form-group">
                          <div class="col-lg-6">
                            <label>Foto After <span style="color:red">*</span></label>
                          </div>
                          <div class="col-lg-6"></div>
                          <?php if (!empty($getAuditY)): ?>
                            <?php echo '<div class="panel-body" style="margin-bottom:-10px;margin-right:30px">
                            <div class="alert alert-info alert-dismissible fade in col-lg-12" style="margin-bottom:0px;margin-top:-2px" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close" name="button">
                                <span aria-hidden="true">
                                  <i class="fa fa-close"></i>
                                </span>
                              </button>
                              <p><span style="color:red">*</span><strong>Info :</strong> Gambar dibawah adalah preview gambar yang diinsert sebelumnya, harap masukkan gambar baru setiap insert data.</p>
                            </div>
                            </div>' ?>
                          <?php endif; ?>
                        </div>
                      </div>
                          <!-- <?php
                            /*$foto_after = explode(", ", $getAudit[0]['foto_after']);
                            foreach ($foto_after as $key => $value): ?>
                            <?php if ($value != NULL): ?>
                          <?php echo '<div class="panel-body" style="margin-top:-25px">
                          <div class="form-group">
                            <div class="col-lg-12">
                              <div class="imgWrap">
                                <img src="'.base_url('assets/upload/MenjawabTemuanAudite/Handling/'.$value).'" class="img-fluid img-thumbnail rounded" alt="'.$value.'" style="margin-top:7px;width:20%">
                              </div>
                              <small class="last_update_after">Last Update '.$getAudit[0]['last_update_date_jawaban'].' By '.$getAudit[0]['last_update_by_jawaban'].'</small>
                            </div>
                          </div>
                          </div>' ?>
                          <?php endif; ?>
                          <?php endforeach;*/ ?> -->
                          <?php if (!empty($getAuditY)): ?>
                          <div class="panel-body" style="margin-top:-25px">
                            <div class="form-group" style="border:1px solid black;padding-bottom:5px;margin-left:0px;margin-right:0px">
                              <label class="col-lg-12" style="background-color:#88cbf1"><span>Foto After Log</span></label>
                              <div class="col-lg-12" style="overflow:auto;height:300px">
                                  <?php foreach ($getAuditY as $key => $value): ?>
                                    <?php $foto_after = explode(", ", $value['foto_after']) ?>
                                    <?php foreach ($foto_after as $key => $value2) {
                                      echo '<img src="'.base_url('assets/upload/MenjawabTemuanAudite/Handling/'.$value2).'" class="img-fluid img-thumbnail" alt="'.$value2.'" style="margin-top:7px;width:35%;border-radius:10px">
                                      <span style="font-weight:bold;font-size:14px;margin-left:7px">Last Update '.$value['last_update_date_jawaban'].' By '.$value['last_update_by_jawaban'].'</span><br>';
                                    } ?>
                                  <?php endforeach; ?>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                      <!-- Tempat untuk input gambar-->
                      <div class="panel-body" style="margin-top:-25px" id="container-handling-mta">
                          <div class="form-group">
                            <div class="col-lg-6">
                              <input style="margin-left:0px;width:100%" type="file" onchange="getGambarb(this)" required class="form-control inp1" accept=".jpeg,.png,.jpg" name="foto_after[]" >
                            </div>
                              <button type="button" class="btn btn-danger delAfter" style="display:none"><i class="fa fa-times"></i></button>
                            <div class="col-lg-12">
                              <div class="imgWrap">
                                <img src="" id="base-preview" name="prev-handling" class="img-fluid" style="margin-top:7px;margin-bottom:-5px;border-radius:10px">
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="panel-body" style="margin-top:-25px">
                      <div class="form-group">
                        <div class="col-lg-12">
                          <button type="button" class="btn btn-info addAfter" style="margin-left:0px"> <i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                      </div>
                      <?php if (!empty($getAuditAlasan)): ?>
                        <?php if ($getAuditAlasan[0]['alasan_masih_open'] != NULL): ?>
                      <div class="panel-body" style="margin-top:-25px">
                        <div class="form-group" style="border:1px solid black;padding-bottom:5px;margin-left:0px;margin-right:0px">
                          <label class="col-lg-12" style="background-color:#88cbf1">Alasan Verif Masih Open</label>
                          <div class="col-lg-12" style="overflow:auto;height:65px">
                              <?php //echo '<em>[ '.$getAudit[0]['last_update_date_temuan'].' ] - ( '.$getAudit[0]['last_update_by_temuan'].' ) -  '.$getAudit[0]['alasan_masih_open'].'</em><br>'?>
                              <?php foreach ($getAuditAlasan as $key => $value): ?>
                                <?php echo '<em>[ '.$value['last_update_date_temuan'].' ] - ( '.$value['last_update_by_temuan'].' ) -  '.$value['alasan_masih_open'].'</em><br>'?>
                              <?php endforeach; ?>
                              <?php //else: ?>
                                <?php //echo "-" ?>
                            <!-- <textarea style="width:100%;resize:none;padding:10px" name="alasan_masih_open" rows="6" cols="180" readonly disabled><?php //echo $getAudit[0]['alasan_masih_open'] ?></textarea> -->
                          </div>
                        </div>
                      </div>
                      <?php endif; ?>
                      <?php endif; ?>
                    <div class="box-footer text-right">
                      <button type="submit" class="btn btn-success btn-lg sv-handling"><i class="fa fa-save"></i> Save</button>
                      <a href="<?php echo base_url('MenjawabTemuanAudite/Handling') ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
