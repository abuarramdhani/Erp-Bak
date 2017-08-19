<!-- Content Header (Page header) -->
<section class="content-header">
<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>DATA ORDER IN</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ManagementOrder');?>">
                                <i class="fa fa-ticket fa-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
 </section>
<section class="content">
	        <div class="row">
            <div class="col-md-12">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#menu1" class="js-panel" id="tab1"><b style="color:red;">EMERGENCY</b></a></li>
					<li><a data-toggle="tab" href="#menu2" class="js-panel" id="tab2"><b style="color:red;">OVERDUE</b></a></li>
					<li><a data-toggle="tab" href="#menu3" class="js-panel" id="tab3"><b style="color:red;">UNANSWERED</b></a></li>
					<li><a data-toggle="tab" href="#menu4" class="js-panel" id="tab4"><b style="color:red;">WORK IN PROCESS</b></a></li>
					<li><a data-toggle="tab" href="#menu5" class="js-panel" id="tab5"><b style="color:red;">HOLDED</b></a></li>
				  </ul>
				<div class="box box-danger">
					<div class="box-body">
						  <div class="tab-content">
							  <div id="menu" class="tab-pane fade in active">
								  <table class="table table-striped table-bordered table-hover" id="tableorder-job" style="font-size:12px;min-width:100%;">
										<thead>
											<tr class="bg-primary">
												<th style="text-align:center;">No</th>
												<th style="text-align:center;">Ticket</th>
												<th style="text-align:center;">Subject</th>
												<th style="text-align:center;">Order To*</th>
												<th style="text-align:center;">To Do</th>
												<th style="text-align:center;">Duedate</th>
												<th style="text-align:center;">X</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
						  </div>
					</div>
				</div>
            </div>
        </div>
</section>
<!-- Modal -->


