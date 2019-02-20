<?php

namespace EvenementBundle\Controller;

use Swift_Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Evenement;
use EvenementBundle\Form\AjouterEvenement;
use UserBundle\Entity\User;
use UserBundle\Entity\EvenementRepository;
use EvenementBundle\Form\ModifierEvenement;

class EvenementController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function ajouterEvenementAction(Request $request)
    {
        $user = $this->getUser();
        $event = new Evenement();
        $form = $this->createForm(AjouterEvenement::class, $event);
        $form->handleRequest($request);
        if ($user !== null) {
            if ($form->isValid()) {
                $event->setEtatEvenement("Non");
                $event->setIdUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return $this->redirectToRoute('accueil_evenement');
            }
            return $this->render('@Evenement/Evenement_Views/ajouter_evenement.html.twig', ['evenements' => null, 'ajouter_form' => $form->createView(), 'tag' => 'Ajouter un événement']);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function modifierEvenementAction(Request $request)
    {
        $user = $this->getUser();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('UserBundle:Evenement')->find($id);
        $form = $this->createForm(ModifierEvenement::class, $evenement);
        $form->handleRequest($request);
        if ($user !== null) {
            if ($form->isValid()) {
                $em->persist($evenement);
                $em->flush();
                return $this->redirectToRoute('afficher_mes_evenements');
            }
        } else {
            return $this->redirectToRoute('fos_user_registration_register');
        }
        return $this->render('@Evenement/Evenement_Views/modifier_evenement.html.twig', ['evenements' => null, 'modifier_form' => $form->createView(), 'tag' => 'Modifier un événement']);
    }

    public function supprimerEvenementAction(Request $request){
        $user = $this->getUser();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('UserBundle:Evenement')->find($id);
        if ($user !== null) {
            $em->remove($evenement);
            $em->flush();
            $this->addFlash(
                'success',
                'Supression avec succès!'
            );
        }
        return $this->redirectToRoute('afficher_mes_evenements');
    }

    public function detailsEvenementAction(Request $request){
        $user = $this->getUser();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('UserBundle:Evenement')->find($id);
        if($user !== null) {
            return $this->render('@Evenement/Evenement_Views/details_evenement.html.twig', ['evenements' => $evenements,'tag' => 'détails événement']);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }



    public function afficherEvenementAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository("UserBundle:Evenement")->findAll();

        // pour récuperer l'email d'utilisateur connecté
        $users = $em->getRepository("UserBundle:User")->findBy(array('id' => $user), array());
        $data = ['users' => $users, 'evenements' => $evenements];
        //  return $this->render('@Evenement/Evenement_Views/accueil_evenement.html.twig',['data_evenement' => json_encode($data)]);
        return $this->render('@Evenement/Evenement_Views/accueil_evenement.html.twig', ['tag' => null , 'users' => $users, 'evenements' => $evenements]);
    }

    public function afficherMesEvenementAction()
    {
        $user = $this->getUser();
        if ($user !== null) {

            $em = $this->getDoctrine()->getManager();
            $evenements = $em->getRepository("UserBundle:Evenement")->findBy(array('idUser' => $user), array());

            return $this->render('@Evenement/Evenement_Views/afficher_mes_evenements.html.twig', ['tag' => "Mes Evénements", 'evenements' => $evenements]);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }

    }

    public function reservationEvenementAction()
    {
    return $this->render('@Evenement/Evenement_Views/mes_reservations_evenement.html.twig',['tag' => "Mes Evénements"]);
    }

    public function autreEvenementAction()
    {
    return $this->render('@Evenement/Evenement_Views/autre_evenement.html.twig',['tag' => "Autre Evenement"]);
    }

    public function envoyerTicketAction()
    {
        //send tiquet at mail
        $user = $this->getUser();
        $message = (new \Swift_Message())->setSubject('Bonjour Monsieur ' . $user)
            ->setFrom('soltani.ahmed1994@gmail.com')
            ->setTo('soltani.ahmed1994@gmail.com')
            ->setBody('votre ticket ')
            ->attach(Swift_Attachment::fromPath('C:\wamp64\www\worldfriendship\web\Evenement\image\ticket.jpg')
                ->setDisposition('inline'));
        $this->get('mailer')->send($message);
        $this->addFlash(
            'success',
            'Envoie avec succès!'
        );
        return $this->redirectToRoute('accueil_evenement');
    }






    /* public function testAction(Request $request)
     {
         $length = $request->get('length');
         $length = $length && ($length!=-1)?$length:0;

         $start = $request->get('start');
         $start = $length?($start && ($start!=-1)?$start:0)/$length:0;

         $search = $request->get('search');

         $user = new User();
         $user = $this->getUser();
         $filters = [
             'query' => @$search['value'],
             'user' => @$user,
         ];

         $em = $this->getDoctrine()->getManager();
         $evenements = $em->getRepository("UserBundle:Evenement")->findAll();

         // pour récuperer l'email d'utilisateur connecté
         $users = $em->getRepository("UserBundle:User")->findBy(array('id' => $user), array());
        // $data = ['users'=> $users , 'evenements' => $evenements];

         $output = array(
             'data' => array(),
         );
         foreach ($evenements as $event) {

             $output['data'][] = [
                 'nomEvenement' => $event->getNomEvenement()
             ];
         }
       return new JsonResponse($output);

         //  return $this->render('@Evenement/Evenement_Views/test.html.twig',['data_evenement' => json_encode($output)]);
        //return  $this->render('@Evenement/Evenement_Views/test.html.twig', ['tag' => 'Evenements','users'=> $users , 'evenements' => $evenements]);
        // return new Response("hello world");
           }
 */
/*
    public function testAction(Request $request)
    {
        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $search = $request->get('search');

        $user = $this->getUser();
        $filters = [
            'query' => @$search['value'],
            'user' => @$user,
        ];

        $evenements = $this->getDoctrine()->getRepository('UserBundle:Evenement')->search(
            $filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($this->getDoctrine()->getRepository('UserBundle:Evenement')->search($filters, 0, false)),
            'recordsTotal' => count($this->getDoctrine()->getRepository('UserBundle:Evenement')->search(array(), 0, false))
        );

        foreach ($evenements as $event) {

            $output['data'][] = [
                'nomEvenement' => $event->getNomEvenement()
            ];
        }

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }
*/
    public function testpdfAction(Request $request)
    {
        $user = $this->getUser();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('UserBundle:Evenement')->find($id);
        $snappy = $this->get('knp_snappy.pdf');

        $html = "<h1>salut monsieur : </h1> ".$user.
                "<h1> Evenement : </h1>".$evenement->getNomEvenement();
        $filename = 'pdf '.$evenement->getNomEvenement();

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
            )
        );
    }

}