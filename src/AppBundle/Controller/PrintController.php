<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wlan;
use AppBundle\Form\WlanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Stiwl\PhpPrintIpp\Lib\CupsPrintIPP;
use Stiwl\PhpPrintIpp\Lib\PrintIPP;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrintController extends Controller
{
    /**
     * @Route("/print", name="print")
     */
    public function printAction(Request $request)
    {
        var_dump($this->get('printbox.printer.cupshandler')->getPrinters());
        exit;
    }
}
