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
use AppBundle\Entity\Historialvoto;

class ReportesController extends Controller
{

    
    /**
     * @Route("/seleccionarnivel", name="SeleccionarNivel")
     */
    public function SeleccionarNivelAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("niveltrab"=>$_POST['nivel']),Array("cantvoto"=>'ASC'));
                return $this->render('AppBundle:Reportes:resultadosvotos.html.twig', array("trabajo"=>$trabajo));
            }
            return $this->render('AppBundle:Reportes:seleccionarnivel.html.twig');
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }




    }
    

    
    
 
    
}