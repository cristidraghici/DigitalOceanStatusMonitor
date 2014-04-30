<?php
// Safeguard
if (!file_exists('_stop'))
{
    // DigitalOcean class 
    require_once('DigitalOcean.class.php');
    $ocean = new \DigitalOceanApi\DigitalOcean('client_id_here','api_key_here');
    
    // DigitalOceanStatusMonitor class
    require_once('DigitalOceanStatusMonitor.class.php');
    $monitor = new \DigitalOceanStatusMonitorNamespace\DigitalOceanStatusMonitor('ip_here','port_here', 'path_here', 'timeout_here', 'droplet_name_here');
    
    // Run the code
    if ($monitor->check($ocean) == false)
    {
        echo 'Error encountered. Droplet restarted.';
    }
    else
    {
        echo "Droplet servers are up and running.";
    }
}
?>