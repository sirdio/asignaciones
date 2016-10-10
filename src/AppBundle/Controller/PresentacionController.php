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

class PresentacionController extends Controller
{
   
////////////////////////////////////////////////////////////////////////////////////////////////////////    
    /**
     * @Route("/cargadatos/nuevapresentacion", name="NuevaPresentacion")
     */
    public function MostrarFormularioPresAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
        $em = $this->getDoctrine()->getManager();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        return $this->render('AppBundle:Presentacion:nuevapresentacion.html.twig',
        array('escuela'=>$escuela));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }
 
    /**
     * @Route("/cargadatos/agregarpresentacion", name="AgregarPresentacion")
     */
    public function AgregarPresentacionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);   
            $presentacion = new Presentacion();
            $presentacion->setAdpresentacion($_POST['adpresentacion']);
            $presentacion->setCatpresentacion($_POST['catpresentacion']);
            $presentacion->setEsppresentacion($_POST['esppresentacion']);
            $presentacion->setPavpresentacion($_POST['pavpresentacion']);
            $presentacion->setNapresentacion($_POST['napresentacion']);
            $presentacion->setEscuela($escuela);
            $presentacion->setNivelpres('expped');
            $presentacion->setCantvoto(0);
            $em->persist($presentacion);
            $em->flush();            
            $msj = "Trabajo cargado con exito.";              
            return $this->render('AppBundle:Presentacion:mensajealtapress.html.twig', array('msj'=>$msj));            

        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }

    /**
     * @Route("/cargadatos/listarpresentacion", name="ListarPresentacion")
     */
    public function ListarPresentacionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
        $em = $this->getDoctrine()->getManager();
        $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
        if (!$presentacion){
            $msj = "No existen Presentaciones cargados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Presentacion:listarpresentacion.html.twig',array('presentacion'=>$presentacion));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }   
    
    /**
     * @Route("/cargadatos/mostrarpresentacion/{id}", name="MostrarPresentacion")
     */
    public function MostrarPresentacionAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
        $em = $this->getDoctrine()->getManager();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        $presentacion = $em->getRepository('AppBundle:Presentacion')->find($id);
        if (!$presentacion){
            $msj = "No existe Presentaciones.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        $idesc = $presentacion->getEscuela()->getId();
        $nombreescuela = $presentacion->getEscuela()->getNombesc();
        return $this->render('AppBundle:Presentacion:editarpresentacion.html.twig',
        array('presentacion'=>$presentacion, 'escuela'=>$escuela,
        'nombreescuela'=>$nombreescuela, 'idescuela'=>$idesc));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }
    
    /**
     * @Route("/cargadatos/guardarcambiospresentacion/{id}", name="GuardarCambiosPresentacion")
     */
    public function GuardarCambiosPresentacionAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);   
            $presentacion = $em->getRepository('AppBundle:Presentacion')->find($id);   
            $presentacion->setAdpresentacion($_POST['adpresentacion']);
            $presentacion->setCatpresentacion($_POST['catpresentacion']);
            $presentacion->setEsppresentacion($_POST['esppresentacion']);
            $presentacion->setPavpresentacion($_POST['pavpresentacion']);
            $presentacion->setNapresentacion($_POST['napresentacion']);
            $presentacion->setCantvoto(0);
            $presentacion->setEscuela($escuela);
            $em->persist($presentacion);
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

}