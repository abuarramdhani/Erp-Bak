<style>
  input.form-control {
    padding: 0 1em;
    /* height: 2em !important; */
  }

  .bordered {
    border: 1px solid #c3e3ff;
  }

  .float-right {
    float: right;
  }

  .bl-none {
    border-left: none;
  }

  .br-none {
    border-right: none;
  }

  .mb-1 {
    margin-bottom: .25em;
  }

  .mb-2 {
    margin-bottom: .5em;
  }

  .mt-2 {
    margin-top: .5em;
  }

  .mt-4 {
    margin-top: 1em;
  }

  .p-0 {
    padding: 0;
  }

  .px-1 {
    padding-left: .25em;
    padding-right: .25em;
  }

  .pl-4 {
    padding-left: 1em !important;
  }

  .p-2 {
    padding: .5em;
  }

  .p-4 {
    padding: 1em !important;
  }

  .flex {
    display: flex;
  }

  select.form-control {
    padding: 0 .5em;
  }

  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .radio-inline {
    padding-left: 0;
  }

  legend {
    width: auto !important;
    margin-bottom: 0.25em;
  }

  button[disabled] {
    opacity: 0.8;
  }

  .uppercase {
    text-transform: uppercase;
  }

  /* not work */
  .hover-pointer:hover {
    cursor: pointer;
  }

  .hover-pointer>*:hover {
    cursor: pointer;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  .bigdrop {
    width: 200px !important;
  }

  .select2 {
    width: 100% !important;
  }

  table.table>tbody>tr>td {
    padding: 2px 5px;
  }


  tr.red>td {
    color: red;
  }

  .form-group {
    margin-bottom: .25em;
  }

  .medium-size {
    width: 20px;
    height: 20px;
  }

  .ml--2 {
    margin-left: -20px !important;
  }

  table th:hover {
    cursor: pointer;
    -webkit-touch-callout: none;
    /* iOS Safari */
    -webkit-user-select: none;
    /* Safari */
    -khtml-user-select: none;
    /* Konqueror HTML */
    -moz-user-select: none;
    /* Firefox */
    -ms-user-select: none;
    /* Internet Explorer/Edge */
    user-select: none;
  }

  [v-cloak] {
    display: none;
  }

  /* head fix table  */
  table.table>thead>tr>th {
    border-bottom: 1px solid black;
    position: sticky;
    top: 0;
    background-color: #337ab7;
  }

  /* Fixed 2 column & header  */
  /* table.table>thead>tr>th:nth-child(1) {
    width: 50px;
    min-width: 50px;
    max-width: 100px;
    left: 0;
  }

  table.table>thead>tr>th:nth-child(2) {
    width: 70px;
    min-width: 70px;
    max-width: 100px;
    left: 50px;
  } */

  /* table tbody tr td:nth-child(1) {
    position: sticky;
    z-index: 10;
    width: 50px;
    min-width: 50px;
    max-width: 100px;
    left: 0px;
  }

  table tbody tr td:nth-child(2) {
    position: sticky;
    z-index: 10;
    width: 70px;
    min-width: 70px;
    max-width: 100px;
    left: 50px;
  }

  table tbody tr:not(.bg-primary) td:nth-child(1) {
    background-color: white;
  }

  table tbody tr.bg-primary td:nth-child(1) {
    background-color: #337ab7;
  }

  table tbody tr:not(.bg-primary) td:nth-child(2) {
    background-color: white;
  }

  table tbody tr.bg-primary td:nth-child(2) {
    background-color: #337ab7;
  } */
</style>

<section id="app" style="margin-top: 5px;">
  <div class="col-md-12">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading" style="padding: 5px;">
          <h4>Kesepakatan Kerja CV. Karya Hidup Sentosa</h4>
        </div>
        <div class="panel-body">
          <form @submit.prevent="" action="" class="form-horizontal">
            <div class="col-md-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="" class="col-md-3">Pencarian Data</label>
                    <div class="col-md-3">
                      <select v-model="out" name="active" id="" class="form-control">
                        <option value="f">Aktif</option>
                        <option value="t">Keluar</option>
                        <option value="*">Semua</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select v-model="param" name="param" id="" class="form-control select2">
                        <?php foreach ($param_option as $key => $name) : ?>
                          <option value="<?= $key ?>"><?= $name ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="col-md-10">
                      <input v-model="keyword" type="text" name="q" placeholder="Keyword" class="form-control">
                    </div>
                    <div class="col-md-2">
                      <button @click.prevent="find" class="btn btn-sm btn-primary">
                        <i class="fa fa-search"></i>
                        <span>Cari</span>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="" class="col-md-3">Limit Data</label>
                    <div class="col-md-2">
                      <select v-model="limit" class="form-control" name="" id="">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="300">300</option>
                        <option value="-">∞</option>
                      </select>
                    </div>
                    <div class="col-md-4">

                    </div>
                  </div>
                  <div class="col-md-6 text-right">
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-2">
                      <button @click.prevent="exportExcel" class="btn btn-sm btn-success">
                        <i class="fa fa-file-excel-o"></i>
                        <span>Excel</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="col-md-12">
            <div class="row">
              <div v-cloak class="col-md-12">
                Total data : {{ tableBody.length }}
              </div>
            </div>
            <div class="table-responsive" style="height: 450px; overflow: auto; border: 1px solid #676767;">
              <table class="table table-bordered" id="table-pencarian-pekerja">
                <thead class="bg-primary">
                  <tr v-cloak>
                    <!-- <th>No</th>
                    <th>Noind</th>
                    <th>Nama</th>
                    <th>Seksi</th>
                    <th>Unit</th>
                    <th>Tgl. Masuk</th>
                    <th>Tgl. Diangkat</th>
                    <th>Akhir Kontrak</th>
                    <th>Tgl. Keluar</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Alamat</th>
                    <th>Desa</th>
                    <th>Kecamatan</th>
                    <th>Kabupaten</th>
                    <th>Propinsi</th>
                    <th>Kode Pos</th>
                    <th>No. HP</th>
                    <th>No. Telp</th>
                    <th>NIK</th>
                    <th>No. KK</th>
                    <th>Nokes</th>
                    <th>BPU</th>
                    <th>No. KPJ</th>
                    <th>Email</th>
                    <th>Sebab Keluar</th>
                    <th>Lokasi Kerja</th> -->
                    <th class="bg-primary" nowrap v-for="(name, i) in tableHead" @click="sortColumn(i)">
                      {{ name }} <i class="fa" :class="[ tableHeadToggled[i-1] === false ? 'fa-sort-asc' : 'fa-sort-desc' ]"></i>
                    </th>
                  </tr>
                </thead>
                <tbody v-cloak>
                  <tr v-if="tableLoading">
                    <td colspan="27" class="text-center">
                      Sedang mengambil data ...
                    </td>
                  </tr>
                  <!-- FIX THIS  -->
                  <tr :class="[ activeRow === i ? 'bg-primary' : '' ]" @click="setActiveRow(i)" v-for="(item, i) in tableBody">
                    <td>{{ i + 1 }}</td>
                    <td nowrap v-for="key in tableKeys">
                      {{ item[key] }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<script>
  const SESSION_USER = '<?= $this->session->user ?>'
</script>