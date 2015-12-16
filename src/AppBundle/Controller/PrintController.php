<?php

namespace AppBundle\Controller;

use AppBundle\Form\PrintType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PrintController extends Controller
{
    /**
     * @Route("/print", name="print")
     * @Method({"POST"})
     */
    public function printAction(Request $request)
    {
        $form = $this->createForm(PrintType::class);
        $form->handleRequest($request);

        $defaultPrinter = $this->get('printbox.printers')->getDefaultPrinter();
        if (!$defaultPrinter) {
            $this->get('logger')->error('PRINTING FAILED: No current printer selected.');
            return new Response('Print failed: No current printer selected.', 500);
        }

        if ($form->isValid()) {
            $file = $form->getData()['file'];
            if (!$file) {
                $this->get('logger')->error('PRINTING FAILED: Empty file provided.');
                return new Response('Print failed: No file provided.', 400);
            }

            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file = $file->move($this->getParameter('print_dir'), $fileName);

            $printResponse = $this->get('printbox.printers')->submit(
                $file->getRealPath(),
                $defaultPrinter
            );

            unlink($file->getRealPath());

            if (!strstr($printResponse[0], 'request id is')) {
                $this->get('logger')->error('PRINTING FAILED: ' . serialize($printResponse));
                return new Response('Print failed: ' . $printResponse[0], 400);
            }

            return new Response('Print accepted', 202);
        }

        return new Response('No print provided', 400);
    }
}
