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
use AppBundle\Entity\Jurisdiccion;
use AppBundle\Entity\Detalleconfiguracion;

class TrabajoController extends Controller
{
      
    /**
     * @Route("/cargadatos/nuevotrabajo", name="NuevoTrabajo")
     */
    public function MostrarFormularioTrabAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
        $em = $this->getDoctrine()->getManager();
        //$encargado = $em->getRepository('AppBundle:Encargado')->findAll(Array('dni'=>'asc'));
            $em=$this->getDoctrine()
                     ->getManager()
                        ->createQueryBuilder('AppBundle:Encargado')
                        ->select('e')
                        ->from('AppBundle:Encargado','e')
                        ->orderBy("e.dni","asc")
                        ->getQuery();
         $encargado=$em->getArrayResult();
            $em=$this->getDoctrine()
                     ->getManager()
                        ->createQueryBuilder('AppBundle:Escuela')
                        ->select('e')
                        ->from('AppBundle:Escuela','e')
                        ->orderBy("e.cue","asc")
                        ->getQuery();
         $escuela=$em->getArrayResult();
        return $this->render('AppBundle:Trabajo:nuevotrabajo.html.twig',
        array('encargado'=>$encargado, 'escuela'=>$escuela));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }

    }

    /**
     * @Route("/cargadatos/agregartrabajo", name="AgregarTrabajo")
     */
    public function AgregarTrabajoAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['encargado']);
                $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);  
                $configuracion = new Configuracion();
                $configuracion->setCtvcbs(1);
                $configuracion->setCtvcss(1);
                $configuracion->setCtvfp(1);
                $configuracion->setCtvts(1);
                $em->persist($configuracion);
                $em->flush();
                $trabajo = new Trabajo();
                $trabajo->setNombproyecto($_POST['nombproyecto']);
                $trabajo->setCvmencion(0);
                $trabajo->setCvdestacado(0);
                $trabajo->setStand($_POST['stand']);
                $trabajo->setEncargado($encargado);
                $trabajo->setEscuela($escuela);
                $trabajo->setNiveltrab($_POST['nivel']);
                $trabajo->setIsActive(0);
                $trabajo->setConfiguracion($configuracion);
                $em->persist($trabajo);
                $em->flush();            
                $msj = "Trabajo cargado con exito.";              
                return $this->render('AppBundle:Trabajo:mensajealtatrab.html.twig', array('msj'=>$msj));            
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }
    
    /**
     * @Route("/cargadatos/listartrabajo", name="ListarTrabajo")
     */
    public function ListarTrabajoAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
            if (!$trabajo){
                $msj = "No existen trabajos cargados.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
            }        
            return $this->render('AppBundle:Trabajo:listartrabajo.html.twig',array('trabajo'=>$trabajo));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }        

    }    

    /**
     * @Route("/cargadatos/mostrartrabajo/{id}", name="MostrarTrabajo")
     */
    public function MostrarTrabajoAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
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
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }
    
    /**
     * @Route("/cargadatos/guardarcambiostrabajo/{id}", name="GuardarCambiosTrabajo")
     */
    public function GuardarCambiosTrabajoAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['encargado']);
            $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);   
            $trabajo = $em->getRepository('AppBundle:Trabajo')->find($id);   
            $trabajo->setNombproyecto($_POST['nombproyecto']);
            $trabajo->setCvmencion(0);
            $trabajo->setCvdestacado(0);
            $trabajo->setEncargado($encargado);
            $trabajo->setEscuela($escuela);
            $em->persist($trabajo);
            $em->flush();
            $msj = "Los datos se modificaron con exito.";              
            return $this->render('AppBundle:Default:mensajemodificacion.html.twig', array('msj'=>$msj));            
        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }       
    
    /**
     * @Route("/cargadatos/activartrabajo", name="ActivarTrabajo")
     */
    public function ActivarTrabajoAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 0));
        if (!$trabajo){
            $msj = "No existen trabajos desactivados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Trabajo:listartrabajodesactivados.html.twig',array('trabajo'=>$trabajo));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }        

    }     
    
    /**
     * @Route("/cargadatos/desactivartrabajo", name="DesactivarTrabajo")
     */
    public function DesactivarTrabajoAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
        if (!$trabajo){
            $msj = "No existen trabajos desactivados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Trabajo:listartrabajosactivos.html.twig',array('trabajo'=>$trabajo));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }        

    }     
    
    /**
     * @Route("/cargadatos/TrabajoActivarDesactivar/{id}", name="TrabajoActivarDesactivar")
     */
    public function TrabajoActivarDesactivarAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->find($id);
            $estudiante = $em->getRepository('AppBundle:Estudiante')->findBy(Array('trabajo' => $trabajo));
            if ($trabajo->getIsActive() == 1){
                $trabajo->setIsActive(0);
                $em->persist($trabajo);
                $em->flush();
                
                foreach($estudiante as $alumno){
                    $docu =$alumno->getDni();
                    $estadopago = $this->getDesactivarAlumno($docu);
                }
                
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                if (!$trabajo){
                    $msj = "No existen trabajos desactivos.";              
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
                }                 
                $this->get('session')->getFlashBag()->add('mensaje','El trabajo se Desactivo con exito.');
                return $this->render('AppBundle:Trabajo:listartrabajosactivos.html.twig',array('trabajo'=>$trabajo));
                
            }elseif($trabajo->getIsActive() == 0){
                $trabajo->setIsActive(1);
                $em->persist($trabajo);
                $em->flush();
                
                foreach($estudiante as $alumno){
                    $docu =$alumno->getDni();
                    $estadopago = $this->getActivarAlumno($docu);
                }                
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 0));
                if (!$trabajo){
                    $msj = "No existen trabajos desactivados.";              
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
                }                
                $this->get('session')->getFlashBag()->add('mensaje','El trabajo se Activo con exito.');
                return $this->render('AppBundle:Trabajo:listartrabajodesactivados.html.twig',array('trabajo'=>$trabajo));
            }        
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }        
    }     


    public function getActivarAlumno($dnialu)
    {
        $em = $this->getDoctrine()->getManager();
        $alumnos = $em->getRepository('AppBundle:Estudiante')->findOneByDni($dnialu);
        $alumnos->setIsActive(1);
        $em->persist($alumnos);
        $em->flush();
        $dn = $alumnos->getDni();
        return $dn;
    }
    
    public function getDesactivarAlumno($dnialu)
    {
        $em = $this->getDoctrine()->getManager();
        $alumnos = $em->getRepository('AppBundle:Estudiante')->findOneByDni($dnialu);
        $alumnos->setIsActive(0);
        $em->persist($alumnos);
        $em->flush();        
        $dn = $alumnos->getDni();
        return $dn;
    }
    

 
}