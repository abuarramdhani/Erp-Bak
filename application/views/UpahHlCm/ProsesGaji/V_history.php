<style type="text/css">
	.timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
}

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline > li {
        margin-bottom: 20px;
        position: relative;
    }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li > .timeline-panel {
            width: 46%;
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 20px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }

            .timeline > li > .timeline-panel:before {
                position: absolute;
                top: 26px;
                right: -15px;
                display: inline-block;
                border-top: 15px solid transparent;
                border-left: 15px solid #ccc;
                border-right: 0 solid #ccc;
                border-bottom: 15px solid transparent;
                content: " ";
            }

            .timeline > li > .timeline-panel:after {
                position: absolute;
                top: 27px;
                right: -14px;
                display: inline-block;
                border-top: 14px solid transparent;
                border-left: 14px solid #fff;
                border-right: 0 solid #fff;
                border-bottom: 14px solid transparent;
                content: " ";
            }

        .timeline > li > .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            left: 50%;
            margin-left: -25px;
            background-color: #999999;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .timeline > li.timeline-inverted > .timeline-panel {
            float: right;
        }

            .timeline > li.timeline-inverted > .timeline-panel:before {
                border-left-width: 0;
                border-right-width: 15px;
                left: -15px;
                right: auto;
            }

            .timeline > li.timeline-inverted > .timeline-panel:after {
                border-left-width: 0;
                border-right-width: 14px;
                left: -14px;
                right: auto;
            }

.timeline-badge.primary {
    background-color: #2e6da4 !important;
}

.timeline-badge.success {
    background-color: #3f903f !important;
}

.timeline-badge.warning {
    background-color: #f0ad4e !important;
}

.timeline-badge.danger {
    background-color: #d9534f !important;
}

.timeline-badge.info {
    background-color: #5bc0de !important;
}

.timeline-title {
    margin-top: 0;
    color: inherit;
}

.timeline-body > p,
.timeline-body > ul {
    margin-bottom: 0;
}

    .timeline-body > p + p {
        margin-top: 5px;
    }

@media (max-width: 767px) {
    ul.timeline:before {
        left: 40px;
    }

    ul.timeline > li > .timeline-panel {
        width: calc(100% - 90px);
        width: -moz-calc(100% - 90px);
        width: -webkit-calc(100% - 90px);
    }

    ul.timeline > li > .timeline-badge {
        left: 15px;
        margin-left: 0;
        top: 16px;
    }

    ul.timeline > li > .timeline-panel {
        float: right;
    }

        ul.timeline > li > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        ul.timeline > li > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<br>
								<h4>History Tambahan / Potongan</h4>
								<br>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table id="hlcm-tbl-potongantambahan-history" class="table table-bordered table-striped table-hover">
											<thead>
												<tr>
													<th>No.</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Cutoff Awal</th>
													<th>Cutoff Akhir</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if (isset($data) and !empty($data)) {
												$angka = 1;
												foreach ($data as $key) { ?>
													<tr>
														<td><?php echo $angka ?></td>
														<td><?php echo $key['noind'] ?></td>
														<td><?php echo $key['nama'] ?></td>
														<td><?php echo $key['tgl_awal_periode'] ?></td>
														<td><?php echo $key['tgl_akhir_periode'] ?></td>
														<td><button type="button" onclick="showDetailHistoryPotonganTambahanHLCM('<?php echo $key['noind'] ?>','<?php echo $key['tgl_awal_periode']." - ".$key['tgl_akhir_periode'] ?>')" class="btn btn-primary">Show</button></td>
													</tr>
												<?php $angka++;
												}
											}
											?>
											</tbody>
										</table>
									</div>
								</div>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div id="hlcm-modal-potongantambahan" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 class="modal-title">Detail Aktivitas</h4>
	      	</div>
	      	<div class="modal-body">
	        	<ul class="timeline" id="hlcm-modal-body-potongantambahan-history">
			        <li>
			          	<div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
			          	<div class="timeline-panel">
			            	<div class="timeline-heading">
			              		<h4 class="timeline-title"></h4>
			              		<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> </small></p>
			            	</div>
			            	<div class="timeline-body">
			              		<p></p>
			            	</div>
			          	</div>
			        </li>
			        <li class="timeline-inverted">
			          	<div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
			          	<div class="timeline-panel">
			            	<div class="timeline-heading">
			              		<h4 class="timeline-title"></h4>
			              		<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> </small></p>
			            	</div>
			            	<div class="timeline-body">
			              		<p></p>
			            	</div>
			          	</div>
			        </li>
    			</ul>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      	</div>
	    </div>
  	</div>
</div>
