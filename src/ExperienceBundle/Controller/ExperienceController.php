<?php

namespace ExperienceBundle\Controller;

use ExperienceBundle\ExperienceBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\categorie;
use UserBundle\Entity\Commentaire;
use UserBundle\Entity\Experience;
use UserBundle\Form\CommentaireType;
use UserBundle\Form\ExperienceType;
use UserBundle\UserBundle;

class ExperienceController extends Controller
{
    public function indexAction()
    {
        $experience = $this->getDoctrine()->getRepository('UserBundle:Experience')->topExp();
        return $this->render('@Experience/experience.html.twig', array(
            'exp' => $experience,
        ));
    }


    public function AfficherAjouterAction(Request $request)
    {
        $user = $this->getUser();
        $experience = new Experience();
        $exp = $this->getDoctrine()->getRepository('UserBundle:Experience')->findAll();
        $cat = $this->getDoctrine()->getRepository('UserBundle:categorie')->findAll();
        $form = $this->createForm(ExperienceType::class, $experience);
        $form = $form->handleRequest($request);


        /**
         * @var  $paginator \Knp\Component\Pager\Paginator
         */

        $paginator = $this->get('knp_paginator');
        $res = $paginator->paginate(
            $exp,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );


        if ($user !== null) {
            $experience->setDateExp(new \DateTime());

            if ($form->isSubmitted()) {
                $experience->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($experience);
                $em->flush();

                return $this->redirectToRoute('allPosts', array());
            }
            return $this->render('@Experience/allPosts.html.twig', array(
                'form' => $form->createView(),
                'experience' => $res,
                'categorie' => $cat,
                'user' => $user

            ));
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    public function PostDetailsAction(Request $request, $id, Experience $exp)
    {
        $user = $this->getUser();
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire)->handleRequest($request);
        $experience = $this->getDoctrine()->getRepository(Experience::class)->findIdParameter($id);
        $comm = $this->getDoctrine()->getRepository(Commentaire::class)->findCommIdParameter($id);
        //$nbr_comm = $this->getDoctrine()->getRepository('UserBundle:Commentaire')->countComments($id);


        $this->get('views_counter.views_counter')->count($exp);


        if ($user !== null) {
            $commentaire->setDateCommentaire(new \DateTime());

            if ($form->isValid()) {
                $commentaire->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $commentaire->setExperience($em->getRepository('UserBundle:Experience')->find($id));
                $em->persist($commentaire);
                $em->flush();

                return $this->redirectToRoute('postDetail', array('id' => $commentaire->getExperience()));
            }
            return $this->render('@Experience/postDetail.html.twig', array(
                'form' => $form->createView(),
                'experience' => $experience,
                'comm' => $comm,
                'user' => $user
                //'nbr'=>$nbr_comm
            ));
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function myPostsAction($id)
    {
        $exp = $this->getDoctrine()->getManager()->getRepository
        (Experience::class)->findExpByUserParameter($id);

        return $this->render('@Experience/myPosts.html.twig',
            array('exp' => $exp,
                'id' => $id,
            )
        );
    }

    Public function SupprimerExpAction($id, Experience $experience)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($experience->getUser() == $user) {
            $em = $this->getDoctrine()->getManager();
            $exp = $em->getRepository(Experience::class)->find($id);

            $em->remove($exp);
            $em->flush();
        } else {
            return $this->redirectToRoute("fos_user_security_login");
        }
        return $this->redirectToRoute("allPosts");
    }

    Public function SupprimerCommAction($id, Commentaire $commentaire)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($commentaire->getUser() == $user) {
            $em = $this->getDoctrine()->getManager();
            $comm = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);
            $em->remove($comm);
            $em->flush();
        } else {
            return $this->redirectToRoute("fos_user_security_login");
        }
        return $this->redirectToRoute("postDetail", array('id' => $commentaire->getExperience()));
    }

    public function categorieAction(Request $request, $id)
    {
        $user = $this->getUser();
        $experience = new Experience();
        $exp = $this->getDoctrine()->getRepository('UserBundle:Experience')->findExpByCatParameter($id);
        $nom_cat = $this->getDoctrine()->getRepository('UserBundle:categorie')->findCatByParameter($id);
        $form = $this->createForm(ExperienceType::class, $experience);
        $form = $form->handleRequest($request);


        /**
         * @var  $paginator \Knp\Component\Pager\Paginator
         */

        $paginator = $this->get('knp_paginator');
        $res = $paginator->paginate(
            $exp,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );


        if ($user !== null) {

            if ($form->isSubmitted()) {
                $experience->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($experience);
                $em->flush();

                return $this->redirectToRoute('allPosts');
            }
            return $this->render('@Experience/categorie.html.twig', array(
                'form' => $form->createView(),
                'experience' => $res,
                'id' => $id,
                'nom_cat' => $nom_cat


            ));
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    public function rechercheAction(Request $request)
    {

    }

    public function updateAction(Request $request, $id, Experience $experience)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($experience->getUser() == $user) {
            $exp = $this->getDoctrine()->getRepository(Experience::class)
                ->find($id);

            $form = $this->createForm(ExperienceType::class, $exp);
            $form->handleRequest($request);


            if ($user !== null) {
                //$forum->setDate(new \DateTime());
                if ($form->isSubmitted()) {
                    $exp->setUser($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    return $this->redirectToRoute('allPosts',
                        array('id' => $exp->getCategorie()->getId()));
                }

                return $this->render('@Experience/updateExp.html.twig',
                    array("form" => $form->createView()));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('allPosts',
            array('id' => $experience->getCategorie()->getId()));

    }
}