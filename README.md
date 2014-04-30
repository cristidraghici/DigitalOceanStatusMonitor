# Digital Ocean Status Monitor

The folowing script uses [Kuruka / DigitalOcean-PHP-Class](https://github.com/Kuruka/DigitalOcean-PHP-Class)

The script checks if a droplet is alive by opening a specified port. If the connection is successful, then it tries to retrieve a php file which locally checks the services on the droplet (in our example, just the MySQL server).

## Installation

* Copy the ./server.php file into your droplet;
* Copy the rest of the files into the server which will do the checking;
* Rename ./demo.php if needed;
* Edit the content of ./demo.php, if it content satisfies your needs.

* Optionally, you can set un a cron to run **Digital Ocean Status Monitor** for you.

In order to use **Digital Ocean Status Monitor** at its best, please do take the follwing into consideration:

## Example usage

```php
<?php
// DigitalOcean class 
require_once('DigitalOcean.class.php');
$ocean = new \DigitalOceanApi\DigitalOcean('client_id_here','api_key_here');

// DigitalOceanStatusMonitor class
require_once('DigitalOceanStatusMonitor.class.php');
$monitor = new \DigitalOceanStatusMonitorNamespace\DigitalOceanStatusMonitor('ip_here','port_here', 'path_here', 'timeout_here', 'droplet_name_here');

if ($monitor->check($ocean) == false) { echo 'Error'; }
?>
```

### Notes

Please take into consideration that the script has not yet been lively tested.