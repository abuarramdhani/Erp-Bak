<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Data Pekerja</h3>
			</div>
			<div class="panel-body">
				<br>
				<div class="row">
					<div class="form-group">
						<div class="col-lg-1">
							<label for="select_pekerjacbg" class="control-label">Lokasi </label>
						</div>
						<div class="col-lg-3">
							<select name="datapekerja_cbg" id="select_datapekerjacbg" class="form-control">
								<option disabled="disabled" selected="selected"><i>Lokasi Kerja</i></option>
								<option value="01">Jogja</option>
								<option value="02">Tuksono</option>
							</select>
						</div>
						<div class="col-lg-8">
							<button class="btn btn-default pull-right"><a class="text-muted" href="<?php echo base_url('HitungHlcm/DataPekerja/tambahData');?>">Tambah Data</a></button>
						</div>
					</div>
				</div>
				<br>
				<table id="tabel_dataPekerja" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>No Induk</th>
							<th>Nama</th>
							<th>Pekerjaan</th>
							<th>No Rekening</th>
							<th>Atas Nama</th>
							<th>Bank</th>
							<th>Cabang</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody id="tbody_datapekerja">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
		
</section>
</body>