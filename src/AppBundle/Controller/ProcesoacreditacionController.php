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

class ProcesoacreditacionController extends Controller
{

 ////////////////////////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////ACREDITACION/////////////////////////////////////////////////////////
 //////////////////////////////////////////////////////////////////////////////////////////////////   
    /**
     * @Route("/cargadatos/iniciandoprocesodeacreditacion", name="IniciarProcesoAcreditacion")
     */
    public function IniciarProcesoAcreditacionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);

                if($escuela){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("escuela"=>$escuela));
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("idesc"=>$escuela->getId()));
                    if($directivo){
                        $estd = 1;    
                    }else{
                        $estd = 0;
                    }
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findAll();
                    return $this->render('AppBundle:Acreditacion:acreditar.html.twig', 
                    array("estd"=>$estd, "escuela"=>$escuela, "trabajo"=>$trabajo, "directivo"=>$directivo, "estudiante"=>$estudiante));
                }
            }
            $em=$this->getDoctrine()
                     ->getManager()
                        ->createQueryBuilder('AppBundle:Escuela')
                        ->select('e')
                        ->from('AppBundle:Escuela','e')
                        ->orderBy("e.cue","asc")
                        ->getQuery();
         $escuela=$em->getArrayResult();
         return $this->render('AppBundle:Acreditacion:seleccionarescuela1.html.twig', array("escuela"=>$escuela));
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        } 
    }
    
    /**
     * @Route("/cargadatos/guardarcambios", name="ConfirmarAcreditacion")
     */
    public function ConfirmarAcreditacionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                foreach($_POST['acreditacion'] as $nombre ){
                    $arreglo = explode('-', $nombre);
                    $tipousuario = $arreglo[0];
                    $dni = $arreglo[1];
                    if ($tipousuario == 'd'){
                        $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array('dni' => $dni));
                        $escuela = $em->getRepository('AppBundle:Escuela')->findOneBy(Array('id'=>$directivo->getIdesc()));
                        
                        $directivo->setIsActive(1);
                        $em->persist($directivo);
                        $em->flush();    
                        /*$escuela->getConfiguracion()->setIsActive(1);
                        $em->persist($escuela);
                        $em->flush();*/
                    }elseif ($tipousuario == 'en'){
                        $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni' => $dni));
                        $encargado->setIsActive(1);
                        $encargado->getConfiguracion()->setIsActive(1);
                        $em->persist($encargado);
                        $em->flush();                                            
                    }elseif ($tipousuario == 'es'){
                        $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array('dni' => $dni));
                        $estudiante->setIsActive(1);
                        $em->persist($estudiante);
                        $em->flush();                              
                    }elseif ($tipousuario == 't'){
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(Array('id' => $dni));
                        $trabajo->setIsActive(1);
                        $trabajo->getConfiguracion()->setIsActive(1);
                        $em->persist($trabajo);
                        $em->flush();                          
                    }
                    
                }
                $msj = "El proceso de acreditación finalizó con exito.";              
                return $this->render('AppBundle:Acreditacion:msjacreditarok.html.twig', array('msj'=>$msj));
            }else{
                $msj = "Ocurrio un problema y el proceso de acreditación no finalizó con exito.";              
                return $this->render('AppBundle:Acreditacion:msjacreditarerro.html.twig', array('msj'=>$msj));
            }
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

    /**
     * @Route("/cargadatos/volveracreditacion/{id}", name="VolverAcreditacion")
     */
    public function VolverAcreditacionAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->find($id);

                if($escuela){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("escuela"=>$escuela));
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("idesc"=>$escuela->getId()));
                    if($directivo){
                        $estd = 1;    
                    }else{
                        $estd = 0;
                    }
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findAll();
                    return $this->render('AppBundle:Acreditacion:acreditar.html.twig', 
                    array("estd"=>$estd, "escuela"=>$escuela, "trabajo"=>$trabajo, "directivo"=>$directivo, "estudiante"=>$estudiante));
                }
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }   
    }

    /**
     * @Route("/cargadatos/datosestablecimiento/{id}", name="EstablecimientoMostrar")
     */
    public function EstablecimientoMostrarAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $escuela = $em->getRepository('AppBundle:Escuela')->find($id);
            $jurisdiccion = $em->getRepository('AppBundle:Jurisdiccion')->findAll();       
            return $this->render('AppBundle:Acreditacion:editarescuela.html.twig',
                array('escuela'=>$escuela, 'jurisdiccion'=>$jurisdiccion));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }   
    }

    /**
     * @Route("/cargadatos/guardarescuela/{id}", name="GuardarEscuela")
     */
    public function GuardarEscuelaAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {

                $em = $this->getDoctrine()->getManager();
                $verifescuela = $em->getRepository('AppBundle:Escuela')->findOneByCue($request->get('cue'));
                if(count($verifescuela) == 0 or $verifescuela->getId() == $id){
                    $em = $this->getDoctrine()->getManager();
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($id);
                    $escuela->setCue($_POST['cue']);
                    $escuela->setNombesc($_POST['nombesc']);
                    $escuela->setJurisdiccion($_POST['jurisdiccion']);
                    $escuela->setLocalidad($_POST['localidad']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($escuela);
                    $em->flush();
                    $msj = "Los datos del Establecimiento se modificaron con exito.";              
                    return $this->render('AppBundle:Acreditacion:msjconfirmacion.html.twig', array('msj'=>$msj, 'id'=>$id));
                }else{
                    $msj = "El nuevo CUE ingresado ya existe, verifique los datos por favor.";        
                    return $this->render('AppBundle:Acreditacion:msjerro.html.twig',Array('msj'=>$msj, 'id'=>$id));
                }
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Acreditacion:msjerro.html.twig',Array('msj'=>$msj, 'id'=>$id));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }         

    }   

    /**
     * @Route("/cargadatos/trabajomostrar/{ide}/{idt}", name="TrabajoMostrar")
     */
    public function TrabajoMostrarAction(Request $request, $ide, $idt)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findAll();
            $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->find($idt);       
            $dnienc = $trabajo->getEncargado()->getDni();
            $aynenc = $trabajo->getEncargado()->getApellido().", ".$trabajo->getEncargado()->getNombre();
            $idesc = $trabajo->getEscuela()->getId();
            $nombreescuela = $trabajo->getEscuela()->getNombesc();
            return $this->render('AppBundle:Acreditacion:edittrabajo.html.twig',
            array('trabajo'=>$trabajo,
            'encargado'=>$encargado, 'escuela'=>$escuela,
            'aynenc'=>$aynenc, 'nombreescuela'=>$nombreescuela,
            'dnienc'=>$dnienc, 'idescuela'=>$idesc, 'ide'=>$ide ));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }  
    }
    
    /**
     * @Route("/cargadatos/guardarmodificaciontrabajo/{idt}/{ide}", name="GuardarDTM")
     */
    public function GuardarDTMAction(Request $request, $idt, $ide)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['encargado']);
                $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);
                $idesc = $escuela->getId();   
                $trabajo = $em->getRepository('AppBundle:Trabajo')->find($idt);   
                $trabajo->setNombproyecto($_POST['nombproyecto']);
                $trabajo->setCvmencion(0);
                $trabajo->setCvdestacado(0);
                $trabajo->setEncargado($encargado);
                $trabajo->setEscuela($escuela);
                $em->persist($trabajo);
                $em->flush();
                $msj = "Los datos se modificaron con exito.";              
                return $this->render('AppBundle:Acreditacion:msjconfirmacion.html.twig', array('msj'=>$msj, 'id'=>$idesc));            
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Acreditacion:msjerro.html.twig',Array('msj'=>$msj, 'id'=>$ide));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }   
    } 

    /**
     * @Route("/cargadatos/editdirectivo/{ide}/{dni}", name="EditDatosDirectivo")
     */
    public function EditDatosDirectivoAction(Request $request, $ide, $dni)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array('dni'=>$dni));
            $escuela = $em->getRepository('AppBundle:Escuela')->findOneBy(array('id'=>$directivo->getIdesc()));
            $idesc = $escuela->getId();
            $nombreescuela = $escuela->getNombesc();
            $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
            return $this->render('AppBundle:Acreditacion:editdirectivo.html.twig',
                array('directivo'=>$directivo, 'escuela'=>$escuela, 'idescuela'=>$idesc, 'nombreescuela'=>$nombreescuela));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }
    
    /**
     * @Route("/cargadatos/guardarmodificaciondirectivo/{dni}/{ide}", name="GuardarModDirectivo")
     */
    public function GuardarModDirectivoAction(Request $request, $dni, $ide)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneByDni($dni);
                $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);
                $idesc = $escuela->getId();   
                $directivo->setDni($_POST['dni']);
                $directivo->setNombre($_POST['nombre']);
                $directivo->setApellido($_POST['apellido']);
                $directivo->setCargo($_POST['cargo']);
                $directivo->setIdesc($idesc);
                $em->persist($directivo);
                $em->flush();
                $msj = "Los datos se modificaron con exito.";              
                return $this->render('AppBundle:Acreditacion:msjconfirmacion.html.twig', array('msj'=>$msj, 'id'=>$ide));
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Acreditacion:msjerro.html.twig',Array('msj'=>$msj, 'id'=>$ide));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }  
    } 

    /**
     * @Route("/cargadatos/editencargado/{ide}/{dni}", name="EditDatosDocenteResp")
     */
    public function EditDatosDocenteRespAction(Request $request, $ide, $dni)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni'=>$dni));
            return $this->render('AppBundle:Acreditacion:editencargado.html.twig',
                array('encargado'=>$encargado, 'ide'=>$ide));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

    /**
     * @Route("/cargadatos/guardarmodificacionencargado/{dni}/{ide}", name="GuardarModEncargado")
     */
    public function GuardarModEncargadoAction(Request $request, $dni, $ide)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($dni);
                $encargado->setDni($_POST['dni']);
                $encargado->setNombre($_POST['nombre']);
                $encargado->setApellido($_POST['apellido']);
                $encargado->setMateriadic($_POST['materiadic']);
                $em->persist($encargado);
                $em->flush();
                $msj = "Los datos se modificaron con exito.";              
                return $this->render('AppBundle:Acreditacion:msjconfirmacion.html.twig', array('msj'=>$msj, 'id'=>$ide));
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Acreditacion:msjerro.html.twig',Array('msj'=>$msj, 'id'=>$ide));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }  
    } 

    /**
     * @Route("/cargadatos/editalumno/{ide}/{dni}", name="EditDatosAlumno")
     */
    public function EditDatosAlumnoAction(Request $request, $ide, $dni)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array('dni'=>$dni));
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
            return $this->render('AppBundle:Acreditacion:editalumno.html.twig',
                array('estudiante'=>$estudiante, 'trabajo'=>$trabajo, 'ide'=>$ide));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

    /**
     * @Route("/cargadatos/guardarmodificacionalumno/{dni}/{ide}", name="GuardarModAlumno")
     */
    public function GuardarModAlumnoAction(Request $request, $dni, $ide)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneByDni($dni);
                $trabajo = $em->getRepository('AppBundle:Trabajo')->find($_POST['trabajo']);
                $estudiante->setDni($_POST['dni']);
                $estudiante->setNombre($_POST['nombre']);
                $estudiante->setApellido($_POST['apellido']);
                $estudiante->setAniocursa($_POST['aniocursa']);
                $estudiante->setEspecialidada($_POST['especialidada']);
                $estudiante->setNivel($_POST['nivel']);
                $estudiante->setTrabajo($trabajo);
                $em->persist($estudiante);
                $em->flush();
                $msj = "Los datos se modificaron con exito.";              
                return $this->render('AppBundle:Acreditacion:msjconfirmacion.html.twig', array('msj'=>$msj, 'id'=>$ide));
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Acreditacion:msjerro.html.twig',Array('msj'=>$msj, 'id'=>$ide));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }  
    }     
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/cargadatos/inicarvotacion", name="IniciarVotacion")
     */
    public function InicarVotacionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1,'estado' => 0));
            if($trabajo){
                foreach ($trabajo as $key ) {
                    $estadotrabajo = $this->getEstadoIniciar($key->getId());
                }
                $msj ="Votación Iniciada.";
                return $this->render('AppBundle:Default:msjestadovotacion.html.twig', array('msj'=>$msj));
            }else{
                $msj ="Las Votaciones ya fueron iniciadas.";
                return $this->render('AppBundle:Default:msjexcepcion.html.twig', array('msj'=>$msj));
            }
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        } 
    }

    /**
     * @Route("/cargadatos/finalizarvotacion", name="FinalizarVotacion")
     */
    public function FinalizarVotacionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1,'estado' => 1));
            if($trabajo){
                foreach ($trabajo as $key) {
                    $estadotrabajo = $this->getEstadoCerrar($key->getId());
                }
                $msj ="Votaciones cerradas.";
                return $this->render('AppBundle:Default:msjestadovotacion.html.twig', array('msj'=>$msj));
            }else{
                $msj ="Las Votaciones ya fueron cerradas.";
                return $this->render('AppBundle:Default:msjexcepcion.html.twig', array('msj'=>$msj));
            }
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        } 
    } 

    public function getEstadoIniciar($idtrab)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->find($idtrab);
        $trabajo->setEstado(1);
        $em->persist($trabajo);
        $em->flush();
        $valor = $trabajo->getId();
        return $valor;
    } 

    public function getEstadoCerrar($idtrab)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->find($idtrab);
        $trabajo->setEstado(0);
        $em->persist($trabajo);
        $em->flush();
        $valor = $trabajo->getId();
        return $valor;
    }  

    /**
     * @Route("/cargadatos/contarvotos", name="ContarVotos")
     */
    public function ContarVotosAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1,'estado' => 0));
            if($trabajo){
                foreach ($trabajo as $key ) {
                    $estadotrabajo = $this->getContadorVotos($key->getId());
                }
                $msj ="Finalizó el Conteo de Votos.";
                return $this->render('AppBundle:Default:msjestadovotacion.html.twig', array('msj'=>$msj));
            }else{
                $msj ="No Finalizó la Votación.";
                return $this->render('AppBundle:Default:msjexcepcion.html.twig', array('msj'=>$msj));
            }
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        } 
    }
    
    public function getContadorVotos($idtrab)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->find($idtrab);
        $historialvotos = $em->getRepository('AppBundle:Historialvoto')->findBy(Array('trabajo' => $trabajo));
        $contadordevotos = count($historialvotos);
        $trabajo->setCantvoto($contadordevotos);
        $em->persist($trabajo);
        $em->flush();
        $valor = $trabajo->getId();
        return $valor;
    }     
}