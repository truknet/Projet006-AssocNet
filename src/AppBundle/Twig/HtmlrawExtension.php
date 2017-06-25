<?php

namespace AppBundle\Twig;

class HtmlrawExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('html', [$this, 'html'], ['is_safe' => ['html']]),
        ];
    }

    public function html($html)
    {
        $ban = array("<script>", "</script>", "<?php", "php", "iframe", "javascript", "onload", "xml");
        $html = str_replace($ban, "", $html);
        return $html;
    }

    public function getName()
    {
        return 'app_extension';
    }
}

