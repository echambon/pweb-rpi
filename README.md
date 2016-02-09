PWEB-RPI
============
Raspberry PI monitoring page for pweb

pweb is distributed under The MIT License (see LICENSE)

Website: http://emmanuel-chambon.fr/22

DESCRIPTION
============

On this page, you can get basic information on your Raspberry PI webserver (compatible with nginx):

* Hostname;
* Uptime (/var/run/nginx.pid);
* CPU temperature (measure_temp);
* Network load (ifconfig);
* Active connections (netstat);

INSTALLATION
============

* Copy and paste the file in the adm folder of a valid pweb installation;
* Add a link in the menu (adm/menu.php) if you want;
* Access page from the administation board as any other page (/adm/rpi);
* Make sure the user www-data is in the video group.
