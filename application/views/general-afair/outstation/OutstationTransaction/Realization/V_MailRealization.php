
	<section class="content-header">
		<h1>
			Quick Outstation Simulation
		</h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-primary" style="margin-top: 10px">
				  <form method="post" id="simulation-form" class="form-horizontal" action="<?php echo base_url('Outstation/realization/mail/send') ?>">
						<div class="box box-body">
							<div class="form-group">
								<label class="col-sm-1">To</label>
								<div class="col-sm-5">
									<input type="text" name="r_id" class=""  value="<?php echo $realization_id; ?>" hidden>
									<input type="email" name="to" class="form-control" placeholder="To :" required="required">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-1">Cc</label>
								<div class="col-sm-5">
									<input type="email" name="cc" class="form-control" placeholder="Cc :" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-1">Bcc</label>
								<div class="col-sm-5">
									<input type="email" name="bcc" class="form-control" placeholder="Bcc :" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-1">Subjec</label>
								<div class="col-sm-5">
									<input type="text" name="subjek" class="form-control" placeholder="Subjec :" value="Informasi Tagihan Pelaporan Dinas Luar" required="required">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-12">Content</label>
								<div class="col-md-12">
								<textarea class="textarea" name='isi' placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>
<b>MEMO PERSONALIA</b><br>
Dengan Hormat,<br><br>

Bersama dengan ini kami informasikan bahwa Laporan Dinas Luar pekerja atas nama berikut sudah selesai kami cek:<br>
<ul>
	<?php
		foreach ($data_realization as $dr) {
			if($all_cost['total_all'] < 0){
				$action = "dibayarkan";
			}else{
				$action = "dikembalikan";
			}
			echo "<li>".trim($dr['employee_name'])." - ".$dr['employee_code'].", tujuan ".$dr['area_name'].", tgl ".date_format(date_create($dr['depart_time']),"d-m-Y")." - ".date_format(date_create($dr['return_time']),"d-m-Y").", jumlah uang yang ".$action." Rp.".number_format(abs($all_cost['total_all']) , 2, ',', '.')."</li>";
		}
	?>
</ul>

Mohon  disampaikan kepada pekerja terkait untuk segera melakukan realisasi bon  sementara di admin AP Oracle (Cahyo/Septi 15107) dan kasir maksimal 2 hari setelah memo ini dikirim.<br>

Demikian informasi ini kami sampaikan. Atas perhatiannya, kami ucapkan terima kasih.<br><br>

Kasie General Affair
								</textarea>
								</div>
							</div>

						</div>
						<div class="box-footer">
							<a style="margin-left: 2px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
							<a style="margin-left: 2px; width: 100px;" onclick="location.reload()" class="btn btn-primary">Reset</a>
							<button style="margin-left: 2px; width: 100px;" class="btn btn-primary">Send</button>
						</div>
				  </form>
				</div>
			</div>
		</div>
	</section>