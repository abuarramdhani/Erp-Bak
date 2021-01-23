<?php
function truncate($string, $length)
{
  return strlen($string) > $length ? substr($string, 0, $length) . " ..." : $string;
}
?>
<style>
  table#table-pemutihan-pekerja>tbody>tr.pending {
    background-color: orange;
  }

  table#table-pemutihan-pekerja>tbody>tr.cancel {
    color: white;
    background-color: grey;
  }

  table#table-pemutihan-pekerja>tbody>tr.reject {
    background-color: tomato;
  }

  table#table-pemutihan-pekerja>tbody>tr.accept {
    background-color: greenyellow;
  }

  /* NAV TAB */
  .nav.nav-tabs>li {
    width: 25%;
  }

  .tab-pane {
    padding: 1em;
  }

  .nav-pending {
    color: orange;
  }

  .nav-revision {
    color: #72b8ff;
  }

  .nav-approved {
    color: #65c952;
  }

  .nav-rejected {
    color: tomato;
  }

  li.active>.nav-pending {
    color: white !important;
    background-color: orange !important;
    font-weight: bold;
  }

  li.active>.nav-revision {
    color: white !important;
    background-color: #72b8ff !important;
    font-weight: bold;
  }

  li.active>.nav-approved {
    color: white !important;
    background-color: #65c952 !important;
    font-weight: bold;
  }

  li.active>.nav-rejected {
    color: white !important;
    background-color: tomato !important;
    font-weight: bold;
  }

  table {
    width: 100% !important;
  }
</style>
<section class="content">
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3>List Pengajuan Pemutihan Data Pekerja</h3>
      </div>
      <div class="panel-body">
        <?php
        $countPending = count($tablePending);
        $countRevision = count($tableRevision);
        $countApproved = count($tableApproved);
        $countRejected = count($tableRejected);
        ?>
        <ul class="nav nav-tabs">
          <li class="active">
            <a class="nav-pending" data-toggle="tab" href="#pending">Pending (<?= $countPending ?>)</a>
          </li>
          <li>
            <a class="nav-revision" data-toggle="tab" href="#revision">Revisi (<?= $countRevision ?>)</a>
          </li>
          <li>
            <a class="nav-approved" data-toggle="tab" href="#approved">Approved (<?= $countApproved ?>)</a>
          </li>
          <li>
            <a class="nav-rejected" data-toggle="tab" href="#rejected">Rejected (<?= $countRejected ?>)</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="pending" class="tab-pane fade in active" style="border: 4px solid orange">
            <div class="table-responsive">
              <table class="table table-striped" id="table-pemutihan-pekerja-pending">
                <thead class="bg-primary">
                  <tr>
                    <td>Order</td>
                    <td>Action</td>
                    <td>No Induk</td>
                    <td>Nama</td>
                    <td>Seksi</td>
                    <td>Lokasi Kerja</td>
                    <td>Tanggal Pengajuan</td>
                    <td>Approver</td>
                    <td>Tanggal Approve</td>
                    <td>Keterangan</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tablePending as $item) : ?>
                    <tr class="<?= $item->status_req ?>">
                      <td class="text-center"><?= $item->id_req ?></td>
                      <td nowrap>
                        <a href="<?= base_url("/MasterPekerja/Pemutihan/Request?id={$item->id_req}&redirect=pending") ?>" class="btn btn-primary btn-sm">Check</a>
                      </td>
                      <td><?= $item->noind ?></td>
                      <td><?= $item->nama ?></td>
                      <td title="<?= $item->seksi ?>"><?= truncate($item->seksi, 20) ?></td>
                      <td><?= $item->lokasi_kerja ?></td>
                      <td>
                        <strong><?= date('d/m/Y', strtotime($item->created_at)) ?></strong>
                        <?= date('H:i:s', strtotime($item->created_at)) ?>
                      </td>
                      <td><?= $item->status_update_by ?></td>
                      <td><?= $item->status_update_at ?></td>
                      <td><?= $item->feedback ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <span>*Data pada tabel terupdate otomatis dalam 5 detik</span>
            </div>
          </div>
          <div id="revision" class="tab-pane fade" style="border: 4px solid #72b8ff">
            <div class="table-responsive">
              <table class="table table-striped" id="table-pemutihan-pekerja-revision">
                <thead class="bg-primary">
                  <tr>
                    <td>Order</td>
                    <td>Action</td>
                    <td>No Induk</td>
                    <td>Nama</td>
                    <td>Seksi</td>
                    <td>Lokasi Kerja</td>
                    <td>Tanggal Pengajuan</td>
                    <td>Approver</td>
                    <td>Tanggal Approve</td>
                    <td>Keterangan</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tableRevision as $item) : ?>
                    <tr class="<?= $item->status_req ?>">
                      <td class="text-center">#<?= $item->id_req ?></td>
                      <td nowrap>
                        <a href="<?= base_url("/MasterPekerja/Pemutihan/Request?id={$item->id_req}&redirect=revision") ?>" class="btn btn-primary btn-sm">Check</a>
                      </td>
                      <td><?= $item->noind ?></td>
                      <td><?= $item->nama ?></td>
                      <td title="<?= $item->seksi ?>"><?= truncate($item->seksi, 20) ?></td>
                      <td><?= $item->lokasi_kerja ?></td>
                      <td>
                        <strong><?= date('d/m/Y', strtotime($item->created_at)) ?></strong>
                        <?= date('H:i:s', strtotime($item->created_at)) ?>
                      </td>
                      <td><?= $item->status_update_by ?></td>
                      <td><?= $item->status_update_at ?></td>
                      <td><?= $item->feedback ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <div id="approved" class="tab-pane fade" style="border: 4px solid #65c952">
            <div class="table-responsive">
              <table class="table table-striped" id="table-pemutihan-pekerja-approved">
                <thead class="bg-primary">
                  <tr>
                    <td>Order</td>
                    <td>Action</td>
                    <td>No Induk</td>
                    <td>Nama</td>
                    <td>Seksi</td>
                    <td>Lokasi Kerja</td>
                    <td>Tanggal Pengajuan</td>
                    <td>Approver</td>
                    <td>Tanggal Approve</td>
                    <td>Keterangan</td>
                    <td title="Data yang sudah diupdate ke database asli">Distribusi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tableApproved as $item) : ?>
                    <tr class="<?= $item->status_req ?>">
                      <td class="text-center">#<?= $item->id_req ?></td>
                      <td nowrap>
                        <a href="<?= base_url("/MasterPekerja/Pemutihan/Request?id={$item->id_req}&redirect=approved") ?>" class="btn btn-primary btn-sm">Check</a>
                      </td>
                      <td><?= $item->noind ?></td>
                      <td><?= $item->nama ?></td>
                      <td title="<?= $item->seksi ?>"><?= truncate($item->seksi, 20) ?></td>
                      <td><?= $item->lokasi_kerja ?></td>
                      <td>
                        <strong><?= date('d/F/Y', strtotime($item->created_at)) ?></strong>
                        <?= date('H:i:s', strtotime($item->created_at)) ?>
                      </td>
                      <td><?= $item->status_update_by ?></td>
                      <td><?= date('d/F/Y', strtotime($item->status_update_at)) ?></td>
                      <td><?= $item->feedback ?></td>
                      <td><?= date('d/F/Y', strtotime($item->distributed_at)) ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <div id="rejected" class="tab-pane fade" style="border: 4px solid tomato">
            <div class="table-responsive">
              <table class="table table-striped" id="table-pemutihan-pekerja-rejected">
                <thead class="bg-primary">
                  <tr>
                    <td>Order</td>
                    <td>Action</td>
                    <td>No Induk</td>
                    <td>Nama</td>
                    <td>Seksi</td>
                    <td>Lokasi Kerja</td>
                    <td>Tanggal Pengajuan</td>
                    <td>Approver</td>
                    <td>Tanggal Approve</td>
                    <td>Keterangan</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tableRejected as $item) : ?>
                    <tr class="#<?= $item->status_req ?>">
                      <td class="text-center"><?= $item->id_req ?></td>
                      <td nowrap>
                        <a href="<?= base_url("/MasterPekerja/Pemutihan/Request?id={$item->id_req}&redirect=rejected") ?>" class="btn btn-primary btn-sm">Check</a>
                      </td>
                      <td><?= $item->noind ?></td>
                      <td><?= $item->nama ?></td>
                      <td title="<?= $item->seksi ?>"><?= truncate($item->seksi, 20) ?></td>
                      <td><?= $item->lokasi_kerja ?></td>
                      <td>
                        <strong><?= date('d/m/Y', strtotime($item->created_at)) ?></strong>
                        <?= date('H:i:s', strtotime($item->created_at)) ?>
                      </td>
                      <td><?= $item->status_update_by ?></td>
                      <td><?= $item->status_update_at ?></td>
                      <td><?= $item->feedback ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // init when url is contain hash
  // it will click tab if exist
  !(function() {
    const hash = window.location.hash

    if (hash) {
      $(`a[href=${hash}]`).click()
    }
  })();

  /**
   * Document on ready
   */
  $(() => {
    // to set hash when tab is clicked
    $('a[data-toggle=tab]').click(function() {
      let hash = $(this).attr('href')
      window.history.pushState({}, "Example Title", hash);
    })

    // datatable initialize
    $('table#table-pemutihan-pekerja-pending').dataTable({
      order: []
    });
    $('table#table-pemutihan-pekerja-approved').dataTable({
      order: []
    });
    $('table#table-pemutihan-pekerja-revision').dataTable({
      order: []
    });
    $('table#table-pemutihan-pekerja-rejected').dataTable({
      order: []
    });

    // Realtime refresh 
    // https://datatables.net/forums/discussion/42533/how-to-refresh-table-data-in-real-time-automatically
    // table.ajax.reload();

    /**
     * Pending environtment 
     */
    !(function() {
      // $('table#table-pemutihan-pekerja-pending').dataTable({
      //   processing: true,
      //   serverside: true,
      //   ajax: baseurl + 'MasterPekerja/Pemutihan/api/list/pending/datatable',
      //   order: [],
      //   // columnDefs: [{
      //   //   targets: 1,
      //   //   // data: ''
      //   // }]
      // });
    })();

    /**
     * Approved environtment 
     */
    !(function() {

    })();

    /**
     * Rejected environtment 
     */
    !(function() {

    })();
  })
</script>