<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Temuan-Audit-Handling-<?php echo $handlingPdf[0]['area'] ?>-<?php echo date('dmYHis') ?></title>
  </head>
  <body>
    <div style="width:100%">
      <div style="width:100%;float:left;margin-right:23.5px">
        <table style="border-collapse:collapse;width:100%;page-break-inside:avoid">
          <tr>
            <td colspan="8" style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;border-bottom:1px solid black;padding:5px;font-weight:bold;text-align:center;font-size:18px">TEMUAN AUDIT HANDLING TUKSONO</td>
          </tr>
          <tr>
            <td colspan="2" style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:left;font-size:12px">TANGGAL : <?php echo $handlingPdf[0]['tanggal_audit'] ?></td>
            <td colspan="3" style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:left;font-size:12px">TIM : <?php echo strtoupper($handlingPdf[0]['tim']) ?></td>
            <td colspan="3" style="width:100%;border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:left;font-size:12px">AREA : <?php echo $handlingPdf[0]['area'] ?></td>
          </tr>
          <tr>
            <td colspan="8" style="border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:14px">SARANA HANDLING</td>
          </tr>
          <tr>
            <td colspan="1" style="border-left:1px solid black; padding:5px;padding-left:30px">
              <?php foreach ($getSaranaHandling as $key => $value): ?>
              <?php if (($key+1) % 4 == 1) {
                echo ($key+1) > 4 ? '<br>' : '' ;
                echo $handlingPdf[0]['sarana_handling'] == $getSaranaHandling[$key]['sarana'] ? '<span style="font-size:13px">&#9745; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>' : '<span style="font-size:13px">&#9744; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>';
              } ?>
              <?php endforeach; ?>
            </td>
            <td colspan="3" style="padding:5px;padding-right:35px">
              <?php foreach ($getSaranaHandling as $key => $value): ?>
              <?php if (($key+1) % 4 == 2) {
                echo ($key+1) > 4 ? '<br>' : '';
                echo $handlingPdf[0]['sarana_handling'] == $getSaranaHandling[$key]['sarana'] ? '<span style="font-size:13px">&#9745; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>' : '<span style="font-size:13px">&#9744; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>';
              } ?>
              <?php endforeach; ?>
            </td>
            <td colspan="2" style="padding:5px;padding-left:35px">
              <?php foreach ($getSaranaHandling as $key => $value): ?>
              <?php if (($key+1) % 4 == 3) {
                echo ($key+1) > 4 ? '<br>' : '' ;
                echo $handlingPdf[0]['sarana_handling'] == $getSaranaHandling[$key]['sarana'] ? '<span style="font-size:13px">&#9745; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>' : '<span style="font-size:13px">&#9744; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>';
              } ?>
              <?php endforeach; ?>
            </td>
            <td colspan="2" style="border-right:1px solid black;padding:5px;padding-left:40px">
              <?php foreach ($getSaranaHandling as $key => $value): ?>
              <?php if (($key+1) % 4 == 0) {
                echo ($key+1) > 4 ? '<br>' : '';
                echo $handlingPdf[0]['sarana_handling'] == $getSaranaHandling[$key]['sarana'] ? '<span style="font-size:13px">&#9745; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>' : '<span style="font-size:13px">&#9744; '.strtoupper($getSaranaHandling[$key]['sarana']).'</span>';
              } ?>
              <?php endforeach; ?>
            </td>
          </tr>
          <tr>
            <td colspan="8" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:14px">VISUALISASI TEMUAN</td>
          </tr>
          <tr>
            <td colspan="4" style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px">BEFORE</td>
            <td colspan="4" style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:12px">AFTER</td>
          </tr>
          <tr>
            <td colspan="4" style="border-left:1px solid black;border-bottom:1px solid black;text-align:center;font-size:12px">
              <?php
              $foto_before = explode(", ", $gambarHandlingPdf[0]['foto_before']);
              foreach ($foto_before as $key => $value): ?>
                <img src="http://produksi.quick.com/api-audit/assets/img/photo_before/<?php echo $value ?>" class="img-fluid" style="width:35%;padding:5px"> <br>
              <?php endforeach; ?>
            </td>
            <td colspan="4" style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;text-align:center;font-size:12px">
              <?php
              $foto_after = explode(", ", $gambarHandlingPdf[0]['foto_after']);
              foreach ($foto_after as $key => $value): ?>
                <img src="<?php echo base_url('assets/upload/MenjawabTemuanAudite/Handling/'.$value) ?>" class="img-fluid" style="width:35%;padding:5px"> <br>
              <?php endforeach; ?>
            </td>
          </tr>
          <tr>
            <td rowspan="5" colspan="4" style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;vertical-align:baseline;font-size:12px">Poin Penyimpangan : <br><?php echo $handlingPdf[0]['poin_penyimpangan'] ?></td>
            <td style="width:14%;border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">Tgl. Selesai</td>
            <td style="width:12%;border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px"><?php echo $handlingPdf[0]['tanggal_selesai'] != NULL ? $handlingPdf[0]['tanggal_selesai'] : '-' ?></td>
            <td style="width:12%;border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px"><?php echo $handlingPdf[1]['tanggal_selesai'] != NULL ? $handlingPdf[1]['tanggal_selesai'] : '-' ?></td>
            <td style="width:12%;border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:2px;text-align:center;font-size:12px"><?php echo $handlingPdf[2]['tanggal_selesai'] != NULL ? $handlingPdf[2]['tanggal_selesai'] : '-' ?></td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px">Ttd Auditee</td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"><?php echo $handlingPdf[0]['tanggal_selesai'] != NULL ? $handlingPdf[0]['last_update_by_jawaban'] : '-' ?></td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"><?php echo $handlingPdf[1]['tanggal_selesai'] != NULL ? $handlingPdf[1]['last_update_by_jawaban'] : '-' ?></td>
            <td style="border-left:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:12px"><?php echo $handlingPdf[2]['tanggal_selesai'] != NULL ? $handlingPdf[2]['last_update_by_jawaban'] : '-' ?></td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">Tgl. Verifikasi</td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">
              <?php echo $handlingPdf[0]['waktu_verifikasi'] > $handlingPdf[0]['waktu_selesai'] && $handlingPdf[0]['tanggal_selesai'] != NULL ? $handlingPdf[0]['tanggal_verifikasi'] : '-' ?>
            </td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">
              <?php echo $handlingPdf[0]['waktu_verifikasi'] > $handlingPdf[1]['waktu_selesai'] && $handlingPdf[1]['tanggal_selesai'] != NULL ? $handlingPdf[1]['tanggal_verifikasi'] : '-'?>
            </td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:2px;text-align:center;font-size:12px">
              <?php echo $handlingPdf[0]['waktu_verifikasi'] > $handlingPdf[2]['waktu_selesai'] && $handlingPdf[2]['tanggal_selesai'] != NULL ? $handlingPdf[2]['tanggal_verifikasi'] : '-' ?>
            </td>
          </tr>

          <tr>
            <td rowspan="4" colspan="4" style="width:100%;border-left:1px solid black;border-bottom:1px solid black;padding:5px;vertical-align:baseline;font-size:12px">Action Plan : <br>
            <?php $numItems = count($handlingPdf);$i = 0;foreach ($handlingPdf as $key => $value): ?>
              <?php
              if (!empty($value['action_plan'])) {
                if (++$i === $numItems) {
                  echo "&#9899;";
                  echo $value['action_plan'];
                  echo ".";
                }else {
                  echo "&#9899;";
                  echo $value['action_plan'];
                  echo ", ";
                  echo "<br>";
                }
              }
              ?>
            <?php endforeach; ?>
            </td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px">Ttd Auditor</td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px">
              <?php echo $handlingPdf[0]['waktu_verifikasi'] > $handlingPdf[0]['waktu_selesai'] && $handlingPdf[0]['tanggal_selesai'] != NULL ? $handlingPdf[0]['last_update_by_temuan'] : '' ?>
            </td>
            <td style="border-left:1px solid black;padding:5px;text-align:center;font-size:12px">
              <?php echo $handlingPdf[0]['waktu_verifikasi'] > $handlingPdf[1]['waktu_selesai'] && $handlingPdf[1]['tanggal_selesai'] != NULL ? $handlingPdf[1]['last_update_by_temuan'] : ''?>
            </td>
            <td style="border-left:1px solid black;border-right:1px solid black;padding:2px;text-align:center;font-size:12px">
              <?php echo $handlingPdf[0]['waktu_verifikasi'] > $handlingPdf[2]['waktu_selesai'] && $handlingPdf[2]['tanggal_selesai'] != NULL ? $handlingPdf[2]['last_update_by_temuan'] : '' ?>
            </td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-size:12px"></td>
          </tr>
          <tr>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">Status</td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">
            <?php
            if ($handlingPdf[0]['status'] != NULL && $handlingPdf[0]['status'] == 'OPEN') {
                echo "Open / <s>Close</s>";
            }elseif ($handlingPdf[0]['status'] != NULL && $handlingPdf[0]['status'] == 'CLOSE') {
                echo "<s>Open</s> / Close";
            }else {
                echo "Open / Close";
            } ?>
            </td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;padding:2px;text-align:center;font-size:12px">
            <?php
            if ($handlingPdf[1]['status'] != NULL && $handlingPdf[1]['status'] == 'OPEN') {
              echo "Open / <s>Close</s>";
            }elseif ($handlingPdf[1]['status'] != NULL && $handlingPdf[1]['status'] == 'CLOSE') {
              echo "<s>Open</s> / Close";
            }else {
              echo "Open / Close";
            } ?>
            </td>
            <td style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:2px;text-align:center;font-size:12px">
            <?php
            if ($handlingPdf[2]['status'] != NULL && $handlingPdf[2]['status'] == 'OPEN') {
              echo "Open / <s>Close</s>";
            }elseif ($handlingPdf[2]['status'] != NULL && $handlingPdf[2]['status'] == 'CLOSE'){
              echo "<s>Open</s> / Close";
            }else {
              echo "Open / Close";
            } ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
