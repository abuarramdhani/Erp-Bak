Script Sync otomatis Erp.quick.com lokal ke internet / begitu sebaliknya 

*/5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/img/ root@192.168.168.25:/var/www/html/assets/img/

*/5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/limbah/ root@192.168.168.25:/var/www/html/assets/limbah/

*/5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/upload/ root@192.168.168.25:/var/www/html/assets/upload/

*/5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/upload_cr/ root@192.168.168.25:/var/www/html/assets/upload_cr/

*/5 * * * * rsync -azP --perms --chmod=777 /var/www/html/assets/upload_kaizen/ root@192.168.168.25:/var/www/html/assets/upload_kaizen/

*/5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/img/ /var/www/html/assets/img/

*/5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/limbah/ /var/www/html/assets/limbah/

*/5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/upload/ /var/www/html/assets/upload/

*/5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/upload_cr/ /var/www/html/assets/upload_cr/

*/5 * * * * rsync -azP --perms --chmod=777 root@192.168.168.25:/var/www/html/assets/upload_kaizen/ /var/www/html/assets/upload_kaizen/

* /5 * * * * rsync -azP --perms --chmod=777 root@quick.com:/var/www/aplikasi/photo/* /var/www/html/assets/img/photo/

*/5 * * * * cd /var/www/html && git pull > /home/administrator/cronerp.txt

*/5 * * * * cd /var/www/html/approval-izin-satpam && git pull > /home/administrator/cronizinsatpam.txt

*/5 * * * * cd /var/www/html/ekatalog && git pull > /home/administrator/cronekatalog.txt

*/5 * * * * cd /var/www/html/portal-karyawan && git pull > /home/administrator/cronportal.txt

*/5 * * * * cd /var/www/html/perizinan && git pull > /home/administrator/cronizin.txt

*/5 * * * * cd /var/www/html/quick-support-system && git pull > /home/administrator/cronqss.txt

*/5 * * * * cd /var/www/html/presensi_cabang && git pull > /home/administrator/cronpresensicabang.txt

6,11,16,21,26,31,36,41,46,51,56 * * * * sh /home/administrator/email_proses_update.sh