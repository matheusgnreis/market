<?php
namespace Market\Services;

class CMS
{
    protected $pathConfig = '/assets/cms/cms.json';
    protected $cmsConfig = [];
    protected $pagesContent = [];

    public function __construct(array $options)
    {
        $rootPath = dirname(__DIR__, 3);
        $this->pathConfig = $rootPath . $this->pathConfig;
    }

    public function parseConfig(array $config = [])
    {
        $json = file_get_contents($this->pathConfig);
        $this->pagesContent = json_decode($json, true);
    }

    public function getPageContent(String $page, String $content = null, String $element = null)
    {
        $contentPage;

        if (!$this->pagesContent) {
            $this->parseConfig();
        }

        if ($page) {
            $contentPage = $this->pagesContent[$page]['contents'];
        }

        if ($content) {
            $contentPage = $contentPage[$content];
        }

        if ($element) {
            $contentPage = $contentPage[$element];
        }
        return $contentPage;
    }

}