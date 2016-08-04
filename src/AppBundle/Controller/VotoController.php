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
     * @Route("/vototrabajo/{id}", name="VotoTrabajo")
     */
    public function VotoTrabajoAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("dni") and $session->has("cue"))
        {
        /////////////////////////////////////////////////////////////////////
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->find($id);
            if($session->has("tipovot") == "Directivo"){
                if ($trabajo->getEscuela()->getCue() == $session->get('cue')){
                        $msj = "No puede votar a los trabajos.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));                    
                }
                
            }elseif($session->has("tipovot") == "Encargado"){
                
            }elseif($session->has("tipovot") == "Estudiante"){
                
            }elseif($session->has("tipovot") == "Copetyp"){
                
            }
        //////////////////////////////////////////////////////////////////////
        }else
        {
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }        
        //$em = $this->getDoctrine()->getManager(Request $request);
        //$trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
        //return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
    }
    
    /**
     * @Route("/iniciarselecciondetrabajo", name="IniciarSelecdeTrabajo")
     */
    public function IniciarSelecTrabajoAction(Request $request)
    {
        if($request->isMethod('POST')){
            if($request->get('dni')!= "" && $request->get('password')!=""){
                $em = $this->getDoctrine()->getManager();
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneBy(Array("dni"=>$request->get('dni'))); 
                if($directivo){
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                    if($escuela->getCue() == $request->get('password')){
                        $session=$request->getSession();
                        $session->set("dni",$directivo->getDni());
                        $session->set("tipovot",$directivo->getTipovot());
                        $session->set("cue",$escuela->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                        return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));                        
                    }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                    }
                }elseif($encargado){
                    echo "es encargado";
                }elseif($estudiante){
                    echo "es estudiante";
                }elseif($copetyp){
                    echo "es copetyp";
                }else{
                    $msj = "El D.N.I. del usuario que intenta acceder, no se encuentra autorizado para votar.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                }
                die();
            }else{
                return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');    
            }    
        }
        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
    }

    /**
     * @Route("/vertrabajos", name="VerTrabajos")
     */
    public function VerTrabajosAction(Request $request)
    {
        //{{app.session.get('nombre')}}
        $session=$request->getSession();
        if($session->has("dni") and $session->has("cue"))
        {
        /////////////////////////////////////////////////////////////////////
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig',
            array('trabajo'=>$trabajo));
        //////////////////////////////////////////////////////////////////////
        }else
        {
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }        

    }    
    
}
