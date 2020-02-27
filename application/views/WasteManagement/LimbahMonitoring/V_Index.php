<style>
    [v-cloak] {
        display: none;
    }
    
    html {
        scroll-behavior: smooth;
    }
</style>
<section class="content" id="root">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3><b>Monitoring Limbah</b></h3>
                            </div>
                            <div class="box-body text-center">
                                <div class="" style="margin: 0 auto; width: 40em;">
                                    <div class="box box-solid box-primary">
                                        <label style="font-size:20px;" class="bg-primary text-center col-lg-12">Monitoring</label>
                                        <form v-on:submit.prevent="getMonitoring">
                                            <div class="row">
                                                <div class="form-group col-lg-12" style="margin-top:5px;">
                                                    <label class="control-label col-lg-2">Periode</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="" id="periodeLimbah1" class="date form-control" required autocomplete="off" placeholder="Periode awal">
                                                    </div>
                                                    <span class="col-lg-1" style="padding: 5px;">s/d</span>
                                                    <div class="col-lg-4">
                                                        <input type="text " name=" " id="periodeLimbah2" class="date form-control " required autocomplete="off" placeholder="Periode akhir ">
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <label class="control-label col-lg-2 "> Jenis Limbah</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-control select2" multiple name="jenisLimbah" id="jenisLimbah">
															<?php foreach($jenisLimbah as $limbah): ?>
															<option value="<?= $limbah['id_jenis_limbah'] ?>"><?= $limbah['kode_limbah'].' - '.$limbah['jenis_limbah'] ?></option>
															<?php endforeach; ?>
														</select>
                                                        <small style="color: red; float: left;">*Kosongkan bila pilih semua jenis</small>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <div class="col-lg-2"></div>
                                                    <div class="col-lg-4 text-left">
                                                        <input class="checkbox" type="checkbox" name="detail" id="detailed">
                                                        <label for="">Detail</label>
                                                    </div>
                                                    <div class="col-lg-5 text-right">
                                                        <button type="submit" class="btn btn-info">
															<i v-if="isLoading" class="fa fa-spin fa-spinner"></i>
															<span v-else>Proses</span>
														</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-cloak v-if="dataLimbah.length || isDataLimbahEmpty" id="dataLimbah" class="col-lg-12">
                        <div class="box box-primary box-solid ">
                            <div class="box-header with-border ">
                                <a v-if="dataLimbah.length" :href="urlExport" id="exportExcel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            </div>
                            <div class="box-body">
                                <div v-if="dataLimbah.length" class="table-responsive ">
                                    <table id="tableLimbah" class="table table-striped table-bordered table-hover text-left" style="font-size: 12px; width: 600px; margin: 0 auto;">
                                        <thead class="bg-primary ">
                                            <tr>
                                                <td width="5%">No</td>
                                                <td>Jenis Limbah</td>
                                                <td v-if="detailed">Tanggal Masuk</td>
                                                <td v-if="detailed">Seksi Pengirim</td>
                                                <td width="7%">Berat(Kg)</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) of dataLimbah">
                                                <td>{{ index+1 }}</td>
                                                <td>{{ item.jenis_limbah }}</td>
                                                <td v-if="detailed">{{ item.tanggal_kirim }}</td>
                                                <td v-if="detailed">{{ item.section_name }}</td>
                                                <td>{{ item.berat_kirim }}</td>
                                            </tr>
                                            <tr>
                                                <td :colspan="detailed ? 4 : 2">Total Berat Limbah</td>
                                                <td>{{ beratTotal }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="isDataLimbahEmpty">
                                    <div class="text-center">
                                        Tidak ada data
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('assets/plugins/vue/vue@2.6.11.js') ?>"></script>
<script src="<?= base_url('assets/plugins/axios/axios.min.js') ?>"></script>

<script>
    var rooturl = '<?= base_url() ?>'

    document.addEventListener('DOMContentLoaded', () => {
        $('#periodeLimbah1, #periodeLimbah2').datepicker({
            todayHighlight: true,
            format: 'dd-mm-yyyy'
        })

        $('#jenisLimbah').select2({
            placeholder: 'Jenis Limbah'
        })

        // change vue use jquery
        $('#periodeLimbah1').on('change', function() {
            root.params.start = $(this).val()
        })

        $('#periodeLimbah2').on('change', function() {
            root.params.end = $(this).val()
        })

        $('#jenisLimbah').on('change', function() {
            root.params.jenis = $(this).val()
        })

        $('#detailed').on('ifChecked ifUnchecked', function() {
            root.$data.detailed = !root.$data.detailed
            console.log("changed")
        })
    })

    // lets vue time
    const root = new Vue({
        name: 'Root of element',
        el: "#root",
        data() {
            return {
                params: {
                    start: '',
                    end: '',
                    jenis: []
                },
                dataLimbah: [],
                isDataLimbahEmpty: false,
                detailed: false,
                isLoading: false
            }
        },
        methods: {
            getMonitoring() {
                let vm = this
                const url = rooturl + 'WasteManagement/MonitoringLimbah/api/getDataLimbah'

                vm.isDataLimbahEmpty = false
                vm.isLoading = true
                vm.dataLimbah = []

                axios.get(url, {
                    params: {
                        start: vm.params.start,
                        end: vm.params.end,
                        jenis: vm.params.jenis,
                        detailed: vm.detailed
                    }
                }).then(res => {
                    if (res.data.success) {
                        vm.dataLimbah = res.data.data
                    } else {
                        new Error('Terjadi kesalahan, coba reload browser')
                    }

                    if (res.data.data.length == 0) {
                        vm.isDataLimbahEmpty = true
                    }

                    vm.isLoading = false

                    if (vm.dataLimbah.length > 0) {
                        window.scrollTo(0, 350)
                    }

                }).catch(e => {
                    alert(e)
                })
            }
        },
        computed: {
            beratTotal() {
                let beratTotal = 0
                for (item of this.$data.dataLimbah) {
                    beratTotal += parseFloat(item.berat_kirim)
                }
                return beratTotal.toFixed(3)
            },
            urlExport() {
                const vm = this
                let urlExport = baseurl + 'WasteManagement/MonitoringLimbah/CetakExcel?'

                let params = {
                    start: vm.params.start,
                    end: vm.params.end,
                    jenis: vm.params.jenis,
                    detailed: vm.detailed ? 1 : 0
                }

                return urlExport + $.param(params)
            }
        }
    })
</script>