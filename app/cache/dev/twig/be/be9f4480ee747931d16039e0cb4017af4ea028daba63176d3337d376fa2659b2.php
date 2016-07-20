<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_f219883a74433165ba781ad6d60d9f4c3b5230b2aef6c9f232d86b187de0b416 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_6d7626e6fe158def8dc9c11b44a4d2e74d749df1c57174df51c058b265c69928 = $this->env->getExtension("native_profiler");
        $__internal_6d7626e6fe158def8dc9c11b44a4d2e74d749df1c57174df51c058b265c69928->enter($__internal_6d7626e6fe158def8dc9c11b44a4d2e74d749df1c57174df51c058b265c69928_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_6d7626e6fe158def8dc9c11b44a4d2e74d749df1c57174df51c058b265c69928->leave($__internal_6d7626e6fe158def8dc9c11b44a4d2e74d749df1c57174df51c058b265c69928_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_32685cb0f9179f98d4e208defc24005ecec9e599bc9dfe71bb909bcd1e3895ca = $this->env->getExtension("native_profiler");
        $__internal_32685cb0f9179f98d4e208defc24005ecec9e599bc9dfe71bb909bcd1e3895ca->enter($__internal_32685cb0f9179f98d4e208defc24005ecec9e599bc9dfe71bb909bcd1e3895ca_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_32685cb0f9179f98d4e208defc24005ecec9e599bc9dfe71bb909bcd1e3895ca->leave($__internal_32685cb0f9179f98d4e208defc24005ecec9e599bc9dfe71bb909bcd1e3895ca_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_45ffd6c746ad710b1371fb7bbf19c1fac6bd3b89cef73ba1554d97421ffbe6a2 = $this->env->getExtension("native_profiler");
        $__internal_45ffd6c746ad710b1371fb7bbf19c1fac6bd3b89cef73ba1554d97421ffbe6a2->enter($__internal_45ffd6c746ad710b1371fb7bbf19c1fac6bd3b89cef73ba1554d97421ffbe6a2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_45ffd6c746ad710b1371fb7bbf19c1fac6bd3b89cef73ba1554d97421ffbe6a2->leave($__internal_45ffd6c746ad710b1371fb7bbf19c1fac6bd3b89cef73ba1554d97421ffbe6a2_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_5f0cb6cb624e5c83c77eb516b790bcf00f7d688d15263aa90f9e87d04f0b49b5 = $this->env->getExtension("native_profiler");
        $__internal_5f0cb6cb624e5c83c77eb516b790bcf00f7d688d15263aa90f9e87d04f0b49b5->enter($__internal_5f0cb6cb624e5c83c77eb516b790bcf00f7d688d15263aa90f9e87d04f0b49b5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_5f0cb6cb624e5c83c77eb516b790bcf00f7d688d15263aa90f9e87d04f0b49b5->leave($__internal_5f0cb6cb624e5c83c77eb516b790bcf00f7d688d15263aa90f9e87d04f0b49b5_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
