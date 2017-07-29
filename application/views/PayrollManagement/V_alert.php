			<?php
				if($this->session->userdata('success_insert')){ 
			?>
				<div class="alert alert-success alert-dismissable"  style="width:100%;" >
								 <li class="fa fa-warning"> </li> Simpan Data Berhasil !!!
						</div>
			<?php
				}
			?>
			<?php
				if($this->session->userdata('success_update')){ 
			?>
				<div class="alert alert-success alert-dismissable"  style="width:100%;" >
								 <li class="fa fa-warning"> </li> Perubahan Data Berhasil !!!
						</div>
			<?php
				}
			?>
			<?php
				if($this->session->userdata('success_import')){ 
			?>
				<div class="alert alert-success alert-dismissable"  style="width:100%;" >
								 <li class="fa fa-warning"> </li> Import <b>Master Status Kerja</b> Berhasil !!!
						</div>
			<?php
				}
			?>
			<?php
				if($this->session->userdata('not_found')){ 
			?>
				<div class="alert alert-warning alert-dismissable"  style="width:100%;" >
								 <li class="fa fa-warning"> </li> Data tidak di temukan !!!
						</div>
			<?php
				}
			?>
			<?php
				if($this->session->userdata('success_delete')){ 
			?>
				<div class="alert alert-danger alert-dismissable"  style="width:100%;" >
								 <li class="fa fa-warning"> </li> Delete Data Berhasil !!!
						</div>
			<?php
				}
			?>
			<?php
				if($this->session->userdata('failed_import')){ 
			?>
				<div class="alert alert-danger alert-dismissable" style="width:100%;">
					<b> Import Gagal ! </b> Terjadi kesalahan saat melakukan import data
				</div>
			<?php
				}
			?>