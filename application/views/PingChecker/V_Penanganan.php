<section class="content">
    <div class="row">
        <div class="col-lg-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Input Penanganan</h3>
                </div>
                <form action="<?= base_url('PingChecker/Monitoring/SaveData') ?>" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <th>IP/Link</th>
                                <th>:</th>
                                <td>
                                    <select class="slcIPIPM" style="width:350px;" name="slcIPIPM" tabindex="1" required>
                                        <option></option>
                                        <option value="172.16.100.93" title="IconPlus PUSAT-BANJARMASIN">172.16.100.93 - IconPlus PUSAT-BANJARMASIN</option>
                                        <option value="172.16.100.25" title="IconPlus PUSAT-JAKARTA">172.16.100.25 - IconPlus PUSAT-JAKARTA</option>
                                        <option value="172.16.100.61" title="IconPlus PUSAT-LANGKAPURA">172.16.100.61 - IconPlus PUSAT-LANGKAPURA</option>
                                        <option value="172.16.100.29" title="IconPlus PUSAT-MAKASSAR">172.16.100.29 - IconPlus PUSAT-MAKASSAR</option>
                                        <option value="172.16.100.17" title="IconPlus PUSAT-MEDAN">172.16.100.17 - IconPlus PUSAT-MEDAN</option>
                                        <option value="172.16.100.21" title="IconPlus PUSAT-MLATI">172.16.100.21 - IconPlus PUSAT-MLATI</option>
                                        <option value="172.16.100.101" title="IconPlus PUSAT-PALU">172.16.100.101 - IconPlus PUSAT-PALU</option>
                                        <option value="172.16.100.89" title="IconPlus PUSAT-PEKANBARU">172.16.100.89 - IconPlus PUSAT-PEKANBARU</option>
                                        <option value="172.16.100.49" title="IconPlus PUSAT-PONTIANAK">172.16.100.49 - IconPlus PUSAT-PONTIANAK</option>
                                        <option value="172.16.100.9" title="IconPlus PUSAT-SURABAYA">172.16.100.9 - IconPlus PUSAT-SURABAYA</option>
                                        <option value="172.16.100.5" title="IconPlus PUSAT-TUKSONO">172.16.100.5 - IconPlus PUSAT-TUKSONO</option>
                                        <option value="172.18.22.1" title="LDP PUSAT-TUKSONO">172.18.22.1 - LDP PUSAT-TUKSONO</option>
                                        <option value="192.168.38.25" title="TUKSONO PNP">192.168.38.25 - TUKSONO PNP</option>
                                        <option value="192.168.38.11" title="TUKSONO SHEET METAL">192.168.38.11 - TUKSONO SHEET METAL</option>
                                        <option value="192.168.38.22" title="TUKSONO MACH TIMUR">192.168.38.22 - TUKSONO MACH TIMUR</option>
                                        <option value="192.168.38.203" title="TUKSONO MACH BARAT">192.168.38.203 - TUKSONO MACH BARAT</option>
                                        <option value="192.168.38.14" title="TUKSONO FOUNDRY">192.168.38.14 - TUKSONO FOUNDRY</option>
                                        <option value="192.168.38.24" title="TUKSONO HTM">192.168.38.24 - TUKSONO HTM</option>
                                    </select>
                                    <input type="hidden" class="form-control ipnameIPM" name="ipNameIPM">
                                </td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <th>:</th>
                                <td><textArea class="form-control" style="width:500px;" tabindex="2" required placeholder="Masukan Action" name="actionIPM"></textArea></td>    
                            </tr>
                            <tr>
                                <th>No Ticket</th>
                                <th>:</th>
                                <td><input type="text" style="width:300px;" class="form-control" name="ticketIPM" tabindex="3" placeholder="Masukan No Ticket"></td>     
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div align="right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

