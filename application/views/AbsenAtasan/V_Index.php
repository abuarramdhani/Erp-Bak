<section class="content">
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Menu Absen Atasan </strong></h3>
			</div>
		</div>
		<div class="panel box-body" >
			<div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-12 text-right reup">    
                        <h4><small>You are logged in as : <?php echo $this->session->user;?></small></h4>
                    </div>  
                        
                        <center> 
                            
                            <img  src="<?php echo base_url("assets/img/cs.png");?>" style="max-width:27%;" />
                        
                        </center>
                        <br /><br />
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
	</div>
</section>