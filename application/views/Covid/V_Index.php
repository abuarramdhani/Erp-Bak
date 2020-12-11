<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style type="text/css">
	.swal2-content li, .swal2-content p{
		text-align: left !important;
	}
</style>
<script type="text/javascript">
	$(document).on('ready', function(){
		<?php 
		$lokasi = "";
		if (isset($reminder) && !empty($reminder)) {
			foreach ($reminder as $r) {
				$lokasi .= "<li>".$r['nama_seksi']." - ".$r['lokasi']."</li>";
			}
			?>
		swal.fire({
			title: "[REMINDER]",
			html: "<p>Untuk Area Isolasi: </p><ul><?php echo $lokasi ?></ul><p>Akan Berkhir Masa Isolasi Besok.</p>",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#fdcb6e',
		})
			<?php
		}
		?>
	})
</script>