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
use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Trabajo;
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
            $em = $this->getDoctrine()->getManager();
            $tipovotante = $_POST['selectbasic'];
            if ($_POST['selectbasic'] == "Directivo"){
                
                $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                if (!$escuela){
                    $msj = "Para cargar un usuario Directivo es necesario cargar antes datos del establecimiento.";              
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
                }    
                return $this->render('AppBundle:Default:nuevodirectivo.html.twig', 
                array('tipovotante'=>$tipovotante, 'escuela'=>$escuela));
            }elseif ($_POST['selectbasic'] == "Encargado"){
                $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                return $this->render('AppBundle:Default:nuevoencargado.html.twig', 
                array('tipovotante'=>$tipovotante, 'escuela'=>$escuela));
            }elseif ($_POST['selectbasic'] == "Docente"){
                echo "nuevo docente";
            }elseif ($_POST['selectbasic'] == "Estudiante"){
                
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                if (!$trabajo){
                    $msj = "Para cargar un usuario Estudiante es necesario cargar antes los trabajos.";              
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
                }    
                return $this->render('AppBundle:Default:nuevoestudiante.html.twig', 
                array('tipovotante'=>$tipovotante, 'trabajo'=>$trabajo));           
                
                
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
            $em = $this->getDoctrine()->getManager();
            if ($_POST['tipovotante'] == "Directivo"){
                $configuracion = new Configuration();
                $configuracion->setCantcbsec(3);
                $configuracion->setCantcssec(3);
                $configuracion->setCantfp(0);
                $configuracion->setCantts(0);
                $configuracion->setCantexpped(0);
                $em->persist($configuracion);
                $em->flush();
                $id = $configuracion->getId();
                $directivo = new Directivo();
                $directivo->setDni($_POST['dni']);
                $directivo->setNombre($_POST['nombre']);
                $directivo->setApellido($_POST['apellido']);
                $directivo->setTipovot($_POST['tipovotante']);
                $directivo->setCargo($_POST['cargo']);
                $directivo->setTeld($_POST['tel']);
                $directivo->setEmaild($_POST['email']);
                $directivo->setIdesc($_POST['establecimiento']);
                $directivo->setIdconf($id);
                $em->persist($directivo);
                $em->flush();
                $msj = "Usuario cargado con exito.";              
                return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));
            }elseif ($_POST['tipovotante'] == "Encargado"){
               
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneByIdesc($_POST['establecimiento']);
                $idconf = $directivo->getIdconf();
                $encargado = new Encargado();
                $encargado->setDni($_POST['dni']);
                $encargado->setNombre($_POST['nombre']);
                $encargado->setApellido($_POST['apellido']);
                $encargado->setTipovot($_POST['tipovotante']);
                $encargado->setMateriadic($_POST['materiadic']);
                $encargado->setTele($_POST['tele']);
                $encargado->setEmaile($_POST['emaile']);
                $encargado->setIdconf($idconf);
                $em->persist($encargado);
                $em->flush();
                $msj = "Usuario cargado con exito.";              
                return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));                
                

            }elseif ($_POST['tipovotante'] == "Docente"){
                echo "nuevo docente";
            }elseif ($_POST['tipovotante'] == "Estudiante"){
                
                //foreach($_POST as $nombre => $valor){
                //    echo $nombre. " = ".$valor."<br>";
                //}
                //die();                 
                
                
                $trabajo = $em->getRepository('AppBundle:Trabajo')->find($_POST['trabajo']);
                $estudiante = new Estudiante();
                $estudiante->setDni($_POST['dni']);
                $estudiante->setNombre($_POST['nombre']);
                $estudiante->setApellido($_POST['apellido']);
                $estudiante->setTipovot($_POST['tipovotante']);
                $estudiante->setAniocursa($_POST['aniocursa']);
                $estudiante->setEspecialidada($_POST['especialidada']);
                $estudiante->setNivel($_POST['nivel']);
                $estudiante->setTrabajo($trabajo);
                $em->persist($estudiante);
                $em->flush();
                $msj = "Usuario cargado con exito.";              
                return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));                 
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
////////////////////////////////////////////////////////////////////////////////////////////////////////    
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
    
////////////////////////////////////////////////////////////////////////////////////////////////////////    
    /**
     * @Route("/nuevotrabajo", name="NuevoTrabajo")
     */
    public function MostrarFormularioTrabAction()
    {
        $em = $this->getDoctrine()->getManager();
        $encargado = $em->getRepository('AppBundle:Encargado')->findAll();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        return $this->render('AppBundle:Trabajo:nuevotrabajo.html.twig',
        array('encargado'=>$encargado, 'escuela'=>$escuela));
    }

    /**
     * @Route("/agregartrabajo", name="AgregarTrabajo")
     */
    public function AgregarTrabajoAction(Request $request)
    {
        if ($request->isMethod('POST')) {
//            echo "leo encargado <br>";
//            foreach($_POST as $nombre => $valor){
//                echo $nombre. " = ".$valor."<br>";
//            }
//            die();                
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['encargado']);
            $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);   
            $trabajo = new Trabajo();
            $trabajo->setNombproyecto($_POST['nombproyecto']);
            $trabajo->setDescproyecto($_POST['descproyecto']);
            $trabajo->setPavproyecto($_POST['pavproyecto']);
            $trabajo->setDpwproyecto($_POST['dpwproyecto']);
            $trabajo->setAemproyecto($_POST['aemproyecto']);
            $trabajo->setCantvoto(0);
            $trabajo->setEncargado($encargado);
            $trabajo->setEscuela($escuela);
            $em->persist($trabajo);
            $em->flush();            
            $msj = "Trabajo cargado con exito.";              
            return $this->render('AppBundle:Trabajo:mensajealtatrab.html.twig', array('msj'=>$msj));            

        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
    }
    
    /**
     * @Route("/listartrabajo", name="ListarTrabajo")
     */
    public function ListarTrabajoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
        if (!$trabajo){
            $msj = "No existen trabajos cargados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Trabajo:listartrabajo.html.twig',array('trabajo'=>$trabajo));
    }    

    /**
     * @Route("/mostrartrabajo/{id}", name="MostrarTrabajo")
     */
    public function MostrarTrabajoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $encargado = $em->getRepository('AppBundle:Encargado')->findAll();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->find($id);
        if (!$trabajo){
            $msj = "No existe trabajo.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        $dnienc = $trabajo->getEncargado()->getDni();
        $aynenc = $trabajo->getEncargado()->getApellido().", ".$trabajo->getEncargado()->getNombre();
        $idesc = $trabajo->getEscuela()->getId();
        $nombreescuela = $trabajo->getEscuela()->getNombesc();
        return $this->render('AppBundle:Trabajo:editartrabajo.html.twig',
        array('trabajo'=>$trabajo,
        'encargado'=>$encargado, 'escuela'=>$escuela,
        'aynenc'=>$aynenc, 'nombreescuela'=>$nombreescuela,
        'dnienc'=>$dnienc, 'idescuela'=>$idesc));
    }
    
    /**
     * @Route("/guardarcambiostrabajo/{id}", name="GuardarCambiosTrabajo")
     */
    public function GuardarCambiosTrabajoAction(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['encargado']);
            $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);   
            $trabajo = $em->getRepository('AppBundle:Trabajo')->find($id);   
            $trabajo->setNombproyecto($_POST['nombproyecto']);
            $trabajo->setDescproyecto($_POST['descproyecto']);
            $trabajo->setPavproyecto($_POST['pavproyecto']);
            $trabajo->setDpwproyecto($_POST['dpwproyecto']);
            $trabajo->setAemproyecto($_POST['aemproyecto']);
            $trabajo->setCantvoto(0);
            $trabajo->setEncargado($encargado);
            $trabajo->setEscuela($escuela);
            $em->persist($trabajo);
            $em->flush();
            $msj = "Los datos se modificaron con exito.";              
            return $this->render('AppBundle:Default:mensajemodificacion.html.twig', array('msj'=>$msj));            
        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
    }       
    
}
