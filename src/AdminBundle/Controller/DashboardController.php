<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\UserRepository;
use UserBundle\Entity\Evenement;
use UserBundle\Entity\User;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Admin/Dashboard/index.html.twig');
    }


    public function afficherEvenementAdminAction(){

        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository("UserBundle:Evenement")->findAll();
        $username = $this->getDoctrine()->getRepository(User::class)->getNomUtilisateur();




        return $this->render('@Admin/Dashboard/admin_evenement.html.twig', ['evenements' => $evenements ]);

    }
}
