<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Directivo;
use AppBundle\Entity\Encargado;
use AppBundle\Entity\Docente;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Copetyp;
use AppBundle\Entity\Escuela;
use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Trabajo;
use AppBundle\Entity\Presentacion;
use AppBundle\Entity\Users;

class VotoController extends Controller
{
    /**
     * @Route("/presentartrabajos", name="PresentarTrabajos")
     */
    public function PresentarTrabajosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
        return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
    }
    
    /**
     * @Route("/confirmarvoto/{id}", name="ConfirmarVoto")
     */
    public function ConfirmarVotoAction(Request $request, $id)
    {
        if($request->isMethod('POST')){
     
        }
        return $this->render('AppBundle:PesVotos:identificarvotante.html.twig', array('trabid'=>$id));
    }
}
