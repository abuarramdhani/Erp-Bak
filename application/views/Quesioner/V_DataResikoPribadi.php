<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title">Data Resiko Pribadi</h1>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="tblDataresikoPribadiMP" width="300%">
                        <thead>
                            <tr class="bg-primary">
                                <th class="bg-primary">No</th>
                                <th class="bg-primary">Nama</th>
                                <th class="bg-primary">Seksi</th>
                                <th>Resiko tertular di luar rumah (10)</th>
                                <th>Resiko tertular di dalam rumah (6)</th>
                                <th>Imunitas (5)</th>
                                <th>Histori kesehatan 2 Minggu terakhir (9)</th>
                                <th>Total</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                                <th>7</th>
                                <th>8</th>
                                <th>9</th>
                                <th>10</th>
                                <th>11</th>
                                <th>12</th>
                                <th>13</th>
                                <th>14</th>
                                <th>15</th>
                                <th>16</th>
                                <th>17</th>
                                <th>18</th>
                                <th>19</th>
                                <th>20</th>
                                <th>21</th>
                                <th>22</th>
                                <th>23</th>
                                <th>24</th>
                                <th>25</th>
                                <th>26</th>
                                <th>27</th>
                                <th>28</th>
                                <th>29</th>
                                <th>30</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; foreach ($data_resiko_pribadi as $key => $list) { $no++; ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $list['nama'];?></td>
                                <td><?= $list['seksi'];?></td>
                                <td><?= $list['r_luar_rumah'];?></td>
                                <td><?= $list['r_dalam_rumah'];?></td>
                                <td><?= $list['r_imun'];?></td>
                                <td><?= $list['r_kesehatan'];?></td>
                                <td><?= $list['total'];?></td>
                                <td><?= $list['question_1'];?></td>
                                <td><?= $list['question_2'];?></td>
                                <td><?= $list['question_3'];?></td>
                                <td><?= $list['question_4'];?></td>
                                <td><?= $list['question_5'];?></td>
                                <td><?= $list['question_6'];?></td>
                                <td><?= $list['question_7'];?></td>
                                <td><?= $list['question_8'];?></td>
                                <td><?= $list['question_9'];?></td>
                                <td><?= $list['question_10'];?></td>
                                <td><?= $list['question_11'];?></td>
                                <td><?= $list['question_12'];?></td>
                                <td><?= $list['question_13'];?></td>
                                <td><?= $list['question_14'];?></td>
                                <td><?= $list['question_15'];?></td>
                                <td><?= $list['question_16'];?></td>
                                <td><?= $list['question_17'];?></td>
                                <td><?= $list['question_18'];?></td>
                                <td><?= $list['question_19'];?></td>
                                <td><?= $list['question_20'];?></td>
                                <td><?= $list['question_21'];?></td>
                                <td><?= $list['question_22'];?></td>
                                <td><?= $list['question_23'];?></td>
                                <td><?= $list['question_24'];?></td>
                                <td><?= $list['question_25'];?></td>
                                <td><?= $list['question_26'];?></td>
                                <td><?= $list['question_27'];?></td>
                                <td><?= $list['question_28'];?></td>
                                <td><?= $list['question_29'];?></td>
                                <td><?= $list['question_30'];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</section>