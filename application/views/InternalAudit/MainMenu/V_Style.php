<style type="text/css">
	/*custom radius nya kurt :)*/
		.form-control{
			border-radius: 20px;
		}

		textarea.form-control{
			border-radius: 10px;
		}

		.select2-selection{
			border-radius: 20px !important;
		}

		ul.select2-results__options:last-child{
			border-bottom-right-radius: 20px !important;
			border-bottom-left-radius: 20px !important;
		}

		input.select2-search__field{
			border-radius: 20px !important;
		}

		span.select2-dropdown{
			border-radius: 20px !important;
		}

		.btn {
			border-radius: 20px !important;
		}

		.btn-add {
			text-align: right;
			background-color: white !important;
			color: #3c8dbc !important;
			border: 0px !important;
			font-weight: bold;
		}

		.btn-cust-f{
			border-radius: 2px !important;
			border-top-left-radius: 20px !important;
			border-bottom-left-radius: 20px !important;
		}

		.btn-cust-m{
			border-radius: 2px !important;
		}

		.btn-cust-e{
			border-radius: 2px !important;
			border-top-right-radius: 20px !important;
			border-bottom-right-radius: 20px !important;
		}
		.btn-cust-b{
			border-radius: 2px !important;
			border-bottom-right-radius: 20px !important;
			border-bottom-left-radius: 20px !important;
		}


	/*end of border radius custom*/

	/*custom butt on nya gaes :))*/
		.btnHoPg{
			height: 50px;
			width: 50px;
			margin-top: 10px;
		}

		.btn-draft-success{
			border: 1px solid #1abd3e;
			color: #076f1e;
			background-color: #b7ffde;
		}
		.btn-draft-success:hover{
			border: 1px solid #1abd3e;
			color: #fff;
			background-color: #1abd3e;
		}

		.btn-draft-error{
			border: 1px solid #bc2e2e;
			color: #bc2e2e;
			background-color: #fedad7;
		}
		.btn-draft-error:hover{
			border: 1px solid #bc2e2e;
			color: #fff;
			background-color: #d14646;
		}

		.btn-del-draft{
			border: 1px solid #929292;
			color: #929292;
			background-color: #f2f2f2;
		}

		#prevBtnIA{
			display: none;
			background-color: #7cbbe0;
			border: 1px solid #3c8dbc;
			color: white;
			border-top-left-radius: 20px ;
			border-bottom-left-radius: 20px ;
		}
		#prevBtnIA:hover{
			background-color: #367fa9;
			border: 1px solid #3c8dbc;
			color: white;
		}

		#nextBtnIA{
			border-top-right-radius: 20px;
			border-bottom-right-radius: 20px;
		}

		.btn-add-row{
			width: 30px;
			height: 30px;
			border-radius: 50%;
			background-color: #b7ffde;
			vertical-align: middle;
			text-align: center;
			padding: 5px;
			border: 1px solid #207850;
			color: #207850;
		}
		.btn-delete-row{
			width: 30px;
			height: 30px;
			border-radius: 50%;
			background-color: #eab7b5;
			vertical-align: middle;
			text-align: center;
			padding: 5px;
			border: 1px solid #9c3d3d;;
			color: #9c3d3d;
		}

		.btndis{
			background-color: #ececec;
			border: 1px solid #757575;
			color: #959595;
		}

		.btnfile{
			border-radius: 5px;
			background-color: #ececec;
			padding: 5px;
		}

	/*end og custom butt on*/

	/*custom table yang pojoknya tumpul*/
		.table-curved {
		   border-collapse: separate;
		   border: solid #ddd 1px;
		   border-radius: 6px;
		   border-left: 0px;
		   border-top: 0px;
		}

		.table-curved th {
			background-color: #424c53 !important;
			color: white;;
			text-align: center;
			vertical-align: middle !important;
			font-weight: normal !important;
		}
		.table-curved > thead:first-child > tr:first-child > th {
		    border-bottom: 0px;
		    border-top: solid #ddd 1px;

		}
		.table-curved td:first-child {
		    text-align: center;

		}
		.table-curved td, .table-curved th {
		    border-left: 1px solid #ddd;
		    border-top: 1px solid #ddd;
		}
		.table-curved > :first-child > :first-child > :first-child {
		    border-top-left-radius: 6px;
		}
		.table-curved > :first-child > :first-child > :last-child {
		    border-top-right-radius: 6px;
		}
		.table-curved > :last-child > :last-child > :first-child {
		    border-bottom-left-radius: 6px;
		}
		.table-curved > :last-child > :last-child > :last-child {
		    border-bottom-right-radius: 6px;
		}
	/*enf of custom pojok tumpul*/


	.dataTables_scroll	{
	    overflow:auto;
	}

	.slc2 {
		width: 100% !important
	}
	.det_improve{
		cursor: pointer;
	}
	.det_improve:hover{
		background-color: #cbfccb;
	}

	.grs{
		width: 100%;
		vertical-align: middle;
	}

	.title-tengah{
		padding-top: 10px;
		padding-bottom: 10px;
		vertical-align: middle;
	}

	.bg-request{
		background-color: #7fe5f2 !important;
	}

	.userIa:hover {
		color: blue !important;
		text-decoration: underline !important;
		cursor: pointer;
	}

	.image-cropper {
    width: 100px;
    height: 100px;
    position: relative;
    overflow: hidden;
    border-radius: 50%;
	}

	.imgs {
	    display: inline;
	    margin: 0 auto;
	    width: 100px;
	    height: auto;
	}
</style>

<!--  -->
	<div class="modal fade" id="ModUserIa" data-id="" role="dialog" aria-labelledby="ModUserIa" aria-hidden="true">
		<div class="modal-dialog" style="min-width:400px; border-radius: 20px">
			<div class="modal-content" style=" border-radius: 20px; height: 405px" id="viewDataUser">
				<!-- contentt -->
			   <div class="box box-widget widget-user">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-aqua-active">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	              <h3 class="widget-user-username">Kuswandaru</h3>
	              <h5 class="widget-user-desc">Founder &amp; CEO</h5>
	            </div>
	            <div class="widget-user-image">
	              <div style="width: 100%; text-align: center;">
	              <div class="image-cropper" style="display: inline-block">
				    <?php
					$path_photo  		=	base_url('assets/img/foto').'/';
					$file 					= 	$path_photo.$this->session->user.'.'.'JPG';
					$file_headers 	= 	@get_headers($file);
					if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
						$file 			= 	$path_photo.$this->session->user.'.'.'JPG';
						$file_headers 	= 	@get_headers($file);
						if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
							$ekstensi 	= 	'Not Found';
						}else{
							$ekstensi 	= 	'JPG';
						}
					}else{
						$ekstensi 	= 	"jpg";
					}

					if($ekstensi=='jpg' || $ekstensi=='JPG'){
						echo '<img src="'.$path_photo.$this->session->user.'.'.$ekstensi.'" class="rounded imgs" alt="User Image" title="'.$this->session->user.' - '.$this->session->employee.'">';
					}else{
						echo '<img src="'.base_url('assets/theme/img/user.png').'" class="rounded imgs" alt="User Image" />';
					}
	              	?>
					</div>
	              </div>
	            </div>
	            <div class="box-footer">
	              <div class="col-md-12">
	              	<form class="form-horizontal">
                 <strong><i class="fa fa-phone margin-r-5"></i> VOIP</strong>

	              <p class="text-muted">
	                12300
	              </p>

	              <hr>
	              <strong><i class="fa fa-mobile-phone margin-r-5"></i> My Group</strong>

	              <p class="text-muted">
	                089692010766
	              </p>

	              <hr>
	              <strong><i class="fa fa-envelope margin-r-5"></i> Email Internal</strong>

	              <p class="text-muted">
	                kuswandaru@quick.com
	              </p>

	              <hr>
	              <strong><i class="fa fa-user margin-r-5"></i> Initial</strong>

	              <p class="text-muted">
	                ndaru
	              </p>

	              <hr>
                </form>
	              </div>
	              <!-- /.row -->
	            </div>
	          </div>
	          <!-- contentt -->
			</div>
		</div>
		</div>
	<!--  -->
