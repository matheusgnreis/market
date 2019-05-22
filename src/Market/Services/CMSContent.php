<?php
namespace Market\Services;
use Market\Services\CMS;
class CMSContent extends \Slim\Views\TwigExtension
{
    public function __construct()
    {

    }

    public function getName()
    {
        return 'getPageContent';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getPageContent', array($this, 'cmsPageContents')),
        ];
    }

    public function cmsPageContents($page, $content, $element)
    {
        $t = new CMS([]);
        echo $t->getPageContent($page, $content, $element);
    }
}
