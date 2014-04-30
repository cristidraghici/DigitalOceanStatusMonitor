<?php
namespace DigitalOceanStatusMonitorNamespace;

class DigitalOceanStatusMonitor
{
    public $server;
    public $ip;
    public $port;
    public $path;
    public $droplet;
    
    private $socket;
    private $errorNo;
    private $errorStr;
    private $timeout;
    
    /** Init the class */
	public function __construct($server, $port, $path='/', $timeout=30, $droplet=null) {
		$this->server = $server;
        $this->ip     = @gethostbyname($server);
		$this->port   = $port;
		$this->path   = $path;
        $this->droplet= $droplet;
        
        $this->timeout = $timeout;
        
        return true;
	}
    
    // do the checking
    public function check($ocean=null)
    {
        if ($this->request() != false)
        {
            return true;
        }
        
        if ($ocean != null)
        {
            $this->restartDroplet($ocean);
        }
        
        return false;
    }
    
    // do the restart
    public function restartDroplet($ocean)
    {
        if ($this->droplet == null)
        {
            $droplets = @get_object_vars($ocean->getDroplets());
            if (is_array($droplets))
            {
                $i=0;
                $x=0;
                foreach ($droplets as $drops) {
                    if (!is_array($drops)) {
                        echo $i . '. Status: ' . $drops . '<br />';
                    } else {
                        echo $i . '. Name: ' . $drops[$x]->name . '<br />';
                        echo $i . '. IP: ' . $drops[$x]->ip_address . '<br />';
                        $x++;
                        
                        /** this is the restart code */
                        if ($drops[$x]->ip_address == $this->ip)
                        {
                            $ocean->reboot( $drops[$x]->name );
                        }
                        /** end */
                    }
                    $i++;
                }
            }
            /*
            0. Status: OK
            1. Name: your-droplet-name
            1. IP: your-droplet-ip
            */
        }
        else
        {
            $ocean->reboot( $this->droplet );
        }
    }
    
    // HTTP helpers
    function connect()
    {
        $this->socket = @fsockopen($this->server, $this->port, $this->errorNo, $this->errorStr, $this->timeout );
        if (!$this->socket)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    function request()
    {
        if ($this->connect())
        {
            $result = '';
            
            fwrite($this->socket,
                "GET ".$this->path." HTTP/1.1\r\n".
                "Host: ".$this->server.":".$this->port."\r\n".
                "Connection: Close\r\n\r\n"
            );
            
            while(!@feof($this->socket))
            {
                $result .= @fgets($this->socket, 2048);
            }
            @fclose($this->socket);
            $result = substr($result, strpos($result,"\r\n\r\n")+4);
            
            if ($result != 'Error')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
        return false;
    }
}

?>