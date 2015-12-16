<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wlan;
use AppBundle\Form\WlanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class SetupController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $wlans = $em->getRepository('AppBundle:Wlan')->findBy(array(), array('ssid' => 'asc'));

        return $this->render('@App/Setup/index.html.twig', array(
            'wlans' => $wlans,
            'printers' => $this->get('printbox.printers')->getPrinters()[0],
            'defaultPrinter' => $this->get('printbox.printers')->getDefaultPrinter()
        ));
    }

    /**
     * @Route("/wlan/add", name="addWlan")
     * @Method({"GET", "POST"})
     */
    public function addWlanAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $wlan = new Wlan();
        $form = $this->createForm(WlanType::class, $wlan, array(
            'action' => $this->generateUrl('addWlan'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($wlan);
            $em->flush();

            $this->generateWpaSupplicant();

            return $this->redirect($this->generateUrl('wlan'));
        }

        return $this->render('@App/Setup/wlan_add.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * @Route("/wlan/remove/{id}", name="removeWlan")
     * @Method({"GET"})
     */
    public function removeWlanAction(Request $request, Wlan $wlan)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($wlan);
        $em->flush();

        $this->generateWpaSupplicant();

        return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/printers/use/{printerName}", name="makeDefaultPrinter")
     * @Method({"GET"})
     */
    public function makeDefaultPrinterAction(Request $request, $printerName)
    {
        $this->get('printbox.printers')->setDefaultPrinter($printerName);

        return $this->redirect($this->generateUrl('index'));
    }


    protected function generateWpaSupplicant()
    {
        $em = $this->getDoctrine()->getManager();
        $wlans = $em->getRepository('AppBundle:Wlan')->findBy(array(), array('ssid' => 'asc'));

        $wpaConf = $this->render('@App/Setup/wpa_supplicant.conf.twig', array(
            'wlans'  => $wlans
        ));

        file_put_contents($this->getParameter('wpa_supplicant_path'), $wpaConf->getContent());
    }
}
