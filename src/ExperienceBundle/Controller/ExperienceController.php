<?php

namespace ExperienceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExperienceController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Experience/experience.html.twig');
    }
}
