<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Drectivo;
use AppBundle\Entity\Encargado;
use AppBundle\Entity\Docente;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\COPETyP;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    /**
     * @Route("/inicio", name="Inicio")
     */
    public function InicioAction()
    {
        return $this->render('AppBundle:Default:inicio.html.twig');
    }

    /**
     * @Route("/seleccionatipousuario", name="Default_SelecU")
     */
    public function SelecUAction()
    {
        return $this->render('AppBundle:Default:selectipouduario.html.twig');
    }

    /**
     * @Route("/nuevousuario", name="NuevoUsuario")
     */
    public function NuevoUAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            if ($_POST['selectbasic'] == "Directivo"){
                $directivo = new Directivo(); 
            }elseif ($_POST['selectbasic'] == "Encargado"){
                echo "nuevo encargado";
            }elseif ($_POST['selectbasic'] == "Docente"){
                echo "nuevo docente";
            }elseif ($_POST['selectbasic'] == "Estudiante"){
                echo "nuevo estudiante";
            }elseif ($_POST['selectbasic'] == "COPETyP"){
                echo "nuevo copetyp";
            }else{
                echo "error debe seleccinar un tipo de usuario valido";
            }
            
            
            die();
            //return $this->render('AppBundle:Default:nuevousuario.html.twig');
        }
        echo "no es post";
        die();
    }

}
