<?php
$this->load->view('template/head');
?>

<!-- Datepicker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/datepicker/date_picker_bootstrap/bootstrap-datetimepicker.min.css')?>" rel="stylesheet" media="screen"/>

<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.css') ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<!--   <link href="<?php echo base_url('assets/wizard/css/gsdk-base.css') ?>" rel="stylesheet" type="text/css" /> -->

<script src="<?php echo base_url() ?>assets/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<style type="text/css">
.back-to-top {
cursor: pointer;
position: fixed;
bottom: 0;
right: 20px;
display:none;
}
</style>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.4.min.js') ?>" type="text/javascript"></script>
			<script src="<?php echo base_url('assets/datepicker/jquery.min.js') ?>" type="text/javascript"></script>

			<script type="text/javascript">
			$(document).ready(function(){
			$(".komponen").hide();
			$("#data").show();

			$('#data').click(function(){
			$(".komponen").slideToggle();
			});

			});
			</script>
			<script type="text/javascript">
			$(document).ready(function(){
			$(".tambahPPh").hide();
			$("#newPPh").show();

			$('#newPPh').click(function(){
			$(".tambahPPh").slideToggle();
			});
			
			});
			function test(){
			$(".tambahPPh").hide(500);
			}
			function test2(){
			$(".komponen").hide(500);
			}
			</script>
			<script type="text/javascript">
			function getDetail(){
				//alert("asdasd");
					var Kode = document.getElementById("Kode").value;
					$.post("http://quick.com/aplikasi/QC.Component/C_Component/getNama", {Kode:Kode}, function(data){
					$('input#Nama').val(data);
					//alert("asdasd");
					});
					//alert(Kode);
					$.post("http://quick.com/aplikasi/QC.Component/C_Component/gettype", {Kode:Kode}, function(data){
					$('input#Type').val(data);
					});
				};
			</script>

			<script type="text/javascript">
			function getDetailCari(){
				//alert("asdasd");
					var Kode = document.getElementById("KodeCari").value;
					$.post("http://quick.com/aplikasi/QC.Component/C_Component/getNama", {Kode:Kode}, function(data){
					$('input#NamaCari').val(data);
					});
					$.post("http://quick.com/aplikasi/QC.Component/C_Component/gettype", {Kode:Kode}, function(data){
					$('input#TypeCari').val(data);
					});
				};
			</script>

			<script type="text/javascript">
			function getData(){
				//alert("asdasd");
				var KodeCari = $("select#KodeCari option:selected").attr('value');
					$.post("http://quick.com/aplikasi/QC.Component/C_Component/getNamacari", {KodeCari:KodeCari}, function(data){
					$('input#NamaCari').val(data);
					});
				$.post("http://quick.com/aplikasi/QC.Component/C_Component/gettypeCari", {KodeCari:KodeCari}, function(data){
					$('input#TypeCari').val(data);
					});
				
				};
			</script>
			
				<script>
			//angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
            $(document).ready(function(){;
//            angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
            setTimeout(function(){$(".alert").fadeOut();}, 1000);
			});
			</script>
			<script type="text/javascript">
    $(document).ready(function(){
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');
});
</script>


<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
	<?php
			$link = $this->uri->segment(3);
			$keyword = $this->uri->segment(4);
		
			if ($link == "tampil" && $keyword != null){
				foreach ($data2 as $c){
					$id = $c->id;
					$Kode = $c->Kode;
					$Nama_Komponen = $c->Nama_Komponen;
					$Type_Komponen = $c->Type_Komponen;
					$Jumblah = $c->Jumblah;
					$Tanggal = $c->Tanggal;
					$Proses = $c->Proses;
					$Shift = $c->Shift;
					$Judgement = $c->Judgement;
					$Keterangan = $c->Keterangan;
				}
				}else {
				$id="";
				$Kode="";
				$Nama_Komponen="";
				$Type_Komponen="";
				$Jumblah="";
				$Tanggal="";
				$Proses="";
				$Shift="";
				//$Judgement="";
				$Keterangan="";
				}  
		
			  ?>			
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
        <small>  <i class="fa fa-dashboard"></i>  Dashboard<span> ></span> </small>
        <small>Home</small> 
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
	<div class="box box-primary">
		<div class="box-header with-border"  style="background:#2E6DA4; color:#FFFFFF;">
			<div class="col-md-6">
				<h4 style="color:white;">
				   <b></b>LAMPIRAN ORDER UNTUK ARSIP IR<br>
				</h4>
			</div>
				<div class="col-md-6">
					<h4 style="color:white;">
						<div class="text-right">
							<div id="clockbox"></div>
						</div>
					</h4>
				</div>
		</div>
			<div style="   border-width:1px;border-style:solid;border-color:#2E6DA4;"></div>
				<div class="box-body">
					<div class="box-header">
						<div class="col-xs-6">
							<label align="center"><h4>Tanggal Hari ini : <?php echo date('Y-m-d') ?></h4></label>
						</div>
						<div class="col-xs-6 text-right">
							<?php 
								if($username=="admin")
								{
							?>
							<a class="btn btn-default leftmargin" id="newPPh">
								<img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/add.png') ?>" width="20px">&nbsp; New
							</a>
							<?php
								}
							?>
							<a class="btn btn-default leftmargin" id="data">
								<img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/active-search-2-xxl.png') ?>" width="20px">&nbsp; Search
							</a>
						</div>
					</div>
		
		<!---------iNSERT LAMPIRAN ORDER---------->
		<div class="box tambahPPh">
			<div class="box-header with-border" >
				<h4>-Insert Data Component Document - </h4>
			</div>
				 <fieldset class="row2" style="background:#F8F8F8 ;">
				 	<?php  if(empty($data2)){ 
					$attributes = array('class' => 'form-horizontal', 'id' => 'formProduction');
					echo form_open_multipart('C_Component/upload',$attributes); 
					?>
					  <?php } else {?>
					<form action="<?php echo site_URL('C_Component/insert/ect_edit')?>/<?php echo $id?>" method="post" enctype="multipart/form-data" id="pph">
                    <?php } ?>
					<div class="box-body">
						<div class="row">
						 <div class="col-md-2">
							<div class="form-group" style="margin-left:20px;">
							  <label for="exampleInputPassword1">Kode Komponen</label>
							  <br>
								<input style="width:300px;" type="text" id="Kode" class="form-control " onkeyup="getDetail()" name="Kode"  value="<?php echo $Kode?>" placeholder="Kode Komponen" autocomplete="on" required>
							</div>
						</div>
				<br><br><br><br>
					 <input type="hidden" value="" style="width:300px;" class="form-control "  name="id"  placeholder="Nama Komponen" autocomplete="off" onfocus="this.value='';">
						<div class="col-md-4">
						<div class="form-group" style="margin-left:20px;">
						  <label for="exampleInputPassword1">Nama Komponen</label>
								<div class="input-group">
									 <input type="text" id="Nama" value="<?php echo $Nama_Komponen?>" style="width:300px;" class="form-control "  name="nama"  placeholder="Nama Komponen" autocomplete="off" onfocus="this.value='';" readonly>
								</div>
						  <label for="exampleInputPassword1">Type Komponen</label>
								<div class="input-group">
									 <input type="text" id="Type"  value="<?php echo $Type_Komponen?>" style="width:300px;" class="form-control " name="type"  placeholder="Type Komponen" autocomplete="off"  onfocus="this.value='';" readonly>
								</div>
						  <label for="exampleInputPassword1">Jumlah</label>
								<div class="input-group">
									 <input type="text" id="nomor" class="form-control " onkeypress="return hanyaAngka(event, false)" name="jumblah"  value="<?php echo $Jumblah?>" placeholder="jumblah" autocomplete="off" required>
								</div>
						</div>
					</div>
					 <div class="col-md-3">
						<div class="form-group">
						
						  <label for="exampleInputPassword1">Tanggal(H/B/T)</label>
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									<div class="date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										<input id="tanggal_berlaku" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo $Tanggal?>"  data-date-format="yyyy-mm-dd" type="text" name="tanggal" riquaite placeholder=" Date"autocomplete="off" required>
									</div>
								</div>
							<label for="exampleInputPassword1">Proses</label>
								<div class="input-group">
								<select name="proses" class="form-control" value="<?php echo $Proses?>" style="width:265px;" required>
										<option value="<?php echo $Proses?>">- pilih -</option>
										<option value="CMM">CMM</option>
										<option value="HTM">HTM</option>
										<option value="FINISH">FINISH</option>
										<option value="BEFORE CARBONE TRIDING">BEFORE CARBONE TRIDING</option>
										<option value="AFTER CARBONE TRIDING">AFTER CARBONE TRIDING</option>
										<option value="BLANK">BLANK</option>
									</select >
								</div>	
								
							<label for="exampleInputPassword1">Shift</label>
								<div class="input-group">
								<select name="shift" class="form-control" value="<?php echo $Shift?>" style="width:265px;" required>
										<option value="<?php echo $Shift?>">- pilih -</option>
										<option value="I">I</option>
										<option value="II">II</option>
										<option value="III">III</option>
										<option value="L">L</option>
									</select >
								</div>
							<label for="exampleInputPassword1">Judgement</label>
								<div class="input-group">
								<select name="Judgement" value=""  class="form-control"style="width:265px;" required>
										<option value="">- pilih -</option>
										<option value="OK">OK</option>
										<option value="OKB">OKB</option>
										<option value="OKM">OKM</option>
										<option value="OKK">OKK</option>
										<option value="NG">NG</option>
									</select >
								</div>
						</div>
					</div>
					<div class="col-md-4" >
						<div class="form-group" style="margin-left:2px;">
							<label for="exampleInputPassword1">Keterangan</label>
								<div class="input-group" style="width:350px;">
									<textarea name="Keterangan" value="" class="form-control" type="text" style="text-transform:uppercase; "><?php echo $Keterangan?></textarea>
								</div>
								<br>
								<label for="exampleInputPassword1">Upload</label>
									<div class="input-group">
											<input type="file" name="userfile" id="import" style="text-transform:uppercase" class="btn btn-default btn-flat pull-right" onchange="readURL(this)"; required>
									</div>
								</div>
							</div>
					</div><!-- /.box-body -->
			 </fieldset>
				<div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="save"><b>Simpan Data</b></button>
					<a class="btn btn-danger btn-sm" title="Edit" onclick="test()"> Cancel</a>
             </div>
		</div>
	</form>
		<!---------iNSERT LAMPIRAN ORDER---------->
		
		
		
		<!---------Cari LAMPIRAN ORDER---------->
		<div class="box komponen">
			<div class="box-header with-border" >
				<h4>-Cari Data Component Document - </h4>
			</div>
				 <fieldset class="row2" style="background:#F8F8F8 ;">
				 	<form action="<?php echo base_URL()?>C_Component/Cari/get" method="post" enctype="multipart/form-data" id="pph">
                     <div class="box-body">
						<div class="row">
						 <div class="col-md-2">
							<label for="exampleInputPassword1">Tanggal Awal </label>
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									<div class="date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										<input id="tanggal_awal" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" type="text" name="tanggalawal" riquaite placeholder=" Date"autocomplete="off">
									</div>
								</div>
						</div>
						<div class="col-md-2">
							<label for="exampleInputPassword1">Tanggal Akhir</label>
								<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								<div class="date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
									<input id="tanggal_akhir" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" type="text" name="tanggalakhir" riquaite placeholder=" Date" autocomplete="off">
								</div>
							</div>
						</div>
						<br><br><br><br>
						<div class="col-md-2">
							<div class="form-group">
							  <label for="exampleInputPassword1">Kode Komponen</label>
							  <br>
								<input type="text" id="KodeCari" class="form-control " onkeyup="getDetailCari()" name="KodeCari"  value="<?php echo $Kode?>" placeholder="Kode Komponen" autocomplete="on">
							</div>
						</div>
						 <div class="col-md-3">
							<div class="form-group" style="margin-left:50px;">
								<label for="exampleInputPassword1">Nama Komponen</label>
									<div class="input-group">
										<input type="text" id="NamaCari" style="width:280px;" class="form-control" name="NamaCari"  value="" placeholder="Nama Komponen" autocomplete="off"  onfocus="this.value='';"  >
										<!-- <select id="NamaCari" name="NamaCari" class="form-control select2" style="width:280px;" >
											<option value=""></option>
										</select> -->
									</div>
							</div>
						</div>
						 <div class="col-md-3">
						<div class="form-group" style="margin-left:90px;">
						  <label for="exampleInputPassword1">Type Komponen</label>
								<div class="input-group">
									 <input type="text" id="TypeCari" style="width:280px;" class="form-control " name="TypeCari"  value="" placeholder="Type Komponen" autocomplete="off"  onfocus="this.value='';" >
								</div>
						</div>
						</div>
						 <div class="col-md-2">
						<div class="form-group">
						<label for="exampleInputPassword1" style="margin-left:140px;">Judgement</label>
								<select name="JudgementCari"  class="form-control"style="width:100px; margin-left:140px;">
										<option value="">- ALL -</option>
										<option value="OK">OK</option>
										<option value="OKB">OKB</option>
										<option value="OKM">OKM</option>
										<option value="OKK">OKK</option>
										<option value="NG">NG</option>
									</select >
								</div>
							</div>
						</div>
				</div><!-- /.box-body -->
			 </fieldset>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary btn-sm" id="save"><b>Cari Data</b></button>
					<a class="btn btn-danger btn-sm" title="Edit" class="btn btn-default leftmargin"  onclick="test2()" > Cancel</a>
            </div>
		</div>
	</form>
		<!---------Cari LAMPIRAN ORDER---------->
		
		<!---------DATA TABLE LAMPIRAN ORDER---------->
			<div class="box">
				<div class="box-header with-border  text-left">
					<div class="col-md-7">
							<h4>
									- DOKUMENT SECARA SOFTCOPY QUALITY CONTROL -
							</h4>

							<?php
								if($this->session->userdata('suksessave')){ 
							?>
							<div class="alert alert-success alert-dismissable"  style="width:1120px;">
							<h4><i class="icon fa fa-check"></i>Sucess!</h4></div>
							<?php
							}
							?>

						</div>
						<?php 
							$link = $this->uri->segment(3);
							if ($link != "get"){
							?>
					<b></b><br><br>
					<?php } else { ?>
					<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo date('d F Y', strtotime($tanggalawal)) ?> s/d <?php echo  date('d F Y', strtotime($tanggalakhir)) ?>
					<?php
					if($KodeCari=='%'){
						$KodeCari='none';
					}
					if($NamaCari=='%'){
						$NamaCari='none';
					}
					if($TypeCari=='%'){
						$TypeCari='none';
					}
					if($Judgement=='%'){
						$Judgement='none';
					}
					?>
					<?php echo " - Kode Komponen: ".$KodeCari;?>
					<?php echo " - Nama Komponen: ".$NamaCari;?>
					<?php echo " - Type Komponen: ".$TypeCari;?>
					<?php echo " - Judgement: ".$Judgement;?>
					<div class="text-right">
					<a class="btn btn-info btn-sm" title="Export Data"  href="<?php echo base_url("/C_Component/export_data/$tanggalawal/$tanggalakhir/$KodeCari/$NamaCari/$TypeCari/$Judgement")?>" target="blank"><i class="glyphicon glyphicon-floppy-disk"></i>Export Data</a>
					</div>	
					<?php } ?>
				</div>
					<div class="table-responsive">
						<fieldset class="row2" style="background:#FFFFFF;">
							  <table id="example2" class="table table-bordered table-striped table-hover" style="width:2000px;">
									<thead style="background:#2E6DA4; color:#FFFFFF;">
										 <tr>
										  <th class="text-center" style="width:2%">No.</th>
										  <th class="text-center" style="width:10%">Kode Komponen</th>
										  <th class="text-center" style="width:10%">Nama Komponen</th>
										  <th class="text-center" style="width:8%">Type</th>
										  <th class="text-center" style="width:8%">Jumlah</th>
										  <th class="text-center" style="width:5%">Tgl_Inspeksi</th>
										  <th class="text-center" style="width:8%">Proses</th>
										  <th class="text-center" style="width:6%">Shift Inspeksi</th>
										  <th class="text-center" style="width:8%">Judgement</th>
										  <th class="text-center" style="width:8%">Keterangan</th>
										<th class="text-center"  style="width:10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$i=0;
											foreach ($data as $row)
											{
											$i++;
											?>
											<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $row->kode?></td>
												<td><?php echo $row->nama_komponen?></td>
												<td><?php echo $row->type_komponen?></td>
												<td><?php echo $row->jumlah?></td>
												<td><?php echo $row->tanggal?></td>
												<td><?php echo $row->proses?></td>
												<td><?php echo $row->shift?></td>
												<td><?php echo $row->judgement?></td>
												<td><?php echo $row->keterangan?></td>
												<td>

													<a class="btn btn-info btn-sm" title="View Data"  href="<?php echo base_url().'assets/upload/'.$row->id.'.pdf'?>" target="blank"><i class="glyphicon glyphicon-search"></i></a>	
													
													<a class="btn btn-info btn-sm" title="Download Data"  href="<?php echo site_url ()?>C_Component/download/<?php echo $row->id;?>"><img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/arrow-download-icon.png') ?>" width="20px"></i></a>	
													<?php 
														if($username=="admin")
														{
													?>
													<a class="btn btn-warning btn-sm" title="Edit" href="<?php echo site_url ()?>C_Component/ediitdata/tampil/<?php echo $row->id?>"><i class="glyphicon glyphicon-edit"></i></a>
													
													<a class="btn btn-danger btn-sm" title="Delete" href="<?php echo site_url()?>/C_Component/insert/delete/<?php echo $row->id ?>" onclick="return confirm('Anda YAKIN menghapus data \n (<?php echo $row->kode?>)<?php echo $row->nama_komponen?>..?');"><i class="glyphicon glyphicon-trash"></i></a>
													<?php 
														}
													?>
												</td>
											</tr>
										<?php }?>
									</tbody>
									<tfoot>
										  <tr>
											  <tr>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
												<th align="center">-</th>
											  </tr>
										  </tr>
									</tfoot>
							  </table>
							<div class="clear"></div>
						</fieldset>
					</div>
					<div class="box-footer clearfix"></div><!-- /.box-footer -->
			</div>
			<!---------DATA TABLE LAMPIRAN ORDER---------->
		</div>
	</div>
</section><!-- /.content -->
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" 
  role="button"  data-toggle="tooltip" data-placement="top">
  <span class="glyphicon glyphicon-chevron-up"></span>
</a>
<?php
$this->load->view('template/js');
?>

<!--- modal --->
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
<!-- jQuery dari View -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js')?>"></script>
<!-- END GLOBAL SCRIPTS -->
<!--Fungsi sitemenu tidak aktif <script src="<?php echo base_url('assets/datepicker/jquery-1.11.0.js') ?>"></script> -->
<script src="<?php echo base_url('assets/datepicker/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/datepicker/date_picker_bootstrap/js/bootstrap-datetimepicker.js')?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url('assets/datepicker/date_picker_bootstrap/js/locales/bootstrap-datetimepicker.id.js')?>" charset="UTF-8"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
<!-- jQuery dari view -->

   <script>
      $(function () {
    	$('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
		  "info": true,
          "autoWidth": false,
		    "scrollX": true,
		    "pageLength" : 50,
		  "deferRender" : true,
		  "scroller": true,
		  "columnDefs": [
							{ className: "text-center", "targets": [ 0 ] },
							{ className: "text-center", "targets": [ 1 ] },
							{ className: "text-center", "targets": [ 2 ] },
							{ className: "text-center", "targets": [ 3 ] },
							{ className: "text-center", "targets": [ 4 ] },
							{ className: "text-center", "targets": [ 5 ] },
							{ className: "text-center", "targets": [ 6 ] },
							{ className: "text-center", "targets": [ 7 ] },
							{ className: "text-center", "targets": [ 8 ] },
							{ className: "text-center", "targets": [ 9 ] }
							
						]
		  
        });
      });
    </script>
	<script>
function goBack() {
    window.history.back();
}
</script>
	<!-- Fungsi datepickier yang digunakan -->
	<script type="text/javascript">
	 $('.datepicker').datetimepicker({
	        language:  'id',
	        weekStart: 1,
	        todayBtn:  1,
	  autoclose: 1,
	  changeDate: false,
	  todayHighlight: 1,
	  startView: 2,
	  minView: 2,
	  forceParse: 0
	    });
	</script> 
<script type="text/javascript">
$(".select2").select2({
				allowClear: true,
				placeholder: "Select by Name..",
				minimumInputLength: 1,
				ajax: {
					url: "<?php echo base_url();?>C_Component/get_all_name",
					dataType: 'json',
					type: "GET",
					data: function (params) {

						var queryParameters = {
							term: params.term
						}
						return queryParameters;
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id: obj.nama_komponen, text:obj.nama_komponen  };
							})
						};
					}
				} 
		});
</script>
<?php
$this->load->view('template/foot');
?>