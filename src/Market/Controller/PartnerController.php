<?php
namespace Market\Controller;

use Market\Model\Partner;
use Market\Services\Database;
use Market\Services\FileUploader;
use claviska\SimpleImage;

class PartnerController
{
    public function __construct()
    {
        new Database();
    }

    public function updatePicture($request, $response, $args)
    {
        $uploader = new FileUploader('files', array(
            'limit' => 12,
            'maxSize' => 12,
            'fileMaxSize' => null,
            'extensions' => ['jpg', 'jpeg', 'png', 'JPG'],
            'required' => false,
            'uploadDir' => '/var/www/data/uploads/',
            'title' => 'e_com_club_{random}',
            'replace' => false,
            'listInput' => true,
            'editor' => array(
                'quality' => 80,
            ),
        ));

        $upload = $uploader->upload();

        if ($upload['hasWarnings']) {
            return $response->withJson(['erros' => ['erro' => '415', 'message' => 'Arquivo inválido.', 'Avisos' => $upload['warnings']]]);
        }

        $img = new SimpleImage();
        $img->fromFile($upload['files'][0]['file'])
            ->bestFit('300','300')
            ->toFile($upload['files'][0]['file'], 'image/png', 80);

        $files = $upload['files'];

        if(!isset($_SESSION)){
            session_start();
        }

        $partner = Partner::find($_SESSION['id']);
        $update = $partner->update([
            'path_image' => $files[0]['file']
        ]);
        return $update;
        
    }
}
