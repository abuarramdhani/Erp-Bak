Script Sync otomatis Erp.quick.com lokal ke internet / begitu sebaliknya 

5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/img/ root@192.168.168.25:/var/www/html/assets/img/

5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/limbah/ root@192.168.168.25:/var/www/html/assets/limbah/

5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/upload/ root@192.168.168.25:/var/www/html/assets/upload/

5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/upload_cr/ root@192.168.168.25:/var/www/html/assets/upload_cr/

5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/upload_kaizen/ root@192.168.168.25:/var/www/html/assets/upload_kaizen/

5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/img/ /var/www/html/assets/img/

5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/limbah/ /var/www/html/assets/limbah/

5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/upload/ /var/www/html/assets/upload/

5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/upload_cr/ /var/www/html/assets/upload_cr/

5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/upload_kaizen/ /var/www/html/assets/upload_kaizen/