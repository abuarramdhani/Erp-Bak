<section id="content">
    <div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >
            <!-- Content Header (Page header) -->
            <section class="content-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <br />
                            <h3 style="text-align: center;"><b ><?php echo $Menu ?></b></h3>
                        </div>
                    </div>
            </section>
            <hr />
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-12 text-right reup">
                        <h4><small>You are logged in as : <b><?php echo $this->session->user;?></b></small></h4>
                    </div>

                        <div style="height: 300px ;vertical-align: middle; text-align: center;">
                        <center>

                            <img  src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:20%;" />
                            <br>
                            Selamat Bekerja <br> <b> <?= $this->session->employee ?> </b> <b class="fa fa-smile-o"></b>
                        </center>

                        </div>
                        <br /><br /><br /><br /><br />
                        <center>
                        <?php $load = microtime();
                            echo '<p style="font: normal 15px courier">Halaman ini dimuat dalam ';
                            echo round($load, 3);
                            echo ' detik';
                        ?>
                        </center>

                </div>
            </div>
        </div>
</section>
