<style>
    .textareax {
        width: 100%;
        min-width: 100%;
        resize: vertical;
        height: 100px;
        min-height: 100px;
        max-height: 500px;
    }
    
    .bold {
        font-weight: bold;
    }
    
    footer {
        display: none;
    }
    
    [v-cloak] {
        display: none;
    }
    
    .select2 {
        width: 100% !important;
    }
</style>
<section id="root" v-cloak style="margin-top: 2em;">
    <div class="col-lg-12">
        <div class="box box-default" style="border-radius: 5px;">
            <div class="box-header with-border">
                <h2 class="box-title bold">Menambahkan akun / responsbility batch</h2>
            </div>
            <div class="box-body">
                <!-- <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Pilih mode</label>
                        <input type="radio" name="mode" id=""> Manual
                        <input type="radio" name="mode" id=""> Custom
                    </div>
                </div> -->

                <form @submit.prevent class="form">
                    <div class="form-group">
                        <textarea :disabled="disabled.textarea" v-model="input" v-on:change="format" style="border-radius: 8px;" class="form-control textareax" name="" id="" placeholder="example: H3333 H4444 H5555"></textarea>
                    </div>
                    <div v-show="showHasil" v-cloak class="form-group">
                        <table class="table table-bordered table-hover text-center" style="table-layout: fixed;" name="tblUserResponsbility" id="tblUserResponsbility">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="60%">Responsibility</th>
                                    <th width="10%">Lokal</th>
                                    <th width="10%">Internet</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyUserResponsibility">
                                <tr class="clone">
                                    <td>
                                        <select v-model="responsibility.id" width="100%" class="form-control select4" name="" id="slcUserResponsbility" required>
                                            <option value=""></option>
                                            <option v-for="item in listResponsibility" :value="item.user_group_menu_id">{{ item.user_group_menu_name }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select v-model="responsibility.local" class="form-control select4" name="" id="slcLokal" required>
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select v-model="responsibility.inet" class="form-control select4" name="" id="slcInternet" required>
                                            <option value="" ></option>
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button :disabled="disabled.reset" v-on:click.prevent="reset" class="btn btn-danger" style="margin-top: 1em; float: left">Reset</button>
                        <button :disabled="disabled.preview" v-on:click.prevent="preview" class="btn btn-primary" style="margin-top: 1em; float: right">Preview</button>
                        <button :disabled="disabled.process" v-on:click.prevent="finalProcess" type="submit" v-if="showHasil" class="btn btn-success" style="margin-top: 1em; margin-right: 10px; float: right">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div v-if="showHasil" v-cloak class="col-lg-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title bold" style="float: left;">Preview Pekerja</h2>
                <h2 class="box-title bold" style="float: right;">Jumlah : {{ previewPerson.length }} Pekerja</h2>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered">
                    <thead class="bg-primary">
                        <td>No induk</td>
                        <td>Nama</td>
                        <td>Punya akun</td>
                        <td>Seksi</td>
                    </thead>
                    <tbody>
                        <tr v-for="person in previewPerson">
                            <td>{{ person.noind }}</td>
                            <td>{{ person.name }}</td>
                            <td>{{ person.account ? 'ya' : '' }}</td>
                            <td>{{ person.seksi }}</td>
                        </tr>
                        <tr v-if="!previewPerson.length">
                            <td colspan="4" style="text-align: center;">tidak ada pekerja yang ditemukan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<script src="<?= base_url('assets/plugins/vue/vue@2.6.11.js') ?>"></script>
<script src="<?= base_url('assets/plugins/axios/axios.min.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#slcUserResponsbility').on('change', function() {
            root.$data.responsibility.id = $(this).val()
        })

        $('#slcLokal').on('change', function() {
            root.$data.responsibility.local = $(this).val()
        })
        $('#slcInternet').on('change', function() {
            root.$data.responsibility.inet = $(this).val()
        })
    })

    Vue.component('Manual', {

    })

    var baseurlx = "<?= base_url() ?>"
    const root = new Vue({
        el: '#root',
        name: 'Root of eternity',
        data() {
            return {
                input: '',
                responsibility: {
                    id: '',
                    local: '',
                    inet: ''
                },
                showHasil: false,
                previewPerson: [],
                listResponsibility: [],
                disabled: {
                    preview: true,
                    process: true,
                    reset: true,
                    textarea: false
                }
            }
        },
        watch: {
            input() {
                this.disabled.preview = !this.input
                this.disabled.reset = !this.input

                // set url string without reload
                let params = $.param({
                    noind: this.input
                })

                let pathname = window.location.pathname + '?' + params
                window.history.replaceState(null, null, pathname);
                //
            },
            showHasil() {
                this.disabled.textarea = this.showHasil
                this.disabled.process = !this.showHasil
                this.disabled.preview = this.showHasil
            },
            previewPerson() {
                this.disabled.process = !this.previewPerson.length
            }
        },
        computed: {

        },
        methods: {
            reset() {
                // if (!confirm("yakin untuk mereset ?")) return

                this.input = ''
                this.showHasil = false
                this.previewPerson = []

                $('#slcUserResponsbility').select2('val', '')
                $('#slcLokal').select2('val', '')
                $('#slcInternet').select2('val', '')
            },
            format() {
                this.input = this.input.replace(/(\r\n|\n|\r|\s\s+|[^A-Za-z0-9])/gm, " ").trim().toUpperCase()
            },
            validation() {
                // get char selain A-Z dan 
                let case1 = this.input.match(/[^A-Z0-9\s]/g)
                let case2 = !this.input

                // return boolean
                return case1 || case2
            },
            preview() {
                if (this.validation()) return false

                const urlApi = baseurlx + 'SystemAdministration/Batch/api/preview_person'

                axios.get(urlApi, {
                    params: {
                        'noind': this.input
                    }
                }).then((res) => {
                    const {
                        success,
                        data
                    } = res.data

                    if (!success) {
                        this.previewPerson = []

                        this.displayError = true
                    } else {
                        this.previewPerson = data
                        window.scrollTo(0, 250)
                    }
                })

                this.showHasil = true
            },
            finalProcess() {
                // validation
                const vm = this

                if (!this.responsibility.id || !this.responsibility.inet || !this.responsibility.local) {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    }).fire({
                        customClass: 'swal-font-small',
                        type: 'error',
                        title: 'Silahkan melengkapi konfigurasi responsibility'
                    });

                    return
                }

                if (!confirm("yakin untuk menambahkan ?")) return

                const url = baseurlx + 'SystemAdministration/Batch/api/input'

                // actually i hate it
                $.ajax({
                    url,
                    data: {
                        noind: vm.input,
                        inet: vm.responsibility.inet,
                        local: vm.responsibility.local,
                        res_id: vm.responsibility.id
                    },
                    dataType: 'json',
                    method: 'POST',
                    success: res => {
                        if (res.success) {
                            swal.fire(res.message, 'silahkan melakukan pengecekan manual', 'success').then(() => {
                                vm.reset()
                            })
                        } else {
                            swal.fire(res.message, '', 'error')
                        }
                    },
                    error: e => {
                        console.error(e)
                    }
                })
            }
        },
        created() {
            const vm = this
            axios.get(baseurlx + 'SystemAdministration/Batch/api/getResponsbility')
                .then(res => {
                    vm.listResponsibility = res.data
                })
        },
        mounted() {
            var url_string = window.location.href
            var url = new URL(url_string);
            var c = url.searchParams.get("noind");
            if (c) {
                this.input = c
                this.preview()
            }
        }
    })
</script>