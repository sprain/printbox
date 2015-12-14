<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wlan;
use AppBundle\Form\WlanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SetupController extends Controller
{
    /**
     * @Route("/", name="wlan")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $wlans = $em->getRepository('AppBundle:Wlan')->findBy(array(), array('ssid' => 'asc'));

        return $this->render('@App/Setup/wlan.html.twig', array(
            'wlans' => $wlans,
        ));
    }

    /**
     * @Route("/wlan/add", name="addWlan")
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
     * @ParamConverter("post", class="AppBundle:Wlan")
     */
    public function removeWlanAction(Request $request, Wlan $wlan)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($wlan);
        $em->flush();

        $this->generateWpaSupplicant();

        return $this->redirect($this->generateUrl('wlan'));
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
