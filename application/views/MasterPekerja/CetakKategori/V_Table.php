<table id="TDP_viewall" class="table table-striped table-bordered table-hover text-left">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <th class="induk">No Induk</th>
            <th class="nama">Nama</th>
            <th class="jenkel">Jenis Kelamin</th>
            <th class="agama">Agama</th>
            <th class="tempatlahir">Tempat Lahir</th>
            <th class="tgllahir">Tgl. Lahir</th>
            <th class="goldarah">Gol. Darah</th>
            <th class="nik">NIK</th>
            <th class="no_kk">NO KK</th>
            <th class="nohp">NO HP</th>
            <th class="notelepon">NO Telepon</th>

            <th class="alamat">Alamat</th>
            <th class="prop">Provinsi</th>
            <th class="kab">Kabupaten</th>
            <th class="kec">Kecamatan</th>
            <th class="desa">Desa</th>
            <th class="kodepos">Kode Pos</th>
            <th class="statrumah">Status Rumah</th>
            <th class="almt_kost">Alamat Kost</th>

            <th class="gelard">Gelar Depan</th>
            <th class="gelarb">Gelar Belakang</th>
            <th class="pendidikan">Pendidikan</th>
            <th class="jurusan">Jurusan</th>
            <th class="sekolah">Sekolah</th>

            <th class="namaayah">Nama Ayah</th>
            <th class="namaibu">Nama Ibu</th>
            <th class="statnikah">Status Nikah</th>
            <th class="tglnikah">Tgl. Nikah</th>
            <th class="jumanak">Jumlah Anak</th>
            <th class="jumsdr">Jumlah Saudara</th>
            <th class="jtanak">JT Anak</th>
            <th class="jtbknanak">JTBKN Anak</th>

            <th class="email_internal">Email Internal</th>
            <th class="email_external">Email</th>
            <th class="telkomsel_mygroup">Telkomsel Myroup</th>
            <th class="pidgin">Akun Pidgin</th>
            <th class="uk_baju">Ukuran Baju</th>
            <th class="uk_celana">Ukuran Celana</th>
            <th class="uk_sepatu">Ukuran Sepatu</th>

            <th class="kodesie">Kode Sie</th>
            <th class="kodejabatan">Kode Jabatan</th>
            <th class="jabatan">Jabatan</th>
            <th class="dept">Departemen</th>
            <th class="unit">Unit</th>
            <th class="seksi">Seksi</th>
            <th class="bidang">Bidang</th>
            <th class="pekerjaan">Pekerjaan</th>
            <th class="asalkantor">Kantor Asal</th>
            <th class="lokasi_kerja">Lokasi Kerja</th>
            <th class="ruang">Ruang</th>
            
            <th class="asal_outsourcing">Asal Outsourcing</th>
            <th class="golkerja">Gol. Kerja</th>
            <th class="masukkerja">Tgl. Masuk Kerja</th>
            <th class="diangkat">Tgl. Diangkat</th>
            <th class="lmkontrak">Lama Kontrak</th>
            <th class="akhkontrak">Akhir Kontrak</th>
            <th class="tglkeluar">Tgl. Keluar</th>
            <th class="sebabklr">Sebab Keluar</th>

            <th class="statpajak">Status Pajak</th>
            <th class="npwp">NPWP</th>

            <th class="makan">Tempat Makan</th>
            <th class="makan1">Tempat Makan 1</th>
            <th class="makan2">Tempat Makan 2</th>

            <th class="tglspsi">Tgl. Daftar SPSI</th>
            <th class="nospsi">No. SPSI</th>
            <th class="tglkop">Tgl. Daftar Koperasi</th>
            <th class="nokop">No. Koperasi</th>

            <th class="nokeb">No. Keb</th>
            <th class="upamk">Ang_upamk</th>

            <th class="nokes">No. Kes</th>
            <th class="tglmulaik">Tgl. Mulai</th>
            <th class="tglakhirk">Tgl. Akhir</th>
            <th class="bpu">BPU</th>
            <th class="bpg">BPG</th>
            <th class="rsb">RSB</th>
            <th class="dokterjpk">Dokter JPK</th>

            <th class="nokpj">No. KPJ</th>
            <th class="tglmulai">Tgl. Mulai</th>
            <th class="tglakhir">Tgl. Akhir</th>
            <th class="pensiun">Kartu Jaminan Pensiun</th>



        </tr>
    </thead>
    <tbody>
        <?php foreach ($FilterAktif as $key => $val) : {
                if (isset($select)) {
                    ?>
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <?php
                        if (in_array("tp.noind", $select)) { echo "<td>" . $val['noind'] . "</td>";}
                        if (in_array("tp.nama", $select)) { echo "<td>" . $val['nama'] . "</td>";}
                        if (in_array("tp.jenkel", $select)) { echo "<td>" . $val['jenkel'] . "</td>";}
                        if (in_array("tp.agama", $select)) { echo "<td>" . $val['agama'] . "</td>";}
                        if (in_array("tp.templahir", $select)) { echo "<td>" . $val['templahir'] . "</td>";}
                        if (in_array("to_char(tgllahir", $select)) { echo "<td>" . $val['tgllahir'] . "</td>";}
                        if (in_array("tp.goldarah", $select)) { echo "<td>" . $val['goldarah'] . "</td>";}
                        if (in_array("tp.nik", $select)) { echo "<td>" . $val['nik'] . "</td>";}
                        if (in_array("tp.no_kk", $select)) { echo "<td>" . $val['no_kk'] . "</td>";}
                        if (in_array("tp.nohp", $select)) { echo "<td>" . $val['nohp'] . "</td>";}
                        if (in_array("tp.telepon", $select)) { echo "<td>" . $val['telepon'] . "</td>";}

                        if (in_array("tp.alamat", $select)) { echo "<td>" . $val['alamat'] . "</td>";}
                        if (in_array("tp.prop", $select)) { echo "<td>" . $val['prop'] . "</td>";}
                        if (in_array("tp.kab", $select)) { echo "<td>" . $val['kab'] . "</td>";}
                        if (in_array("tp.kec", $select)) { echo "<td>" . $val['kec'] . "</td>";}
                        if (in_array("tp.desa", $select)) { echo "<td>" . $val['desa'] . "</td>";}
                        if (in_array("tp.kodepos", $select)) { echo "<td>" . $val['kodepos'] . "</td>";}
                        if (in_array("tp.statrumah", $select)) { echo "<td>" . $val['statrumah'] . "</td>";}
                        if (in_array("tp.almt_kost", $select)) { echo "<td>" . $val['almt_kost'] . "</td>";}

                        if (in_array("tp.gelard", $select)) { echo "<td>" . $val['gelard'] . "</td>";}
                        if (in_array("tp.gelarb", $select)) { echo "<td>" . $val['gelarb'] . "</td>";}
                        if (in_array("tp.pendidikan", $select)) { echo "<td>" . $val['pendidikan'] . "</td>";}
                        if (in_array("tp.jurusan", $select)) { echo "<td>" . $val['jurusan'] . "</td>";}
                        if (in_array("tp.sekolah", $select)) { echo "<td>" . $val['sekolah'] . "</td>";}

                        if (in_array("(select tk.nama from hrd_khs.tkeluarga tk where nokel = '01A' and tk.noind = tp.noind limit 1) ayah", $select)) { echo "<td>" . $val['ayah'] . "</td>";}
                        if (in_array("(select tk.nama from hrd_khs.tkeluarga tk where nokel = '02A' and tk.noind = tp.noind limit 1) ibu", $select)) { echo "<td>" . $val['ibu'] . "</td>";}
                        if (in_array("tp.statnikah", $select)) { echo "<td>" . $val['statnikah'] . "</td>";}
                        if (in_array("to_char(tglnikah", $select)) { echo "<td>" . $val['tglnikah'] . "</td>";}
                        if (in_array("tp.jumanak", $select)) { echo "<td>" . $val['jumanak'] . "</td>";}
                        if (in_array("tp.jumsdr", $select)) { echo "<td>" . $val['jumsdr'] . "</td>";}
                        if (in_array("tp.jtanak", $select)) { echo "<td>" . $val['jtanak'] . "</td>";}
                        if (in_array("tp.jtbknanak", $select)) { echo "<td>" . $val['jtbknanak'] . "</td>";}
                        
                        if (in_array("tp.email_internal", $select)) { echo "<td>" . $val['email_internal'] . "</td>";}
                        if (in_array("tp.email", $select)) { echo "<td>" . $val['email'] . "</td>";}
                        if (in_array("tp.telkomsel_mygroup", $select)) { echo "<td>" . $val['telkomsel_mygroup'] . "</td>";}
                        if (in_array("tp.pidgin_account", $select)) { echo "<td>" . $val['pidgin_account'] . "</td>";}
                        if (in_array("tp.uk_baju", $select)) { echo "<td>" . $val['uk_baju'] . "</td>";}
                        if (in_array("tp.uk_celana", $select)) { echo "<td>" . $val['uk_celana'] . "</td>";}
                        if (in_array("tp.uk_sepatu", $select)) { echo "<td>" . $val['uk_sepatu'] . "</td>";}

                        if (in_array("tp.kodesie", $select)) { echo "<td>" . $val['kodesie'] . "</td>";}
                        if (in_array("tp.kd_jabatan", $select)) { echo "<td>" . $val['kd_jabatan'] . "</td>";}
                        if (in_array("tp.jabatan", $select)) { echo "<td>" . $val['jabatan'] . "</td>";}
                        if (in_array("ts.dept", $select)) { echo "<td>" . $val['dept'] . "</td>";}
                        if (in_array("ts.unit", $select)) { echo "<td>" . $val['unit'] . "</td>";}
                        if (in_array("ts.seksi", $select)) { echo "<td>" . $val['seksi'] . "</td>";}
                        if (in_array("ts.bidang", $select)) { echo "<td>" . $val['bidang'] . "</td>";}   
                        if (in_array("case when tp.kd_pkj is null then null else (select pekerjaan from hrd_khs.tpekerjaan tpe where tp.kd_pkj = tpe.kdpekerjaan) end pekerjaan", $select)) { echo "<td>" . $val['pekerjaan'] . "</td>";}   
                        if (in_array("tp.kantor_asal", $select)) { echo "<td>" . $val['kantor_asal'] . "</td>";}                    
                        if (in_array("tp.lokasi_kerja", $select)) { echo "<td>" . $val['lokasi_kerja'] . "</td>";}
                        if (in_array("tp.ruang", $select)) { echo "<td>" . $val['ruang'] . "</td>";}

                        if (in_array("tp.asal_outsourcing", $select)) { echo "<td>" . $val['asal_outsourcing'] . "</td>";}
                        if (in_array("tp.golkerja", $select)) { echo "<td>" . $val['golkerja'] . "</td>";}
                        if (in_array("to_char(masukkerja", $select)) { echo "<td>" . $val['masukkerja'] . "</td>";}
                        if (in_array("to_char(diangkat,", $select)) { echo "<td>" . $val['diangkat'] . "</td>";}
                        if (in_array("tp.lmkontrak", $select)) { echo "<td>" . $val['lmkontrak'] . "</td>";}
                        if (in_array("to_char(akhkontrak", $select)) { echo "<td>" . $val['akhkontrak'] . "</td>";}
                        if (in_array("to_char(tglkeluar", $select)) { echo "<td>" . $val['tglkeluar'] . "</td>";}
                        if (in_array("tp.sebabklr", $select)) { echo "<td>" . $val['sebabklr'] . "</td>";}

                        if (in_array("tp.statpajak", $select)) { echo "<td>" . $val['statpajak'] . "</td>";}
                        if (in_array("tp.npwp", $select)) { echo "<td>" . $val['npwp'] . "</td>";}

                        if (in_array("tp.tempat_makan", $select)) { echo "<td>" . $val['tempat_makan'] . "</td>";}
                        if (in_array("tp.tempat_makan1", $select)) { echo "<td>" . $val['tempat_makan1'] . "</td>";}
                        if (in_array("tp.tempat_makan2", $select)) { echo "<td>" . $val['tempat_makan2'] . "</td>";}

                        if (in_array("to_char(tglspsi", $select)) { echo "<td>" . $val['tglspsi'] . "</td>";}
                        if (in_array("tp.nospsi", $select)) { echo "<td>" . $val['nospsi'] . "</td>";}
                        if (in_array("to_char(tglkop", $select)) { echo "<td>" . $val['tglkop'] . "</td>";}
                        if (in_array("tp.nokoperasi", $select)) { echo "<td>" . $val['nokoperasi'] . "</td>";}

                        if (in_array("tp.nokeb", $select)) { echo "<td>" . $val['nokeb'] . "</td>";}
                        if (in_array("tp.ang_upamk", $select)) { echo "<td>" . $val['ang_upamk'] . "</td>";}

                        if (in_array("tb.no_peserta", $select)) { echo "<td>" . $val['no_peserta'] . "</td>";}
                        if (in_array("to_char(tb.tglmulai", $select)) { echo "<td>" . $val['tglmulaik'] . "</td>";}
                        if (in_array("to_char(tb.tglakhir", $select)) { echo "<td>" . $val['tglakhirk'] . "</td>";}
                        if (in_array("tb.bpu", $select)) { echo "<td>" . $val['bpu'] . "</td>";}
                        if (in_array("tb.bpg", $select)) { echo "<td>" . $val['bpg'] . "</td>";}
                        if (in_array("tb.rsb", $select)) { echo "<td>" . $val['rsb'] . "</td>";}
                        if (in_array("tb.dokterjpk", $select)) { echo "<td>" . $val['dokterjpk'] . "</td>";}

                        if (in_array("ttk.no_peserta", $select)) { echo "<td>" . $val['no_peserta'] . "</td>";}
                        if (in_array("to_char(ttk.tglmulai", $select)) { echo "<td>" . $val['tglmulai'] . "</td>";}
                        if (in_array("to_char(ttk.tglakhir", $select)) { echo "<td>" . $val['tglakhir'] . "</td>";}
                        if (in_array("ttk.kartu_jaminan_pensiun", $select)) { echo "<td>" . $val['kartu_jaminan_pensiun'] . "</td>";}
                    
                                                                   
                        ?>

                    </tr>
        <?php }
            }
        endforeach; ?>
</table>