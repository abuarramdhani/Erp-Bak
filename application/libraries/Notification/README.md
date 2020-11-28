# Notification

## usage example
```php
  /**
 * Usage Example on CI 3
 * 
 * $this->load->library('notification');
 * 
 * $Notification = new Notification;
 * 
 * $Notification->message('Selamat Datang', 'Silahkan mengecek data diri anda', Notification::PRIORITY_LOW)
 * $Notification->to('T0013');
 * 
 * you also can use chaining ways
 * $Notification
 *  ->message('Selamat Datang', 'Silahkan mengecek data diri anda', Notification::PRIORITY_LOW)
 *  ->to('T0013');
 * 
 * OR YOU also can use static method
 * 
 * Notification::make()
 *  ->message([])
 *  ->to('someone')
 *  ->send()
 */
```