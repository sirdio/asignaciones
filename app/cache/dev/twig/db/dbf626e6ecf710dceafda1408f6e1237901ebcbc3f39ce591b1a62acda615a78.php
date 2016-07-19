<?php

/* ::base.html.twig */
class __TwigTemplate_65f1d69c8d9c9c71a02e4fd4b2ddafbac6b5998617d1d07c33960aef2cd57e0e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_49f8989e75d8e67a71f983623f3bdadd24973a70df5290fc4098f890705da4f0 = $this->env->getExtension("native_profiler");
        $__internal_49f8989e75d8e67a71f983623f3bdadd24973a70df5290fc4098f890705da4f0->enter($__internal_49f8989e75d8e67a71f983623f3bdadd24973a70df5290fc4098f890705da4f0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 8
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 13
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
      
    </head>
    <body>
        ";
        // line 17
        $this->displayBlock('body', $context, $blocks);
        // line 20
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 25
        echo "    </body>
</html>
\t";
        
        $__internal_49f8989e75d8e67a71f983623f3bdadd24973a70df5290fc4098f890705da4f0->leave($__internal_49f8989e75d8e67a71f983623f3bdadd24973a70df5290fc4098f890705da4f0_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_41a736f3c86e22584340fb2aacaa9015670052c7488fd2391b551a39f898a45a = $this->env->getExtension("native_profiler");
        $__internal_41a736f3c86e22584340fb2aacaa9015670052c7488fd2391b551a39f898a45a->enter($__internal_41a736f3c86e22584340fb2aacaa9015670052c7488fd2391b551a39f898a45a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenidos!!!";
        
        $__internal_41a736f3c86e22584340fb2aacaa9015670052c7488fd2391b551a39f898a45a->leave($__internal_41a736f3c86e22584340fb2aacaa9015670052c7488fd2391b551a39f898a45a_prof);

    }

    // line 8
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_e7953b02a436a31c8d17b90a83745d8e5017de8d915e714cf408a1d3bc102cb5 = $this->env->getExtension("native_profiler");
        $__internal_e7953b02a436a31c8d17b90a83745d8e5017de8d915e714cf408a1d3bc102cb5->enter($__internal_e7953b02a436a31c8d17b90a83745d8e5017de8d915e714cf408a1d3bc102cb5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 9
        echo "        <!-- Latest compiled and minified CSS -->
             <link href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/css/bootstrap.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
             <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/css/bootstrap.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        ";
        
        $__internal_e7953b02a436a31c8d17b90a83745d8e5017de8d915e714cf408a1d3bc102cb5->leave($__internal_e7953b02a436a31c8d17b90a83745d8e5017de8d915e714cf408a1d3bc102cb5_prof);

    }

    // line 17
    public function block_body($context, array $blocks = array())
    {
        $__internal_10bb3a19ab49cb2989cb434dda449b79d9bfe9ea1c32fe596e348c40218a853b = $this->env->getExtension("native_profiler");
        $__internal_10bb3a19ab49cb2989cb434dda449b79d9bfe9ea1c32fe596e348c40218a853b->enter($__internal_10bb3a19ab49cb2989cb434dda449b79d9bfe9ea1c32fe596e348c40218a853b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 18
        echo "        ";
        echo twig_include($this->env, $context, "menu.html.twig");
        echo "
        ";
        
        $__internal_10bb3a19ab49cb2989cb434dda449b79d9bfe9ea1c32fe596e348c40218a853b->leave($__internal_10bb3a19ab49cb2989cb434dda449b79d9bfe9ea1c32fe596e348c40218a853b_prof);

    }

    // line 20
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_35f89e422b1e978d97f44cfb3c64cac7154a69a43a9e0a54906d2b4d8061ca74 = $this->env->getExtension("native_profiler");
        $__internal_35f89e422b1e978d97f44cfb3c64cac7154a69a43a9e0a54906d2b4d8061ca74->enter($__internal_35f89e422b1e978d97f44cfb3c64cac7154a69a43a9e0a54906d2b4d8061ca74_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 21
        echo "           <!-- Latest compiled and minified JavaScript -->
           <script src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/js/jquery-3.1.0.min.js"), "html", null, true);
        echo "\"></script>
           <script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>  
        ";
        
        $__internal_35f89e422b1e978d97f44cfb3c64cac7154a69a43a9e0a54906d2b4d8061ca74->leave($__internal_35f89e422b1e978d97f44cfb3c64cac7154a69a43a9e0a54906d2b4d8061ca74_prof);

    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  125 => 23,  121 => 22,  118 => 21,  112 => 20,  102 => 18,  96 => 17,  87 => 11,  83 => 10,  80 => 9,  74 => 8,  62 => 7,  53 => 25,  50 => 20,  48 => 17,  40 => 13,  38 => 8,  34 => 7,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <meta http-equiv="X-UA-Compatible" content="IE=edge">*/
/*         <meta name="viewport" content="width=device-width, initial-scale=1">*/
/*         <title>{% block title %}Bienvenidos!!!{% endblock %}</title>*/
/*         {% block stylesheets %}*/
/*         <!-- Latest compiled and minified CSS -->*/
/*              <link href="{{ asset('public/css/bootstrap.css') }}" type="text/css" rel="stylesheet" />*/
/*              <link href="{{ asset('public/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />*/
/*         {% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*       */
/*     </head>*/
/*     <body>*/
/*         {% block body %}*/
/*         {{include('menu.html.twig')}}*/
/*         {% endblock %}*/
/*         {% block javascripts %}*/
/*            <!-- Latest compiled and minified JavaScript -->*/
/*            <script src="{{ asset('public/js/jquery-3.1.0.min.js') }}"></script>*/
/*            <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>  */
/*         {% endblock %}*/
/*     </body>*/
/* </html>*/
/* 	*/
