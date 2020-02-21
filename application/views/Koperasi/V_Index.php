<style>
    .content {
        position: relative;
    }
    
    .text-bold {
        font-weight: bold !important;
    }
    
    .ml-1 {
        margin-left: 1em !important;
    }
    
    .mb-1 {
        margin-bottom: 1em !important;
    }
    
    .modal-content {
        border-radius: 5px !important;
        padding: 10px;
        width: 50rem;
        margin: auto;
    }
    
    [v-cloak] {
        display: none;
    }
    
    .modal-dialog {
        width: auto !important;
    }
    
    .modal-content.fullscreen {
        width: auto;
    }
    
    .modal-body.scrolled {
        height: 100vh;
        overflow: auto;
    }
    
    .tableDetail.tbody {
        height: 100vh;
        overflow: auto;
    }
    /* spinner */
    
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }
    
    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid rgb(255, 255, 255);
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: rgb(27, 112, 230) transparent transparent transparent;
    }
    
    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }
    
    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }
    
    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }
    
    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    /* spinner */
    
    .modal-dialog.fullscreen {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
    }
    
    .modal-content.fullscreen {
        height: 100%;
        border-radius: 0;
        color: #333;
        overflow: auto;
    }
    
    .modal-title.fullscreen {
        font-size: 3em;
        font-weight: 300;
        margin: 0 0 10px 0;
    }
    
    .close {
        color: black ! important;
        opacity: 1.0;
    }
    
    table>thead>tr>th {
        text-align: center;
    }
</style>
<section class="content">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading text-center text-bold">
                <h1>Koperasi</h1>
            </div>
            <div class="panel-body">
                <div class="row" id="btnModalUpload">
                    <div class="col-lg-12 ml-1 mb-1">
                        <button v-on:click="btnModalUpload()" data-toggle="modal" data-target="#modalUploadData" class="btn btn-success">Upload data <i class="fa fa-upload"></i></button>
                        <a :href="pathTutorial" target="_BLANK" class="btn btn-warning"><i class="fa fa-play"></i> Tutorial</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsie">
                            <table v-cloak id="tableData" class="table dataTable table-striped table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th width="5%">No</th>
                                        <th>Periode</th>
                                        <th>Jumlah data</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, no) in dataTable">
                                        <td>{{ no+1 }}</td>
                                        <td>{{ _p2date(item.periode) }}</td>
                                        <td>{{ item.count }}</td>
                                        <td><button v-on:click="showDetail(item.periode)" class="btn btn-sm btn-success">detail</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal upload file -->
<div v-cloak class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUploadData" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div v-if="modalContent.type == 0" class="modal-content" v-bind:class="{fullscreen: tablePreview}">
            <div class="modal-header modal-detail text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title center"><b>Upload file</b></h3>
            </div>
            <div class="modal-body">
                <form id="modalForm">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="periode">Periode</label>
                        <div class="col-sm-9">
                            <input type="text" id="periode" autocomplete="off" placeholder="masukkan periode" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="periode">Pilih File</label>
                        <div class="col-sm-9">
                            <input @change="filePreview" id="fileinput" class="form-control-file" name="fileinput" type="file">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div v-if="!validation.valid" class="alert alert-dismissible text-center" v-bind:class="[validation.color]" role="alert"><b>{{ validation.message }}</b><span v-if="tablePreview"> klik simpan untuk menyimpan data</span></div>
                <div v-if="progress && validation.valid" class="progress text-center">
                    <div class="progress-bar-striped" v-bind:class="[progressColor]" role="progressbar" aria-valuemin="0" aria-valuemax="100" v-bind:style="{ width: progressUpload + '%' }">
                        {{ progressUpload }} %
                    </div>
                </div>
                <button v-if="tablePreview" v-on:click="saveData()" class="btn btn-primary"><i class="fa fa-save"></i> simpan</button>
                <button v-on:click="uploadBtn()" :disabled="uploadDisabled" class="btn btn-success"><i class="fa fa-upload "></i> upload</button>
            </div>
            <div v-if="tablePreview">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3><b>Data Koperasi Periode {{ _p2date(data.periode, true) }}</b></h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-preview" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th></th>
                                <th></th>
                                <th>{{ _numFormat(tableSum.s_pokok) }}</th>
                                <th>{{ _numFormat(tableSum.s_wajib) }}</th>
                                <th>{{ _numFormat(tableSum.s_sukarela) }}</th>
                                <th></th>
                                <th>{{ _numFormat(tableSum.p_uang) }}</th>
                                <th>{{ _numFormat(tableSum.b_uang) }}</th>
                                <th></th>
                                <th>{{ _numFormat(tableSum.bpd_pmotor) }}</th>
                                <th>{{ _numFormat(tableSum.bpd_adm) }}</th>
                                <th>{{ _numFormat(tableSum.p_uang) }}</th>
                                <th>{{ _numFormat(tableSum.b_barang) }}</th>
                                <th>{{ _numFormat(tableSum.total) }}</th>
                                <th></th>
                                <th>{{ _numFormat(tableSum.jumlah) }}</th>
                                <th></th>
                            </tr>
                            <tr class="bg-primary">
                                <th>No</th>
                                <th>Noind</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th>S Pokok</th>
                                <th>S Wajib</th>
                                <th>S Sukarela</th>
                                <th>Uang ke</th>
                                <th>P Uang</th>
                                <th>B Uang</th>
                                <th>Barang Ke</th>
                                <th>BPD Pmotor</th>
                                <th>BPD ADM</th>
                                <th>P Barang</th>
                                <th>B Barang</th>
                                <th>Total</th>
                                <th>Rp</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, n) in tablePreview">
                                <td>{{ n }}</td>
                                <td>{{ item.NO_AGT }}</td>
                                <td>{{ item.NAMA_AGT }}</td>
                                <td>{{ item.BAGIAN }}</td>
                                <td>{{ _numFormat(item.S_POKOK) }}</td>
                                <td>{{ _numFormat(item.S_WAJIB) }}</td>
                                <td>{{ _numFormat(item.S_SUKARELA) }}</td>
                                <td>{{ item.UANG_KE }}</td>
                                <td>{{ _numFormat(item.P_UANG) }}</td>
                                <td>{{ _numFormat(item.B_UANG) }}</td>
                                <td>{{ item.BARANG_KE }}</td>
                                <td>{{ _numFormat(item.BPD_PMOTOR) }}</td>
                                <td>{{ _numFormat(item.BPD_ADM) }}</td>
                                <td>{{ _numFormat(item.P_BARANG) }}</td>
                                <td>{{ _numFormat(item.B_BARANG) }}</td>
                                <td>{{ _numFormat(item.TOTAL) }}</td>
                                <td>{{ _numFormat(item.RP) }}</td>
                                <td>{{ _numFormat(item.JUMLAH) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-else-if="modalContent.type == 1" class="modal-content">
            <div class="modal-header modal-detail text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div v-if="modalContent.status == 'Success'">
                    <img :src="iconPath.success" width="100px" alt="">
                </div>
                <div v-else>
                    <img :src="iconPath.fail" width="100px" alt="">
                </div>
                <div>
                    <h2>{{ modalContent.status }}</h2>
                    <p>{{ modalContent.message }}</p>
                </div>
                <div class="text-center">
                    <button class="btn-success btn-sm" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
        <div v-else-if="modalContent.type == 2" class="modal-content">
            <div class="modal-body text-center ">
                <div class="lds-ring ">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div>
                    <span>Memproses data ...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal detail data -->
<div v-cloak class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-lg" v-bind:class="{fullscreen: dataTable}" role="document">
        <div v-if="!dataTable" class="modal-content">
            <div class="modal-body text-center">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div>
                    <span> {{ message }}</span>
                </div>
            </div>
        </div>
        <div v-else class="modal-content fullscreen">
            <div class="modal-header modal-detail text-center">
                <div class="row">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <h3 class="modal-title"><b>Data Koperasi Periode {{ _p2date(periode) }}</b></h3>
                    </div>
                    <div class="col-lg-2 text-center">
                        <button @click="deleteMe(periode)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                        <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body text-center scrolled">
                <div class="table-responsive">
                    <table id="tableDetail" class="table table-striped table-bordered">
                        <thead>
                            <tr v-for="item in totalAll">
                                <th colspan="2">TOTAL</th>
                                <th></th>
                                <th></th>
                                <th>{{ _numFormat(item.s_pokok) }}</th>
                                <th>{{ _numFormat(item.s_wajib) }}</th>
                                <th>{{ _numFormat(item.s_sukarela) }}</th>
                                <th></th>
                                <th>{{ _numFormat(item.p_uang) }}</th>
                                <th>{{ _numFormat(item.b_uang) }}</th>
                                <th></th>
                                <th>{{ _numFormat(item.bpd_pmotor) }}</th>
                                <th>{{ _numFormat(item.bpd_adm) }}</th>
                                <th>{{ _numFormat(item.p_uang) }}</th>
                                <th>{{ _numFormat(item.b_barang) }}</th>
                                <th>{{ _numFormat(item.total) }}</th>
                                <th></th>
                                <th>{{ _numFormat(item.jumlah) }}</th>
                                <th></th>
                            </tr>
                            <tr class="bg-primary">
                                <th>No</th>
                                <th>Noind</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th>S Pokok</th>
                                <th>S Wajib</th>
                                <th>S Sukarela</th>
                                <th>Uang ke</th>
                                <th>P Uang</th>
                                <th>B Uang</th>
                                <th>Barang Ke</th>
                                <th>BPD Pmotor</th>
                                <th>BPD ADM</th>
                                <th>P Barang</th>
                                <th>B Barang</th>
                                <th>Total</th>
                                <th>Rp</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="tableDetail tbody">
                            <tr v-for="(item, n) in dataTable">
                                <td>{{ n+1 }}</td>
                                <td>{{ item.no_agt }}</td>
                                <td>{{ item.nama_agt }}</td>
                                <td>{{ item.bagian }}</td>
                                <td>{{ _numFormat(item.s_pokok) }}</td>
                                <td>{{ _numFormat(item.s_wajib) }}</td>
                                <td>{{ _numFormat(item.s_sukarela) }}</td>
                                <td>{{ item.uang_ke }}</td>
                                <td>{{ _numFormat(item.p_uang) }}</td>
                                <td>{{ _numFormat(item.b_uang) }}</td>
                                <td>{{ item.barang_ke }}</td>
                                <td>{{ _numFormat(item.bpd_pmotor) }}</td>
                                <td>{{ _numFormat(item.bpd_adm) }}</td>
                                <td>{{ _numFormat(item.p_barang) }}</td>
                                <td>{{ _numFormat(item.b_barang) }}</td>
                                <td>{{ _numFormat(item.total) }}</td>
                                <td>{{ _numFormat(item.rp) }}</td>
                                <td>{{ _numFormat(item.jumlah) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>