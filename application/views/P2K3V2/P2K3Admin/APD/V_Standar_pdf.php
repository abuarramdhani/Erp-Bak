<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <td rowspan=" 8" style="text-align:center;">
        <img width="60" src="<?= base_url('assets/img/logo/logo.png') ?>" alt="">
      </td>
    </tr>
    <tr>
      <td rowspan="4" style="height:3rem; text-align:center;">
        <h3>STANDART ALAT PELINDUNG DIRI (APD)</h3>
      </td>
    </tr>
    <tr>
      <td rowspan="6" style="text-align:center;">
        <img style="margin-left:5px; margin-right:5px;" width="60" src="<?= base_url('assets/img/logo/p2k3wtext.png') ?>" alt="">
      </td>
    </tr>
    <tr>
      <td style="height:2rem; width:6rem; padding-left:5px;">
        <p style="font-size:12px;">Doc. No.</p>
      </td>
      <td style="height:2rem; width:8rem; padding-left:5px;">
        <p style="font-size:12px;">KKK-FAB-FIN-03</p>
      </td>
    </tr>
    <tr>
      <td style="height:2rem; width:6rem; padding-left:5px;">
        <p style="font-size:12px;">Revisi No.</p>
      </td>
      <td style="height:2rem; width:8rem; padding-left:5px;">
        <p style="font-size:12px;"><?= $data_kop['rev_no']; ?></p>
      </td>
    </tr>
    <tr>
      <td rowspan="3" style="text-align:center;">
        <h4><?= $pekerjaan; ?></h4>
        <h5>SEKSI : <?= $seksiName; ?></h5>
      </td>
    </tr>
    <tr>
      <td style="height:2rem; width:6rem; padding-left:5px;">
        <p style="font-size:12px;">Rev. Date</p>
      </td>
      <td style="height:2rem; width:8rem; padding-left:5px;">
        <p style="font-size:12px;"><?= $this->personalia->konversitanggalIndonesia($data_kop['rev_date']); ?></p>
      </td>
    </tr>
    <tr>
      <td style="height:2rem; width:6rem; padding-left:5px;">
        <p style="font-size:12px;">Page</p>
      </td>
      <td style="height:2rem; width:8rem; padding-left:5px;">
        <p style="font-size:12px;">1/1</p>
      </td>
    </tr>
  </thead>
</table>
<table class="tbody" width="100%" cellpadding=" 0" cellspacing="0" style="border-collapse:collapse;">
  <tbody>
    <tr>
      <td style="width:50%; text-align:center; border-left:2px solid black; border-bottom:2px solid black;">
        <img style="margin:3rem;" width="100%" src="<?= base_url("assets/img/PegawaiKHS/$person") ?>" alt="">
      </td>

      <td style="border-right:2px solid black; border-bottom:2px solid black; padding:3rem;">
        <table style="border-bottom:1px solid black; border-right: 1px solid black; border-left: 1px solid black;" cellpadding="0" cellspacing="0" width="100%">
          <?php foreach ($apd as $apdKey => $apdval) : ?>
            <tr>
              <th style="text-align:left; border-top:1px solid black; border-bottom: 1px solid black; font-size:16;"><?= 'Alat ' . $apdKey; ?></th>
            </tr>
            <tr>
              <td>
                <table style="width:100%;">
                  <?php foreach ($apdval as $apdv) : ?>
                    <tr>
                      <td style="text-align:center;">
                        <img style="margin:1.2rem;" width="60" src="http://erp.quick.com/assets/upload/P2K3/item/<?= $apdv['nama_file']; ?>" alt="<?= $apdv['nama_file']; ?>">
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center; font-size:16;"><?= $apdv['item']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<table width="100%" cellpadding=" 0" cellspacing="0" style="border-collapse:collapse;" style="border-left:2px solid black; border-right:2px solid black; border-bottom:2px solid black;">
  <tbody>
    <tr>
      <td>
        <table style="border-right: 1px solid black;" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="border-bottom:2px solid black; width:7rem;  height:4rem; padding:10px; border-right:2px solid black;">
              <p>Dibuat</p>
            </td>
            <td style="border-bottom:2px solid black; height:4rem; padding:10px; border-right:2px solid black;">
              <div>
                <p style="font-weight:bold;"><?= $this->session->employee; ?> </p>
              </div>
              <small>Seksi Standarisasi P2K3</small>
            </td>
            <td style="width:7rem;border-bottom:2px solid black;"></td>
          </tr>
          <tr>
            <td style="border-bottom:2px solid black; width:7rem; height:4rem; padding:10px; border-right:2px solid black;">
              <p>Diperiksa</p>
            </td>
            <td style="border-bottom:2px solid black; height:4rem; padding:10px; border-right:2px solid black;">
              <div>
                <p style="font-weight:bold;"><?= $data_kop['approve_askanit_by']; ?></p>
              </div>
              <small style="text-transform:capitalize;">Ass. Unit <?= !empty($seksiUnit) ? $seksiUnit[0]['unit'] : '-';  ?></small>
            </td>
            <td style="width:7rem;border-bottom:2px solid black;"></td>
          </tr>
          <tr>
            <td style="width:7rem; height:4rem; padding:10px; border-right:2px solid black;">
              <p>Disetujui</p>
            </td>
            <td style="height:4rem; padding:10px; border-right:2px solid black;">
              <div>
                <p style="font-weight:bold;"><?= $data_kop == '01' ? 'Daryono' : 'Daryono'; ?></p>
              </div>
              <small>Ketua P2K3</small>
            </td>
            <td style="width:7rem;"></td>
          </tr>
        </table>
      </td>
      <td style="width:45%; border-left: 1px solid black; vertical-align:text-top; padding:.5rem;">
        <p>Catatan Revisi:</p>
      </td>
    </tr>
  </tbody>
</table>