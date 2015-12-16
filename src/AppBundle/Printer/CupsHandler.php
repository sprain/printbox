<?php

namespace AppBundle\Printer;

use Symfony\Component\Filesystem\Filesystem;

class CupsHandler
{
    protected $defaultPrinterFile;

    public function __construct($defaultPrinterFile)
    {
        $this->defaultPrinterFile = $defaultPrinterFile;
    }

    public function getDefaultPrinter()
    {
        if (file_exists($this->defaultPrinterFile) && is_readable($this->defaultPrinterFile)) {
            return file_get_contents($this->defaultPrinterFile);
        }

        return null;
    }

    public function setDefaultPrinter($printerName)
    {
        if (!file_exists($this->defaultPrinterFile) || is_writable($this->defaultPrinterFile)) {
             return file_put_contents($this->defaultPrinterFile, $printerName);
        }

        return false;
    }

    public function getPrinters()
    {
        $response  = $this->runCommand('lpstat -p');
        $printers  = array();

        foreach($response as $row){
            preg_match('/printer\s(.*)\is/', $row, $printer);
            preg_match('/is\s(.*)\./', $row, $statusCode);

            if(end($printer)){
                $printers[] = array(
                    'name' => end($printer),
                    'status' => end($statusCode)
                );
            }
        }

        return array($printers);
    }

    public function submit($filename, $printerName = false, $capabilities = array())
    {
        if($printerName){
            $command = 'lp -d ' . $printerName . ' ';
        } else {
            $command = 'lp ';
        }

        if($capabilities){
            foreach($capabilities  as $cap){
                $command .= '-o ' . $cap . ' ';
            }
        }

        if($filename){
            $command .= $filename;
        }

        return $this->runCommand($command);
    }

    protected function runCommand($command)
    {
        exec($command . '  2>&1', $output);

        return $output;
    }
}