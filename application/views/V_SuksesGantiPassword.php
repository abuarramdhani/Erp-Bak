<!DOCTYPE html>
<html>
<head>
	<title>Sukses Ganti Password</title>
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/AdminLTE.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css') ?>" />
</head>
<body>
	<style>
		.shadow{
			border-radius: 5px;
			/*border: 1px solid #ededed;*/
			padding: 50px;
			box-shadow: 1px 1px #ededed;
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.19);
		}
		.bold tr td{
			font-weight: bold;
		}
		label{
			margin: 0px;
		}
		.spad{
			padding: 10px;
			cursor: pointer;
			/*color: #000;*/
			padding-left: 40px;
			padding-right: 40px;
		}
		.spad label{
			cursor: pointer;
		}
	</style>
	<div class="col-md-12" style="margin-top: 50px;">
		<div class="col-md-3"></div>
		<div class="col-md-6 shadow">
			<div class="row">
				<div class="col-md-12 text-center">
					<h2><b>Password Updated</b></h2>
				</div>
				<div class="col-md-12 text-center">
					<img src="<?= base_url('assets/img/icon/success.png') ?>" style="width: 150px;">
				</div>
				<div class="col-md-12" style="margin-top: 0px;">
					<label>Password dapat di cek di :</label>
				</div>
				<div class="col-md-12">
					<table class="bold">
						<tr>
							<td width="30%">Email</td>
							<td width="5%">:</td>
							<td><?= $email ?></td>
						</tr>
						<tr>
							<td width="30%">Mygroup</td>
							<td width="5%">:</td>
							<td><?= $mygroup ?></td>
						</tr>
					</table>
				</div>
				<div class="col-md-12 text-center" style="margin-top: 50px;">
					<a class="btn btn-info btn-flat spad" href="<?= base_url() ?>" style="margin-right: 50px;">
						<label>Login ERP</label>
					</a>
					<a target="_blank" class="btn btn-warning btn-flat spad" href="https://mail.quick.com/">
						<label>Login Email</label>
					</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
