<style type="text/css">
	#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    z-index:9999;
    display: none;
    background: url(<?php echo base_url('assets/img/gif/loadingquick.gif'); ?>) 
              50% 50% no-repeat rgba(0,0,0,0.7);
}
.rowT{
	color: white;
	background: #3c8dbc;  /* fallback for old browsers */
}

.panel > .panel-heading {
    background-color: #3c8dbc;
    color: white;

}

</style>
<div id="cover-spin">
</div>
<section id="content">
	<div class="inner" style="background: url("<?php echo base_url('assets/img/3.jpg');?>");background-size: cover;" >

			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="panel panel-primary">
					  <div class="panel-heading"><?= $Title ?></div>
					 <div class="panel-body">

						<form>
						  <div class="row">
						  <div class="form-group col-sm-2">
						   <label>Periode</label>
						  </div>
	                                  <div class="form-group col-sm-4">
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                                                <input required oninvalid="return alert('Empty!')" id="daterangepicker" class="form-control datepicker" autocomplete="off" type="text" name="periode" style="width:100%" placeholder="Masukkan Periode" value="" required/>
	                                        </div>
	                                  </div>
	                           </div>

	                            <div class="row">
		                           <div class="form-group col-sm-2">
							  		<label class="form-check-label" for="defaultCheck1">
										All
									</label>
							  		</div>
	                           	<div class="form-group col-sm-4">
	                                  	<div class="form-check">
										  <input class="form-check-input i-checks" type="checkbox" value="">
										  <label>( Rekap hanya berdasarkan periode )</label>
										</div>
	                                  </div>
	                           </div>

	                           <div class="row">
		                           <div class="form-group col-sm-2">								  		
	                                    <label class="control-label" >Status Hubungan Kerja</label>
								  		</div>
	                                  <div class="form-group col-sm-8">
	                                      <div class="input-group">
	                                      			<div class="input-group-addon">
														<i class="glyphicon glyphicon-briefcase"></i>
													</div>
	                                                <select id="vm-status" data-placeholder="Pilih Status Hub. kerja" class="form-control select2 customInput" style="width:100%" name ="statusKerja[]"  multiple="multiple">
														<option value=""><option>
															<!-- <option value="All">ALL</option> -->
															<?php foreach ($status as $status_item){
																?>
																<option value="<?php echo $status_item['fs_noind'];?>"><?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?></option>
																<?php } ?>
															</select>
	                                        </div>
	                                  </div>
	                           </div>

	                            <div class="row">
		                            <div class="form-group col-sm-2">								  		
		                                    <label class="control-label" >Unit</label>
									  	</div>
	                                  <div class="form-group col-sm-8">
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
	                                                <select id="vm-unit" data-placeholder="Pilih Unit" class="form-control select2 customInput" style="width:100%" name ="unit" >
														<option value=""><option>
															<!-- <option value="All">ALL</option> -->
															<?php foreach ($unit as $status_item){
																?>
																<option value="<?php echo $status_item['kodesie'];?>"><?php echo $status_item['kodesie'].' - '.$status_item['unit'];?></option>
																<?php } ?>
															</select>
	                                        </div>
	                                  </div>
	                           </div>

	                           <div class="row">
	                           <div class="form-group col-sm-2">								  		
		                                    <label class="control-label">Seksi</label>
									  	</div>
	                                  <div class="form-group col-sm-8">
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
	                                                <select id="vm-seksi" disabled data-placeholder="Pilih Seksi" class="form-control select2" style="width:100%" name="seksi">
														<option value=""><option>
													</select>
	                                        </div>
	                                  </div>
	                           </div>
	                           <div class="row">
	                           <div class="form-group col-sm-2"></div>
	                                  <div class="form-group col-sm-8">
	                                     <small style="font-style: italic;">* Kosongkan untuk pilih semua.</small>
	                                  </div>
	                           </div>

	                           <div class="row">
	                           <div class="form-group col-sm-2"></div>
	                                  <div class="form-group col-sm-8">
	                                     <button class="btn btn-success btn-submit"><i class="fa fa-send"></i>&nbsp;&nbsp;Proses</button>
	                                  </div>
	                           </div>

	                           <input type="hidden" id="tanggalAwal"></input>
	                           <input type="hidden" id="tanggalAkhir"></input>
	                           <input type="hidden" id="status"></input>
	                           <input type="hidden" id="unit"></input>
	                           <input type="hidden" id="seksi"></input>
	                    </form>
					  </div>
					</div>

			</section>
			<hr />
		</div>


		
</section>

<section id="contentTabel" style="display: none;">
	<div class="inner" style="background: url("<?php echo base_url('assets/img/3.jpg');?>");background-size: cover;" >

			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="panel">
					  <div class="panel-heading rowT">
					  <div class="panel-title pull-left title-panel">
				             Data
				       </div>
				        <div class="panel-title pull-right">
				        	<button class="btn btn-success btn-excel"><i class="fa fa-file-excel-o"></i> &nbsp;Excel</button>
				        </div>
				        <div class="clearfix"></div>
					  </div>
					 <div class="panel-body table-responsive">
					 <table class="table table-bordered table-striped table-hover" id="tblRekap">
					 	<thead>
					 		<tr class="rowT">
					 			<th>No</th>
					 			<th>No. Induk</th>
					 			<th>Nama</th>
					 			<th>Seksi</th>
					 			<th>Jumlah Terlambat</th>
					 			<th>Jumlah Izin Pribadi</th>
					 			<th>Jumlah Mangkir</th>
					 			<th>Jumlah Sakit</th>
					 			<th>Jumlah Izin Pamit (Cuti) </th>
					 			<th>Jumlah Izin Perusahaan </th>
					 			<th>Jumlah Kehadiran</th>
					 			<th>Persentase Kehadiran</th>
					 			<th>Action</th>
					 		</tr>
					 	</thead>
					 	<tbody id="bodyRekap">
					 		
					 	</tbody>
					 </table>
					  </div>
					</div>

			</section>
			<hr />
		</div>


</section>

<!-- Modal -->
<div id="detailGrafikModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail</h4>
      </div>
      <div class="modal-body">
      <div style="position:relative;right: 0;height: 500px !important;width: 100%%;overflow: auto">
      <div id="wadah-grafik"  style="height: 100% !important;width: 48%;float: left;"></div>
      <div id="wadah-pekerja" style="height: 100% !important;width: 48%;float: right;">
      	<div style="width: 100%;" align="center">
      		<img id="gmbrPkj" src="" style="width: 3cm;height: 4cm">
      	</div>
      		<h4 style="font-weight: bold;">Detail Pekerja</h4>
      		<table id="tblPie" class="table table-striped table-bordered table-hover">
      			<tr>
      			<td style="font-weight: bold;background-color: #1fa5ed;color: white;width: 15%">Nomor Induk</td><td class="text-center" style="width: 5%;"> : </td><td id="dNoind"></td>
      			</tr>
      			<tr>
      			<td style="font-weight: bold;background-color: #1fa5ed;color: white">Nama</td><td class="text-center"> : </td><td id="dNama"></td>
      			</tr>
      			<tr>
      			<td style="font-weight: bold;background-color: #1fa5ed;color: white">Seksi</td><td class="text-center"> : </td><td id="dSeksi"></td>
      			</tr>
      			<td style="font-weight: bold;background-color: #1fa5ed;color: white">Masa Kerja</td><td class="text-center"> : </td><td id="dMasaKerja"></td>
      			</tr>
      		</table>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('input[name="periode"]').daterangepicker({
		      autoUpdateInput: false,
		      locale: {
		          cancelLabel: 'Clear'
		      }
		  });

		$('input[name="periode"]').on('apply.daterangepicker', function(ev, picker) {
			if($('#contentTabel').css('display') != 'none'){
				$('#contentTabel').fadeOut()
			}
	      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
	  });

		$('.i-checks').iCheck('check')
		$('.customInput').prop('disabled',true)

		$(document).on('ifChecked', '.i-checks' ,function(event){
			$('.i-checks').iCheck('check')
			$('.customInput').prop('disabled',true)
			$("#vm-status").select2('val','')
			$("#vm-unit").val('')
			$("#vm-seksi").prop('disabled',true)
		});
		$(document).on('ifUnchecked', '.i-checks' ,function(event){
			$('.i-checks').iCheck('uncheck')
			$('.customInput').prop('disabled',false)
		});

		$("#vm-unit").on('change',function(e){
			let val = $(this).val();
			let keyKodesie = val.split(' - ')[0];
			if(val != ""){
				$("#vm-seksi").prop('disabled',false)
			}else{
				$("#vm-seksi").prop('disabled',true)
			}

			$('#vm-seksi').select2({
			allowClear: true,
			searching: true,
			ajax: {
				url: '<?php echo base_url(''); ?>AdmCabang/Monitoring/getSeksiByUnit',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					kodesie: keyKodesie
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						// return {id: obj.employee_name, text: obj.employee_name};
						return {id: obj.kodesie+" - "+obj.seksi, text: obj.kodesie+" - "+obj.seksi};
					})
				};
			}
			}
		})

		})


		$('.btn-excel').on('click',function(e){
			e.preventDefault();
			let tanggalAwal = $('#tanggalAwal').val();
			let tanggalAkhir = $('#tanggalAkhir').val();
			let status = $("#vm-status").val();
			let unit = $("#vm-unit").val();
			let seksi = $("#vm-seksi").val();
			if(status==null){
				status='empty';
			}
			if(unit==null){
				unit='empty';
			}
			if(seksi == null){
				seksi ='empty';
			}

			let url = '<?php echo base_url(''); ?>AdmCabang/Rekap/cetakExcel?tanggalAwal='+tanggalAwal+'&tanggalAkhir='+tanggalAkhir+'&statusKerja='+status+'&unitKerja='+unit+'&seksiKerja='+seksi+' ';
			window.location.href = url;
		})

		$('.btn-submit').on('click',function(e){
			e.preventDefault();
			$('#tblRekap').dataTable().fnDestroy();
			$("#note").remove()
			if($('#contentTabel').css('display') != 'none'){
				$('#contentTabel').fadeOut()
			}			
			let periode = $('input[name="periode"]').val();

			let tanggal = periode.split(' - ');
			let tanggalAwal = tanggal[0];
			let tanggalAkhir = tanggal[1];

			let status = $("#vm-status").val();
			let unit = $("#vm-unit").val();
			let seksi = $("#vm-seksi").val();

			var start = moment(tanggalAwal, "YYYY-MM-DD");
			var end = moment(tanggalAkhir, "YYYY-MM-DD");
			var selisihHari = ((moment.duration(end.diff(start)).asDays()) + 0);
			if(selisihHari < 7)
				selisihHari += 1
			console.log(selisihHari)
			if(!periode){
				alert('Empty!');

			}else{
				$('#cover-spin').fadeIn();
				$.ajax({
					url: '<?php echo base_url(''); ?>AdmCabang/Rekap/getData',
					type: 'POST',
					data: {tanggalAwal: tanggalAwal,tanggalAkhir: tanggalAkhir,statusKerja: status,unitKerja: unit,seksiKerja: seksi},
					dataType: 'json',
					success: function(res){
							
						$('#cover-spin').fadeOut();
						$('#tanggalAwal').val(tanggalAwal);
						$('#tanggalAkhir').val(tanggalAkhir);
						$('#status').val(status)
						$('#unit').val(unit)
						$('#seksi').val(seksi)

						$('#contentTabel').fadeIn();
						var i;
	                    var no = 0;
	                    var html = "";
	                    for(i=0;i < res.length ; i++){
	                        no++;
	                        html = html + '<tr>'
	                        			+ '<td>' + no + '</td>'
	                                    + '<td>' + res[i].noind  + '</td>'
	                                    + '<td>' + res[i].nama  + '</td>'
	                                    + '<td style="width: 20%" >' + res[i].seksi  + '</td>'
	                                    + '<td>' + res[i].terlambat  + '</td>'
	                                    + '<td>' + res[i].izin_pribadi  + '</td>'
	                                    + '<td>' + res[i].mangkir  + '</td>'
	                                    + '<td>' + res[i].sakit  + '</td>'
	                                    + '<td>' + res[i].izin_pamit  + '</td>'
	                                    + '<td>' + res[i].izin_perusahaan  + '</td>'
	                                    + '<td>' + (res[i].bekerja - res[i].izin_pribadi) + '</td>'
	                                    + '<td>' + ((res[i].bekerja - res[i].izin_pribadi) / selisihHari * 100 ).toFixed(2)  + '</td>'
	                                    + '<td style="width: 3%" >' + '<button data-id='+res[i].noind+' class="btn btn-info btn-grafik" ><i class="fa fa-pie-chart"></i>  Lihat Grafik</button>'  + '</td>'
	                                    + '</tr>';
	                    }
	                    $('#bodyRekap').html(html);
	                    $('#tblRekap').DataTable();

	                    var keterangan = "<p id='note' style='font-style: italic;font-weight:bold'>Persentase Kehadiran = Jumlah Kehadiran / Jumlah Hari * 100</p>";
	                    $("#tblRekap_wrapper").after(keterangan)
						
					},
					error: function(res){
						$('#cover-spin').hide();
						Swal.fire({
							type: 'error',
							title: 'Request Error'
						})
					},
					complete: function(){
						Date.prototype.getMonthName = function() {
					    var monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
					                       "Juli", "Agustus", "September", "Oktober", "November", "Desember" ];
					    return monthNames[this.getMonth()];
					}

					var tglA = new Date(tanggalAwal).getDate();
					var blnA = new Date(tanggalAwal).getMonthName();
					var thnA = new Date(tanggalAwal).getFullYear();

					var tglB = new Date(tanggalAkhir).getDate();
					var blnB = new Date(tanggalAkhir).getMonthName();
					var thnB = new Date(tanggalAkhir).getFullYear();

					$('.title-panel').text('Data Rekap '+tglA+' '+blnA+ ' '+thnA+ ' s.d '+ tglB + ' '+blnB+' '+thnB);
					}
				})
			}	
		})

		$("#tblRekap").on('click', '.btn-grafik' ,function(e){
			let noinduk = $(this).attr('data-id')
			let periode = $('input[name="periode"]').val();

			let tanggal = periode.split(' - ');
			let tanggalAwal = tanggal[0];
			let tanggalAkhir = tanggal[1];

			const today = moment();
			console.log(today)
			$("#cover-spin").fadeIn();
			$.ajax({
				url: '<?php echo base_url(''); ?>AdmCabang/Rekap/getGrafik',
				type: 'GET',
				dataType: 'json',
				data: {tanggalAwal: tanggalAwal,tanggalAkhir:tanggalAkhir,noinduk: noinduk},
				success: res =>{
					setTimeout(() => {
					$("#cover-spin").fadeOut();
					$('#detailGrafikModal').modal('show');
					document.getElementById("wadah-grafik").innerHTML = '&nbsp;';
					document.getElementById("wadah-grafik").innerHTML = '<canvas id="chartPie"></canvas>';
					var ctx = document.getElementById("chartPie").getContext('2d');
					var myChart = new Chart(ctx, {
					  type: 'doughnut',
					  data: {
					    labels: res.label,
					    datasets: [{
					      backgroundColor: [
					        "#f06292",
					        "#3498db",
					        "#d32f2f",
					        "#9b59b6",
					        "#f1c40f",
					        "#80deea",
					        "#00e676",
					        "#d9f711"
					      ],
					      data: res.data
					    }]
					  },
					  options: {
				        responsive: true,
   						maintainAspectRatio: false
					  }
					});//end chart

					var masaKerja = moment.preciseDiff(res.inf.masukkerja,today,true);
					console.log(masaKerja)

					$("#dNoind").text(res.inf.noind)
					$("#dNama").text(res.inf.nama)
					$("#dSeksi").text(res.inf.seksi)
					$("#dMasaKerja").text(masaKerja.years + ' Tahun ' + masaKerja.months + ' Bulan '+ masaKerja.days + ' Hari');
					$("#gmbrPkj").attr('src','http://quick.com/aplikasi/photo/'+res.inf.noind+' ')
					},1500) //end timeout
					
				}
			})
		})
	})
</script>