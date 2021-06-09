<div class="box box-solid">
    <div class="box-body">
        <span id="table_info"></span>
        <form action="<?php echo base_url('PerhitunganUM/HitungOPM/exportDataPUM'); ?>" method="post">
            <div class="table-responsive">
                <table id="tblhtgopm" class="table table-striped table-bordered table-hover tblhtgopm" style="font-size: 13px;">
                    <thead class="bg-info">
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" width="4%">NO.</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">COST CENTER</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" class="text-nowrap">RESOURCE CODE</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">DESCRIPTION</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">JENIS MESIN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">NO MESIN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">TAG NUMBER</th>
                            <th hidden rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">ITEM_ID</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" class="text-nowrap">KODE KOMPONEN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">DESKRIPSI KOMPONEN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">STOK AWAL</th>
                            <th colspan="3" style="text-align: center; vertical-align: middle;">PLANNED ORDER DEMAND AND FORECAST</th>
                            <th colspan="4" style="text-align: center; vertical-align: middle;">PLAN PRODUKSI (PCS)</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">CYCLE TIME (HR)</th>
                            <th colspan="4" style="text-align: center; vertical-align: middle;">TOTAL JAM DIBUTUHKAN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">TOTAL JAM DIBUTUHKAN PER BULAN</th>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">UTILITAS MESIN (%)</th>
                        </tr>
                        <tr>
                            <?php foreach ($headerbln as $key => $val){ ?>
                                <th style="text-align: center; vertical-align: middle;"><?php echo $val['BULAN'] ?></th> 
                            <?php } ?>
                            <?php foreach ($headerbln as $key => $val){ ?>
                                <th style="text-align: center; vertical-align: middle;"><?php echo $val['BULAN'] ?></th> 
                            <?php } ?>
                            <th style="text-align: center; vertical-align: middle;">Rata-rata 1 bulan</th>
                            <?php foreach ($headerbln as $key => $val){ ?>
                                <th style="text-align: center; vertical-align: middle;"><?php echo $val['BULAN'] ?></th> 
                            <?php } ?>
                            <th style="text-align: center; vertical-align: middle;">Rata-rata 1 bulan</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1;foreach($result as $row){ ?>
                        <?php foreach($row['Detail'] as $key => $v){ ?>
                            <tr style="text-align: center; vertical-align: middle;">                        
                                <td><?= $no; ?>
                                    <input type="hidden" name="routclass[]" id="routclass" value="<?= $routclass ?>">
                                    <input type="hidden" name="rsrc[]" id="rsrc" value="<?= $rsrc ?>">
                                    <input type="hidden" name="merge[]" id="merge" value="<?= $row['Merge']?>">
                                </td>              
                                <td><input type="hidden" name="cost_center[]" id="cost_center" value="<?= $v['cost_center']?>"><?= $v['cost_center']?></td>               
                                <td class="text-nowrap"><input type="hidden" name="resource_code[]" id="resource_code" value="<?= $v['resource_code']?>"><?= $v['resource_code']?></td>               
                                <td><input type="hidden" name="deskripsi[]" id="deskripsi" value="<?= $v['deskripsi']?>"><?= $v['deskripsi']?></td>               
                                <td><input type="hidden" name="jenis_mesin[]" id="jenis_mesin" value="<?= $v['jenis_mesin']?>"><?= $v['jenis_mesin']?></td>               
                                <td style="text-align: left;"><input type="hidden" name="mesin[]" id="mesin" value="<?= $v['mesin']?>"><?= $v['mesin']?></td>               
                                <td><input type="hidden" name="tag_number[]" id="tag_number" value="<?= $v['tag_number']?>"><?= $v['tag_number']?></td>      
                                <td hidden><input type="hidden" name="item_id[]" id="item_id" value="<?= $v['item_id']?>"><?= $v['item_id']?></td>                 
                                <td class="text-nowrap"><input type="hidden" name="item[]" id="item" value="<?= $v['item']?>"><?= $v['item']?></td>               
                                <td style="text-align: left;"><input type="hidden" name="item_desc[]" id="item_desc" value="<?= $v['item_desc']?>"><?= $v['item_desc']?></td>
                                <td class="sa_<?php echo $v['item_id'] ?>"></td>
                                <td class="pod1_<?php echo $v['item_id'] ?>"></td>
                                <td class="pod2_<?php echo $v['item_id'] ?>"></td>
                                <td class="pod3_<?php echo $v['item_id'] ?>"></td>
                                <td class="bulan1_<?php echo $v['item_id'] ?>"></td>
                                <td class="bulan2_<?php echo $v['item_id'] ?>"></td>
                                <td class="bulan3_<?php echo $v['item_id'] ?>"></td>
                                <td class="ratabulan_<?php echo $v['item_id'] ?>"></td>
                                <td><input type="hidden" name="cycle_time[]" id="cycle_time" value="<?= $v['cycle_time']?>"><?= $v['cycle_time']?></td>
                                <td class="jam1_<?php echo $v['item_id'] ?>"></td>
                                <td class="jam2_<?php echo $v['item_id'] ?>"></td>
                                <td class="jam3_<?php echo $v['item_id'] ?>"></td>
                                <td class="ratajam_<?php echo $v['item_id'] ?> ratajam_<?= str_replace(' ','',$v['resource_code']) ?>"></td>
                                <td class="totaljam_<?= str_replace(' ','',$v['resource_code']) ?>"></td>
                                <td class="utilitas_<?= str_replace(' ','',$v['resource_code']) ?>"></td>
                            </tr>
                        <?php $no++; } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row  text-right" style="padding-right: 10px ">
                    <button type="submit" title="Export" class="btn btn-success">
                        <i class="fa fa-download"></i> Export Excel
                    </button>
				</div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    let master_data = Array();
    $(".tblhtgopm tbody tr").each(function(i, v){
        master_data[i] = Array();
        $(this).children('td').each(function(ii, vv){
            master_data[i][ii] = $(this).text();
        });
    })
    // console.log(master_data)
    let requests = master_data.reduce((promiseChain, item, i) => {
        return promiseChain.then(() => new Promise((resolve) => {
            asyncFunction(item, resolve, i);
        }));
    }, Promise.resolve());
    // console.log(requests)
    let total_per_resource = 0;
    let utilitas = 0;
    let resource_before = 99;
    let totalmesin = 0;
    // let idtampil = 0;

    function asyncFunction(item, cb, id) {
        // console.log(item);
        ajax_1 = $.ajax({
            url: baseurl + 'PerhitunganUM/HitungOPM/getsapod',
            type: 'POST',
            dataType: 'JSON',
            data: {
                plan: <?php echo $plan ?>,
                item_id: item[7]
            },
            cache: false,
            beforeSend: function() {

            },
            success: function(result) {
                // console.log(item);
                let sa = Number(result[0].STOK_AWAL);
                let pod1 = Number(result[0].POD1);
                let pod2 = Number(result[0].POD2);
                let pod3 = Number(result[0].POD3);

                if(sa > pod1){
                    bulan1 = 0;
                    sisa1 = sa - pod1;
                }else{
                    bulan1 = pod1 - sa;
                    sisa1 = 0;
                }
                if(sisa1 > pod2){
                    bulan2 = 0;
                    sisa2 = sisa1 - pod2;
                }else{
                    bulan2 = pod2 - sisa1;
                    sisa2 = 0;
                }
                if(sisa2 > pod3){
                    bulan3 = 0;
                }else{
                    bulan3 = pod3 - sisa2;
                }

                ratabulan = Math.round((bulan1+bulan2+bulan3)/3);
                jam1 = Math.round((bulan1*item[18])*100)/100;
                jam2 = Math.round((bulan2*item[18])*100)/100;
                jam3 = Math.round((bulan3*item[18])*100)/100;
                ratajam = Math.round(((jam1+jam2+jam3)/3)*100)/100;

                $(`.sa_${item[7]}`).html("<input type='hidden' name='sa[]' id='sa' value='"+sa+"'>"+sa+"");
                $(`.pod1_${item[7]}`).html("<input type='hidden' name='pod1[]' id='pod1' value='"+pod1+"'>"+pod1+"");
                $(`.pod2_${item[7]}`).html("<input type='hidden' name='pod2[]' id='pod2' value='"+pod2+"'>"+pod2+"");
                $(`.pod3_${item[7]}`).html("<input type='hidden' name='pod3[]' id='pod3' value='"+pod3+"'>"+pod3+"");
                $(`.bulan1_${item[7]}`).html("<input type='hidden' name='bulan1[]' id='bulan1' value='"+bulan1+"'>"+bulan1+"");
                $(`.bulan2_${item[7]}`).html("<input type='hidden' name='bulan2[]' id='bulan2' value='"+bulan2+"'>"+bulan2+"");
                $(`.bulan3_${item[7]}`).html("<input type='hidden' name='bulan3[]' id='bulan3' value='"+bulan3+"'>"+bulan3+"");
                $(`.ratabulan_${item[7]}`).html("<input type='hidden' name='ratabulan[]' id='ratabulan' value='"+ratabulan+"'>"+ratabulan+"");
                $(`.jam1_${item[7]}`).html("<input type='hidden' name='jam1[]' id='jam1' value='"+jam1+"'>"+jam1+"");
                $(`.jam2_${item[7]}`).html("<input type='hidden' name='jam2[]' id='jam2' value='"+jam2+"'>"+jam2+"");
                $(`.jam3_${item[7]}`).html("<input type='hidden' name='jam3[]' id='jam3' value='"+jam3+"'>"+jam3+"");
                $(`.ratajam_${item[7]}`).html("<input type='hidden' name='ratajam[]' id='ratajam' value='"+ratajam+"'>"+ratajam+"");

                if(id == 0) {
                    item[2] = item[2].split(' ').join('');
                    resource_before = item[2]
                    idtampil = Number($(`.ratajam_${item[2]}`).length) - 1;
                    console.log('cek', resource_before);
                    console.log('cekcekcek', idtampil);
                    console.log('cekcekcek__', id);
                    
                    total_per_resource = ratajam;
                    console.log(total_per_resource);
                    totaljam = Math.round(total_per_resource*100)/100;
                    
                    if(item[5] != ''){
                        totalmesin++;
                        console.log(totalmesin);
                    }

                    utilitas_per_resource = (totaljam/totalmesin)/487.5*100;
                    console.log(utilitas_per_resource);
                    utilitas = Math.round(utilitas_per_resource*100)/100;
                    persenutilitas = utilitas > 100 ? '100%' : utilitas+'%';

                    if(idtampil == id){
                        $(`.totaljam_${item[2]}`).each((i,v)=>{
                            if(Number(i)+1 <= totalmesin){
                                $(v).html("<input type='hidden' name='totaljam[]' id='totaljam' value='"+totaljam+"'>"+totaljam+"");
                            }else{
                                $(v).html("<input type='hidden' name='totaljam[]' id='totaljam' value=' '>");
                            }
                        });
                        $(`.utilitas_${item[2]}`).each((i,v)=>{
                            if(Number(i)+1 <= totalmesin){
                                $(v).html("<input type='hidden' name='utilitas[]' id='utilitas' value='"+persenutilitas+"'>"+persenutilitas+"");
                            }else{
                                $(v).html("<input type='hidden' name='utilitas[]' id='utilitas' value=' '>");
                            }
                        });
                        // $(`.totaljam_${item[2]}`).html("<input type='hidden' name='totaljam[]' id='totaljam' value='"+totaljam+"'>"+totaljam+"");
                        // $(`.utilitas_${item[2]}`).html("<input type='hidden' name='utilitas[]' id='utilitas' value='"+persenutilitas+"'>"+persenutilitas+"");
                    }
                }else if (id != 0){
                    item[2] = item[2].split(' ').join('');
                    if(resource_before == item[2]){
                        console.log('cekcekcek', idtampil);
                        console.log('cekcekcek__', id);

                        total_per_resource += ratajam;
                        console.log(total_per_resource);
                        totaljam = Math.round(total_per_resource*100)/100;

                        if(item[5] != ''){
                            totalmesin++;
                            console.log(totalmesin);
                        }

                        utilitas_per_resource = (totaljam/totalmesin)/487.5*100;
                        console.log(utilitas_per_resource);
                        utilitas = Math.round(utilitas_per_resource*100)/100;
                        persenutilitas = utilitas > 100 ? '100%' : utilitas+'%';
                        
                        if(idtampil == id){
                            $(`.totaljam_${item[2]}`).each((i,v)=>{
                                if(Number(i)+1 <= totalmesin){
                                    $(v).html("<input type='hidden' name='totaljam[]' id='totaljam' value='"+totaljam+"'>"+totaljam+"");
                                }else{
                                    $(v).html("<input type='hidden' name='totaljam[]' id='totaljam' value=' '>");
                                }
                            });
                            $(`.utilitas_${item[2]}`).each((i,v)=>{
                                if(Number(i)+1 <= totalmesin){
                                    $(v).html("<input type='hidden' name='utilitas[]' id='utilitas' value='"+persenutilitas+"'>"+persenutilitas+"");
                                }else{
                                    $(v).html("<input type='hidden' name='utilitas[]' id='utilitas' value=' '>");
                                }
                            });
                            // $(`.totaljam_${item[2]}`).html("<input type='hidden' name='totaljam[]' id='totaljam' value='"+totaljam+"'>"+totaljam+"");
                            // $(`.utilitas_${item[2]}`).html("<input type='hidden' name='utilitas[]' id='utilitas' value='"+persenutilitas+"'>"+persenutilitas+"");
                        }
                        
                    }
                    if(resource_before != item[2]){
                        resource_before = item[2];
                        idtampil += Number($(`.ratajam_${item[2]}`).length);

                        console.log('cekcekcek', idtampil);
                        console.log('cekcekcek__', id);

                        total_per_resource = ratajam;
                        console.log(total_per_resource);
                        totaljam = Math.round(total_per_resource*100)/100;

                        if(item[5] != ''){
                            totalmesin = 1;
                            console.log(totalmesin);
                        }

                        utilitas_per_resource = (totaljam/totalmesin)/487.5*100;
                        console.log(utilitas_per_resource);
                        utilitas = Math.round(utilitas_per_resource*100)/100;
                        persenutilitas = utilitas > 100 ? '100%' : utilitas+'%';

                        if(idtampil == id){
                            $(`.totaljam_${item[2]}`).each((i,v)=>{
                                if(Number(i)+1 <= totalmesin){
                                    $(v).html("<input type='hidden' name='totaljam[]' id='totaljam' value='"+totaljam+"'>"+totaljam+"");
                                }else{
                                    $(v).html("<input type='hidden' name='totaljam[]' id='totaljam' value=' '>");
                                }
                            });
                            $(`.utilitas_${item[2]}`).each((i,v)=>{
                                if(Number(i)+1 <= totalmesin){
                                    $(v).html("<input type='hidden' name='utilitas[]' id='utilitas' value='"+persenutilitas+"'>"+persenutilitas+"");
                                }else{
                                    $(v).html("<input type='hidden' name='utilitas[]' id='utilitas' value=' '>");
                                }
                            });
                            // $(`.totaljam_${item[2]}`).html("<input type='hidden' name='totaljam[]' id='totaljam' value='"+totaljam+"'>"+totaljam+"");
                            // $(`.utilitas_${item[2]}`).html("<input type='hidden' name='utilitas[]' id='utilitas' value='"+persenutilitas+"'>"+persenutilitas+"");
                        }
                    }
                }


                // if(id != 0){ 
                //     if(resource_before == item[2]){
                //         let index_terakir_09 = '';
                //         $(`.ratajam_${item[2]}`).each((i,v)=>{
                //             total_per_resource += $(v).text();
                //             index_terakir_09 = i;
                //         });
                //         console.log('cekcekcek', Number($(`.ratajam_${item[2]}`).length) - 1);
                //         console.log('cekcekcek__', Number(index_terakir_09));

                //         if( (Number($(`.ratajam_${item[2]}`).length) - 1) == Number(index_terakir_09)){
                //             total_per_resource = 0;
                //             $(`.totaljam_${item[2]}`).text(Math.round(total_per_resource*100)/100);
                //         }
                //         resource_before = item[2];
                //     }else {
                //         resource_before = item[2];
                //     }
                // //     if (utilitas > 100){
                // //         $(`.utilitas`).text('100.00%');
                // //     }else{
                // //         $(`.utilitas`).text(utilitas);
                // //     }
                // }else if(id == 0){
                //     resource_before = item[2];
                // }

                cb();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire({
                    allowOutsideClick: true,
                    type: 'error',
                    cancelButtonText: 'Ok!',
                    html: 'Proses Dihentikan',
                })
                ajax_1 = null;
                console.error();
            }
        })
    }
})

</script>