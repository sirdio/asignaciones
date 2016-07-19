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
        $__internal_5521c979867f265301970db4ef721d132bc4797d25810a91bdc8fbc0f1a987a6 = $this->env->getExtension("native_profiler");
        $__internal_5521c979867f265301970db4ef721d132bc4797d25810a91bdc8fbc0f1a987a6->enter($__internal_5521c979867f265301970db4ef721d132bc4797d25810a91bdc8fbc0f1a987a6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Default:selectipouduario.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5521c979867f265301970db4ef721d132bc4797d25810a91bdc8fbc0f1a987a6->leave($__internal_5521c979867f265301970db4ef721d132bc4797d25810a91bdc8fbc0f1a987a6_prof);

    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        $__internal_21a1ef1da248d5175cd9567c1c27a731ffd6cb69bc9615856732deeada17a669 = $this->env->getExtension("native_profiler");
        $__internal_21a1ef1da248d5175cd9567c1c27a731ffd6cb69bc9615856732deeada17a669->enter($__internal_21a1ef1da248d5175cd9567c1c27a731ffd6cb69bc9615856732deeada17a669_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenido a TECNICAMENTE 2016!!!";
        
        $__internal_21a1ef1da248d5175cd9567c1c27a731ffd6cb69bc9615856732deeada17a669->leave($__internal_21a1ef1da248d5175cd9567c1c27a731ffd6cb69bc9615856732deeada17a669_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_41c34297a436e3e9cb17e853428d9180377ece2f9e96ebfd2648b7010c9efbde = $this->env->getExtension("native_profiler");
        $__internal_41c34297a436e3e9cb17e853428d9180377ece2f9e96ebfd2648b7010c9efbde->enter($__internal_41c34297a436e3e9cb17e853428d9180377ece2f9e96ebfd2648b7010c9efbde_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
    ";
        // line 5
        $this->displayParentBlock("body", $context, $blocks);
        echo "
<div class=\"container\">
  <div class=\"row\">
    <div class=\"col-md-4\">
    </div>
    <div class=\"col-md-4\">
      <form action=\"";
        // line 11
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
        // line 43
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</p>
</footer>
";
        // line 45
        $this->displayBlock('javascripts', $context, $blocks);
        
        $__internal_41c34297a436e3e9cb17e853428d9180377ece2f9e96ebfd2648b7010c9efbde->leave($__internal_41c34297a436e3e9cb17e853428d9180377ece2f9e96ebfd2648b7010c9efbde_prof);

    }

    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_2f5532ddb6318e959dbc7480827ddbd6eccbda47df95152f8c8bd97d1f5a5e09 = $this->env->getExtension("native_profiler");
        $__internal_2f5532ddb6318e959dbc7480827ddbd6eccbda47df95152f8c8bd97d1f5a5e09->enter($__internal_2f5532ddb6318e959dbc7480827ddbd6eccbda47df95152f8c8bd97d1f5a5e09_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 46
        echo "
<script>

\$(document).ready(function(){
    \$('#singlebutton').on('click', function(e){
      e.preventDefault();        
      alert(\"hola\");
    //    link  = \$(this).attr('value');      
    //    if (tipouser == \"Empleado\") {
    //        var url = \"";
        // line 55
        echo "\";  
    //    }else{
    //        var url = \"";
        // line 57
        echo "\";  
    //    }                
    //    url = url.replace(\"fId\",link);         
    //    location.href = url;
   });
});
</script>
  
";
        
        $__internal_2f5532ddb6318e959dbc7480827ddbd6eccbda47df95152f8c8bd97d1f5a5e09->leave($__internal_2f5532ddb6318e959dbc7480827ddbd6eccbda47df95152f8c8bd97d1f5a5e09_prof);

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
        return array (  132 => 57,  128 => 55,  117 => 46,  105 => 45,  100 => 43,  66 => 11,  57 => 5,  54 => 4,  48 => 3,  36 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block title %}Bienvenido a TECNICAMENTE 2016!!!{% endblock %}*/
/* {% block body %}*/
/* */
/*     {{parent()}}*/
/* <div class="container">*/
/*   <div class="row">*/
/*     <div class="col-md-4">*/
/*     </div>*/
/*     <div class="col-md-4">*/
/*       <form action="{#{ path('NuevoUsuario') }#}" method="post" class="form-horizontal">*/
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
/* $(document).ready(function(){*/
/*     $('#singlebutton').on('click', function(e){*/
/*       e.preventDefault();        */
/*       alert("hola");*/
/*     //    link  = $(this).attr('value');      */
/*     //    if (tipouser == "Empleado") {*/
/*     //        var url = "{#{path('pedido_buscararcdesemp',{'fId':'fId'})}#}";  */
/*     //    }else{*/
/*     //        var url = "{#{path('pedido_buscararcdes',{'fId':'fId'})}#}";  */
/*     //    }                */
/*     //    url = url.replace("fId",link);         */
/*     //    location.href = url;*/
/*    });*/
/* });*/
/* </script>*/
/*   */
/* {% endblock %}*/
/* {% endblock %}*/
