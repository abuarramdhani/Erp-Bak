<style>
  input.form-control {
    padding: 0 1em;
    height: 2em !important;
  }

  .bordered {
    border: 1px solid #a6a6a6;
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

  table.table>thead>tr>th {
    border-bottom: 1px solid black;
    background-color: white;
    position: sticky;
    top: 0;
  }

  table#table-kesepakatan-kerja tbody tr {
    cursor: pointer;
    user-select: none;
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

  [v-cloak] {
    display: none;
  }

  /* custom */
  table.table-parent>tbody>tr:hover {
    background-color: #e8e8e8;
    cursor: pointer;
  }

  .bg-selected {
    background: #c5c5c5;
  }
</style>
<!-- 
**
|-----------------------------------------
|                 --------               |
| THIS VIEW IS USING VUE 2               |
| Thank you :>                           |
|-----------------------------------------
** -->

<section id="app" style="margin-top: 5px;">
  <div class="col-md-12">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading" style="padding: 5px;">
          <h4>Kesepakatan Kerja CV. Karya Hidup Sentosa</h4>
        </div>
        <div class="panel-body">
          <form action="" class="form-horizontal">
            <div class="col-md-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="" class="col-md-2">Bulan</label>
                    <div class="col-md-3">
                      <select v-model="selectedMonth" name="" id="" class="form-control" data-placeholder="Bulan">
                        <?php
                        $monthNames = [
                          "Januari",
                          "Februari",
                          "Maret",
                          "April",
                          "Mei",
                          "Juni",
                          "Juli",
                          "Agustus",
                          "September",
                          "Oktober",
                          "November",
                          "Desember",
                        ];
                        ?>
                        <?php foreach ($monthNames as $index => $month) : ?>
                          <option value="<?= $index + 1 ?>"><?= $month ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <label for="" class="col-md-2">Tahun</label>
                    <div class="col-md-3">
                      <select v-model="selectedYear" name="" id="" class="form-control" data-placeholder="Tahun">
                        <?php for ($x = date('Y'); $x >= 2010; $x--) : ?>
                          <option value="<?= $x ?>"><?= $x ?></option>
                        <?php endfor ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="" class="col-md-2">Pekerja</label>
                    <div class="col-md-8">
                      <input v-model="queryParam" type="text" name="" id="" placeholder="Cari nama/noind" class="form-control">
                    </div>
                    <div class="col-md-2">
                      <button @click.prevent="filterTable" class="btn btn-sm btn-primary">
                        <i class="fa fa-search"></i>
                        <span>Cari</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="col-md-12">
            <div class="table-responsive" style="height: 200px; overflow: auto; border: 1px solid #676767;">
              <table class="table table-bordered" id="table-kesepakatan-kerja">
                <thead>
                  <tr>
                    <th>[]</th>
                    <th>Noind</th>
                    <th>Nama</th>
                    <th>Seksi</th>
                    <th>Dept</th>
                    <th>Tgl. Diangkat</th>
                    <th>Tgl. Evaluasi</th>
                    <th>Tgl. Pemanggilan</th>
                    <th>Tgl. Tanda Tangan</th>
                    <th>Keterangan</th>
                    <th>Oleh</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!tableLoading" v-cloak v-for="(item, index) in table" :key="index" :class="{ 'bg-selected': (index === 'activeRow' || selectedNoind.includes(item.noind)) , 'red': item.keluar == 't' }" @click="rowOnClick(index, item.noind)">
                    <td>
                      <input type="checkbox" @change.stop :value="item.noind" v-model="selectedNoind">
                    </td>
                    <td nowrap>{{ item.noind }}</td>
                    <td>{{ item.nama }}</td>
                    <td>{{ item.seksi }}</td>
                    <td nowrap>{{ item.dept }}</td>
                    <td nowrap>{{ item.tgldiangkat }}</td>
                    <td nowrap>{{ item.tglevaluasi }}</td>
                    <td nowrap>{{ item.tglpemanggilan }}</td>
                    <td nowrap>{{ item.tgltandatangan }}</td>
                    <td>{{ item.keterangan }}</td>
                    <td nowrap>{{ item.user }}</td>
                  </tr>
                  <tr v-cloak v-if="table.length === 0 && !tableLoading">
                    <td class="text-center" style="vertical-align: middle; height: 140px;" colspan="10">
                      <!-- <img src="<?= base_url('assets/img/gif/spinner.gif') ?>" style="width: 40px; height: auto;" alt=""> -->
                      Data tidak ditemukan :(
                    </td>
                  </tr>
                  <tr v-if="tableLoading">
                    <td class="text-center" style="vertical-align: middle; height: 140px;" colspan="10">
                      <img src="<?= base_url('assets/img/gif/spinner.gif') ?>" style="width: 40px; height: auto;" alt="">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- red square -->
          <div class="col-md-12 mt-2">
            <div class="inline">
              <span style="height: 13px; width: 13px; background-color: red; display: inline-block;"></span>
              <span>Pekerja sudah keluar</span>
            </div>
            <div v-cloak class="pull-right">
              Total Pencarian ({{ searchedCount }})
            </div>
          </div>
          <!-- /red square -->
          <div class="col-md-12 mt-4">
            <div style="border-radius: 10px; padding: 1em; border: 2px solid #ababab;">
              <div class="row">
                <form action="" class="form-horizontal">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Noind</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control" :value="selectedData.noind" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Nama</label>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control" :value="selectedData.nama" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Tanggal Diangkat</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control date" data-model="tgldiangkat" :value="selectedData.tgldiangkat">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Tanggal Evaluasi</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control date" data-model="tglevaluasi" :value="selectedData.tglevaluasi || today" :disabled="!checkbox.tglevaluasi">
                      </div>
                      <div class="col-md-3">
                        <input class="medium-size ml--2" type="checkbox" name="" id="" v-model="checkbox.tglevaluasi">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Keterangan</label>
                      </div>
                      <div class="col-md-8">
                        <textarea class="form-control" v-model="selectedData.keterangan" rows="3" style="max-height: 90px; min-height: 50px; resize: vertical;"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Oleh</label>
                      </div>
                      <div class="col-md-3">
                        <input type="text" class="form-control" :value="selectedData.user" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Seksi</label>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control" :value="selectedData.seksi" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Departemen</label>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control" :value="selectedData.dept" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Tanggal Pemanggilan</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control date" data-model="tglpemanggilan" :disabled="!checkbox.tglpemanggilan" :value="selectedData.tglpemanggilan || today">
                      </div>
                      <div class="col-md-3">
                        <input class="medium-size ml--2" type="checkbox" name="" id="" v-model="checkbox.tglpemanggilan">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4">
                        <label for="" class="label-control">Tanggal Tanda Tangan</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" class="form-control date" data-model="tgltandatangan" :disabled="!checkbox.tgltandatangan" :value="selectedData.tgltandatangan || today">
                      </div>
                      <div class="col-md-3">
                        <input class="medium-size ml--2" type="checkbox" name="" id="" v-model="checkbox.tgltandatangan">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 text-right">
                    <button @click="printOpen" disabled :disabled="!selectedData.noind && !selectedNoind.length" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-print">Cetak</button>
                    <button @click="exportToExcel" type="button" class="btn btn-success">
                      <i class="fa fa-file-excel-o"></i>
                      Export
                    </button>
                    <button @click="updateTableItem" ref="saveButton" disabled :disabled="!selectedData.noind" type="button" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<!-- modal cetak -->
<div class="modal" id="modal-print">
  <div class="modal-dialog" style="width: auto;" role="document">
    <div class="modal-content" style="border-radius: 5px; border: 2px solid #337ab7; width: 750px; margin: 0 auto;">
      <div class=" modal-header bg-primary" style="padding: 0.4em;">
        <label class=" modal-title" id="exampleModalLongTitle">Perjanjian Kerja</label>
        <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-top: 1em;">
        <div v-if="alertOpen" class="alert alert-success alert-dismissible mt-2" role="alert">
          <strong>Sukses!</strong> template berhasil disimpan
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="table-responsive" style="height: 300px; overflow: auto; border: 1px solid #676767;">
          <table v-if="activeTable == 'parent'" class="table table-bordered table-parent">
            <thead>
              <tr>
                <!-- <th width="10px">[]</th> -->
                <th width="10px">Pasal</th>
                <th>Item</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in perjanjian" @click="handleClick(i)">
                <!-- <td>
                  <input type="checkbox">
                </td> -->
                <td class="text-center">{{ item.pasal }}</td>
                <td>{{ item.title.isi }}</td>
              </tr>
            </tbody>
          </table>
          <table v-if="activeTable == 'child'" class="table table-bordered table-child">
            <thead>
              <tr>
                <th width="10px">[]</th>
                <th width="10px">No</th>
                <th>Isi</th>
                <th width="10px">Sub</th>
                <th width="10px">Lokasi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in v_perjanjian[activePasal].item">
                <td>
                  <input type="checkbox" v-model="tableChildTemporaryCheck" :value="i" id="">
                </td>
                <td :class="{ 'text-right': item.sub == '0'}">{{ (item.sub != '0') ? item.sub : '-' }}</td>
                <td>
                  <textarea type="text" v-model="item.isi" style="border: 0; height: 20px; min-height: 20px; overflow-y: hidden; width: 100%; resize: none;"></textarea>
                </td>
                <td class="text-center">
                  <input type="checkbox" v-on:input="item.sub = $event.target.checked ? '2' : '0'" :checked="item.sub != '0'" name="" id="">
                </td>
                <td class="text-center">
                  <select v-model="item.lokasi" style="border: 0;" name="" id="">
                    <option value="0">semua</option>
                    <option value="1">pusat</option>
                    <option value="2">tksno</option>
                    <option value="3">mlati</option>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-if="activeTable == 'child'" class="col-md-12 mt-2">
          <div class="row">
            <div class="col-md-6">
              <button @click="addChildRow" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
              </button>
              <button @click="removeChildRow" :disabled="!tableChildTemporaryCheck.length" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
              </button>
            </div>
            <div class="col-md-6 text-right">
              <button @click="backTable" class=" btn btn-sm" :disabled="activeTable=='parent'">Back</button>
              <button @click="handleSave" class=" btn btn-sm btn-primary">simpan</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mt-2">
            <div class="row">
              <div class="col-md-6">
                <div class="row mt-2">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="">Lokasi kerja</label>
                      </div>
                      <div class="col-md-6">
                        <select v-model="selectedLoker" name="" id="" class="form-control select2">
                          <option value="pst">Yogyakarta</option>
                          <option value="tks">Tuksono</option>
                          <option value="mlt">Mlati</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="">Besar upah</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" v-model="upahValue" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <button @click="setUpah" :disabled="!upahValue" class="btn btn-sm btn-primary">Ok</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="">Tanda tangan</label>
                      </div>
                      <div class="col-md-6">
                        <select name="" id="signer" class="form-control select2"></select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div style="padding: 0.5em; background-color: #e8e8e8;">
                  <span><b>Penggunaan karakter khusus pada teks,</b></span>
                  <ul style="list-style: none; padding-left: 10px;">
                    <li><span style="width: 15px; display: inline-block; font-weight: bold;">$</span> : Untuk mensubstitusikan besar upah</li>
                    <li><span style="width: 15px; display: inline-block; font-weight: bold;">@</span> : Untuk mensubstitusikan lama kontrak</li>
                    <li><span style="width: 15px; display: inline-block; font-weight: bold;">#</span> : Untuk mensubstitusikan tgl masuk</li>
                    <li><span style="width: 15px; display: inline-block; font-weight: bold;">%</span> : Untuk mensubstitusikan tgl akhir masuk</li>
                    <li><span style="width: 15px; display: inline-block; font-weight: bold;">^</span> : Untuk mensubstitusikan nama seksi</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-left">
            <!-- <button class="btn btn-primary" @click="add">Tambah</button> -->
            <button class="btn btn-danger" style="min-width: 150px;" @click="printNow" :disabled="!upahValue || !signer || download_is_processing">
              <span v-if="download_is_processing">
                Memproses
                <i class="fa fa-spinner fa-spin"></i>
              </span>
              <span v-else>
                <i class="fa fa-file-pdf-o"></i> Cetak Sekarang
              </span>
            </button>
            <div style="display: inline-block; margin-left: 1em;">
              <input v-model="newtab" type="checkbox" name="" id=""> <span> buka di tab baru ?</span>
            </div>
            <button style="float: right;" class="btn btn-default" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const SESSION_USER = '<?= $this->session->user ?>'
</script>