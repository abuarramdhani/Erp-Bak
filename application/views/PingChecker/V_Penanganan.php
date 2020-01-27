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
                                        <option value="172.16.100.94">172.16.100.94 - IconPlus PUSAT-BANJARMASIN</option>
                                        <option value="172.16.100.26">172.16.100.26 - IconPlus PUSAT-JAKARTA</option>
                                        <option value="172.16.100.14">172.16.100.14 - IconPlus PUSAT-LAMPUNG</option>
                                        <option value="172.16.100.62">172.16.100.62 - IconPlus PUSAT-LANGKAPURA</option>
                                        <option value="172.16.100.30">172.16.100.30 - IconPlus PUSAT-MAKASSAR</option>
                                        <option value="172.16.100.18">172.16.100.18 - IconPlus PUSAT-MEDAN</option>
                                        <option value="172.16.100.22">172.16.100.22 - IconPlus PUSAT-MLATI</option>
                                        <option value="172.16.100.102">172.16.100.102 - IconPlus PUSAT-PALU</option>
                                        <option value="172.16.100.90">172.16.100.90 - IconPlus PUSAT-PEKANBARU</option>
                                        <option value="172.16.100.50">172.16.100.50 - IconPlus PUSAT-PONTIANAK</option>
                                        <option value="172.16.100.10">172.16.100.10 - IconPlus PUSAT-SURABAYA</option>
                                        <option value="172.16.100.6">172.16.100.6 - IconPlus PUSAT-TUKSONO</option>
                                        <option value="172.18.22.2">172.18.22.2 - LDP PUSAT-TUKSONO</option>
                                    </select>
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

