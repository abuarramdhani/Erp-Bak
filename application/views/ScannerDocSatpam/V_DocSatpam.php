<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      $folder = ('./assets/upload/docsatpam');
      if (!($open_folder = opendir($folder))) {
        die("eRorr... Tidak bisa membuka folder");
      }

      $file_array = array();
      while ($read_folder = readdir($open_folder)) {
        if (substr($read_folder,0,1)!='.') {
          $file_array[] = $read_folder;
        }
      }
      // echo "<pre>";print_r($file_array);echo "</pre>";

      while (list($index, $file_name) = each($file_array)) {
        $nomor = $index + 1;
        echo "$nomor. <a href='".base_url('/assets/upload/docsatpam/'.$file_name)."'>$file_name</a>";
        echo "<br>";
      }

      closedir($open_folder);
     ?>
  </body>
</html>
