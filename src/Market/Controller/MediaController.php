<?php
namespace Market\Controller;

use Market\Model\AppsImagens;
use Market\Model\ThemesImagens;
use Market\Services\Database;
use Market\Services\FileUploader;

class MediaController
{
    private $dirUpload = '/var/www/data/uploads';
    private $app_id;
    private $quality = 80;
    private $data = [];
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
        if ($request->getParams()['type'] === 'screenshots') {
            $uploader = new FileUploader('files', array(
                'limit' => 6,
                'maxSize' => 5,
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
                return $response->withJson(['erros' => ['status' => '400', 'user_message' => 'Inválid file', 'message' => $upload['warnings']]], 400);
            } else {
                $this->data = $upload['files'];
                $this->app_id = $request->getParams()['item_id'];
                $this->_request = $request;
                $this->_response = $response;
                switch ($request->getParams()['item']) {
                    case 'theme':
                        $this->type = 'theme';
                        // no break
                    default:
                        $this->type = 'apps';
                }
                return $this->save();
            }
        } elseif ($request->getParams()['type'] === 'icon') {
            $uploader = new FileUploader('files', [
                'extensions' => ['jpg', 'jpeg', 'png', 'JPG', 'icon'],
                'uploadDir' => '/var/www/data/uploads/',
                'title' => '{random}',
                'replace' => false,
            ]);

            $upload = $uploader->upload();

            if ($upload['hasWarnings']) {
                return $response->withJson(['erros' => ['status' => '400', 'user_message' => 'Inválid file', 'message' => $upload['warnings']]], 400);
            } else {
                return $response->withJson($upload['files'], 201);
            }
        }
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
        for ($i = 0; $i < $count; $i++) {
            $media = [
                'app_id' => $this->app_id,
                'name' => $this->data[$i]['name'],
                'path_image' => $this->data[$i]['name'],
                'width_px' => 600,
                'height_px' => 600,
            ];
            AppsImagens::create($media);
            $resp[] = $media;
        }

        return $this->_response->withJson($resp, 201);
    }

    public function theme()
    {
        $count = count($this->data);
        $resp = [];
        for ($i = 0; $i < $count; $i++) {
            $resp[] = ThemesImagens::create(
                [
                    'theme_id' => $this->app_id,
                    'name' => $this->data[$i]['name'],
                    'path_image' => $this->data[$i]['name'],
                    'width_px' => 600,
                    'height_px' => 600,
                ]
            );
        }
        print_r(json_encode(['status' => 201, 'message' => 'created', 'data' => $resp]));

        //return $resp ? $this->_response->withJson(['status' => 201, 'message' => 'created', 'data' => $resp], 201) : $this->_response->withJson(['erro' => 'Error: media request'], 400);
    }
}
