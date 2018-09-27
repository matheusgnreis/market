<?php
namespace Market\Controller;

use Market\Services\FileUploader;
use Market\Model\AppsImagens;
use Market\Model\ThemesImagens;
use Market\Services\Database;

class MediaController
{
    private $dirUpload = '/var/www/data/uploads';
    private $aid;
    private $quality = 80;
    private $data;
    private $type;
    private $_request;
    private $_response;

    protected $small = [
        'mh' => 300,
        'mw' => 300,
    ];
    protected $medium = [
        'mh' => 600,
        'mw' => 600,
    ];
    protected $large = [
        'mh' => 840,
        'mw' => 490,
    ];

    public function __construct()
    {
        new Database();
    }

    public function create($request, $response, $args)
    {
        $uploader = new FileUploader('files', array(
            'limit' => 12,
            'maxSize' => 12,
            'fileMaxSize' => null,
            'extensions' => ['jpg', 'jpeg', 'png', 'JPG'],
            'required' => false,
            'uploadDir' => '/var/www/data/uploads/',
            'title' => '{random}',
            'replace' => false,
            'listInput' => true,
            'editor' => array(
                'quality' => $this->quality,
            ),
        ));

        $upload = $uploader->upload();

        if ($upload['hasWarnings']) {
            return $response->withJson(['erros' => ['erro' => '415', 'message' => 'Arquivo inválido.', 'Avisos' => $upload['warnings']]]);
        }

        $uri = $request->getUri();
        $this->data = $upload['files'];
        $this->aid = $args['id'];
        $this->type = explode('/', $uri->getPath())[2];
        $this->_request = $request;
        $this->_response = $response;
        $this->save();

        //$img = new SimpleImage();
        //$img->fromFile($upload['files'][0]['file'])
        //    ->bestFit($this->medium['mw'], $this->medium['mh'])
        //    ->toFile($upload['files'][0]['file'], 'image/png', 80);

        //$apps = Apps::find($_SESSION['id']);
        //$update = $apps->update([
        //    'path_image' => $files[0]['file']
        //]);
        //return $update;
    }

    public function save()
    {
        switch ($this->type) {
            case 'apps':
                $this->app();
                break;
            case 'themes':
                $this->theme();
                break;
            default:
                break;
        }
    }

    public function app()
    {
        $count = count($this->data);
        $resp = [];
        for ($i=0; $i < $count; $i++) {
            $resp[] = AppsImagens::create(
                [
                 'app_id' => $this->aid,
                 'name' => $this->data[$i]['name'],
                 'path_image' => $this->data[$i]['name'],
                 'width_px' => 600,
                 'height_px' => 600
                ]
            );
        }
        //var_dump(!empty($resp));
        //return !empty($resp) ? $this->_response->withJson(['status' => 201, 'message' => 'created', 'data' => $resp], 201) : $this->_response->withJson(['erro' => 'Error: media request'], 400);        
        //return !empty($resp) ? json_encode(['status' => 201, 'message' => 'created', 'data' => $resp]) : json_encode(['erro' => 'Error: media request']);        
        print_r(json_encode(['status' => 201, 'message' => 'created', 'data' => $resp]));
    }

    public function theme()
    {
        $count = count($this->data);
        $resp = [];
        for ($i=0; $i < $count; $i++) {
            $resp[] = ThemesImagens::create(
                [
                 'theme_id' => $this->aid,
                 'name' => $this->data[$i]['name'],
                 'path_image' => $this->data[$i]['name'],
                 'width_px' => 600,
                 'height_px' => 600
                ]
            );
        }
        print_r(json_encode(['status' => 201, 'message' => 'created', 'data' => $resp]));

        //return $resp ? $this->_response->withJson(['status' => 201, 'message' => 'created', 'data' => $resp], 201) : $this->_response->withJson(['erro' => 'Error: media request'], 400);
    }
}
