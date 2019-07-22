<div>
    <div class="row">
        <table class="table table-bordered" style="font-size:11px;">
            <tr>
                <td rowspan="4">
                    <img src="<?php echo base_url('assets/img/logo.png')?>" style="width:80px;"/>
                </td>
                <td rowspan="4" style="width: 300px; padding-left: 5px; padding-right: 5px;">
                    <h4>
                        <b>
                            CV. KARYA HIDUP SENTOSA
                        </b>
                    </h4>
                    <small>
                        Jl. Magelang No. 144 Yogyakarta 55241
                    </small>
                    <br>
                        <small>
                            Phone: (0274) 563217, 556923, 513025, 584874, 512095 (hunting)
                        </small>
                        <br>
                            <small>
                                Email: operator1@quick.co.id
                            </small>
                            <br>
                                <small>
                                    Fax: (0274) 563523
                                </small>
                                <br>
                                </br>
                            </br>
                        </br>
                    </br>
                </td>
                <td colspan="2" style="padding: 5px; text-align: center;">
                    <h5>
                        <b>
                            CORRECTIVE ACTION REQUEST (CAR)
                        </b>
                    </h5>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;">
                    CAR Number
                </td>
                <td style="padding: 5px;">
                    NC-PUR-05-17-002 ( 1 )
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;">
                    CAR Type
                </td>
                <td style="padding: 5px;">
                    <input class="form-control" name="CLAIM" type="checkbox">
                        CLAIM
                        <input class="form-control" name="COMPLAIN" type="checkbox">
                            COMPLAIN
                        </input>
                    </input>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;">
                    NC Scope
                </td>
                <td style="padding: 5px;">
                    <input class="form-control" name="Delivery" type="checkbox">
                        Delivery
                        <input class="form-control" name="Quality" type="checkbox">
                            Quality
                            <input class="form-control" name="Quantity" type="checkbox">
                                Quantity
                                <input class="form-control" name="Other" type="checkbox">
                                    Other
                                </input>
                            </input>
                        </input>
                    </input>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-12">
        <h5>
            <b>
                ATTACHMENT
            </b>
        </h5>
        <hr/>
        <br><br>
        <table class="table">
            <tr>
                <?php foreach ($image as $key => $img) { ?>
                    <td align="center">
                        <img style="max-height : 100px;" src="<?php echo base_url().$img['image_path'].''.$img['file_name']; ?>">
                    </td>
                <?php } ?>
            </tr>
            <!-- <tr>
                <td align="center">
                <?php foreach ($lines as $ln) { ?>
                    <img src="<?php echo base_url('assets/upload_pm/'.$ln['image1']); ?>" style="max-width: 300px;padding-bottom: 5px;">
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td align="center">
                <?php foreach ($lines as $ln) { ?>
                    <img src="<?php echo base_url('assets/upload_pm/'.$ln['image2']); ?>" style="max-width: 80%;padding-top: 5px;">
                <?php } ?>
                </td>
            </tr> -->
        </table>
    </div>
    <div class="row" style="font-size:12px;">
        <hr>
        Vendor must give their respond maximum 6 days from the date of this CAR
    </div>
</div>