<style>
  html {
    scroll-behavior: smooth;
  }

  .flex-row {
    display: flex;
    flex-direction: row;
  }

  .flex-end {
    display: flex;
    justify-content: flex-end;
  }

  .bold {
    font-weight: bold;
  }

  .mt-2 {
    margin-top: 2em;
  }

  .mb-2 {
    margin-bottom: 2em;
  }

  .mr-2 {
    margin-right: 2em;
  }

  .p-0 {
    padding: 0 !important;
  }

  .navbar-float a div:hover,
  .navbar-float a.active {
    background-color: #3c8dfa !important;
  }

  .with-bg {
    padding: 7px 1em;
    border: 1px solid #d2d6de;
  }

  .m-0 {
    margin: 0;
  }

  table {
    width: 100%;
    margin: 0;
  }

  table.bordered {
    padding: 0;
    border-collapse: collapse;
  }

  table.bordered td {
    border: 1px solid black;
  }

  .centered td,
  .centered th {
    text-align: center;
  }

  table.bordered thead td,
  table.bordered thead th {
    font-weight: bold;
  }

  table.bordered th,
  table.bordered td {
    border: 1px solid black;
  }

  table.header>tr {
    height: 100px;
  }

  .logo {
    width: 60px;
    height: auto;
  }

  /* ------------------------------------------------ */
  .title {
    background-color: #C0C0C0;
    width: 100%;
    font-weight: bold;
  }

  .center {
    text-align: center;
  }

  .text-left {
    text-align: left;
  }

  .text-top-left {
    text-align: left;
    vertical-align: top;
  }

  .bold {
    font-weight: bold;
  }

  .select2 {
    width: 100%;
  }

  .disabled-div {
    pointer-events: none;
    opacity: 0.5;
  }

  [v-cloak] {
    display: none;
  }
</style>
<section id="app">
  <div class="row" style="margin: 1em;">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h2>Blanko Evaluasi Penilaian Untuk Perpanjangan Pekerja Kontrak</h2>
        </div>
        <div class="box-body">
          <div class="col-md-12">

            <div class="col-lg-6">
              <div class="bg-primary" style="padding: 5px 1em; border-radius: 8px; margin-bottom: 1em;">
                <span>Pekerja</span>
              </div>
              <form action="" class="form-horizontal">
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="">Nama</label>
                  <div class="col-lg-8">
                    <select class="form-control" name="" id="worker-select">
                      <option value=""></option>
                      <?php
                      foreach ($workers as $worker) {
                        echo "<option value='{$worker['noind']}'>{$worker['noind']} - {$worker['nama']}</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="">No Induk</label>
                  <div class="col-lg-8">
                    <input v-model="state.worker.noind" class="form-control" type="text" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="">Seksi/Unit/Departemen</label>
                  <div class="col-lg-8">
                    <input v-model="state.worker.seksi" class="form-control" type="text" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="">Nama/Jenis Pekerjaan</label>
                  <div class="col-lg-8">
                    <input v-model="state.worker.pekerjaan" class="form-control" type="text" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="">Jabatan</label>
                  <div class="col-lg-8">
                    <input v-model="state.worker.status_jabatan" class="form-control" type="text" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label" for="">Tanggal Akhir Kontrak</label>
                  <div class="col-lg-8">
                    <input v-model="state.worker.akhir_kontrak" class="form-control" type="text" readonly>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-6" v-bind:class="{ 'disabled-div': !state.worker.noind }">
              <div class="bg-primary" style="padding: 5px 1em; border-radius: 8px; margin-bottom: 1em;">
                <span>Penilaian Atasan</span>
              </div>
              <div>
                <textarea v-model="state.atasan" class="form-control" placeholder="Tuliskan penilaian pekerja" style="border-radius: 8px; max-height: 100%; resize: none;" cols="30" rows="13"></textarea>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div>
              <hr>
            </div>
            <div class="col-lg-6" v-bind:class="{ 'disabled-div': !state.worker.noind }">
              <div class="bg-primary" style="padding: 5px 1em; border-radius: 8px; margin-bottom: 1em;">
                <span>Usulan atasan</span>
              </div>
              <div>
                <form action="" class="form-horizontal">
                  <div class="form-group">
                    <div class="col-md-2 flex-end">
                      <input v-model="perpanjang" selected class="minimal-red" id="ext" type="radio" name="perpanjang" value="1">
                    </div>
                    <label for="ext" class="label-control col-md-3">
                      Diperpanjang
                    </label>
                    <div class="col-md-3">
                      <input v-model="state.usulan" :disabled="perpanjang == '0'" class="form-control" type="number" min="1" max="24">
                    </div>
                    <label class="label-control col-md-2">
                      Bulan
                    </label>
                  </div>
                  <div class="form-group">
                    <div class="col-md-2 flex-end">
                      <input v-model="perpanjang" class="" id="no-ext" type="radio" name="perpanjang" value="0" selected>
                    </div>
                    <label for="no-ext" class="label-control col-md-8">
                      Tidak Diperpanjang
                    </label>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-lg-6" v-bind:class="{ 'disabled-div': !state.worker.noind }">
              <div class="bg-primary" style="padding: 5px 1em; border-radius: 8px; margin-bottom: 1em;">
                <span>Approval</span>
              </div>
              <div>
                <form action="" class="form-horizontal">
                  <div class="form-group">
                    <label class="col-lg-4 control-label" for="">Unit/Bidang</label>
                    <div class="col-lg-8">
                      <select id="atasan-unit" class="form-control">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-4 control-label" for="">Departemen</label>
                    <div class="col-lg-8">
                      <select id="atasan-departemen" class="form-control">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12 center mt-2 mb-2" v-bind:class="{ 'disabled-div': !state.worker.noind }">
            <button :disabled="disableButton" @click="handleSave" class="btn btn-primary">
              Simpan <i class="fa fa-save"></i>
            </button>
            <button :disabled="disableButton" @click="handlePreview" class="btn btn-success">
              Preview <i class="fa fa-eye"></i>
            </button>
            <button :disabled="disableButton" @click="resetForm" class="btn btn-danger">Reset</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="<?= base_url('assets/plugins/vue/vue@2.6.11.js') ?>"></script>
<script>
  var basesite = '<?= base_url() ?>'
  const d = document
  const w = window

  $(() => {
    const workerSelect = $('#worker-select')

    workerSelect.select2({
      placeholder: 'Cari Pekerja',
    })

    workerSelect.on('change', function() {
      const selected = this.value
      if (!selected) return

      vueApp.getWorkerInformation(selected)
    })
  })
</script>
<script>
  const initialState = () => ({
    worker: {

    },
    atasan: '',
    pekerja: '',
    usulan: 1,
    approval1: '',
    approval2: '',
    approval3: 'HENDRO WIJAYANTO',
  })
  const vueApp = new Vue({
    el: '#app',
    data() {
      return {
        constant: {
          apiWorkerInformation: basesite + 'BlankoEvaluasi/api/workers/information',
          apiPreviewPdf: basesite + 'BlankoEvaluasi/Staff/Print',
          apiStore: basesite + 'BlankoEvaluasi/Staff/Store'
        },
        state: initialState(),
        perpanjang: '1',
        disableButton: false
      }
    },
    watch: {
      perpanjang(newval) {
        this.$data.state.usulan = newval == 0 ? 0 : 1
      }
    },
    methods: {
      _convertSelect(data = []) {
        return data.map(e => ({
          id: e.nama,
          text: e.noind + ' - ' + e.nama
        }))
      },
      resetForm() {
        window.location.reload()
      },
      checkForm() {
        if (!this.state.atasan) {
          return 'Berikan penilaian terhadap pekerja'
        }

        if (!this.state.approval1) {
          return ('Pilih approval unit / bidang terlebih dahulu')
        }

        if (!this.state.approval2) {
          return ('Pilih approval departemen terlebih dahulu')
        }
      },
      getFormJson() {
        const newState = {
          ...this.$data.state
        }
        delete newState.worker.atasan
        return newState
      },
      handleSave() {
        const check = this.checkForm()
        if (check) {
          return Swal.fire(check, '', 'warning')
        }
        this.$data.disableButton = true
        // do save
        const json = this.getFormJson()
        const parsedUrl = this.$data.constant.apiStore + '?' + $.param(json)
        window.location.href = parsedUrl
      },
      handlePreview() {
        const check = this.checkForm()
        if (check) {
          return Swal.fire(check, '', 'warning')
        }

        const json = this.getFormJson()
        const parsedUrl = this.$data.constant.apiPreviewPdf + '?' + $.param(json)
        window.open(parsedUrl, '_blank')
      },
      getWorkerInformation(props = null) {
        const self = this
        const {
          apiWorkerInformation
        } = this.$data.constant
        // use async if using babel, want to try ?
        fetch(`${apiWorkerInformation}?noind=${props}`)
          .then(e => e.json())
          .then(result => {
            const {
              error,
              message,
              data
            } = result

            if (error) return alert(message)

            self.handleAtasan(data.atasan)
            // delete data.atasan
            self.$data.state.worker = data
          }).catch(e => {
            alert("Gagal mengambil data, periksa koneksi anda")
          })
      },
      handleAtasan(prop = null) {
        if (!prop) return
        const self = this
        const {
          kasie,
          unit,
          bidang,
          dept
        } = prop

        const dataKasie = this._convertSelect(kasie)
        const dataUnit = this._convertSelect(unit).concat(this._convertSelect(bidang))
        const dataDept = this._convertSelect(dept)
        const empty = {
          id: '',
          text: ''
        }

        // using select2 jquery, so also using that
        const selectKasie = $('#atasan-seksi')
        const selectUnit = $('#atasan-unit')
        const selectDept = $('#atasan-departemen')

        // ------------------------
        // selectKasie.empty().trigger('change')
        // selectKasie.select2({
        //   placeholder: 'Kasie',
        //   data: [empty, ...dataKasie]
        // })
        // selectKasie.on('change', function() {
        //   self.$data.state.four.kasie = this.value
        // })

        // -------------------------
        selectUnit.empty().trigger('change')
        selectUnit.select2({
          placeholder: 'Unit',
          data: [empty, ...dataUnit]
        })
        selectUnit.attr('disabled', !dataUnit.length)
        selectUnit.on('change', function() {
          self.$data.state.approval1 = this.value
        })

        // ---------------------------
        selectDept.empty().trigger('change')
        selectDept.select2({
          placeholder: 'Departemen',
          data: [empty, ...dataDept]
        })
        selectDept.on('change', function() {
          self.$data.state.approval2 = this.value
        })
      }
    }
  })
</script>