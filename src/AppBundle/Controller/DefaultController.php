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
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
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
//            die();
            if ($_POST['tipovotante'] == "Directivo"){
                $directivo = new Directivo();
                $directivo->setDni($_POST['dni']);
                $directivo->setNombre($_POST['nombre']);
                $directivo->setApellido($_POST['apellido']);
                $directivo->setTipovot($_POST['tipovotante']);
                $directivo->setCargo($_POST['cargo']);
                $directivo->setTeld($_POST['tel']);
                $directivo->setEmaild($_POST['email']);
                $directivo->setIdesc($_POST['establecimiento']);
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
                $msj = "Ocurrio un problema debe seleccinar un tipo de usuario valido.";        
                return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));                
            }
            
            //return $this->render('AppBundle:Default:nuevousuario.html.twig');
        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
    }
    
    /**
     * @Route("/nuevoestablecimiento", name="NuevoEstablecimiento")
     */
    public function MostrarFormularioAction()
    {
        return $this->render('AppBundle:Default:nuevaescuela.html.twig');
    }

    /**
     * @Route("/agregarestablecimiento", name="AgregarEstablecimiento")
     */
    public function AgregarEstAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $escuela = new Escuela();
            $escuela->setCue($_POST['cue']);
            $escuela->setNombesc($_POST['nombesc']);
            $escuela->setAmbitogestion($_POST['ambitogestion']);
            $escuela->setJurisdiccion($_POST['jurisdiccion']);
            $escuela->setDepartamento($_POST['departamento']);
            $escuela->setLocalidad($_POST['localidad']);
            $escuela->setDomicilio($_POST['domicilio']);
            $escuela->setTelefono($_POST['telefono']);
            $escuela->setEmailesc($_POST['emailesc']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($escuela);
            $em->flush();
            $msj = "Establecimiento cargado con exito.";              
            return $this->render('AppBundle:Default:mensajealtaest.html.twig', array('msj'=>$msj));            
        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
    }
    
    /**
     * @Route("/listarestablecimiento", name="ListarEstablecimiento")
     */
    public function ListarEstAction()
    {
        $em = $this->getDoctrine()->getManager();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        if (!$escuela){
            $msj = "No existe Establecimientos cargados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Default:listarestablecimiento.html.twig',array('escuela'=>$escuela));
    }    

    /**
     * @Route("/mostrarestablecimiento/{id}", name="MostrarEstablecimiento")
     */
    public function MostrarEstAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $escuela = $em->getRepository('AppBundle:Escuela')->find($id);
        if (!$escuela){
            $msj = "No existe Establecimiento.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Default:editarestablecimiento.html.twig',array('escuela'=>$escuela));
    }

    /**
     * @Route("/guardarcambiosest/{id}", name="GuardarCambiosEst")
     */
    public function GuardarCambiosEstAction(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $escuela = $em->getRepository('AppBundle:Escuela')->find($id);
            $escuela->setCue($_POST['cue']);
            $escuela->setNombesc($_POST['nombesc']);
            $escuela->setAmbitogestion($_POST['ambitogestion']);
            $escuela->setJurisdiccion($_POST['jurisdiccion']);
            $escuela->setDepartamento($_POST['departamento']);
            $escuela->setLocalidad($_POST['localidad']);
            $escuela->setDomicilio($_POST['domicilio']);
            $escuela->setTelefono($_POST['telefono']);
            $escuela->setEmailesc($_POST['emailesc']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($escuela);
            $em->flush();
            $msj = "Los datos del Establecimiento se modificaron con exito.";              
            return $this->render('AppBundle:Default:mensajemodificacion.html.twig', array('msj'=>$msj));            
        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
    }    
    
    
}
