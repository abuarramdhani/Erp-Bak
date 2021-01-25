<?php ?>
<input type="hidden" value="<?= $namaa ?>" id="nama_slide">
<?php ?>
<script src="<?php echo base_url('assets/plugins/sweetAlert/sweetalert.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var n = $('#nama_slide').val();
        Swal.fire({
            title: "Slide Show telah disimpan dan bisa di akses di Link berikut",
            text: baseurl + "Slide/Show/Name/" + n,
            type: "success",
            showCancelButton: true,
            confirmButtonColor: "#00a65a",
            cancelButtonColor: "#b0bec5",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
        }).then((result) => {
            if (result.value) {
                window.open(baseurl + "Slide/Show/Name/" + n, "_blank");
                location.href = baseurl + "Slideshow/UploadFile";
            } else {
                location.href = baseurl + "Slideshow/UploadFile";
            }
        });
    })
</script>