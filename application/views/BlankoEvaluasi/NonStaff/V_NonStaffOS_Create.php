<style>
html {
  scroll-behavior: smooth;
}

.flex-row {
  display: flex;
  flex-direction: row;
}

.bold {
  font-weight: bold;
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

[v-cloak] {
  display: none;
}
</style>
<section id="app">
  <div class="row" style="margin: 1em;">
    <div class="box">
      <div class="box-header">
        <h3>Buat Blanko Evaluasi Non Staf dan Outsourcing</h3>
      </div>
      <div class="box-body">
        <div style="position: fixed; right: 0; top: 30%;">
          <div class="navbar-float" style="background-color: #3c8dbc; width: 3em; display: flex; flex-direction: column; border-radius: 8px 0 0 8px;">
            <a style="text-decoration: none; color: white;" href="#one">
              <div style="padding: 1em;">
                <span>I</span>
              </div>
            </a>
            <a style="text-decoration: none; color: white;" href="#two">
              <div style="padding: 1em;">
                <span>II</span>
              </div>
            </a>
            <a style="text-decoration: none; color: white;" href="#three">
              <div style="padding: 1em;">
                <span>III</span>
              </div>
            </a>
            <a style="text-decoration: none; color: white;" href="#four">
              <div style="padding: 1em;">
                <span>IV</span>
              </div>
            </a>
          </div>
        </div>
        <div id="one">
          <div class="bg-primary" style="padding: 1em;">
            <span>I. DATA PEKERJA</span>
          </div>
          <div style="padding: 1em 2em;">
            <form action="" class="form-horizontal">
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Nama</label>
                <div class="col-lg-3">
                  <select class="form-control" name="" id="worker-select">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">No Induk</label>
                <div class="col-lg-3">
                  <input v-model="state.worker.noind" class="form-control" type="text" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Seksi/Unit/Departemen</label>
                <div class="col-lg-3">
                  <input v-model="state.worker.seksi" class="form-control" type="text" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Nama/Jenis Pekerjaan</label>
                <div class="col-lg-3">
                  <input v-model="state.worker.pekerjaan" class="form-control" type="text" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Masa Kerja</label>
                <div class="col-lg-3">
                  <input v-model="state.worker.masa_kerja" class="form-control" type="text" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Tanggal Akhir Kontrak</label>
                <div class="col-lg-3">
                  <input v-model="state.worker.akhir_kontrak" class="form-control" type="text" readonly>
                </div>
              </div>
              <div v-cloak class="form-group">
                <label class="col-lg-2 control-label" for="">Periode Penarikan Data</label>
                <div class="col-lg-3">
                  <input :value="state.worker.periode_awal" v-show="state.worker.periode_awal && utils.disableInputPeriode1" class="form-control" type="text" readonly>
                  <input v-show="!utils.disableInputPeriode1" type="text" id="periode-awal" autocomplete="off" placeholder="Periode awal" class="form-control datepicker1">
                </div>
                <div class="col-lg-3">
                  <input type="text" id="periode-akhir" autocomplete="off" placeholder="Periode akhir" class="form-control datepicker2">
                </div>
                <div class="col-lg-3">
                  <button type="button" @click="handleCheckPresence" v-show="state.worker.periode_akhir" class="btn btn-md btn-success" :disabled="state.worker.presensi_ok == 'loading'">
                    Cek presensi
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="two">
          <div class="bg-primary" style="padding: 1em;">
            <span>II. EVALUASI PEKERJA</span>
          </div>
          <div style="padding: 1em 2em;">
            <form action="" class="form-horizontal">
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Kehadiran / Presensi</label>
                <div v-cloak class="col-lg-3">
                  <label class="control-label with-bg">
                    <span v-if="state.worker.presensi_ok == 'loading'"><i class="fa fa-spinner fa-pulse"></i></span>
                    <span v-else-if="state.worker.presensi_ok === true">OK <i class="fa fa-check-circle" style="color: green;"></i></span>
                    <span v-else-if="state.worker.presensi_ok === false">TIDAK OK <i class="fa fa-close" style="color: red;"></i></span>
                  </label>
                  <label style="padding-left: 1em;" for="" class="control-label">
                    <button type="button" data-toggle="popover" title="Skala Penilaian">
                      <i class="fa fa-question-circle"></i>
                    </button>
                  </label>
                </div>
              </div>
            </form>
            <table class="table table-bordered table-info">
              <thead>
                <tr class="bg-primary">
                  <th>ASPEK PENILAIAN</th>
                  <th>BUKTI PERILAKU(ISI DENGAN KEADAAN DILAPANGAN)</th>
                  <th>NILAI (Skor)</th>
                  <th>PERTIMBANGAN</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1. HARD SKILL/KEMAMPUAN TEKNIS</td>
                  <td class="p-0">
                    <textarea v-model="state.two.nilai[0].bukti" class="form-control evaluasi-limiter" placeholder="ketik disini ..." style="border: none; resize: vertical; max-height: 6em; min-height: 3em; height: 100%; width: 100%;" name="" id="" cols="20" rows="2"></textarea>
                  </td>
                  <td>
                    <select v-model="state.two.nilai[0].skor" class="select form-control" placeholder="nilai" name="" id="">
                      <option value="5">5 (Baik Sekali)</option>
                      <option value="4">4 (Baik)</option>
                      <option value="3">3 (Cukup)</option>
                      <option value="2">2 (Kurang)</option>
                      <option value="1">1 (Kurang Sekali)</option>
                    </select>
                  </td>
                  <td rowspan="5">
                    <textarea v-model="state.two.pertimbangan" class="form-control" placeholder="ketik disini ..." style="border: none; resize: none; height: 100%; width: 100%;" rows="12" name="" id=""></textarea>
                  </td>
                </tr>
                <tr>
                  <td>2. PERILAKU</td>
                  <td class="p-0">
                    <textarea v-model="state.two.nilai[1].bukti" class="form-control evaluasi-limiter" placeholder="ketik disini ..." style="border: none; resize: vertical; max-height: 6em; min-height: 3em; height: 100%; width: 100%;" name="" id="" cols="20" rows="2"></textarea>
                  </td>
                  <td>
                    <select v-model="state.two.nilai[1].skor" class="select form-control" placeholder="nilai">
                      <option value="5">5 (Baik Sekali)</option>
                      <option value="4">4 (Baik)</option>
                      <option value="3">3 (Cukup)</option>
                      <option value="2">2 (Kurang)</option>
                      <option value="1">1 (Kurang Sekali)</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>3. KAIZEN</td>
                  <td class="p-0">
                    <textarea v-model="state.two.nilai[2].bukti" class="form-control evaluasi-limiter" placeholder="ketik disini ..." style="border: none; resize: vertical; max-height: 6em; min-height: 3em; height: 100%; width: 100%;" name="" id="" cols="20" rows="2"></textarea>
                  </td>
                  <td>
                    <select v-model="state.two.nilai[2].skor" class="select form-control" placeholder="nilai">
                      <option value="5">5 (Baik Sekali)</option>
                      <option value="4">4 (Baik)</option>
                      <option value="3">3 (Cukup)</option>
                      <option value="2">2 (Kurang)</option>
                      <option value="1">1 (Kurang Sekali)</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>4. PRESTASI KERJA</td>
                  <td class="p-0">
                    <textarea v-model="state.two.nilai[3].bukti" class="form-control evaluasi-limiter" placeholder="ketik disini ..." style="border: none; resize: vertical; max-height: 6em; min-height: 3em; height: 100%; width: 100%;" name="" id="" cols="20" rows="2"></textarea>
                  </td>
                  <td>
                    <select v-model="state.two.nilai[3].skor" class="select form-control" placeholder="nilai">
                      <option value="5">5 (Baik Sekali)</option>
                      <option value="4">4 (Baik)</option>
                      <option value="3">3 (Cukup)</option>
                      <option value="2">2 (Kurang)</option>
                      <option value="1">1 (Kurang Sekali)</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>5. KERJASAMA</td>
                  <td class="p-0">
                    <textarea v-model="state.two.nilai[4].bukti" class="form-control evaluasi-limiter" placeholder="ketik disini ..." style="border: none; resize: vertical; max-height: 6em; min-height: 3em; height: 100%; width: 100%;" name="" id="" cols="20" rows="2"></textarea>
                  </td>
                  <td>
                    <select v-model="state.two.nilai[4].skor" class="select form-control" placeholder="nilai" name="" id="">
                      <option value="5">5 (Baik Sekali)</option>
                      <option value="4">4 (Baik)</option>
                      <option value="3">3 (Cukup)</option>
                      <option value="2">2 (Kurang)</option>
                      <option value="1">1 (Kurang Sekali)</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div id="three">
          <div class="bg-primary" style="padding: 1em;">
            <span>III. PROGRAM PENGEMBANGAN DAN PERNYATAAN PEKERJA</span>
          </div>
          <div style="padding: 1em 2em;">
            <form action="" class="form-horizontal">
              <div class="form-group">
                <div class="col-lg-5 flex-row">
                  <span class="mr-2 bold">1</span>
                  <div>
                    <textarea v-model="state.three[0].text" placeholder="Ketik disini ..." style="min-height: 50px; max-height: 80px; min-width: 30em; max-width: 40em;" class="form-control program-limiter" name="" id="" cols="30" rows="3"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-5 flex-row">
                  <span class="mr-2 bold">2</span>
                  <div>
                    <textarea v-model="state.three[1].text" placeholder="Ketik disini ..." style="min-height: 50px; max-height: 80px; min-width: 30em; max-width: 40em;" class="form-control program-limiter" name="" id="" cols="30" rows="3"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-5 flex-row">
                  <span class="mr-2 bold">3</span>
                  <div>
                    <textarea v-model="state.three[2].text" placeholder="Ketik disini ..." style="min-height: 50px; max-height: 80px; min-width: 30em; max-width: 40em;" class="form-control program-limiter" name="" id="" cols="30" rows="3"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="four">
          <div class="bg-primary" style="padding: 1em;">
            <span>IV. USULAN ATASAN</span>
          </div>
          <div style="padding: 1em 2em;">
            <form action="" class="form-horizontal">
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Penilai</label>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Supervisor</label>
                <div class="col-lg-3">
                  <select id="atasan-supervisor" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Kepala Seksi</label>
                <div class="col-lg-3">
                  <select id="atasan-seksi" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Usulan Perpanjangan</label>
                <div class="col-lg-1" style="padding-right: 0;">
                  <input v-model="state.four.usulan" class="form-control" type="number" min="1">
                </div>
                <div class="col-lg-2" style="padding-left: 0;">
                  <label class="col-lg-2 control-label" for="">Bulan</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="">Unit</label>
                <div class="col-lg-3">
                  <select id="atasan-unit" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div v-if="!state.worker.kd_jabatan == '18' || state.worker.presensi_ok == false" class="form-group">
                <label class="col-lg-2 control-label" for="">Departemen</label>
                <div class="col-lg-3">
                  <select id="atasan-departemen" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </form>
          </div>
        </div>
        <hr>
        <div class="row" style="margin-top: 3em;">
          <div class="col-lg-4"></div>
          <div class="col-lg-4" style="display: flex; justify-content: center;">
            <button v-on:click="handleSave" class="btn btn-primary mr-2" :disabled="state.worker.presensi_ok === null">
              Simpan <i class="fa fa-save"></i>
            </button>
            <button type="button" target="_blank" v-on:click="handlePreview" class="btn btn-success mr-2" :disabled="state.worker.presensi_ok === null">
              Preview
            </button>
            <button v-on:click="resetForm()" class="btn btn-danger">
              Reset
            </button>
          </div>
          <div class="col-lg-4"></div>
        </div>
        <div class="row">
          <div class="col-lg-12" style="height: 4em;">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="popover_content_skala_penilaian" style="display: none;">
  <table class="bordered">
    <tbody>
      <tr class="centered">
        <th colspan="5">SKALA PENILAIAN</th>
      </tr>
      <tr class="centered">
        <td class="bold">NILAI PRESENSI</td>
        <td class="bold" width="5px" rowspan="2">∑ Tot. Frek.</td>
        <td class="bold">Nilai Presensi</td>
        <td class="bold" width="140px;" colspan="2">∑ Total Frekuensi</td>
      </tr>
      <tr>
        <td class="center bold">OS</td>
        <td class="center bold">Kontrak</td>
        <td class="center bold">TIM</td>
        <td class="center bold">TIMS</td>
      </tr>
      <tr class="centered">
        <td>OK</td>
        <td>≤5</td>
        <td>OK</td>
        <td>≤15</td>
        <td>≤20</td>
      </tr>
      <tr class="centered">
        <td>NOT OK</td>
        <td>>5</td>
        <td>NOT OK</td>
        <td>>15</td>
        <td>>20</td>
      </tr>
      <tr class="centered">
        <td colspan="5"><i>Syarat perpanjangan status : Aspek Kehadiran "OK"</i></td>
      </tr>
    </tbody>
  </table>
</div>
<script src="<?= base_url('assets/plugins/vue/vue@2.6.11.js') ?>"></script>
<script>
// if vanilla can, why not ?
const d = document
const w = window

$(() => {
  $('.evaluasi-limiter').inputlimiter({
    limit: 106,
    remText: '%n /',
    remFullText: 'Telah mencapai Limit karakter',
    limitText: '%n',
    boxId: 'span',
  })
  $('.program-limiter').inputlimiter({
    limit: 122,
    remText: '%n /',
    remFullText: 'Telah mencapai Limit karakter',
    limitText: '%n',
  })
  $('[data-toggle="popover"]').popover({
    trigger: 'focus',
    html: true,
    content: function() {
      return $('#popover_content_skala_penilaian').html();
    }
  })
  $('.datepicker1, .datepicker2').datepicker({
    changeYear: true,
    format: 'dd-mm-yyyy',
    todayHighlight: true
  })
  $('#periode-awal').on('change', (e) => vueApp.$data.state.worker.periode_awal = e.target.value)
  $('#periode-akhir').on('change', (e) => vueApp.$data.state.worker.periode_akhir = e.target.value)
})
// SCROLL SPY
d.addEventListener('DOMContentLoaded', function() {
  // prevent on click 
  d.querySelectorAll('.navbar-float > a').forEach(element => {
    element.addEventListener('click', e => {
      e.preventDefault()
      const id = element.getAttribute('href')
      w.scrollTo(0, d.querySelector(id).offsetTop)
    })
  })

  // make an array
  let spyElement = []
  d.querySelectorAll('#one, #two, #three, #four').forEach(element => {
    const elementHeight = element.offsetTop
    const elementId = element.getAttribute('id')
    spyElement.push({
      elementHeight,
      elementId
    })
  })

  // handleSpy
  const handleSpy = () => {
    const scrollHeight = window.scrollY
    let isState = false
    spyElement.forEach(e => {
      if (!isState && scrollHeight >= e.elementHeight - 100) {
        const active = d.querySelector('.navbar-float > a.active')
        active ? active.classList.remove('active') : null

        const activeElement = d.querySelector(`.navbar-float > a[href="#${e.elementId}"]`)
        activeElement ? activeElement.classList.toggle('active') : null
        isState = false
      }
    })
  }

  // call onload
  handleSpy()
  // handle onscroll
  w.onscroll = () => {
    handleSpy()
  }
})
</script>
<script>
const basesite = '<?= base_url() ?>'

// listener on worker select
$(() => {
  const workerSelect = $('#worker-select')

  workerSelect.select2({
    placeholder: 'Cari Pekerja',
    minimumInputLength: 3,
    ajax: {
      url: baseurl + 'BlankoEvaluasi/api/workers',
      dataType: 'json',
      data: params => {
        return {
          keyword: params.term,
          position: 'nonstaff',
          filterSie: 1
        }
      },
      processResults: (response) => {
        const {
          error,
          data
        } = response

        if (error) alert("Gagal mengambil data pekerja")

        return {
          results: data.map(e => {
            return {
              id: e.noind,
              text: e.noind + ' - ' + e.nama
            }
          })
        }
      }
    }
  })

  workerSelect.on('change', function() {
    const selected = this.value
    if (!selected) return

    vueApp.getWorkerInformation(selected)
  })
})

const initialState = () => ({
  worker: {
    noind: null,
    nama: null,
    seksi: null,
    pekerjaan: null,
    masa_kerja: null,
    akhir_kontrak: null,
    periode_awal: null,
    periode_akhir: null,
    presensi_ok: null
  },
  two: {
    nilai: [{
        no: 1,
        bukti: null,
        skor: 5,
      },
      {
        no: 2,
        bukti: null,
        skor: 5,
      },
      {
        no: 3,
        bukti: null,
        skor: 5,
      },
      {
        no: 4,
        bukti: null,
        skor: 5,
      },
      {
        no: 5,
        bukti: null,
        skor: 5,
      }
    ],
    pertimbangan: ""
  },
  three: [{
      no: 1,
      text: null
    },
    {
      no: 2,
      text: null
    },
    {
      no: 3,
      text: null
    }
  ],
  four: {
    penilai: '',
    supervisor: '',
    kasie: '',
    usulan: null,
    unit: '',
    dept: ''
  }
})

// this is vue working
const vueApp = new Vue({
  name: 'Non Staff',
  el: '#app',
  data() {
    return {
      constant: {
        apiWorkerInformation: basesite + 'BlankoEvaluasi/api/workers/information',
        apiTIMS: basesite + 'BlankoEvaluasi/api/tims',
        apiTIMSCalculation: basesite + 'BlankoEvaluasi/api/tims/calculation'
      },
      utils: {
        disableInputPeriode1: false
      },
      state: initialState()
    }
  },
  computed: {
    urlPreview() {
      return basesite + 'BlankoEvaluasi/NonStaff/Print?' + $.param(this.$data.state)
    },
    urlSave() {
      return basesite + 'BlankoEvaluasi/NonStaff/Store?' + $.param(this.$data.state)
    }
  },
  watch: {
    state: {
      handler: function(newState, oldState) {
        const newStartPeriode = newState.worker.periode_awal
        if (!newStartPeriode) return
        const formattedDate = new Date(newStartPeriode.split('-').reverse().join('-'))
        formattedDate.setDate(formattedDate.getDate() + 1)
        formattedDate.toLocaleDateString()

        if (newStartPeriode) {
          $('.datepicker2').datepicker(
            'setStartDate',
            formattedDate
          )
        }
      },
      deep: true
    }
  },
  methods: {
    _convertSelect(data = []) {
      return data.map(e => ({
        id: e.nama,
        text: e.noind + ' - ' + e.nama
      }))
    },
    checkForm() {
      let error = null
      // form evaluasi
      const formTwo = this.$data.state.two
      const emptyColumn = formTwo.nilai.find(item => !item.bukti)

      if (emptyColumn || !formTwo.pertimbangan) {
        error = true
        Swal.fire('Lengkapi form evaluasi terlebih dahulu !!!', 'wajib diisi', 'error')
      }
      // form usulan atasan
      // check is empty select atasan or not
      const {
        supervisor: supervisorOption,
        kasie: kasieOption,
        unit: unitOption
      } = this.$data.state.worker.atasan
      const {
        supervisor: valSupervisor,
        kasie: valKasie,
        unit: valUnit
      } = this.$data.state.four

      const alertAtasan = () => {
        Swal.fire('Lengkapi form usulan atasan terlebih dahulu !!!', 'wajib diisi', 'error')
        error = true

        return error
      }

      if (!valSupervisor && supervisorOption.count === 0) return alertAtasan()
      if (!valKasie && kasieOption.count === 0) return alertAtasan()
      if (!valUnit && unitOption.count === 0) return alertAtasan()
    },
    handlePreview() {
      const errorCheckForm = this.checkForm()
      if (errorCheckForm) return

      window.open(
        this.urlPreview,
        '_blank'
      )
    },
    handleSave(e) {
      const self = this
      const errorCheckForm = this.checkForm()
      if (errorCheckForm) return

      Swal.fire({
        title: 'Yakin untuk menyimpan surat?',
        text: "Surat yang disimpan tidak dapat di hapus/diubah !!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.value) {
          window.location.href = self.urlSave
        } else {
          e.preventDefault()
        }
      })
    },
    handleCheckPresence() {
      // to show loading animation
      const worker = this.$data.state.worker
      const [from, to] = [
        new Date(worker.periode_awal.split('-').reverse().join('-')),
        new Date(worker.periode_akhir.split('-').reverse().join('-'))
      ]
      const isValid = (from <= to)

      if (!isValid) {
        this.$data.state.worker.presensi_ok = null
        return Swal.fire('Periode tidak valid', 'periode akhir harus lebih besar daripada peridoe awal', 'error')
      }

      this.$data.state.worker.presensi_ok = "loading"
      const fullApi = `${this.$data.constant.apiTIMSCalculation}?` + $.param({
        noind: worker.noind,
        from: worker.periode_awal,
        to: worker.periode_akhir,
        kd_jabatan: worker.kd_jabatan
      })

      fetch(fullApi)
        .then(e => e.json())
        .then(e => this.$data.state.worker.presensi_ok = e.data.passed)

    },
    resetForm() {
      Swal.fire({
        title: 'Yakin untuk mereset ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }).then(e => {
        if (!e.value) return

        this.$data.state = initialState()
        this.$data.utils.disableInputPeriode1 = false

        $('.datepicker1, .datepicker2').val(null)
        $('#worker-select').val(null).trigger('change')
        $('#atasan-supervisor, #atasan-seksi, #atasan-unit, #atasan-departemen').empty().val(null).trigger('change')
      })

    },
    handleUsulanAtasan(atasan = null) {
      if (!atasan) return
      const self = this

      const {
        supervisor,
        kasie,
        unit,
        dept
      } = atasan

      const dataSupervisor = this._convertSelect(supervisor)
      const dataKasie = this._convertSelect(kasie)
      const dataUnit = this._convertSelect(unit)
      const dataDept = this._convertSelect(dept)
      const empty = {
        id: '',
        text: ''
      }

      // using select2 jquery, so also using that
      const selectSupervisor = $('#atasan-supervisor')
      const selectKasie = $('#atasan-seksi')
      const selectUnit = $('#atasan-unit')
      const selectDept = $('#atasan-departemen')

      // ------------------------
      selectSupervisor.empty().trigger('change')
      selectSupervisor.select2({
        placeholder: 'Supervisor',
        data: [empty, ...dataSupervisor]
      })
      selectSupervisor.attr('disabled', !dataSupervisor.length)
      selectSupervisor.on('change', function() {
        self.$data.state.four.supervisor = this.value
      })

      // ------------------------
      selectKasie.empty().trigger('change')
      selectKasie.select2({
        placeholder: 'Kasie',
        data: [empty, ...dataKasie]
      })
      selectKasie.on('change', function() {
        self.$data.state.four.kasie = this.value
      })

      // -------------------------
      selectUnit.empty().trigger('change')
      selectUnit.select2({
        placeholder: 'Unit',
        data: [empty, ...dataUnit]
      })
      selectUnit.attr('disabled', !dataUnit.length)
      selectUnit.on('change', function() {
        self.$data.state.four.unit = this.value
      })

      // ---------------------------
      selectDept.empty().trigger('change')
      selectDept.select2({
        placeholder: 'Departemen',
        data: [empty, ...dataDept]
      })
      selectDept.on('change', function() {
        self.$data.state.four.dept = this.value
      })
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

          self.handleUsulanAtasan(data.atasan)
          // delete data.atasan
          self.$data.state.worker = {
            ...data
          }
          self.$data.utils.disableInputPeriode1 = !!self.$data.state.worker.periode_awal
        }).catch(e => {
          alert("Gagal mengambil data, periksa koneksi anda")
        })
    }
  }
})
</script>