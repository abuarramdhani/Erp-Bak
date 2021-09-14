<div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-left tb-setting_kalibrasi" style="font-size:14px;width:100%">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align:center;width:5%">No</th>
                                <th style="text-align:center;width:20%">No. Alat Ukur</th>
                                <th style="text-align:center;width:20%">Jenis Alat Ukur</th>
                                <th style="text-align:center;width:10%">Last Calibration</th>
                                <th style="text-align:center;width:10%">Next Calibration</th>
                                <th style="text-align:center;width:5%">Lead Time</th>
                                <th style="text-align:center;width:10%">Status</th>
                                <th style="text-align:center;width:10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($getKalibrasi as $key => $value): ?>
                            <?php 
                               $A = date('Y-m-d');
                               $B = $value['next_calibration'];
                               $C = $value['lead_time'];                                             
                                $giveBg = '';
                               if ($A == date('Y-m-d', strtotime($B))){ 
                                $giveBg= "background-color:yellow";
                               }elseif (date('Y-m-d', strtotime($B)) < $A && $A <= date('Y-m-d', strtotime('+'.$C.' day', strtotime($B)))) { 
                                $giveBg= "background-color:green";
                               }elseif ($A > date('Y-m-d', strtotime('+'.$C.' day', strtotime($B)))) {
                                $giveBg = "background-color:#e60a0acf"; 
                               }
                            ?>
                            <tr style="<?php echo $giveBg?>">
                                <td style="text-align:center"><?php echo $no?></td>
                                <td style="text-align:center">
                                <?php echo $value['no_alat_ukur'] ?>
                                </td>
                                <td style="text-align:center"><?php echo $value['jenis_alat_ukur'] ?></td> 
                                <td style="text-align:center"><?php echo $value['last_calibration'] ?></td>
                                <td style="text-align:center"><?php echo $value['next_calibration'] ?></td>
                                <td style="text-align:center"><?php echo $value['lead_time'] ?></td>
                                <td style="text-align:center"><?php echo $value['status'] ?></td>
                                <td style="text-align:center">
                                <a class="btn btn-primary" href="#" title="Update" data-toggle="modal" data-target="#updateKalibrasi" style="width:37px;margin-right:4px" onclick="updateKalibrasi('<?php echo $value['id']?>' ,'<?php echo $value['no_alat_ukur'] ?>', '<?php echo $value['jenis_alat_ukur'] ?>', '<?php echo $value['last_calibration'] ?>', '<?php echo $value['next_calibration'] ?>', '<?php echo $value['lead_time'] ?>', '<?php echo $value['status'] ?>')">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-danger" title="Delete" data-id="<?php echo $value['id']?>" onclick="deleteKalibrasi(<?php echo $value['id']?>)">
                                    <i class="fa fa-trash"></i>
                                </a>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                      </div>


<!--Modal Update-->             
<div class="modal fade" id="updateKalibrasi" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="borde-radius:12px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b><i class="fa fa-edit"></i> Update Kalibrasi</b></h4>
      </div>
      <div class="modal-body">        
            <table style="width:100%;margin-top:20px;margin-bottom:35px;font-size:14px">
            <tr>
                <td hidden><input type="text" name="upd_id" value=""></td>
                <td hidden><input type="text" id="no_alat_ukur_first" value=""></td>
                <td style="width:23%;padding-top:15px"><b>No.Alat Ukur</b></td>
                <td style="width:3%;padding-top:15px"><b>:</b></td>
                <td style="width:74%;padding-top:15px"><input type="text" id="upd_no_alat_ukur" class="form-control" required value=""></td>
            </tr>
            <tr>
                <td style="width:23%;padding-top:15px"><b>Jenis Alat Ukur</b></td>
                <td style="width:3%;padding-top:15px"><b>:</b></td>
                <td style="width:74%;padding-top:15px"><input type="text" id="upd_jenis_alat_ukur" class="form-control" value=""></td>
            </tr>
            <tr>
                <td style="width:23%;padding-top:15px"><b>Last Calibration</b></td>
                <td style="width:3%;padding-top:15px"><b>:</b></td>
                <td style="width:74%;padding-top:15px"><input type="date" id="upd_last_calibration" class="form-control" value=""></td>
            </tr>
            <tr>
                <td style="width:23%;padding-top:15px"><b>Next Calibration</b></td>
                <td style="width:3%;padding-top:15px"><b>:</b></td>
                <td style="width:74%;padding-top:15px"><input type="date" id="upd_next_calibration" class="form-control" value=""></td>
            </tr>
            <tr>
                <td style="width:23%;padding-top:15px"><b>Lead Time</b></td>
                <td style="width:3%;padding-top:15px"><b>:</b></td>
                <td style="width:74%;padding-top:15px"><input type="number" id="upd_lead_time" class="form-control" value=""></td>
            </tr>
            <tr>
                <td style="width:23%;padding-top:15px"><b>Status</b></td>
                <td style="width:3%;padding-top:15px"><b>:</b></td>
                <td style="width:74%;padding-top:15px">
                <select class="form-control select-2-status" name="upd_status">
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                </select>
                </td>
            </tr>
            </table>
        </div>
        <div class="modal-footer" style="margin-bottom:-15px">
          <button type="button" class="btn btn-success" onclick="kirimUpdate()" style="margin-left:-15px"><i class="fa fa-save"></i> Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
        </div>              
    </div>
  </div>
</div>



<script type="text/javascript" >
$('.tb-setting_kalibrasi').dataTable({});
// $('#updateKalibrasi').on('show.bs.modal', function(e) {
// var getIdKalibrasi = $(e.relatedTarget).data('id');
// $.ajax({
//  url: baseurl + 'SettingKalibrasi/Setting/getIdKalibrasi',
//  type: 'POST',
//  data: {
//    id: getIdKalibrasi,
//  },
//  cache: false,
//  beforeSend: function () {
//    $('.modal-updateKalibrasi').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
//                                <span style="font-size:15px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
//                            </div>`);
//  },
//  success: function(data) {
//    $('.modal-updateKalibrasi').html(data);
//  }
//  });
// });
</script>