<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Group/group.html.twig');
    }
}
