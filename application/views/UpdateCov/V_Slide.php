<section class="content-header">
    <div class="row">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <input type="hidden" id="time_slide" value="<?= $f[0]['SLIDE_TRANSITION_TIME'] ?>">
                <?php foreach ($f as $key => $h) {
                    if ($key == 0) { ?>
                        <div class="item active">
                            <img class="d-block w-100" style="height:98%;float:none;margin:0 auto" src="<?php echo base_url($h['FILE_DIR_ADDRESS']); ?>">
                        </div>
                    <?php } else { ?>
                        <div class="item">
                            <img class="d-block w-100" style="height:98%;;float:none;margin:0 auto" src="<?php echo base_url($h['FILE_DIR_ADDRESS']); ?>">
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</section>