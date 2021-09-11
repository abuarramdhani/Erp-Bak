<style type="text/css">
  .person {
    padding: 0 !important;
  }

  .grid-center {
    width: 100%;
    height: 100%;
    display: grid;
    justify-items: center;
    align-content: center;
  }
</style>
<table style="margin:0; width:100%;" border="1px solid black">
  <tbody>
    <tr>
      <td style="padding:3rem;">
        <div class="grid-center">
          <img width="100%" src="<?= base_url("assets/img/PegawaiKHS/$person") ?>" alt="<?= $person; ?>">
        </div>
      </td>
      <td style="width:50%; padding:3rem;">
        <table border="1px solid black" style="width:100%;">
          <?php foreach ($apd as $apdKey => $apdval) : ?>
            <tr>
              <th style="font-size:16px;"><?= $apdKey; ?></th>
            </tr>
            <tr>
              <td>
                <div class="flex-center">
                  <table style="width:100%;">
                    <?php foreach ($apdval as $apdv) : ?>
                      <tr style="text-align:center;">
                        <td>
                          <img style="margin:1rem;" width="65" src="http://erp.quick.com/assets/upload/P2K3/item/<?= $apdv['nama_file']; ?>" alt="<?= $apdv['nama_file']; ?>">
                        </td>
                      </tr>
                      <tr style="text-align:center; font-size:12;">
                        <td><?= $apdv['item']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </td>
    </tr>

  </tbody>
</table>