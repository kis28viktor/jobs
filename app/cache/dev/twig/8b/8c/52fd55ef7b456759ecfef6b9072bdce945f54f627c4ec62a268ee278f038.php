<?php

/* WorkBundle:Default:index.html.twig */
class __TwigTemplate_8b8c52fd55ef7b456759ecfef6b9072bdce945f54f627c4ec62a268ee278f038 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("@Work/layout.html.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Work/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_header($context, array $blocks = array())
    {
        // line 3
        echo "
";
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo "
    <div class=\"body\">
        <div>
            <a href=\"";
        // line 9
        echo $this->env->getExtension('routing')->getPath("find_work");
        echo "\">
                Хочеш найти роботу?
            </a>
            <br>
            <a href=\"";
        // line 13
        echo $this->env->getExtension('routing')->getPath("post_worker");
        echo "\">
                Хочеш залишити своє резюме?
            </a>
        </div>
        <div>
            <a href=\" ";
        // line 18
        echo $this->env->getExtension('routing')->getPath("find_hire");
        echo "\">
                Хочеш найти працівника?
            </a>
            <br>
            <a href=\" ";
        // line 22
        echo $this->env->getExtension('routing')->getPath("post_hire");
        echo "\">
                Хочеш залишити вакансію?
            </a>
        </div>
    </div>
    <div class=\"footer\" style=\"margin-top: 100%;text-align: center;\">
        All rights reserved @2015
    </div>
";
    }

    public function getTemplateName()
    {
        return "WorkBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 22,  68 => 18,  60 => 13,  53 => 9,  48 => 6,  45 => 5,  40 => 3,  37 => 2,  11 => 1,);
    }
}
