<?php

/* AppBundle:Default:selectipouduario.html.twig */
class __TwigTemplate_5d9c208e9a635af3ca1903e1238f418afb361b7aef51525ec379ec72c41cc1cc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "AppBundle:Default:selectipouduario.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_7b412af2936b06dcfb019cae5d947120b432fc9394656ab2f67c94ffcf7d7fed = $this->env->getExtension("native_profiler");
        $__internal_7b412af2936b06dcfb019cae5d947120b432fc9394656ab2f67c94ffcf7d7fed->enter($__internal_7b412af2936b06dcfb019cae5d947120b432fc9394656ab2f67c94ffcf7d7fed_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Default:selectipouduario.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_7b412af2936b06dcfb019cae5d947120b432fc9394656ab2f67c94ffcf7d7fed->leave($__internal_7b412af2936b06dcfb019cae5d947120b432fc9394656ab2f67c94ffcf7d7fed_prof);

    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        $__internal_63c5433971a3898a70804019949aaf4419978a1bb8a74fc7e5d5a25b0fd01c04 = $this->env->getExtension("native_profiler");
        $__internal_63c5433971a3898a70804019949aaf4419978a1bb8a74fc7e5d5a25b0fd01c04->enter($__internal_63c5433971a3898a70804019949aaf4419978a1bb8a74fc7e5d5a25b0fd01c04_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenido a TECNICAMENTE 2016!!!";
        
        $__internal_63c5433971a3898a70804019949aaf4419978a1bb8a74fc7e5d5a25b0fd01c04->leave($__internal_63c5433971a3898a70804019949aaf4419978a1bb8a74fc7e5d5a25b0fd01c04_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_f26a0b8f7fe957fe7924a3eb73d878ece4326498e19a6cae71c32c5ce54b8ba2 = $this->env->getExtension("native_profiler");
        $__internal_f26a0b8f7fe957fe7924a3eb73d878ece4326498e19a6cae71c32c5ce54b8ba2->enter($__internal_f26a0b8f7fe957fe7924a3eb73d878ece4326498e19a6cae71c32c5ce54b8ba2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

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
        echo $this->env->getExtension('routing')->getPath("NuevoUsuario");
        echo "\" method=\"post\" class=\"form-horizontal\">
        <fieldset>
\t  <legend>Iniciar Carga de Datos</legend>
\t    <div class=\"control-group\">
\t      <div class=\"controls\">
\t\t<select id=\"selectbasic\" name=\"selectbasic\" class=\"input-xlarge\">
\t\t  <option>Seleccionar Opci&oacuten</option>
\t\t  <option>Directivo</option>
                  <option>Encargado</option>
\t\t  <option>Docente</option>
\t\t  <option>Estudiante</option>
\t\t  <option>COPETyP</option>
\t        </select>
\t      </div>
\t    </div>
\t    <div class=\"control-group\">
\t      <div class=\"controls\">
\t        <button id=\"singlebutton\" name=\"singlebutton\" class=\"btn btn-primary\">Iniciar</button>
\t      </div>
\t    </div>
         </fieldset>
       </form>
     </div> 
     <div class=\"col-md-4\">
     </div>
  </div>
</div> 



<footer>
   <p>T&eacutecnicamente 2016 - Sistema de Votaci&oacuten - Creado por <a href=\"https://github.com/dsyph3r\">Navarro Sergio Antonio</a>
        &copy; ";
        // line 49
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</p>
</footer>
";
        // line 51
        $this->displayBlock('javascripts', $context, $blocks);
        
        $__internal_f26a0b8f7fe957fe7924a3eb73d878ece4326498e19a6cae71c32c5ce54b8ba2->leave($__internal_f26a0b8f7fe957fe7924a3eb73d878ece4326498e19a6cae71c32c5ce54b8ba2_prof);

    }

    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_cbd5c7b279c16f52df1ad2c4b5e2931507f053e67742ae93a473c3f4aac6e56a = $this->env->getExtension("native_profiler");
        $__internal_cbd5c7b279c16f52df1ad2c4b5e2931507f053e67742ae93a473c3f4aac6e56a->enter($__internal_cbd5c7b279c16f52df1ad2c4b5e2931507f053e67742ae93a473c3f4aac6e56a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 52
        echo "
<script>

//\$(document).ready(function(){
//    \$('#singlebutton').on('click', function(e){
//      e.preventDefault();        
//      alert(\"hola\");
    //    link  = \$(this).attr('value');      
    //    if (tipouser == \"Empleado\") {
    //        var url = \"";
        // line 61
        echo "\";  
    //    }else{
    //        var url = \"";
        // line 63
        echo "\";  
    //    }                
    //    url = url.replace(\"fId\",link);         
    //    location.href = url;
//   });
//});
</script>
  
";
        
        $__internal_cbd5c7b279c16f52df1ad2c4b5e2931507f053e67742ae93a473c3f4aac6e56a->leave($__internal_cbd5c7b279c16f52df1ad2c4b5e2931507f053e67742ae93a473c3f4aac6e56a_prof);

    }

    public function getTemplateName()
    {
        return "AppBundle:Default:selectipouduario.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  139 => 63,  135 => 61,  124 => 52,  112 => 51,  107 => 49,  72 => 17,  60 => 8,  54 => 4,  48 => 3,  36 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block title %}Bienvenido a TECNICAMENTE 2016!!!{% endblock %}*/
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
/*   <div class="row">*/
/*     <div class="col-md-4">*/
/*     </div>*/
/*     <div class="col-md-4">*/
/*       <form action="{{ path('NuevoUsuario') }}" method="post" class="form-horizontal">*/
/*         <fieldset>*/
/* 	  <legend>Iniciar Carga de Datos</legend>*/
/* 	    <div class="control-group">*/
/* 	      <div class="controls">*/
/* 		<select id="selectbasic" name="selectbasic" class="input-xlarge">*/
/* 		  <option>Seleccionar Opci&oacuten</option>*/
/* 		  <option>Directivo</option>*/
/*                   <option>Encargado</option>*/
/* 		  <option>Docente</option>*/
/* 		  <option>Estudiante</option>*/
/* 		  <option>COPETyP</option>*/
/* 	        </select>*/
/* 	      </div>*/
/* 	    </div>*/
/* 	    <div class="control-group">*/
/* 	      <div class="controls">*/
/* 	        <button id="singlebutton" name="singlebutton" class="btn btn-primary">Iniciar</button>*/
/* 	      </div>*/
/* 	    </div>*/
/*          </fieldset>*/
/*        </form>*/
/*      </div> */
/*      <div class="col-md-4">*/
/*      </div>*/
/*   </div>*/
/* </div> */
/* */
/* */
/* */
/* <footer>*/
/*    <p>T&eacutecnicamente 2016 - Sistema de Votaci&oacuten - Creado por <a href="https://github.com/dsyph3r">Navarro Sergio Antonio</a>*/
/*         &copy; {{ 'now' | date('Y') }}</p>*/
/* </footer>*/
/* {% block javascripts %}*/
/* */
/* <script>*/
/* */
/* //$(document).ready(function(){*/
/* //    $('#singlebutton').on('click', function(e){*/
/* //      e.preventDefault();        */
/* //      alert("hola");*/
/*     //    link  = $(this).attr('value');      */
/*     //    if (tipouser == "Empleado") {*/
/*     //        var url = "{#{path('pedido_buscararcdesemp',{'fId':'fId'})}#}";  */
/*     //    }else{*/
/*     //        var url = "{#{path('pedido_buscararcdes',{'fId':'fId'})}#}";  */
/*     //    }                */
/*     //    url = url.replace("fId",link);         */
/*     //    location.href = url;*/
/* //   });*/
/* //});*/
/* </script>*/
/*   */
/* {% endblock %}*/
/* {% endblock %}*/
