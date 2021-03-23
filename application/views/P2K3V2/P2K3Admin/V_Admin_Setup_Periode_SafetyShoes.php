<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b>Setup Periode Safety Shoes</b></h1>
          </div>
        </div>
        <div class="col-lg-1">
          <div class="text-right hidden-md hidden-sm hidden-xs">

          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11"></div>
            <div class="col-lg-1 "></div>
          </div>
        </div>
        <br />
        <div class="">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="table-responsive" style="overflow:hidden;">
                  <table class="table table-striped table-bordered table-hover et_jenis_penilaian" style="font-size : 14px; ">
                    <thead class=" bg-primary">
                      <tr>
                        <th width="5%">NO</th>
                        <th width="10">Kodesie</th>
                        <th width="25%">Seksi</th>
                        <th width="20%">Unit</th>
                        <th width="20%">Departemen</th>
                        <th width="10%">Periode Safety Shoes</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($periode as $key => $val) :
                        ?>
                        <tr>
                          <td><?= $key + 1 ?></td>
                          <td class="ess_kodesie"><?= substr($val['section_code'], 0, 7); ?></td>
                          <td class="ess_seksi"><?= $val['section_name']; ?></td>
                          <td><?= $val['unit_name']; ?></td>
                          <td><?= $val['department_name']; ?></td>
                          <td class="ess_periode"><?= $val['periode']; ?></td>
                          <td align="center">
                            <button type="button" class="btn btn-info btn-sm btn_editPeriodeSafetyShoes">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>

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
<div class="modal fade" id="editSafetyShoes_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="<?php echo base_url('p2k3adm_V2/Admin/EditPeriodeSafetyShoes'); ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Edit Periode Safety Shoes</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label class="control-label">Kodesie</label>
          <input class="form-control" id="editSafetyShoes_Kodesie" disabled="">
          <input hidden="" id="editSafetyShoes_Kodesie2" name="kodesie">
          <br>
          <label class="control-label">Seksi</label>
          <input class="form-control" id="editSafetyShoes_Seksi" disabled="">
          <br>
          <label class="control-label">Periode (bulan)</label>
          <input required="" type="number" class="form-control" id="editSafetyShoes_Periode" name="periode">
          <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>