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
use AppBundle\Entity\Detalleconfiguracion;
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
            
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
 
 
        //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }        
        
    }
    
    public function getRegistrarVoto($dni, $nombre, $apellido, $trabajoid)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajovoto = $em->getRepository('AppBundle:Trabajo')->find($trabajoid);       
        $hvoto = new Historialvoto();
        $hvoto->setDni($dni);
        $hvoto->setNembre($nombre);
        $hvoto->setApellido($apellido);
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $horaactual = date("H:i:s");
        $fechaactual = date("d-m-Y");
        $hvoto->setFecha($fechaactual);
        $hvoto->setHora($horaactual);
        $hvoto->setTrabajo($trabajovoto);
        $em->persist($hvoto);
        $em->flush();
        $valor = true;
        return $valor;
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

        if($trabajo->getIsActive() == 1 and $trabajo->getEstado() == 1){         
            if($session->get("tipovot") == "Directivo"){
              
                if ($trabajo->getEscuela()->getCue() == $session->get('cue')){
                    $msj = "No puede votar los trabajos que su establecimiento representa.";
                    return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                    
                }else{

                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy( Array("dni"=>$session->get('dni')));
                    $escuela = $em->getRepository('AppBundle:Escuela')->findOneBy( Array("cue"=>$session->get('cue')));     
                    $config = $em->getRepository('AppBundle:Configuracion')->find($escuela->getConfiguracion()->getId());
                    $detconfig = $em->getRepository('AppBundle:Detalleconfiguracion')->findOneBy(
                        array('configuracion'=> $config, 'juris'=>$trabajo->getEscuela()->getJurisdiccion()));
                    $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$directivo->getDni(), "nembre"=>$directivo->getNombre(), 
                            "apellido"=>$directivo->getApellido(), "trabajo"=>$trabajo));                    
                    if(!$historialvoto){  
                        if($trabajo->getNiveltrab() == 'cbs'){     
                            //$juriss = $trabajo->getEscuela()->getJurisdiccion(); 
                            $trabajoid = $trabajo->getId();   
                            if($detconfig->getCantcbs() != 0){
                                $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                $em->persist($detconfig);
                                $em->flush();
                                $registroestado = $this->getRegistrarVoto($session->get('dni'), $directivo->getNombre(),
                                 $directivo->getApellido(), $trabajoid );
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));
                            }else{
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));  
                            }
                            /*foreach ($detconfig as $detconfig) {                                
                                if($detconfig->getJuris()== $juriss){
                                    if($detconfig->getCantcbs() != 0){
                                        $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                        $em->persist($detconfig);
                                        $em->flush();
                                        $registroestado = $this->getRegistrarVoto($session->get('dni'), $directivo->getNombre(), $directivo->getApellido(), $trabajoid );
                                        $msj = "Gracias por votar.";
                                        return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));
                                    }else{
                                        $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));  
                                    }
                                }
                            }*/
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            // $juriss = $trabajo->getEscuela()->getJurisdiccion(); 
                            $trabajoid = $trabajo->getId();  
                            if($detconfig->getCantcss() != 0){
                                $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                $em->persist($detconfig);
                                $em->flush();
                                $registroestado = $this->getRegistrarVoto($session->get('dni'), $directivo->getNombre(), 
                                    $directivo->getApellido(), $trabajoid );
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));
                            }else{
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));  
                            }
                            /*foreach ($detconfig as $detconfig) {                                
                                if($detconfig->getJuris()== $juriss){
                                    if($detconfig->getCantcss() != 0){
                                        $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                        $em->persist($detconfig);
                                        $em->flush();
                                        $registroestado = $this->getRegistrarVoto($session->get('dni'), $directivo->getNombre(), $directivo->getApellido(), $trabajoid );
                                        $msj = "Gracias por votar.";
                                        return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));
                                    }else{
                                        $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));  
                                    }
                                }
                            }*/
                        }else{
                            $msj = "ocurrio un problema intente votar de nuevo, gracias.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                             
                        }
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                    }
                }
                
            }elseif($session->get("tipovot") == "Encargado"){

                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy( Array("dni"=>$session->get('dni')));
                $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                        Array("dni"=>$encargado->getDni(), "nembre"=>$encargado->getNombre(), "apellido"=>$encargado->getApellido(), "trabajo"=>$trabajo));
                if(!$historialvoto){
                    //$trabajos = $em->getRepository('AppBundle:Trabajo')->findBy(array('encargado'=>$encargado));
                    if($trabajo->getEncargado()->getDni() == $session->get('dni')){
                        $msj = "No puede votar los trabajos que representa.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));
                    }else{                      
                        $escuela = $em->getRepository('AppBundle:Escuela')->findOneBy(array('cue'=>$session->get('cue')));
                        $detconfig = $em->getRepository('AppBundle:Detalleconfiguracion')->findOneBy(
                            array('configuracion'=> $escuela->getConfiguracion(), 'juris'=>$trabajo->getEscuela()->getJurisdiccion()));
                        $trabajoid = $trabajo->getId();
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($detconfig->getCantcbs() != 0){
                                $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                $em->persist($detconfig);
                                $em->flush();
                                $registroestado = $this->getRegistrarVoto($session->get('dni'), $encargado->getNombre(), $encargado->getApellido(), $trabajoid );
                            }else{
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));  
                            }
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($detconfig->getCantcss() != 0){
                                $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                $em->persist($detconfig);
                                $em->flush();
                                $registroestado = $this->getRegistrarVoto($session->get('dni'), $encargado->getNombre(), $encargado->getApellido(), $trabajoid );                            
                            }else{
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));  
                            }
                        }else{
                            $msj = "ocurrio un problema intente votar de nuevo, gracias.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));
                        }
                        $msj = "Gracias por votar.";
                        return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));
                    }
                }else{
                    $msj = "Usted ya voto este trabajo.";
                    return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                   
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
                        $detconfig = $em->getRepository('AppBundle:Detalleconfiguracion')->findOneBy(
                            array('configuracion'=>$estudiante->getTrabajo()->getConfiguracion(),'juris'=>$trabajo->getEscuela()->getJurisdiccion()));
                        $trabajoid = $trabajo->getId();
                        if($trabajo->getNiveltrab() == 'cbs'){
                            if($detconfig->getCantcbs() != 0){
                                $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                $em->persist($detconfig);
                                $em->flush();
                                $registroestado = $this->getRegistrarVoto($session->get('dni'), $estudiante->getNombre(), $estudiante->getApellido(), $trabajoid );

                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                                                            
                            }else{
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                            
                            }
                        }elseif($trabajo->getNiveltrab() == 'css'){
                            if($detconfig->getCantcss() != 0){
                                
                                $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                $em->persist($detconfig);
                                $em->flush();
                                $registroestado = $this->getRegistrarVoto($session->get('dni'), $estudiante->getNombre(), $estudiante->getApellido(), $trabajoid );

                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', array('msj'=>$msj));                            
                            }else{
                                $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));                        
                            }
                        }else{
                            $msj = "ocurrio un problema intente votar de nuevo, gracias.";
                            return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));
                        }
                    }else{
                        $msj = "Usted ya voto este trabajo.";
                        return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));
                    }
                }
            }elseif($session->get("tipovot") == "COPETyP"){
                $msj = "Funciones en construcción.";
                return $this->render('AppBundle:PesVotos:mensajeacreditacion1.html.twig', array('msj'=>$msj));        
            }
        }
        ////////////////GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG
        //$msj = "El Trabajo se encuentra desactivado para votar.";
        //return $this->render('AppBundle:PesVotos:mensajevoto1.html.twig', array('msj'=>$msj));        
        $msj = "El trabajo no fue acreditado.";
        return $this->render('AppBundle:PesVotos:mensajeacreditacion1.html.twig', array('msj'=>$msj));         
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
                if($directivo and $directivo->getIsActive() == 1){
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                    if($escuela->getCue() == $request->get('password')){

                        $session=$request->getSession();
                        $session->set("dni",$directivo->getDni());
                        $session->set("tipovot",$directivo->getTipovot());
                        $session->set("cue",$escuela->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
                        if($trabajo){
                            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
                        }else{
                            $msj = "Los trabajos no fueron acreditados o la votación no Inicia.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                        }                        
                    }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                    }
                    
                }elseif($encargado and $encargado->getIsActive() == 1){
                    $trabajo = $em->getRepository('AppBundle:trabajo')->findBy(array('encargado' => $encargado ));
                    foreach ($trabajo as $trabajo ) {

                        if($trabajo->getEscuela()->getCue() == $request->get('password')){
                            $session=$request->getSession();
                            $session->set("dni",$encargado->getDni());
                            $session->set("tipovot",$encargado->getTipovot());
                            $session->set("cue",$trabajo->getEscuela()->getCue());              
                            $em = $this->getDoctrine()->getManager();
                            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
                            if($trabajo){
                                return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
                            }else{
                                $msj = "Los trabajos no fueron acreditados o la votación no Inicia.";
                                return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                            }                        
                        }
                    }
                    $msj = "La Contraseña que ingreso es incorrecta.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                }elseif($estudiante and $estudiante->getIsActive() == 1){
                    
                   if($estudiante->getTrabajo()->getEscuela()->getCue() == $request->get('password')){
                        $session=$request->getSession();
                        $session->set("dni",$estudiante->getDni());
                        $session->set("tipovot",$estudiante->getTipovot());
                        $session->set("cue",$estudiante->getTrabajo()->getEscuela()->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
                        if($trabajo){
                            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
                        }else{
                            $msj = "Los trabajos no fueron acreditados o la votación no Inicia.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                        }                        
                   }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                   }
                }elseif($copetyp and $copetyp->getIsActive() == 1){
                    $msj = "Funcionalidad en construccio.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                }else{
                    $msj = "El D.N.I. del usuario que intenta acceder,
                    no se encuentra autorizado para votar o no fue acreditado.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                }
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
        if($trabajo->getIsActive() == 1 and $trabajo->getEstado() == 1) {
            if($request->isMethod('POST')){
                if($request->get('dni')!= "" && $request->get('password')!=""){
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("dni"=>$request->get('dni'))); 
                    $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni'))); 
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array("dni"=>$request->get('dni'))); 
                    $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneBy(Array("dni"=>$request->get('dni'))); 


                    if($directivo and $directivo->getIsActive() == 1){
                        $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                        if($escuela->getCue() == $request->get('password')){                            
                            if ($trabajo->getEscuela()->getCue() ==  $request->get('password')){
                                $msj = "No puede votar los trabajos que su establecimiento representa.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                    
                            }else{  
                            
                                $config = $em->getRepository('AppBundle:Configuracion')->find(
                                    $escuela->getConfiguracion()->getId());
                                $detconfig = $em->getRepository('AppBundle:Detalleconfiguracion')->findOneBy(
                                    array('configuracion'=> $config, 'juris'=>$trabajo->getEscuela()->getJurisdiccion()));


                                $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                                Array("dni"=>$directivo->getDni(), "nembre"=>$directivo->getNombre(), "apellido"=>$directivo->getApellido(), "trabajo"=>$trabajo));

                                if(!$historialvoto){
                                    if($trabajo->getNiveltrab() == 'cbs'){
                                        $trabajoid = $trabajo->getId();
                                        if($detconfig->getCantcbs() != 0){
                                            $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                            $em->persist($detconfig);
                                            $em->flush();
                                            $registroestado = $this->getRegistrarVoto($directivo->getDni(), $directivo->getNombre(), $directivo->getApellido(), $trabajoid);
                                            $msj = "Gracias por votar.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig',
                                                array('msj'=>$msj));
                                        }else{
                                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                        }
                                    }elseif($trabajo->getNiveltrab() == 'css'){
                                        $trabajoid = $trabajo->getId();
                                        if($detconfig->getCantcss() != 0){
                                            $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                            $em->persist($detconfig);
                                            $em->flush();
                                            $registroestado = $this->getRegistrarVoto($directivo->getDni(), $directivo->getNombre(), $directivo->getApellido(), $trabajoid );
                                            $msj = "Gracias por votar.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                        }else{
                                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                        }
                                    }else{
                                        $msj = "ocurrio un problema intente votar de nuevo, gracias.";
                                        return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                    }
                                }else{
                                    $msj = "Usted ya voto este trabajo.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                        
                                }
                            }
                        }else{
                            $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que ingreso es incorrecta.');
                            return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
                        }
                    }elseif ($encargado and $encargado->getIsActive() == 1) {

                        $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                                Array("dni"=>$encargado->getDni(), "nembre"=>$encargado->getNombre(), "apellido"=>$encargado->getApellido(), "trabajo"=>$trabajo));
                        if(!$historialvoto){
                            //$trabajos = $em->getRepository('AppBundle:Trabajo')->findBy(array('encargado'=>$encargado));
                            if($trabajo->getEncargado()->getDni() == $encargado->getDni()){
                                $msj = "No puede votar los trabajos que representa.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                            }else{

                                $escuela = $em->getRepository('AppBundle:Escuela')->findOneBy(
                                    array('cue'=>$request->get('password')));
                                $detconfig = $em->getRepository('AppBundle:Detalleconfiguracion')->findOneBy(
                                    array('configuracion'=> $escuela->getConfiguracion(), 'juris'=>$trabajo->getEscuela()->getJurisdiccion()));
                                $trabajoid = $trabajo->getId();
                                if($trabajo->getNiveltrab() == 'cbs'){
                                    if($detconfig->getCantcbs() != 0){
                                        $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                        $em->persist($detconfig);
                                        $em->flush();
                                        $registroestado = $this->getRegistrarVoto($encargado->getDni(), $encargado->getNombre(), $encargado->getApellido(), $trabajoid );
                                    }else{
                                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));  
                                    }
                                }elseif($trabajo->getNiveltrab() == 'css'){
                                    if($detconfig->getCantcss() != 0){
                                        $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                        $em->persist($detconfig);
                                        $em->flush();
                                        $registroestado = $this->getRegistrarVoto($encargado->getDni(), $encargado->getNombre(), $encargado->getApellido(), $trabajoid );                            
                                    }else{
                                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));  
                                    }
                                }else{
                                    $msj = "ocurrio un problema intente votar de nuevo, gracias.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                }
                                $msj = "Gracias por votar.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                            }
                        }else{
                            $msj = "Usted ya voto este trabajo.";
                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                   
                        } 
                    }elseif ($estudiante and $estudiante->getIsActive() == 1) {
                        if($estudiante->getTrabajo()->getEscuela()->getCue() == $request->get('password')){
                            if($estudiante->getTrabajo()->getId() == $trabajo->getId()){
                                $msj = "No puede votar su propio trabajo.";
                                return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                    
                            }else{
                                $historialvoto = $em->getRepository('AppBundle:Historialvoto')->findOneBy(
                                    Array("dni"=>$estudiante->getDni(), "nembre"=>$estudiante->getNombre(), "apellido"=>$estudiante->getApellido(), "trabajo"=>$trabajo));   
                                if(!$historialvoto){
                                    $detconfig = $em->getRepository('AppBundle:Detalleconfiguracion')->findOneBy(
                                        array('configuracion' => $estudiante->getTrabajo()->getConfiguracion(), 
                                                'juris' => $trabajo->getEscuela()->getJurisdiccion()));
                                    $trabajoid = $trabajo->getId();
                                    if($trabajo->getNiveltrab() == 'cbs'){
                                        if($detconfig->getCantcbs() != 0){
                                            $detconfig->setCantcbs($detconfig->getCantcbs() - 1);
                                            $em->persist($detconfig);
                                            $em->flush();
                                            $registroestado = $this->getRegistrarVoto($estudiante->getDni(), 
                                                $estudiante->getNombre(), $estudiante->getApellido(), $trabajoid );
                                            $msj = "Gracias por votar.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                        }else{
                                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Básico Secundario.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));                            
                                        }
                                    }elseif($trabajo->getNiveltrab() == 'css'){
                                        if($detconfig->getCantcss() != 0){
                                            $detconfig->setCantcss($detconfig->getCantcss() - 1);
                                            $em->persist($detconfig);
                                            $em->flush();
                                            $registroestado = $this->getRegistrarVoto($estudiante->getDni(), 
                                                $estudiante->getNombre(), $estudiante->getApellido(), $trabajoid );                               
                                            $msj = "Gracias por votar.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                        }else{
                                            $msj = "Supero la cantidad disponible para votar los trabajos de Nivel Ciclo Superior Secundario.";
                                            return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                        }
                                    }else{
                                        $msj = "ocurrio un problema intente votar de nuevo, gracias.";
                                        return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                    }
                                }else{
                                    $msj = "Usted ya voto este trabajo.";
                                    return $this->render('AppBundle:PesVotos:msjvotoQR.html.twig', array('msj'=>$msj));
                                }                                
                            }
                        }else{
                            $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que ingreso es incorrecta.');
                            return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
                        }
                    }elseif ($copetyp and $copetyp->getIsActive() == 1) {
                        $this->get('session')->getFlashBag()->add('mensaje','Funcionalidad en construccio.');
                        return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El D.N.I. del usuario que intenta acceder, 
                        no se encuentra autorizado para votar o no fue acreditado.');
                        return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));   
                    }
                }
                $this->get('session')->getFlashBag()->add('mensaje','Debe ingresar su D.N.I. y Contraseña.');
                return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));            
            }
            return $this->render('AppBundle:PesVotos:Vertrabajo.html.twig', array('trab'=>$trabajo));
        }
        $msj = "El trabajo no fue acreditado o la votación no Inicia.";
        return $this->render('AppBundle:PesVotos:mensajeacreditacion.html.twig', array('msj'=>$msj));
    }
}
