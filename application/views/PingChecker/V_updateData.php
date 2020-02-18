<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <form action="<?= base_url('PingChecker/Monitoring/UpdateData') ?>" method="post">
                <div class="box">
                    <div class="box-body">
                        <input type="text" class="form-control" placeholder="Masukan ID" name="idIPM"><br>
                        <input type="text" class="form-control" placeholder="Masukan Status" name="statusIPM"><br>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>