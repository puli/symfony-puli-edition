<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     */
    public function indexAction()
    {
        return $this->render('/acme/demo-bundle/views/demo/index.html.twig');
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     */
    public function helloAction($name)
    {
        return $this->render('/acme/demo-bundle/views/demo/hello.html.twig', array(
            'name' => $name,
        ));
    }

    /**
     * @Route("/contact", name="_demo_contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mailer = $this->get('mailer');

            // .. setup a message and send it
            // http://symfony.com/doc/current/cookbook/email.html

            $request->getSession()->getFlashBag()->set('notice', 'Message sent!');

            return new RedirectResponse($this->generateUrl('_demo'));
        }

        return $this->render('/acme/demo-bundle/views/demo/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
