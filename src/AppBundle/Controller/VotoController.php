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

class VotoController extends Controller
{
    /**
     * @Route("/salir", name="LogoutSalir")
     */    
    public function LogoutSalirAction(Request $request)
    {
        $session=$request->getSession();
        $session->clear();
        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
    }

    /**
     * @Route("/vertrabajos", name="VerOtrosTrabajos")
     */
    public function VerOtrosTrabajosAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("dni") and $session->has("cue"))
        {
        /////////////////////////////////////////////////////////////////////
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
 
 
        //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }        
        
    }
    
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

        if($trabajo->getIsActive() == 1){         
            if($session->get("tipovot") == "Directivo"){
              
                if ($trabajo->getEscuela()->getCue() == $session->get('cue')){
                    $msj = "No puede votar los trabajos que su establecimiento representa.";
                    return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                    
                }else{
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy( Array("dni"=>$session->get('dni')));
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$directivo->getDni(), "nembre"=>$directivo->getNombre(), "apellido"=>$directivo->getApellido(), "trabajo"=>$trabajo));
                    if(!$historialvoto){
                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($directivo->getIdconf());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($directivo->getNombre());
                                $hvoto->setApellido($directivo->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($directivo->getNombre());
                                $hvoto->setApellido($directivo->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($directivo->getNombre());
                                $hvoto->setApellido($directivo->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($directivo->getNombre());
                                $hvoto->setApellido($directivo->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                    }
                }
                
            }elseif($session->get("tipovot") == "Encargado"){

                if ($trabajo->getEscuela()->getCue() == $session->get('cue')){
                    $msj = "No puede votar los trabajos que su establecimiento representa.";
                    return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                    
                }else{
                    $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy( Array("dni"=>$session->get('dni')));
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$encargado->getDni(), "nembre"=>$encargado->getNombre(), "apellido"=>$encargado->getApellido(), "trabajo"=>$trabajo));
                    if(!$historialvoto){
                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($encargado->getIdconf());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                    }                        
                }
                
            }elseif($session->get("tipovot") == "Estudiante"){
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy( Array("dni"=>$session->get('dni')));
                if($estudiante->getTrabajo()->getId() == $trabajo->getId()){
                    $msj = "No puede votar su propio trabajo.";
                    return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                    
                }else{
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                    Array("dni"=>$estudiante->getDni(), "nembre"=>$estudiante->getNombre(), "apellido"=>$estudiante->getApellido(), "trabajo"=>$trabajo));   
                    if(!$historialvoto){

                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($estudiante->getConfiguracion()->getId());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                    }
                }

            }elseif($session->get("tipovot") == "COPETyP"){
                
                    $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneBy( Array("dni"=>$session->get('dni')));
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$copetyp->getDni(), "nembre"=>$copetyp->getNombre(), "apellido"=>$copetyp->getApellido(), "trabajo"=>$trabajo));
                    if(!$historialvoto){
                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($copetyp->getConfiguracion()->getId());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($session->get('dni'));
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                    }
            }
        }
        
        $msj = "El Trabajo se encuentra desactivado para votar.";
        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));        
        //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }        

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
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                        return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));                        
                    }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                    }
                    
                }elseif($encargado){
                    
                    $directivo = $em->getRepository('AppBundle:Directivo')->find($encargado->getIdconf());
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                    if($escuela->getCue() == $request->get('password')){
                        $session=$request->getSession();
                        $session->set("dni",$encargado->getDni());
                        $session->set("tipovot",$encargado->getTipovot());
                        $session->set("cue",$escuela->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                        return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));                        
                    }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                    }
                    
                }elseif($estudiante){
                    
                   if($estudiante->getTrabajo()->getEscuela()->getCue() == $request->get('password')){
                        $session=$request->getSession();
                        $session->set("dni",$estudiante->getDni());
                        $session->set("tipovot",$estudiante->getTipovot());
                        $session->set("cue",$estudiante->getTrabajo()->getEscuela()->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                        return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));


                   }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));                       
                   }
                    

                }elseif($copetyp){
                   if($copetyp->getNombre() == $request->get('password')){
                        $session=$request->getSession();
                        $session->set("dni",$copetyp->getDni());
                        $session->set("tipovot",$copetyp->getTipovot());
                        $session->set("cue",$copetyp->getNombre());
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                        return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));


                   }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));                       
                   }
                }else{
                    $msj = "El D.N.I. del usuario que intenta acceder, no se encuentra autorizado para votar.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                }
                //die();
            }else{
                return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');    
            }    
        }
        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
    }

    /**
     * @Route("/vertrabajo/{id}", name="VerTrabajo")
     */
    public function VerTrabajoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->find($id); 
    if($trabajo->getIsActive() == 1){
        if($request->isMethod('POST')){
            if($request->get('dni')!= "" && $request->get('password')!=""){
///////////////////////////////////////////////////////////////////////////////
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneBy(Array("dni"=>$request->get('dni'))); 
                if($directivo){
                    
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                    if($escuela->getCue() == $request->get('password')){
///////////////////////////////////////////////////
//////////////////////////////////////////////////
                    if ($trabajo->getEscuela()->getCue() ==  $request->get('password')){
                        $msj = "No puede votar los trabajos que su establecimiento representa.";
                        return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                    
                    }else{
                        //$directivo = $em->getRepository('AppBundle:Directivo')->findOneBy( Array("dni"=>$session->get('dni')));
                        $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$directivo->getDni(), "nembre"=>$directivo->getNombre(), "apellido"=>$directivo->getApellido(), "trabajo"=>$trabajo));
                        if(!$historialvoto){
                            $configuracion = $em->getRepository('AppBundle:Configuracion')->find($directivo->getIdconf());
                            if($trabajo->getNiveltrab() == 'cbs'){
                                if($configuracion->getCantcbsec() != 0){
                                    $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                    $em->persist($trabajo);
                                    $em->flush();
                                    $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                    $em->persist($configuracion);
                                    $em->flush();
                                    $hvoto = new Historialvoto();
                                    $hvoto->setDni($directivo->getDni());
                                    $hvoto->setNembre($directivo->getNombre());
                                    $hvoto->setApellido($directivo->getApellido());
                                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                                    $horaactual = date("H:i:s");
                                    $fechaactual = date("d-m-Y");
                                    $hvoto->setFecha($fechaactual);
                                    $hvoto->setHora($horaactual);
                                    $hvoto->setTrabajo($trabajo);
                                    $em->persist($hvoto);
                                    $em->flush();                                
                                    $msj = "Gracias por votar.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                                                            
                                }
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            
                            }elseif($trabajo->getNiveltrab() == 'css'){
                                if($configuracion->getCantcssec() != 0){
                                    $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                    $em->persist($trabajo);
                                    $em->flush();
                                    $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                    $em->persist($configuracion);
                                    $em->flush();
                                    $hvoto = new Historialvoto();
                                    $hvoto->setDni($directivo->getDni());
                                    $hvoto->setNembre($directivo->getNombre());
                                    $hvoto->setApellido($directivo->getApellido());
                                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                                    $horaactual = date("H:i:s");
                                    $fechaactual = date("d-m-Y");
                                    $hvoto->setFecha($fechaactual);
                                    $hvoto->setHora($horaactual);
                                    $hvoto->setTrabajo($trabajo);
                                    $em->persist($hvoto);
                                    $em->flush();                                
                                    $msj = "Gracias por votar.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                                }
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                            
                            }elseif($trabajo->getNiveltrab() == 'fp'){
                                if($configuracion->getCantfp() != 0){
                                    $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                    $em->persist($trabajo);
                                    $em->flush();
                                    $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                    $em->persist($configuracion);
                                    $em->flush();
                                    $hvoto = new Historialvoto();
                                    $hvoto->setDni($directivo->getDni());
                                    $hvoto->setNembre($directivo->getNombre());
                                    $hvoto->setApellido($directivo->getApellido());
                                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                                    $horaactual = date("H:i:s");
                                    $fechaactual = date("d-m-Y");
                                    $hvoto->setFecha($fechaactual);
                                    $hvoto->setHora($horaactual);
                                    $hvoto->setTrabajo($trabajo);
                                    $em->persist($hvoto);
                                    $em->flush();                                
                                    $msj = "Gracias por votar.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                                }
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));    
                                
                            }elseif($trabajo->getNiveltrab() == 'ts'){
                                if($configuracion->getCantts() != 0){
                                    $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                    $em->persist($trabajo);
                                    $em->flush();
                                    $configuracion->setCantts($configuracion->getCantts() - 1);
                                    $em->persist($configuracion);
                                    $em->flush();
                                    $hvoto = new Historialvoto();
                                    $hvoto->setDni($directivo->getDni());
                                    $hvoto->setNembre($directivo->getNombre());
                                    $hvoto->setApellido($directivo->getApellido());
                                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                                    $horaactual = date("H:i:s");
                                    $fechaactual = date("d-m-Y");
                                    $hvoto->setFecha($fechaactual);
                                    $hvoto->setHora($horaactual);
                                    $hvoto->setTrabajo($trabajo);
                                    $em->persist($hvoto);
                                    $em->flush();                                
                                    $msj = "Gracias por votar.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                                }
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                            }
                            
                        }else{
                            $msj = "Usted ya voto este trabajo.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                        }
                    }

////////////////////////////////////////////////
///////////////////////////////////////////////                        
                        
                    }else{
                    $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que ingreso es incorrecta.');
                    return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
                    }
                    
                }elseif($encargado){
                    
                    $directivo = $em->getRepository('AppBundle:Directivo')->find($encargado->getIdconf());
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                    if($escuela->getCue() == $request->get('password')){
 
 /////////////////////////////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////////////////////////////
 
                if ($trabajo->getEscuela()->getCue() ==  $request->get('password')){
                    $msj = "No puede votar los trabajos que su establecimiento representa.";
                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                    
                }else{
                    //$encargado = $em->getRepository('AppBundle:Encargado')->findOneBy( Array("dni"=>$encargado->getDni()));
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$encargado->getDni(), "nembre"=>$encargado->getNombre(), "apellido"=>$encargado->getApellido(), "trabajo"=>$trabajo));
                    if(!$historialvoto){
                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($encargado->getIdconf());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($encargado->getDni());
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($encargado->getDni());
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($encargado->getDni());
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($encargado->getDni());
                                $hvoto->setNembre($encargado->getNombre());
                                $hvoto->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                    }                        
                }
                
            
 /////////////////////////////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////////////////////////////
                        
                    }else{
                    $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que ingreso es incorrecta.');
                    return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
                    }
                    
                }elseif($estudiante){
                    
                   if($estudiante->getTrabajo()->getEscuela()->getCue() == $request->get('password')){

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
                if($estudiante->getTrabajo()->getId() == $trabajo->getId()){
                    $msj = "No puede votar su propio trabajo.";
                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                    
                }else{
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                    Array("dni"=>$estudiante->getDni(), "nembre"=>$estudiante->getNombre(), "apellido"=>$estudiante->getApellido(), "trabajo"=>$trabajo));   
                    if(!$historialvoto){

                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($estudiante->getConfiguracion()->getId());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($estudiante->getDni());
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($estudiante->getDni());
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($estudiante->getDni());
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($estudiante->getDni());
                                $hvoto->setNembre($estudiante->getNombre());
                                $hvoto->setApellido($estudiante->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                    }
                }
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

                   }else{
                    $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que ingreso es incorrecta.');
                    return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
                   }
                    

                }elseif($copetyp){
                   if($copetyp->getNombre() == $request->get('password')){
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

                    //$copetyp = $em->getRepository('AppBundle:Copetyp')->findOneBy( Array("dni"=>$session->get('dni')));
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$copetyp->getDni(), "nembre"=>$copetyp->getNombre(), "apellido"=>$copetyp->getApellido(), "trabajo"=>$trabajo));
                    if(!$historialvoto){
                        $configuracion = $em->getRepository('AppBundle:Configuracion')->find($copetyp->getConfiguracion()->getId());
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($configuracion->getCantcbsec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcbsec($configuracion->getCantcbsec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($copetyp->getDni());
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                                                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($configuracion->getCantcssec() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantcssec($configuracion->getCantcssec() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($copetyp->getDni());
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                            
                        }elseif($trabajo->getNiveltrab() == 'fp'){
                            if($configuracion->getCantfp() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantfp($configuracion->getCantfp() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($copetyp->getDni());
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));    
                            
                        }elseif($trabajo->getNiveltrab() == 'ts'){
                            if($configuracion->getCantts() != 0){
                                $trabajo->setCantvoto($trabajo->getCantvoto() + 1);
                                $em->persist($trabajo);
                                $em->flush();
                                $configuracion->setCantts($configuracion->getCantts() - 1);
                                $em->persist($configuracion);
                                $em->flush();
                                $hvoto = new Historialvoto();
                                $hvoto->setDni($copetyp->getDni());
                                $hvoto->setNembre($copetyp->getNombre());
                                $hvoto->setApellido($copetyp->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");
                                $hvoto->setFecha($fechaactual);
                                $hvoto->setHora($horaactual);
                                $hvoto->setTrabajo($trabajo);
                                $em->persist($hvoto);
                                $em->flush();                                
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                            }
                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Técnico Superior.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                        }
                        
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                    }

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


                   }else{
                    $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que ingreso es incorrecta.');
                    return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));        
                   }
                }else{
                    $this->get('session')->getFlashBag()->add('mensaje','El D.N.I. del usuario que intenta acceder, no se encuentra autorizado para votar.');
                    return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));        
                }
///////////////////////////////////////////////////////////////////////////////
            }
            $this->get('session')->getFlashBag()->add('mensaje','Debe ingresar su D.N.I. y Contraseña.');
                    
            return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
        }
        //$this->get('session')->getFlashBag()->add('mensaje','Ocurrió un problema intente de nuevo.');
        return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));   
        }////cierra el if que verifica si el trabajo esta habilitado o no
        $this->get('session')->getFlashBag()->add('mensaje','El trabajo esta Desactivado para votar.');
        return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
    }
    
    
 
    
}
