<style>
  td.details-control {
    background: url('<?= base_url('/assets/img/icon/details_open.png') ?>') no-repeat center center;
    cursor: pointer;
  }

  tr.shown td.details-control {
    background: url('<?= base_url('/assets/img/icon/details_close.png') ?>') no-repeat center center;
  }

  .cursor-pointer {
    cursor: pointer;
  }

  .hover-gray:hover {
    background-color: #e8e8e8;
  }

  .disable-select {
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
  }
</style>
<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Rekap Data Kaizen</h1>
      </div>
    </div>
    <div class="panel-body">
      <table id="tableRekapKaizen" data-username="<?= $this->session->user ?>" data-sectioncode="<?= $this->session->kodesie ?>" class="table table-bordered table-striped" cellspacing="0" width="100%">
        <thead class="bg-primary">
          <tr>
            <th style=" width: 5%;">Action</th>
            <th style="width: 5%;">No</th>
            <th style="width: 10%;">Noind</th>
            <th style="width: 30%;">Nama</th>
            <th style="width: 35%;">Seksi</th>
            <th style="width: 5%;">Total Kaizen</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</section>