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
use AppBundle\Entity\Asistencia;

class AsistenciaController extends Controller
{

    
    /**
     * @Route("/asistenciapresentacion", name="AsistenciaPres")
     */
    public function AsistenciaPresAction(Request $request)
    {
        if($request->isMethod('POST')){
            if($request->get('dni')!= ""){
                $em = $this->getDoctrine()->getManager();
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni')));
                $docente = $em->getRepository('AppBundle:Docente')->findOneBy(Array("dni"=>$request->get('dni')));
                if($encargado){
                    $asis = $em->getRepository('AppBundle:Asistencia')->findOneBy(Array("dniasist"=>$encargado->getDni()));
                    if($asis){
                        $msja = "Su asistencia ya se registro Gracias.";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                                        
                    }else{    
                        $asistencia = new Asistencia();
                        $asistencia->setDniasist($encargado->getDni());
                        date_default_timezone_set("America/Argentina/Buenos_Aires");
                        $fechaactual = date("d-m-Y");                    
                        $asistencia->setFechaasist($fechaactual);
                        $em->persist($asistencia);
                        $em->flush();
                        $msja = "Gracias por asistir, recuerde que al finalizar las presentaciones podrá votar por 2 trabajos.";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                
                    }
                }elseif($docente){
                    $asis = $em->getRepository('AppBundle:Asistencia')->findOneBy(Array("dniasist"=>$docente->getDni()));
                    if($asis){
                        $msja = "Su asistencia ya se registro Gracias.";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                                        
                    }else{                    
                        $asistencia = new Asistencia();
                        $asistencia->setDniasist($docente->getDni());
                        date_default_timezone_set("America/Argentina/Buenos_Aires");
                        $fechaactual = date("d-m-Y");                    
                        $asistencia->setFechaasist($fechaactual);
                        $em->persist($asistencia);
                        $em->flush();                    
                        $msja = "Gracias por asistir, recuerde que al finalizar las presentaciones podrá votar por 2 trabajos..";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja)); 
                    }
                }else{
                    $msja = "Usted puede asistir, pero no esta autorizado para votar las presentaciones.";
                    return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));    
                }                                                
            }
            return $this->render('AppBundle:Presentacion:asistenciapresentacion.html.twig');

        }
        return $this->render('AppBundle:Presentacion:asistenciapresentacion.html.twig');
    }   
 
     /**
     * @Route("/verpresentacion/{id}", name="VerPresentacionEXPed")
     */
    public function VerPresentacionEXPedAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $presentacion = $em->getRepository('AppBundle:Presentacion')->find($id);
        if($request->isMethod('POST')){
            if($request->get('dni')!= ""){
                $asist = $em->getRepository('AppBundle:Asistencia')->findOneBy(Array("dniasist"=>$request->get('dni')));
                if($asist){
                    $this->get('session')->getFlashBag()->add('mensaje','puede votar.');
                    return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
                }else{
                    $this->get('session')->getFlashBag()->add('mensaje','No puede votar.');
                    return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
                }
                //$encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni')));
                //$docente = $em->getRepository('AppBundle:Docente')->findOneBy(Array("dni"=>$request->get('dni')));

                                                
            }
            return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));

        }
        return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
    } 
    
}