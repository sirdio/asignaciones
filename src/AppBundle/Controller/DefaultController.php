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
            /////////////////////////////////////////////////////////////////////
            return $this->render('AppBundle:Default:selectipouduario.html.twig');
            //////////////////////////////////////////////////////////////////////
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
                    //$escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                    return $this->render('AppBundle:Default:nuevoencargado.html.twig', 
                    array('tipovotante'=>$tipovotante));//, 'escuela'=>$escuela));
                
                }elseif ($_POST['selectbasic'] == "Docente"){
                    $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                    if (!$presentacion){
                        $msj = "Para cargar un usuario Docente es necesario cargar antes las presentaciones.";              
                        return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
                    }    
                    return $this->render('AppBundle:Default:nuevodocente.html.twig', 
                    array('tipovotante'=>$tipovotante, 'presentacion'=>$presentacion));                
                
                }elseif ($_POST['selectbasic'] == "Estudiante"){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                    if (!$trabajo){
                        $msj = "Para cargar un usuario Estudiante es necesario cargar antes los trabajos.";              
                        return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
                    }    
                    return $this->render('AppBundle:Default:nuevoestudiante.html.twig', 
                    array('tipovotante'=>$tipovotante, 'trabajo'=>$trabajo));           
                
                
                }elseif ($_POST['selectbasic'] == "COPETyP"){
                    return $this->render('AppBundle:Default:nuevocopetyp.html.twig', 
                    array('tipovotante'=>$tipovotante));
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
     * @Route("/cargadatos/guardarusuario", name="GuardarUsuario")
     */
    public function GuardarUAction(Request $request)
    {

        $session=$request->getSession();
        if($session->has("id")){
        /////////////////////////////////////////////////////////////////////////    

            if($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                if(strlen($_POST['dni']) < 8){
                    $msj = "ingrese un D.N.I valido.";  

                    if($request->get('tipovotante') == "Directivo"){
                        $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'),
                                        'tv' => $request->get('tipovotante'),
                                        'escuelaid' => $request->get('establecimiento'),
                                        'cargo' => $request->get('cargo'),
                                        'tel' => $request->get('tel'),
                                        'email' => $request->get('email'));
                        $datoesc = $em->getRepository('AppBundle:Escuela')->find($request->get('establecimiento'));
                        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                        return $this->render('AppBundle:Default:nuevodirectivo1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario, 'escuela'=>$escuela , 'datoesc'=>$datoesc));
                    }elseif($request->get('tipovotante') == "Encargado"){
                        $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'),
                                        'tv' => $request->get('tipovotante'),
                                        //'escuelaid' => $request->get('establecimiento'),
                                        'materiadicta' => $request->get('materiadic'),
                                        'tel' => $request->get('tele'),
                                        'email' => $request->get('emaile'));
                        //$datoesc = $em->getRepository('AppBundle:Escuela')->find($request->get('establecimiento'));
                        //$escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                        return $this->render('AppBundle:Default:nuevoencargado1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario,));// 'escuela'=>$escuela, 'datoesc'=>$datoesc));
                    }elseif($request->get('tipovotante') == "Docente"){
                        $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'), 
                                        'tv' => $request->get('tipovotante'),
                                        'espacioc' => $request->get('espacioc'),
                                        'especialidad' => $request->get('especialidadd'),
                                        'tel' => $request->get('teldoc'), 
                                        'email' => $request->get('emaildoc'));
                        $datopres = $em->getRepository('AppBundle:Presentacion')->find($request->get('presentacion'));
                        $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                        return $this->render('AppBundle:Default:nuevodocente1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario, 'presentacion'=>$presentacion, 'datopres'=>$datopres));
                    }elseif($request->get('tipovotante') == "Estudiante"){
                        $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'), 
                                        'tv' => $request->get('tipovotante'),
                                        'aniocursado' => $request->get('aniocursa'),
                                        'especialidad' => $request->get('especialidada'),
                                        'nivel' => $request->get('nivel'));
                        $datotrab = $em->getRepository('AppBundle:Trabajo')->find($request->get('trabajo'));
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                        return $this->render('AppBundle:Default:nuevoestudiante1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario, 'trabajo'=>$trabajo, 'datotrab'=>$datotrab));
                    }else{
                        $datosusuario = array('dni' => $request->get('dni'),
                                        'nombre' => $request->get('nombre'),
                                        'apellido' => $request->get('apellido'), 
                                        'tv' => $request->get('tipovotante'),
                                        'cargo' => $request->get('cargocop'),
                                        'tel' => $request->get('telcop'), 
                                        'email' => $request->get('emailcop'));                        
                        return $this->render('AppBundle:Default:nuevocopetyp1.html.twig',
                        Array('msj'=>$msj, 'datosusuario'=>$datosusuario));
                    }

                }else{
                    $usuariodir = $em->getRepository('AppBundle:Directivo')->findOneByDni($_POST['dni']);
                    $usuarioenc = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['dni']);
                    $usuarioest = $em->getRepository('AppBundle:Estudiante')->findOneByDni($_POST['dni']);
                    $usuariodoc = $em->getRepository('AppBundle:Docente')->findOneByDni($_POST['dni']);
                    $usuariocop = $em->getRepository('AppBundle:Copetyp')->findOneByDni($_POST['dni']);
                    if(count($usuariodir) != 0 or count($usuarioenc) != 0 or count($usuarioest) != 0 or count($usuariodoc) != 0 or count($usuariocop) != 0 ){
                        $msj = "El dni que ingreso ya fue registrado, verifique antes de continuar con la carga.";
                        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                    }else{
                        if ($_POST['tipovotante'] == "Directivo"){
                            //$configuracion = new Configuracion();
                            //$configuracion->setCantcbsec(3);
                            //$configuracion->setCantcssec(3);
                            //$configuracion->setCantfp(0);
                            //$configuracion->setCantts(0);
                            //$configuracion->setCantexpped(0);
                            //$em->persist($configuracion);
                            //$em->flush();
                            //$id = $configuracion->getId();
                            $directivo = new Directivo();
                            $directivo->setDni($_POST['dni']);
                            $directivo->setNombre($_POST['nombre']);
                            $directivo->setApellido($_POST['apellido']);
                            $directivo->setTipovot($_POST['tipovotante']);
                            $directivo->setCargo($_POST['cargo']);
                            $directivo->setTeld($_POST['tel']);
                            $directivo->setEmaild($_POST['email']);
                            $directivo->setIdesc($_POST['establecimiento']);
                            //$directivo->setIdconf($id);
                            $em->persist($directivo);
                            $em->flush();
                            $msj = "Usuario cargado con exito.";              
                            return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));
                        }elseif ($_POST['tipovotante'] == "Encargado"){
                            //$directivo = $em->getRepository('AppBundle:Directivo')->findOneByIdesc($_POST['establecimiento']);
                            //$idconf = $directivo->getIdconf();
                            $encargado = new Encargado();
                            $encargado->setDni($_POST['dni']);
                            $encargado->setNombre($_POST['nombre']);
                            $encargado->setApellido($_POST['apellido']);
                            $encargado->setTipovot($_POST['tipovotante']);
                            $encargado->setMateriadic($_POST['materiadic']);
                            $encargado->setTele($_POST['tele']);
                            $encargado->setEmaile($_POST['emaile']);
                            //$encargado->setIdconf($idconf);
                            $encargado->SetCantexpped(2);
                            $em->persist($encargado);
                            $em->flush();
                            $msj = "Usuario cargado con exito.";              
                            return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));                                
                        }elseif ($_POST['tipovotante'] == "Docente"){
                            //$configuracion = new Configuracion();
                            //$configuracion->setCantcbsec(0);
                            ///$configuracion->setCantcssec(0);
                            //$configuracion->setCantfp(0);
                            //$configuracion->setCantts(0);
                            //$configuracion->setCantexpped(2);
                            //$em->persist($configuracion);
                            //$em->flush();                                       
                            //$presentacion = $em->getRepository('AppBundle:Presentacion')->find($_POST['presentacion']);
                            //$docente = new Docente();
                            //$docente->setDni($_POST['dni']);
                            //$docente->setNombre($_POST['nombre']);
                            //$docente->setApellido($_POST['apellido']);
                            //$docente->setTipovot($_POST['tipovotante']);
                            //$docente->setEspacioc($_POST['espacioc']);
                            //$docente->setEspecialidadd($_POST['especialidadd']);
                            //$docente->setEmaildoc($_POST['emaildoc']);
                            //$docente->setTeldoc($_POST['teldoc']);
                            //$docente->setPresentacion($presentacion);
                            //$docente->setConfiguracion($configuracion);
                            //$docente->setNiveldoc('expped');
                            //$docente->SetCantexpped(2);
                            //$em->persist($docente);
                            //$em->flush();
                            //$msj = "Usuario cargado con exito.";              
                            $msj = "funcionalidad en construcción";
                            return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));           
                        }elseif ($_POST['tipovotante'] == "Estudiante"){
                            //$configuracion = new Configuracion();
                            //$configuracion->setCantcbsec(3);
                            //$configuracion->setCantcssec(3);
                            //$configuracion->setCantfp(0);
                            //$configuracion->setCantts(0);
                            //$configuracion->setCantexpped(0);
                            //$em->persist($configuracion);
                            //$em->flush();
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
                            //$estudiante->setConfiguracion($configuracion);
                            $em->persist($estudiante);
                            $em->flush();
                            $msj = "Usuario cargado con exito.";              
                            return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));                  
                        }elseif ($_POST['tipovotante'] == "COPETyP"){
                            //$configuracion = new Configuracion();
                            //$configuracion->setCantcbsec(1);
                            //$configuracion->setCantcssec(1);
                            //$configuracion->setCantfp(0);
                            //$configuracion->setCantts(0);
                            //$configuracion->setCantexpped(0);
                            //$configuracion->setIsActive(1);
                            //$em->persist($configuracion);
                            //$em->flush();
                            //$copetyp = new Copetyp();
                            //$copetyp->setDni($_POST['dni']);
                            //$copetyp->setNombre($_POST['nombre']);
                            //$copetyp->setApellido($_POST['apellido']);
                            //$copetyp->setIsActive(1);
                            //$copetyp->setTipovot($_POST['tipovotante']);                
                            //$copetyp->setCargocop($_POST['cargocop']);
                            //$copetyp->setEmailcop($_POST['emailcop']);
                            //$copetyp->setTelcop($_POST['telcop']);
                            //$copetyp->setConfiguracion($configuracion);
                            //$em->persist($copetyp);
                            //$em->flush();        
                            //$msj = "Usuario cargado con exito."; 
                            $msj = "funcionalidad en construcción";             
                            return $this->render('AppBundle:Default:mensaje.html.twig', array('msj'=>$msj));     
                        }else{
                            $msj = "Ocurrio un problema debe seleccinar un tipo de usuario valido.";        
                            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));                
                        }
                    }
                }    

            }
            $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
            return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
        ///////////////////////////////////////////////////////////////////////////    
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
                    
                }elseif ($tv == "Docente"){
                    $docente = $em->getRepository('AppBundle:Docente')->findOneByDni($dni);
                    $idpres = $docente->getPresentacion()->getId();
                    $nombpres = $docente->getPresentacion()->getEsppresentacion();                
                    $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                    return $this->render('AppBundle:Default:editardocente.html.twig',
                    array('idpres'=>$idpres, 'nombpres'=>$nombpres, 
                    'docente'=>$docente, 'presentacion'=>$presentacion));
                
                }elseif ($tv == "Estudiante"){
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneByDni($dni);
                    $idtrab = $estudiante->getTrabajo()->getId();
                    $nombtrab = $estudiante->getTrabajo()->getNombproyecto();
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                    return $this->render('AppBundle:Default:editarestudiante.html.twig',
                    array('idtrab'=>$idtrab, 'nombtrab'=>$nombtrab, 
                    'estudiante'=>$estudiante, 'trabajos'=>$trabajo));
                    
                }elseif ($tv == "COPETyP"){
                    $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneByDni($dni);
                    return $this->render('AppBundle:Default:editarcopetyp.html.twig',
                    array('copetyp'=>$copetyp));                
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
            if ($tv == "Directivo"){
                $verificar = $em->getRepository('AppBundle:Directivo')->findOneByDni($_POST['dni']);
                if(count($verificar)!= 0 and $verificar->getDni() != $dni){
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
                    $directivo->setTeld($_POST['teld']);
                    $directivo->setEmaild($_POST['emaild']);
                    $directivo->setIdesc($establecimiento->getId());
                    $em->persist($directivo);
                    $em->flush();
                }
            }elseif ($tv == "Encargado"){
                $verificar = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['dni']);
                if(count($verificar)!= 0 and $verificar->getDni() != $dni){
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
                    $encargado->setTele($_POST['tele']);
                    $encargado->setEmaile($_POST['emaile']);
                    $em->persist($encargado);
                    $em->flush();                
                }
            }elseif ($tv == "Docente"){
                $verificar = $em->getRepository('AppBundle:Docente')->findOneByDni($_POST['dni']);
                if(count($verificar)!= 0 and $verificar->getDni() != $dni){
                    $msj = "El nuevo DNI que ingreso ya esta registrado, verifique los datos por favor.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }elseif(strlen($_POST['dni']) < 8){
                    $msj = "Debe ingresar un número de DNI valido.";
                    return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
                }else{                
                    $presentacion = $em->getRepository('AppBundle:Presentacion')->find($_POST['presentacion']);
                    $docente = $em->getRepository('AppBundle:Docente')->findOneByDni($dni);
                    $docente->setDni($_POST['dni']);
                    $docente->setNombre($_POST['nombre']);
                    $docente->setApellido($_POST['apellido']);
                    $docente->setEspacioc($_POST['espacioc']);
                    $docente->setEspecialidadd($_POST['especialidadd']);
                    $docente->setTeldoc($_POST['teldoc']);
                    $docente->setEmaildoc($_POST['emaildoc']);
                    $docente->setPresentacion($presentacion);
                    $em->persist($docente);
                    $em->flush();
                }                
            }elseif ($tv == "Estudiante"){
                $verificar = $em->getRepository('AppBundle:Estudiante')->findOneByDni($_POST['dni']);
                if(count($verificar)!= 0 and $verificar->getDni() != $dni){
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
            }elseif ($tv == "COPETyP"){
                $verificar = $em->getRepository('AppBundle:Copetyp')->findOneByDni($_POST['dni']);
                if(count($verificar)!= 0 and $verificar->getDni() != $dni){
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
                    $copetyp->setTelcop($_POST['telcop']);
                    $copetyp->setEmailcop($_POST['emailcop']);
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
            /////////////////////////////////////////////////////////////////////
            $em = $this->getDoctrine()->getManager();
            $jurisdiccion = $em->getRepository('AppBundle:Jurisdiccion')->findAll();
            return $this->render('AppBundle:Default:nuevaescuela.html.twig',array('jurisdiccion'=>$jurisdiccion));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $verifescuela = $em->getRepository('AppBundle:Escuela')->findOneByCue($request->get('cue'));
            if(count($verifescuela) == 0){
                $configuracion = new Configuracion();
                $configuracion->setTotalvotos(30);
                $em->persist($configuracion);
                $em->flush();                 
                $jurisdiccion = $em->getRepository('AppBundle:Jurisdiccion')->findAll();
                foreach ($jurisdiccion as $key ) {
                    $detalleconfig = new Detalleconfiguracion();
                    $detalleconfig->setConfiguracion($configuracion);
                    $detalleconfig->setJuris($key->getnomjuris());
                    $detalleconfig->setCantcbs(3);
                    $detalleconfig->setCantcss(3);
                    $em->persist($detalleconfig);
                    $em->flush();                    
                }
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
                $escuela->setConfiguracion($configuracion);                
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
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        if (!$escuela){
            $msj = "No existe Establecimientos cargados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Default:listarestablecimiento.html.twig',array('escuela'=>$escuela));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        if ($request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $verifescuela = $em->getRepository('AppBundle:Escuela')->findOneByCue($request->get('cue'));
            if(count($verifescuela) == 0 or $verifescuela->getId() == $id){
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->find($id);
                $escuela->setCue($_POST['cue']);
                $escuela->setNombesc($_POST['nombesc']);
                $escuela->setAmbitogestion($_POST['ambitogestion']);
                $escuela->setJurisdiccion($_POST['jurisdiccion']);
                $escuela->setDepartamento($_POST['detartamento']);
                $escuela->setLocalidad($_POST['localidad']);
                $escuela->setDomicilio($_POST['domicilio']);
                $escuela->setTelefono($_POST['telefono']);
                $escuela->setEmailesc($_POST['emailesc']);
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
            //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }         

    }    
    
////////////////////////////////////////////////////////////////////////////////////////////////////////    
    /**
     * @Route("/cargadatos/nuevotrabajo", name="NuevoTrabajo")
     */
    public function MostrarFormularioTrabAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $encargado = $em->getRepository('AppBundle:Encargado')->findAll();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        return $this->render('AppBundle:Trabajo:nuevotrabajo.html.twig',
        array('encargado'=>$encargado, 'escuela'=>$escuela));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findOneByDni($_POST['encargado']);
            $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);  
            $configuracion = new Configuracion();
            $configuracion->setTotalvotos(30);
            $em->persist($configuracion);
            $em->flush();                 
            $jurisdiccion = $em->getRepository('AppBundle:Jurisdiccion')->findAll();
            foreach ($jurisdiccion as $key ) {
                $detalleconfig = new Detalleconfiguracion();
                $detalleconfig->setConfiguracion($configuracion);
                $detalleconfig->setJuris($key->getnomjuris());
                $detalleconfig->setCantcbs(3);
                $detalleconfig->setCantcss(3);
                $em->persist($detalleconfig);
                $em->flush();                    
            } 
            $trabajo = new Trabajo();
            $trabajo->setNombproyecto($_POST['nombproyecto']);
            $trabajo->setDescproyecto($_POST['descproyecto']);
            $trabajo->setPavproyecto($_POST['pavproyecto']);
            $trabajo->setDpwproyecto($_POST['dpwproyecto']);
            $trabajo->setAemproyecto($_POST['aemproyecto']);
            $trabajo->setCantvoto(0);
            $trabajo->setStand($_POST['stand']);
            $trabajo->setEncargado($encargado);
            $trabajo->setEscuela($escuela);
            $trabajo->setNiveltrab($_POST['nivel']);
            $trabajo->setIsActive(1);
            $trabajo->setConfiguracion($configuracion);
            $em->persist($trabajo);
            $em->flush();            
            $msj = "Trabajo cargado con exito.";              
            return $this->render('AppBundle:Trabajo:mensajealtatrab.html.twig', array('msj'=>$msj));            

        }
        $msj = "Ocurrio un problema durante la carga intente nuevamente.";        
        return $this->render('AppBundle:Default:mensajeerro.html.twig',Array('msj'=>$msj));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
        if (!$trabajo){
            $msj = "No existen trabajos cargados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Trabajo:listartrabajo.html.twig',array('trabajo'=>$trabajo));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 0));
        if (!$trabajo){
            $msj = "No existen trabajos desactivados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Trabajo:listartrabajodesactivados.html.twig',array('trabajo'=>$trabajo));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
        if (!$trabajo){
            $msj = "No existen trabajos desactivados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Trabajo:listartrabajosactivos.html.twig',array('trabajo'=>$trabajo));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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

            //////////////////////////////////////////////////////////////////////
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
    
////////////////////////////////////////////////////////////////////////////////////////////////////////    
    /**
     * @Route("/cargadatos/nuevapresentacion", name="NuevaPresentacion")
     */
    public function MostrarFormularioPresAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
        return $this->render('AppBundle:Presentacion:nuevapresentacion.html.twig',
        array('escuela'=>$escuela));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
        $em = $this->getDoctrine()->getManager();
        $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
        if (!$presentacion){
            $msj = "No existen Presentaciones cargados.";              
            return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                    
        }        
        return $this->render('AppBundle:Presentacion:listarpresentacion.html.twig',array('presentacion'=>$presentacion));
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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
            //////////////////////////////////////////////////////////////////////
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
            /////////////////////////////////////////////////////////////////////
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
            //////////////////////////////////////////////////////////////////////
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
        
    }
    
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
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findAll();
                    return $this->render('AppBundle:Acreditacion:acreditar.html.twig', 
                    array("escuela"=>$escuela, "trabajo"=>$trabajo, "directivo"=>$directivo, "estudiante"=>$estudiante));
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
                        $escuela->getConfiguracion()->setIsActive(1);
                        $em->persist($escuela);
                        $em->flush();                                        
                    }elseif ($tipousuario == 'en'){
                        $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni' => $dni));
                        $encargado->setIsActive(1);
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
                
            //die();
            }else{
                $msj = "Ocurrio un problema y el proceso de acreditación no finalizó con exito.";              
                return $this->render('AppBundle:Acreditacion:msjacreditarerro.html.twig', array('msj'=>$msj));                
            }
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
