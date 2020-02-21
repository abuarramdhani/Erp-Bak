// README : this is file js for Koperasi Application, this file is not included in V_Footer.php
//          so you must call this js manually, i hate all js loaded
// TODO   : make it simple as you can
// ABOUT  : use es6 syntax, Vue or Jquery its interesting, lets try it !!
// NOTE   : if you didn't know, i am also :D
// WRITER : DK


'use strict' // what is this? you must declarate variable like const, let, don't use var, read eslint :)

// HELPER
const _p2date = (p, r = false) => {
    let monthIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    let dt = p.split('-')

    if (dt.length < 2) return 'error format date'
    if (r) return monthIndo[dt[0] - 1] + ' ' + dt[1]

    return monthIndo[dt[1] - 1] + ' ' + dt[0]
}

const _numFormat = (val) => {
    if (!val) return ''
    return val.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

// VUE
// loading component
const loading = new Vue({
    el: '.loading',
    name: 'loading comp',
    data: {
        text: 'Memproses data ...',
        show: true,
        stickyHeader: false
    },
    methods: {
        show() {
            $('.loading').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
            })
        },
        hidden() {
            $('.loading').modal('hide')
        }
    }
})

// modalDetail component
const modalDetail = new Vue({
    name: 'Modal detail data',
    el: '#modalDetail',
    data() {
        return {
            dataTable: false,
            totalAll: false,
            message: 'sedang mengambil data ...',
            periode: '',
            search: ''
        }
    },
    methods: {
        show() {
            $('#modalDetail').modal({
                show: true
            })
        },
        close() {
            $('#modalDetail').modal('hide')
        },
        deleteMe(periode) {
            swal.fire({
                title: 'Yakin menghapus data ?',
                text: '.',
                type: 'question',
                showCancelButton: true
            }).then(res => {
                if (!res.value) return
                let uri = baseurl + 'Koperasi/api/delList'

                let formdata = new FormData()
                formdata.append('periode', periode)

                axios.post(uri, formdata).then(res => {
                    if (res.data.success) {
                        this.close()

                        // then refresh table
                        tableData.loadTable()
                    }
                })
            })
        }
    }
})

// modal Upload component
const modalUploadData = new Vue({
    name: 'modal upload',
    el: '#modalUploadData',
    data() {
        return {
            progressUpload: '0',
            progressColor: 'progress-bar',
            progress: false,
            uploadDisabled: false,
            data: {
                periode: '',
                file: ''
            },
            fixedPeriode: '',
            validation: {
                valid: true,
                message: '',
                color: ''
            },
            tablePreview: false,
            tableSum: false,
            tableLoading: false,
            modalContent: {
                type: 0, // 0: show form, 1: show message, 2: show loading
                status: null,
                message: null
            },
            iconPath: {
                fail: baseurl + 'assets/img/icon/failed.png',
                success: baseurl + 'assets/img/icon/success.png',
            }
        }
    },
    methods: {
        uploadBtn() {
            let that = this
            if (!this.data.periode || !this.data.files) {
                return this.validation = {
                    valid: false,
                    message: 'isi data dengan lengkap',
                    color: 'alert-danger'
                }
            } else {
                this.validation = {
                    valid: true,
                    message: '',
                    color: ''
                }
            }

            $('input').prop('disabled', true)

            this.progress = true
            this.uploadDisabled = true
            this.tablePreview = false

            // do the upload
            const uri_parse = baseurl + 'Koperasi/api/uploadData'
            const formData = new FormData()

            formData.append('periode', this.data.periode)
            formData.append('file', this.data.files)

            axios.post(uri_parse, formData, {
                onUploadProgress: event => {
                    let progress = Number(Math.round((event.loaded / event.total) * 100))

                    that.progress = true
                    that.progressUpload = progress
                    if (progress == 100) {
                        that.progressColor = 'progress-bar-success'
                        $('input').prop('disabled', false)
                        this.uploadDisabled = false
                        this.validation = {
                            valid: false,
                            message: 'Sukses upload file',
                            color: 'alert-success'
                        }
                        $('#table-preview').dataTable()
                    }
                }
            }).then(res => {
                if (!res.data.success) {
                    this.validation = {
                        valid: false,
                        message: res.data.message,
                        color: 'alert-danger'
                    }

                    this.tablePreview = false
                } else {
                    this.fixedPeriode = this.data.periode
                    this.tablePreview = res.data.message

                    let sumAll = {
                        s_pokok: 0,
                        s_wajib: 0,
                        s_sukarela: 0,
                        p_uang: 0,
                        b_uang: 0,
                        bpd_pmotor: 0,
                        bpd_adm: 0,
                        p_barang: 0,
                        b_barang: 0,
                        total: 0,
                        jumlah: 0,
                    }

                    for (let x in this.tablePreview) {
                        sumAll.s_pokok += Number(this.tablePreview[x].S_POKOK)
                        sumAll.s_wajib += Number(this.tablePreview[x].S_WAJIB)
                        sumAll.s_sukarela += Number(this.tablePreview[x].S_SUKARELA)
                        sumAll.p_uang += Number(this.tablePreview[x].P_UANG)
                        sumAll.b_uang += Number(this.tablePreview[x].B_UANG)
                        sumAll.bpd_pmotor += Number(this.tablePreview[x].BPD_PMOTOR)
                        sumAll.bpd_adm += Number(this.tablePreview[x].BPD_ADM)
                        sumAll.p_barang += Number(this.tablePreview[x].P_BARANG)
                        sumAll.b_barang += Number(this.tablePreview[x].P_BARANG)
                        sumAll.total += Number(this.tablePreview[x].TOTAL)
                        sumAll.jumlah += Number(this.tablePreview[x].JUMLAH)
                    }

                    this.tableSum = sumAll
                }
            })
        },
        filePreview(event) {
            let that = this

            // check file extension
            if (event.target.files.length == 0) return

            let extension = event.target.files[0].name.split('.').pop().toLowerCase()
            if (extension != 'dbf') {
                this.validation = {
                    valid: false,
                    message: 'Format file harus .dbf',
                    color: 'alert-danger'
                }
                this.uploadDisabled = true
                this.progress = false

                return false
            } else {
                this.validation = {
                    valid: true,
                    message: '',
                    color: ''
                }
                this.uploadDisabled = false
                this.progress = false
            }

            //declarate files data
            this.data.files = event.target.files[0]
        },
        saveData() {
            let that = this
            const uri = baseurl + 'Koperasi/api/saveData'
            const formData = new FormData()
            formData.append('periode', this.fixedPeriode)

            //show loading
            this.modalContent.type = 2
            axios.post(uri, formData).then(res => {
                that.modalContent.type = 1
                that.modalContent.status = (res.data.success) ? 'Success' : 'Gagal'
                that.modalContent.message = res.data.message

                // then refresh table
                tableData.loadTable()
            })
        }
    }
})

// reset state value on modalUpload component on click
const btnModal = new Vue({
    el: '#btnModalUpload',
    data: {
        pathTutorial: baseurl + 'assets/video/upload_data_koperasi.webm'
    },
    methods: {
        btnModalUpload() {
            $('#periode').val('')
            $('#fileinput').val('')
            modalUploadData.progressUpload = '0'
            modalUploadData.progressColor = 'progress-bar'
            modalUploadData.progress = false
            modalUploadData.uploadDisabled = false
            modalUploadData.data = {
                periode: '',
                file: ''
            }
            modalUploadData.fixedPeriode = ''
            modalUploadData.validation = {
                valid: true,
                message: '',
                color: ''
            }
            modalUploadData.tablePreview = false
            modalUploadData.modalContent = {
                type: 0, //0: show form, 1: show message, 2: show loading
                status: null,
                message: null
            }
        }
    }
})

// table component
const tableData = new Vue({
    el: '#tableData',
    name: 'Table utama',
    data() {
        return {
            dataTable: {}
        }
    },
    mounted() {
        this.loadTable()
    },
    methods: {
        loadTable() {
            let that = this
            let uriTable = baseurl + 'Koperasi/api/getList'
            axios.get(uriTable).then(res => {
                that.dataTable = res.data
            }).then(() => {
                $('.dataTable').dataTable()
            })
        },
        showDetail(periode) {
            modalDetail.dataTable = false
            modalDetail.$options.methods.show()

            let formData = new FormData()
            formData.append('periode', periode)

            let uriTable = baseurl + 'Koperasi/api/getListDetail'
            axios.post(uriTable, formData).then(res => {
                modalDetail.dataTable = res.data.list
                modalDetail.totalAll = res.data.sum
                modalDetail.periode = periode
            })
        }
    }
})

// JQUERY
// there you still need this
$(() => {
    $('#periode').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
    })
})

//vue on datepicker not effected
$('#periode').on('change', function() {
    modalUploadData.data.periode = $(this).val()
})