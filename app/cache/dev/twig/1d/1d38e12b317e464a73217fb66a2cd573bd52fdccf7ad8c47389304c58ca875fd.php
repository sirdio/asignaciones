<?php

/* AppBundle:Default:inicio.html.twig */
class __TwigTemplate_00224bddb372e2dda8a53f7d737a3d36adcb564780f37815d075d2f5d4f6510f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "AppBundle:Default:inicio.html.twig", 1);
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
        $__internal_e13b587743db98e11c550495d545d367c2bdcc6ee19c7471108e603115778a97 = $this->env->getExtension("native_profiler");
        $__internal_e13b587743db98e11c550495d545d367c2bdcc6ee19c7471108e603115778a97->enter($__internal_e13b587743db98e11c550495d545d367c2bdcc6ee19c7471108e603115778a97_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Default:inicio.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_e13b587743db98e11c550495d545d367c2bdcc6ee19c7471108e603115778a97->leave($__internal_e13b587743db98e11c550495d545d367c2bdcc6ee19c7471108e603115778a97_prof);

    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        $__internal_8c53edf5e93791db24f9d7ad55cc69c8508f9aa797f7e671072ab84c8a226f10 = $this->env->getExtension("native_profiler");
        $__internal_8c53edf5e93791db24f9d7ad55cc69c8508f9aa797f7e671072ab84c8a226f10->enter($__internal_8c53edf5e93791db24f9d7ad55cc69c8508f9aa797f7e671072ab84c8a226f10_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenido a TECNICAMENTE 2016!!!";
        
        $__internal_8c53edf5e93791db24f9d7ad55cc69c8508f9aa797f7e671072ab84c8a226f10->leave($__internal_8c53edf5e93791db24f9d7ad55cc69c8508f9aa797f7e671072ab84c8a226f10_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_3560f70a85dc55a8bffd0ce37227c4c8da89fee61307a0394206f848dc99bcbb = $this->env->getExtension("native_profiler");
        $__internal_3560f70a85dc55a8bffd0ce37227c4c8da89fee61307a0394206f848dc99bcbb->enter($__internal_3560f70a85dc55a8bffd0ce37227c4c8da89fee61307a0394206f848dc99bcbb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

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
          </div> 
          <div class=\"col-md-4\">
          </div>
    </div>
</div> 



<footer>
   <p>T&eacutecnicamente 2016 - Sistema de Votaci&oacuten - Creado por <a href=\"https://github.com/dsyph3r\">Navarro Sergio Antonio</a>
        &copy; ";
        // line 21
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</p>
</footer>
";
        
        $__internal_3560f70a85dc55a8bffd0ce37227c4c8da89fee61307a0394206f848dc99bcbb->leave($__internal_3560f70a85dc55a8bffd0ce37227c4c8da89fee61307a0394206f848dc99bcbb_prof);

    }

    public function getTemplateName()
    {
        return "AppBundle:Default:inicio.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 21,  56 => 5,  53 => 4,  47 => 3,  35 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block title %}Bienvenido a TECNICAMENTE 2016!!!{% endblock %}*/
/* {% block body %}*/
/* */
/*     {{parent()}}*/
/* <div class="container">*/
/*      <div class="row">*/
/*           <div class="col-md-4">*/
/*           </div>*/
/*           <div class="col-md-4">*/
/*           </div> */
/*           <div class="col-md-4">*/
/*           </div>*/
/*     </div>*/
/* </div> */
/* */
/* */
/* */
/* <footer>*/
/*    <p>T&eacutecnicamente 2016 - Sistema de Votaci&oacuten - Creado por <a href="https://github.com/dsyph3r">Navarro Sergio Antonio</a>*/
/*         &copy; {{ 'now' | date('Y') }}</p>*/
/* </footer>*/
/* {% endblock %}*/
