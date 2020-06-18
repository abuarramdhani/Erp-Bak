<section class="content">
    <div class="row">
        <form action="<?= base_url('PerhitunganBiayaImpor/Laporan/search'); ?>" method="post">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center">
                            <h3>Selamat datang di Aplikasi Perhitungan Biaya Impor</h3>
                            <h4>Silahkan Masukan Request Id</h4>
                        </div>
                        <div align="center">
                            <input type="text" class="form-control" placeholder="Insert Here!" style="width:400px;" name="reqid"><br>
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>