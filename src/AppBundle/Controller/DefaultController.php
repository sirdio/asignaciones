<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Directivo;
use AppBundle\Entity\Encargado;
use AppBundle\Entity\Docente;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\COPETyP;
use AppBundle\Entity\Escuela;
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
                $tipovotante = $_POST['selectbasic'];
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                if (!$escuela){
                    $msj = "Para cargar un usuario Directivo es necesario cargar antes datos del establecimiento.";              
                    return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));                    
                }    
                return $this->render('AppBundle:Default:nuevodirectivo.html.twig', 
                array('tipovotante'=>$tipovotante, 'escuela'=>$escuela));
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

    /**
     * @Route("/guardarusuario", name="GuardarUsuario")
     */
    public function GuardarUAction(Request $request)
    {
        if ($request->isMethod('POST')) {
//            foreach($_POST as $nombre => $valor){
//                echo $nombre. " = ".$valor."<br>";
//            }
            //die();
            if ($_POST['tipovotante'] == "Directivo"){
                $directivo = new Directivo();
                $directivo->setDni($_POST['dni']);
                $directivo->setNombre($_POST['nombre']);
                $directivo->setApellido($_POST['apellido']);
                $directivo->setTipovot($_POST['tipovotante']);
                $directivo->setCargo($_POST['cargo']);
                $directivo->setTeld($_POST['tel']);
                $directivo->setEmaild($_POST['email']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($directivo);
                $em->flush();
                $msj = "Usuario cargado con exito.";              
                return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));
            }elseif ($_POST['tipovotante'] == "Encargado"){
                echo "nuevo encargado";
            }elseif ($_POST['tipovotante'] == "Docente"){
                echo "nuevo docente";
            }elseif ($_POST['tipovotante'] == "Estudiante"){
                echo "nuevo estudiante";
            }elseif ($_POST['tipovotante'] == "COPETyP"){
                echo "nuevo copetyp";
            }else{
                echo "error debe seleccinar un tipo de usuario valido";
            }
            
            
            //die();
            //return $this->render('AppBundle:Default:nuevousuario.html.twig');
        }
        echo "no es post";
        die();
    }

}
