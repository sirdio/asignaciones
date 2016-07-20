<?php

/* AppBundle:Default:nuevousuario.html.twig */
class __TwigTemplate_46009e38bfc97ee28669a24c9c676d42fe5fdd04a63f95cf71336cec05009eb1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "AppBundle:Default:nuevousuario.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_e06f435d31f945cd96aa7a6ab6aa565221abd43176d1f6705234349d068039c9 = $this->env->getExtension("native_profiler");
        $__internal_e06f435d31f945cd96aa7a6ab6aa565221abd43176d1f6705234349d068039c9->enter($__internal_e06f435d31f945cd96aa7a6ab6aa565221abd43176d1f6705234349d068039c9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Default:nuevousuario.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_e06f435d31f945cd96aa7a6ab6aa565221abd43176d1f6705234349d068039c9->leave($__internal_e06f435d31f945cd96aa7a6ab6aa565221abd43176d1f6705234349d068039c9_prof);

    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        $__internal_25987fa93871c081a9a32ac33ebe9ae4d099593433f5e19f1e854d150408b7b4 = $this->env->getExtension("native_profiler");
        $__internal_25987fa93871c081a9a32ac33ebe9ae4d099593433f5e19f1e854d150408b7b4->enter($__internal_25987fa93871c081a9a32ac33ebe9ae4d099593433f5e19f1e854d150408b7b4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Agregar Usuario";
        
        $__internal_25987fa93871c081a9a32ac33ebe9ae4d099593433f5e19f1e854d150408b7b4->leave($__internal_25987fa93871c081a9a32ac33ebe9ae4d099593433f5e19f1e854d150408b7b4_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_810a7364cb26a35e40529bc48a7e8282147462b682496ebf848924b3129d58db = $this->env->getExtension("native_profiler");
        $__internal_810a7364cb26a35e40529bc48a7e8282147462b682496ebf848924b3129d58db->enter($__internal_810a7364cb26a35e40529bc48a7e8282147462b682496ebf848924b3129d58db_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
<nav class=\"navbar navbar-default\">
  <div class=\"container-fluid\">
      <ul class=\"nav navbar-nav\">
        <li class=\"active\"><a href=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("Inicio");
        echo "\">Volver <span class=\"sr-only\">(current)</span></a></li>
      </ul>
  </div><!-- /.container-fluid -->
</nav>
<div class=\"container\">
     <div class=\"row\">
          <div class=\"col-md-4\">
          </div>
          <div class=\"col-md-4\">
               <form action=\"";
        // line 17
        echo $this->env->getExtension('routing')->getPath("Inicio");
        echo "\" method=\"post\" class=\"form-horizontal\">
                     <fieldset>
                         <legend>Iniciar Carga de Datos</legend>
                         <div class=\"control-group\">
                            <div class=\"controls\">
                               <select id=\"selectbasic\" name=\"selectbasic\" class=\"input-xlarge\">
                                  <option>Seleccionar Opci&oacuten</option>
                                  <option>Directivo</option>
                                  <option>Encargado</option>
                                  <option>Docente</option>
                                  <option>Estudiante</option>
                                  <option>COPETyP</option>
                                </select>
                             </div>
                         </div>
                         <div class=\"control-group\">
                           <div class=\"controls\">
                              <button id=\"singlebutton\" name=\"singlebutton\" class=\"btn btn-primary\">Iniciar</button>
                           </div>
                         </div>
                     </fieldset>
               </form>
          </div> 
          <div class=\"col-md-4\">
          </div>
    </div>
</div> 

";
        
        $__internal_810a7364cb26a35e40529bc48a7e8282147462b682496ebf848924b3129d58db->leave($__internal_810a7364cb26a35e40529bc48a7e8282147462b682496ebf848924b3129d58db_prof);

    }

    public function getTemplateName()
    {
        return "AppBundle:Default:nuevousuario.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 17,  59 => 8,  53 => 4,  47 => 3,  35 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block title %}Agregar Usuario{% endblock %}*/
/* {% block body %}*/
/* */
/* <nav class="navbar navbar-default">*/
/*   <div class="container-fluid">*/
/*       <ul class="nav navbar-nav">*/
/*         <li class="active"><a href="{{path('Inicio')}}">Volver <span class="sr-only">(current)</span></a></li>*/
/*       </ul>*/
/*   </div><!-- /.container-fluid -->*/
/* </nav>*/
/* <div class="container">*/
/*      <div class="row">*/
/*           <div class="col-md-4">*/
/*           </div>*/
/*           <div class="col-md-4">*/
/*                <form action="{{ path('Inicio') }}" method="post" class="form-horizontal">*/
/*                      <fieldset>*/
/*                          <legend>Iniciar Carga de Datos</legend>*/
/*                          <div class="control-group">*/
/*                             <div class="controls">*/
/*                                <select id="selectbasic" name="selectbasic" class="input-xlarge">*/
/*                                   <option>Seleccionar Opci&oacuten</option>*/
/*                                   <option>Directivo</option>*/
/*                                   <option>Encargado</option>*/
/*                                   <option>Docente</option>*/
/*                                   <option>Estudiante</option>*/
/*                                   <option>COPETyP</option>*/
/*                                 </select>*/
/*                              </div>*/
/*                          </div>*/
/*                          <div class="control-group">*/
/*                            <div class="controls">*/
/*                               <button id="singlebutton" name="singlebutton" class="btn btn-primary">Iniciar</button>*/
/*                            </div>*/
/*                          </div>*/
/*                      </fieldset>*/
/*                </form>*/
/*           </div> */
/*           <div class="col-md-4">*/
/*           </div>*/
/*     </div>*/
/* </div> */
/* */
/* {% endblock %}*/
