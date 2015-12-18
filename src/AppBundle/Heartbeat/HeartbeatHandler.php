<?php

namespace AppBundle\Heartbeat;

use Buzz\Browser;
use Doctrine\ORM\EntityManager;

class HeartbeatHandler
{
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function sendHeartbeat()
    {
        $ip = null;
        $localIps = $this->getLocalIp();
        if (isset($localIps['eth0'])) {
            $ip = $localIps['eth0'];
        }elseif (isset($localIps['wlan0'])) {
            $ip = $localIps['wlan0'];
        }

        if (null == $ip) {
            throw new \Exception('No local IP available.');
        }

        $settings = $this->em->getRepository('AppBundle:Settings')->findAll();
        if (count($settings) > 0) {
            $settings = $settings[0];
        } else {
            throw new \Exception('No settings provided.');
        }

        $buzz = new Browser();
        $response = $buzz->post($settings->getHeartbeatUrl(), array(
            'Content-Type' => 'application/json'
        ), json_encode(array(
            'locale_ip' => $ip,
            'printbox' => $settings->getPrintboxPid()
        )));

        if ($response->isSuccessful()) {

            return $ip;
        }

        throw new \Exception('Heartbeat failed: ' . $settings->getHeartbeatUrl() . ' ' . $response->getStatusCode() . ' ' . $response->getContent());
    }

    /**
     * @return array
     * @link http://stackoverflow.com/a/19515589/407697
     */
    protected function getLocalIp() {
        $out = explode(PHP_EOL,shell_exec("/sbin/ifconfig"));
        $local_addrs = array();
        $ifname = 'unknown';
        foreach($out as $str) {
            $matches = array();
            if(preg_match('/^([a-z0-9]+)(:\d{1,2})?(\s)+Link/',$str,$matches)) {
                $ifname = $matches[1];
                if(strlen($matches[2])>0) {
                    $ifname .= $matches[2];
                }
            } elseif(preg_match('/inet addr:((?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3})\s/',$str,$matches)) {
                $local_addrs[$ifname] = $matches[1];
            }
        }

        return $local_addrs;
    }
}