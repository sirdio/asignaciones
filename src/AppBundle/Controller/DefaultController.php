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

class DefaultController extends Controller
{
    /**
     * @Route("/login", name="Login")
     */
    public function LoginAction(Request $request)
    {
        
        
        if($request->isMethod('POST')){
            if($request->get('username')!= "" && $request->get('password')!=""){
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('AppBundle:Users')->findOneBy(
                    Array("username"=>$request->get('username'), 
                    "password"=>$request->get('password')));                
                if($user){
                    $session=$request->getSession();
                    $session->set("id",$user->getId());
                    $session->set("username",$user->getUsername());                    
                    return $this->render('AppBundle:Default:inicio.html.twig');                                
                }else{
                    return $this->render('AppBundle:Default:principal.html.twig');    
                }                                                
            }
            return $this->render('AppBundle:Default:principal.html.twig');

        }
        return $this->render('AppBundle:Default:principal.html.twig');

    }
    
    /**
     * @Route("/logout", name="Logout")
     */    
    public function LogoutAction(Request $request)
    {
        $session=$request->getSession();
        $session->clear();
        return $this->render('AppBundle:Default:principal.html.twig');
    }
    
    
///////////////////////////////////////////////////////////////////////////////    
    /**
     * @Route("/cargadatos/inicio", name="Inicio")
     */
    public function InicioAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id"))
        {
            return $this->render('AppBundle:Default:inicio.html.twig');
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }

    /**
     * @Route("/cargadatos/seleccionatipousuario", name="Default_SelecU")
     */
    public function SelecUAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id"))
        {
            return $this->render('AppBundle:Default:selectipouduario.html.twig');
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        } 
    }

    /**
     * @Route("/cargadatos/nuevousuario", name="NuevoUsuario")
     */
    public function NuevoUAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            
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
                    return $this->render('AppBundle:Default:nuevoencargado.html.twig', 
                    array('tipovotante'=>$tipovotante));
                
                }elseif ($_POST['selectbasic'] == "Estudiante"){
                        $em=$this->getDoctrine()
                                 ->getManager()
                                    ->createQueryBuilder('AppBundle:Trabajo')
                                    ->select('t')
                                    ->from('AppBundle:Trabajo','t')
                                    ->orderBy("t.stand","asc")
                                    ->getQuery();
                    $trabajo=$em->getArrayResult();
                    if (!$trabajo){
                        $msj = "Para cargar un usuario Estudiante es necesario cargar antes los trabajos.";              
                        return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));
                    }    
                    return $this->render('AppBundle:Default:nuevoestudiante.html.twig', 
                    array('tipovotante'=>$tipovotante, 'trabajo'=>$trabajo));           
                }elseif ($_POST['selectbasic'] == "Jurado"){
                    $msj = "Funcionalidad en construcción";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                     
                    /*return $this->render('AppBundle:Default:nuevocopetyp.html.twig', 
                    array('tipovotante'=>$tipovotante));*/
                }else{
                    $msj = "error debe seleccinar un tipo de usuario valido";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj)); 
                }
            }
            $msj = "Ocurrio un problema intente nuevamente.";
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }  
    }

    /**
     * @Route("/cargadatos/guardarusuariodirectivo", name="GuardarUsuarioDirectivo")
     */
    public function GuardarUsuarioDirectivoAction(Request $request)
    {

        $session=$request->getSession();
        if($session->has("id")){
            if($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();                
                $verif1 = $em->getRepository('AppBundle:Directivo')->findOneBy(Array('dni'=>$_POST['dni']));
                $verif2 = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni'=>$_POST['dni']));
                $verif3 = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array('dni'=>$_POST['dni']));
                if(strlen($_POST['dni']) < 8 or count($verif1)!= 0 or count($verif2)!= 0 or count($verif3)!= 0){
                    $msj = "ingrese un D.N.I valido.";  
                    $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'),
                                        'tv' => $request->get('tipovotante'),
                                        'escuelaid' => $request->get('establecimiento'),
                                        'cargo' => $request->get('cargo'));
                    $datoesc = $em->getRepository('AppBundle:Escuela')->find($request->get('establecimiento'));
                    $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                    return $this->render('AppBundle:Default:nuevodirectivo1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario, 'escuela'=>$escuela , 'datoesc'=>$datoesc));
                }else{
                    /*$configuracion = new Configuracion();
                    $configuracion->setCtvcbs(1);
                    $configuracion->setCtvcss(1);
                    $configuracion->setCtvfp(1);
                    $configuracion->setCtvts(1);
                    $em->persist($configuracion);
                    $em->flush();*/
                    $directivo = new Directivo();
                    $directivo->setDni($_POST['dni']);
                    $directivo->setNombre($_POST['nombre']);
                    $directivo->setApellido($_POST['apellido']);
                    $directivo->setCargo($_POST['cargo']);
                    $directivo->setIdesc($_POST['establecimiento']);
                    $directivo->setTipovot($_POST['tipovotante']);
                    /*$directivo->setConfiguracion($configuracion);*/
                    $em->persist($directivo);
                    $em->flush();
                    $msj = "Usuario cargado con exito.";              
                    return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));
                }    
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));   
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

    /**
     * @Route("/cargadatos/guardarusuarioencargado", name="GuardarUsuarioEncargado")
     */
    public function GuardarUsuarioEncargadoAction(Request $request)
    {

        $session=$request->getSession();
        if($session->has("id")){
            if($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                $verif1 = $em->getRepository('AppBundle:Directivo')->findOneBy(Array('dni'=>$_POST['dni']));
                $verif2 = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni'=>$_POST['dni']));
                $verif3 = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array('dni'=>$_POST['dni']));
                if(strlen($_POST['dni']) < 8 or count($verif1)!= 0 or count($verif2)!= 0 or count($verif3)!= 0){
                    $msj = "ingrese un D.N.I valido.";  
                    $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'),
                                        'tv' => $request->get('tipovotante'),
                                        'materiadic' => $request->get('materiadic'));
                    return $this->render('AppBundle:Default:nuevoencargado1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario));
                }else{
                    $configuracion = new Configuracion();
                    $configuracion->setCtvcbs(1);
                    $configuracion->setCtvcss(1);
                    $configuracion->setCtvfp(1);
                    $configuracion->setCtvts(1);
                    $em->persist($configuracion);
                    $em->flush();
                    $encargado = new Encargado();
                    $encargado->setDni($_POST['dni']);
                    $encargado->setNombre($_POST['nombre']);
                    $encargado->setApellido($_POST['apellido']);
                    $encargado->setMateriadic($_POST['materiadic']);
                    $encargado->setTipovot($_POST['tipovotante']);
                    $encargado->setConfiguracion($configuracion);
                    $em->persist($encargado);
                    $em->flush();
                    $msj = "Usuario cargado con exito.";              
                    return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));
                }    
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));   
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

   /**
     * @Route("/cargadatos/guardarusuarioalumno", name="GuardarUsuarioAlumno")
     */
    public function GuardarUsuarioAlumnoAction(Request $request)
    {

        $session=$request->getSession();
        if($session->has("id")){
            if($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                $verif1 = $em->getRepository('AppBundle:Directivo')->findOneBy(Array('dni'=>$_POST['dni']));
                $verif2 = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni'=>$_POST['dni']));
                $verif3 = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array('dni'=>$_POST['dni']));
                if(strlen($_POST['dni']) < 8 or count($verif1)!= 0 or count($verif2)!= 0 or count($verif3)!= 0){
                    $msj = "ingrese un D.N.I valido.";  
                    $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'),
                                        'tv' => $request->get('tipovotante'),
                                        'aniocursado' => $request->get('aniocursa'),
                                        'especialidad' => $request->get('especialidada'),
                                        'nivel' => $request->get('nivel'));
                    $datotrabajo = $em->getRepository('AppBundle:Trabajo')->find($_POST['trabajo']);
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                    return $this->render('AppBundle:Default:nuevoestudiante1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario, 
                            'datotrab'=>$datotrabajo, 'trabajo'=>$trabajo));
                }else{
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->find($_POST['trabajo']);
                    $estudiante = new Estudiante();
                    $estudiante->setDni($_POST['dni']);
                    $estudiante->setNombre($_POST['nombre']);
                    $estudiante->setApellido($_POST['apellido']);
                    $estudiante->setTipovot($_POST['tipovotante']);
                    $estudiante->setAniocursa($_POST['especialidada']);
                    $estudiante->setEspecialidada($_POST['especialidada']);
                    $estudiante->setNivel($_POST['nivel']);
                    $estudiante->setTrabajo($trabajo);
                    $em->persist($estudiante);
                    $em->flush();
                    $msj = "Usuario cargado con exito.";              
                    return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));
                }    
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));   
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }


    /**
     * @Route("/cargadatos/listarusuarios", name="ListarUsuarios")
     */
    public function ListarUsuariosAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id"))
        {
            /////////////////////////////////////////////////////////////////////
            $em = $this->getDoctrine()->getManager();
            $usuarios = $em->getRepository('AppBundle:Usuariovotante')->findAll();
            if (!$usuarios){
                $msj = "No existe Usuarios cargados.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
            }        
            return $this->render('AppBundle:Default:listarusuarios.html.twig',array('usuarios'=>$usuarios));
            //////////////////////////////////////////////////////////////////////
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }        
    }   

    /**
     * @Route("/cargadatos/mostrarusuario/{dni}/{tv}", name="MostrarUsuario")
     */
    public function MostrarUsuarioAction(Request $request, $dni, $tv)
    {
        $session=$request->getSession();
        if($session->has("id")){
            /////////////////////////////////////////////////////////////////////
            $em = $this->getDoctrine()->getManager();
                if ($tv == "Directivo"){
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneByDni($dni);
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc());
                    $idesc = $escuela->getId();
                    $nombesc = $escuela->getNombesc();
                    $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                    return $this->render('AppBundle:Default:editardirectivo.html.twig',
                    array('idesc'=>$idesc, 'nombesc'=>$nombesc, 
                    'directivo'=>$directivo, 'escuela'=>$escuela));
                
                }elseif ($tv == "Encargado"){
                    $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($dni);
                    return $this->render('AppBundle:Default:editarencargado.html.twig',
                    array('encargado'=>$encargado));
                    
                }elseif ($tv == "Estudiante"){
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneByDni($dni);
                    $idtrab = $estudiante->getTrabajo()->getId();
                    $nombtrab = $estudiante->getTrabajo()->getNombproyecto();
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                    return $this->render('AppBundle:Default:editarestudiante.html.twig',
                    array('idtrab'=>$idtrab, 'nombtrab'=>$nombtrab, 
                    'estudiante'=>$estudiante, 'trabajos'=>$trabajo));
                    
                }elseif ($tv == "Jurado"){
                    $msj = "error debe seleccinar un tipo de usuario valido";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj)); 
                    /*$copetyp = $em->getRepository('AppBundle:Copetyp')->findOneByDni($dni);
                    return $this->render('AppBundle:Default:editarcopetyp.html.twig',
                    array('copetyp'=>$copetyp));*/
                }
            //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }      
    }
    
    /**
     * @Route("/cargadatos/guardarmodificacion/{dni}/{tv}", name="GuardarModificacion")
     */
    public function GuardarModificacionAction(Request $request, $dni, $tv)
    {
        $session=$request->getSession();
        if($session->has("id")){
            /////////////////////////////////////////////////////////////////////
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $verificar = $em->getRepository('AppBundle:Directivo')->findOneByDni($_POST['dni']);
            $verificar1 = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['dni']);
            $verificar2 = $em->getRepository('AppBundle:Estudiante')->findOneByDni($_POST['dni']);
            $verificar3 = $em->getRepository('AppBundle:Copetyp')->findOneByDni($_POST['dni']);
            if ($tv == "Directivo"){
                
                if(count($verificar)!= 0 and $verificar->getDni() != $dni or count($verificar1)!= 0 and $verificar1->getDni() != $dni or count($verificar2)!= 0 and $verificar2->getDni() != $dni or count($verificar3)!= 0 and $verificar3->getDni() != $dni ){
                    $msj = "El nuevo DNI que ingreso ya esta registrado, verifique los datos por favor.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }elseif(strlen($_POST['dni']) < 8){
                    $msj = "Debe ingresar un número de DNI valido.";        
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }else{
                    $establecimiento = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneByDni($dni);
                    $directivo->setDni($_POST['dni']);
                    $directivo->setNombre($_POST['nombre']);
                    $directivo->setApellido($_POST['apellido']);
                    $directivo->setCargo($_POST['cargo']);
                    $directivo->setIdesc($establecimiento->getId());
                    $em->persist($directivo);
                    $em->flush();
                }
            }elseif ($tv == "Encargado"){
                
                if(count($verificar)!= 0 and $verificar->getDni() != $dni or count($verificar1)!= 0 and $verificar1->getDni() != $dni or count($verificar2)!= 0 and $verificar2->getDni() != $dni or count($verificar3)!= 0 and $verificar3->getDni() != $dni ){
                    $msj = "El nuevo DNI que ingreso ya esta registrado, verifique los datos por favor.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }elseif(strlen($_POST['dni']) < 8){
                    $msj = "Debe ingresar un número de DNI valido.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }else{      
                    $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($dni);
                    $encargado->setDni($_POST['dni']);
                    $encargado->setNombre($_POST['nombre']);
                    $encargado->setApellido($_POST['apellido']);
                    $encargado->setMateriadic($_POST['materiadic']);
                    $em->persist($encargado);
                    $em->flush();                
                }
            }elseif ($tv == "Estudiante"){
                
                if(count($verificar)!= 0 and $verificar->getDni() != $dni or count($verificar1)!= 0 and $verificar1->getDni() != $dni or count($verificar2)!= 0 and $verificar2->getDni() != $dni or count($verificar3)!= 0 and $verificar3->getDni() != $dni ){
                    $msj = "El nuevo DNI que ingreso ya esta registrado, verifique los datos por favor.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }elseif(strlen($_POST['dni']) < 8){
                    $msj = "Debe ingresar un número de DNI valido.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }else{                
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->find($_POST['trabajo']);
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneByDni($dni);
                    $estudiante->setDni($_POST['dni']);
                    $estudiante->setNombre($_POST['nombre']);
                    $estudiante->setApellido($_POST['apellido']);
                    $estudiante->setAniocursa($_POST['aniocursa']);
                    $estudiante->setEspecialidada($_POST['especialidada']);
                    $estudiante->setNivel($_POST['nivel']);
                    $estudiante->setTrabajo($trabajo);
                    $em->persist($estudiante);
                    $em->flush();                
                }
            }elseif ($tv == "Jurado"){
                
                if(count($verificar)!= 0 and $verificar->getDni() != $dni or count($verificar1)!= 0 and $verificar1->getDni() != $dni or count($verificar2)!= 0 and $verificar2->getDni() != $dni or count($verificar3)!= 0 and $verificar3->getDni() != $dni ){
                    $msj = "El nuevo DNI que ingreso ya esta registrado, verifique los datos por favor.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }elseif(strlen($_POST['dni']) < 8){
                    $msj = "Debe ingresar un número de DNI valido.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }else{                
                    $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneByDni($dni);
                    $copetyp->setDni($_POST['dni']);
                    $copetyp->setNombre($_POST['nombre']);
                    $copetyp->setApellido($_POST['apellido']);
                    $copetyp->setCargocop($_POST['cargocop']);
                    $em->persist($copetyp);
                    $em->flush();                  
                }
            }
            $msj = "Los datos se modificaron con exito.";              
            return $this->render('AppBundle:Default:mensajemodificacion.html.twig', array('msj'=>$msj));            
        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
            //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }   

////////////////////////////////////////////////////////////////////////////////////////////////////////    
    /**
     * @Route("/cargadatos/nuevoestablecimiento", name="NuevoEstablecimiento")
     */
    public function MostrarFormularioAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $jurisdiccion = $em->getRepository('AppBundle:Jurisdiccion')->findAll();
            return $this->render('AppBundle:Default:nuevaescuela.html.twig',array('jurisdiccion'=>$jurisdiccion));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }        
    }

    /**
     * @Route("/cargadatos/agregarestablecimiento", name="AgregarEstablecimiento")
     */
    public function AgregarEstAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $verifescuela = $em->getRepository('AppBundle:Escuela')->findOneByCue($request->get('cue'));
                if(count($verifescuela) == 0){              
                    $escuela = new Escuela();
                    $escuela->setCue($_POST['cue']);
                    $escuela->setNombesc($_POST['nombesc']);
                    $escuela->setJurisdiccion($_POST['jurisdiccion']);
                    $escuela->setLocalidad($_POST['localidad']);               
                    $em->persist($escuela);
                    $em->flush();
                    $msj = "Establecimiento cargado con exito.";              
                    return $this->render('AppBundle:Default:mensajealtaest.html.twig', array('msj'=>$msj));            
                }else{
                    $msj = "El CUE ingresado ya existe, verifique los datos por favor.";        
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }
    
    /**
     * @Route("/cargadatos/listarestablecimiento", name="ListarEstablecimiento")
     */
    public function ListarEstAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
            if (!$escuela){
                $msj = "No existe Establecimientos cargados.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
            }        
            return $this->render('AppBundle:Default:listarestablecimiento.html.twig',array('escuela'=>$escuela));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }        
    }    

    /**
     * @Route("/cargadatos/mostrarestablecimiento/{id}", name="MostrarEstablecimiento")
     */
    public function MostrarEstAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $escuela = $em->getRepository('AppBundle:Escuela')->find($id);
            if (!$escuela){
                $msj = "No existe Establecimiento.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
            } 
            $em = $this->getDoctrine()->getManager();
            $jurisdiccion = $em->getRepository('AppBundle:Jurisdiccion')->findAll();       
            return $this->render('AppBundle:Default:editarestablecimiento.html.twig',
                array('escuela'=>$escuela, 'jurisdiccion'=>$jurisdiccion));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        } 
        
    }

    /**
     * @Route("/cargadatos/guardarcambiosest/{id}", name="GuardarCambiosEst")
     */
    public function GuardarCambiosEstAction(Request $request, $id)
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
                    return $this->render('AppBundle:Default:mensajemodificacion.html.twig', array('msj'=>$msj));
                }else{
                    $msj = "El nuevo CUE ingresado ya existe, verifique los datos por favor.";        
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));                
                }
            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }    
}
