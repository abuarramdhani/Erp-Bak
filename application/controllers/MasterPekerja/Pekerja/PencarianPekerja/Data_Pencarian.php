<?php

class Data_Pencarian
{
  /**
   * If you want add item on <select option>, just add option like this
   */
  public $param = [
    'noind' => [
      'name' => 'No. Induk',
      'type' => 'string'
    ],
    'nama' => [
      'name' => 'Nama',
      'type' => 'string'
    ],
    'masukkerja' => [
      'name' => 'Tgl. Masuk',
      'type' => 'date'
    ],
    'tglkeluar' => [
      'name' => 'Tgl. Keluar',
      'type' => 'date'
    ],
    'alamat' => [
      'name' => 'Alamat',
      'type' => 'string'
    ],
    'jabatan' => [
      'name' => 'Jabatan',
      'type' => 'string'
    ],
    'desa' => [
      'name' => 'Desa',
      'type' => 'string'
    ],
    'kec' => [
      'name' => 'Kecamatan',
      'type' => 'string'
    ],
    'kab' => [
      'name' => 'Kabupaten',
      'type' => 'string'
    ],
    'prop' => [
      'name' => 'Provinsi',
      'type' => 'string'
    ],
    'kodesie' => [
      'name' => 'Kodesie',
      'type' => 'number'
    ],
  ];

  /**
   * This is table default on view
   * change this to add/remove table head item
   */
  public $table_head_default = [
    'No',
    'Noind',
    'Nama',
    'Seksi',
    'Unit',
    'Tgl. Masuk',
    'Tgl. Diangkat',
    'Akhir Kontrak',
    'Tgl. Keluar',
    'Tempat Lahir',
    'Tgl Lahir',
    'Alamat',
    'Desa',
    'Kecamatan',
    'Kabupaten',
    'Propinsi',
    'Kode Pos',
    'No. HP',
    'No. Telp',
    'NIK',
    'No. KK',
    'Nokes',
    'BPU',
    'No. KPJ',
    'Email',
    'Sebab Keluar',
    'Lokasi Kerja',
  ];

  /**
   * This is table head when item jabatan is selected
   */
  public $table_head_jabatan = [
    'No',
    'Noind',
    'Nama',
    'Seksi',
    'Unit',
    'Bidang',
    'Departemen',
    'Tgl. Masuk',
    'Jabatan'
  ];
}
