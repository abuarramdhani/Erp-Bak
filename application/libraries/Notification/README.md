# Notification
Module ini dibuat untuk membuat notifikasi berisi pesan singkat ke akun user yang mana user akan mendapakan notifikasi secara semi-langsung ketika trigger pengiriman notifikasi dijalankan


## Usage Example

### Initialize
```php
  // load module on controller in CI 3
  public function __construct() {
    parent::__construct();

    // here
    $this->load->library('notification');
  }

```

### Send Notification to user
```php
  // normal
  $notification = Notification::make()
  $notification->message(
    String, // Title,
    String // message
  );
  $notiication->to(String)
  // this will send to user
  $notification->send();

  // OR you can use chaining
  Notification::make()
    ->message(String, String)
    ->to(String)
    ->send();
```


### Send Notification batch
```php
  Notification::make()
    ->message(String, String)
    ->toSection(String/Int)
    ->send();

  // multiple user
    ->to(["T0001", "T0002", "T0003"])

  // to seksi 
    ->toSection('1010301') // seksi ICT
    // maka akun pekerja di seksi tsb akan mendapakan notifikasi

  // or add more section
  // semua pekerja yang mempunyai kodesie mirip dibawah ini akan menjadi penerima notifikasi
    ->toSection('310101')
    ->toSection('400101')
    ->toSection('103101')
```

### Example
```php
  public function ProductStore() {
    // single user
    Notification::make()
      ->message("Approval Baru", "Pekerja T0001 telah melakukan pengajuan surat izin")
      ->to("B0201")
      ->send();
    
    // multi user
    Notification::make()
      ->message("...", "...")
      ->to(['B0001', 'B0002', 'B0004'])
      ->send();

    // to all section/unit
    // just get section code
  }
```

### API
#### Method
  ```php
    /**
     * Penerima / User
     * 
     * @param  Mixed of String/Array
     * @return Object of this
     */
    to(Array/String)

    /**
     * Penerima / User
     * 
     * @param  String Title
     * @param  String Message
     * @param  String Url -> notifikasi ketika di klik menuju kemana
     * @return Object of this
     */
    message(String, String, String)

    /**
     * Penerima / User dalam 1 kodesie
     * 
     * @param  Mixed of String/Array
     * @return Object of this
     */
    toSection(Array/String)

    /**
     * Kirim action
     * 
     * @param  Void
     * @return Array
     */
    send()
  ```

## Thanks
> Simple life, happier you