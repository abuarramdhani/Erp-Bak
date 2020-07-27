<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-pencil"></i> <b>Simulasi Kebutuhan Komponen</b></li>
        </ul>
        <form method="post" enctype="multipart/form-data">
        <div class="tab-content">
          <div class="row">
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <label> Masukkan File </label>
                </div>
                <div class="col-md-4 "></div>
                <div class="col-md-6 input-group">
                    <input type="file" class="form-control" name="file_simulasi" accept=".csv">    
                    <span class="input-group-btn">
                      <button class="btn btn-info btn-flat" id="submit_go" formaction="<?php echo base_url("InventoryManagement/SimulasiKebutuhan/searchdata")?>">Go!</button>
                    </span>
                    <div class="col-md-2">
                      <button class="btn btn-warning btn-flat" id="downloadcsv" formaction="<?php echo base_url("InventoryManagement/SimulasiKebutuhan/downloadtemplate")?>"><i class="fa fa-download"></i> Template</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </form>
        <br>
        <div id="loadingsimulasi">
        <div class="box box-info box-solid">
            <div class="box-header">Result file : <strong><?= $file?></strong></div>
          <div class="row">
              <div class="col-md-12">
                 <div class="panel-body">
                  <div class="col-md-12 resultsimulasi"  id="resultsimulasi"> </div>
                    <table class="table table-bordered table-hover text-center" style="width:100%">
                        <thead class="bg-primary">
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>QTY</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($data as $key => $val) {?>
                            <tr>
                                <td rowspan="2" class="data<?= $no?>"><?= $no?></td>
                                <td class="data<?= $no?>"><?= $val['header']['kode']?></td>
                                <td class="data<?= $no?>"><?= $val['header']['desc']?></td>
                                <td class="data<?= $no?>"><?= $val['header']['qty']?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="data<?= $no?>">
                                <div class="col-md-12 text-left"><button onclick="seeDetailIMO(this,'<?= $key ?>')" class="btn btn-xs btn-success">see detail >></button></div>
                                <br>
                                <div style="margin-top: 15px ; display: none; " id="detail<?= $key ?>" >
                                    <table class="table table-sm table-bordered table-hover table-striped table-responsive"  style="border: 2px solid #ddd">
                                        <thead class="bg-success">
                                            <tr class="text-center text-nowrap">
                                                <th>NO.</th>
                                                <th>Kode Komponen</th>
                                                <th>Nama Komponen</th>
                                                <th>Gudang Asal</th>
                                                <th>Locator</th>
                                                <th>Unit</th>
                                                <th>Jumlah Dibutuhkan</th>
                                                <th>ATT</th>
                                                <th>MO</th>
                                                <th>STOK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $num = 1; foreach ($val['body'] as $key => $value) { 
                                          $tanda = ($value['REQUIRED_QUANTITY'] > $value['ATT'] || $value['REQUIRED_QUANTITY'] > $value['KURANG']) ? "bg-danger " : "";
                                        ?>
                                        <script>
                                          <?php 
                                            if ($value['REQUIRED_QUANTITY'] > $value['ATT'] || $value['REQUIRED_QUANTITY'] > $value['KURANG']) { ?>
                                              $('.data'+<?= $no?>).addClass('bg-danger');
                                          <?php } ?>
                                        </script>
                                            <tr>
                                                <td class="<?= $tanda?>"><?= $num?></td>
                                                <td class="<?= $tanda?>"><?= $value['KOMPONEN']?></td>
                                                <td class="<?= $tanda?>"><?= $value['KOMP_DESC'] ?></td>
                                                <td class="<?= $tanda?>"><?= $value['GUDANG_ASAL'] ?></td>
                                                <td class="<?= $tanda?>"><?= $value['LOCATOR_ASAL'] ?></td>
                                                <td class="<?= $tanda?>"><?= $value['UOM_ASSY'] ?></td>
                                                <td class="<?= $tanda?>"><?= $value['REQUIRED_QUANTITY'] ?></td>
                                                <td class="<?= $tanda?>"><?= $value['ATT'] ?></td>
                                                <td class="<?= $tanda?>"><?= $value['MO']?></td>
                                                <td class="<?= $tanda?>"><?= $value['KURANG'] ?></td>
                                            </tr>
                                        <?php $num++; }?>
                                        </tbody>
                                    </table>
                                </div>
                                </td>
                            </tr>
                        <?php $no++; }?>
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
</section>