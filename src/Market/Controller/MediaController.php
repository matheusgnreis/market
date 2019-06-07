<?php
namespace Market\Controller;

use Market\Model\AppsImagens;
use Market\Services\FileUploader;

class MediaController
{
    public function __construct()
    {
    }

    public function upload($request, $response)
    {
        // set o tipo de upload
        $uploadType = $request->getParams()['type'];
        $uploadItem = $request->getParams()['item'];
        $uploadItemId = $request->getParams()['item_id'];

        // upload screenshots
        $uploadScreenshot = function () use ($response, $uploadItem, $uploadItemId) {
            $uploader = new FileUploader('file', [
                'limite' => 12,
                'extensions' => ['jpg', 'jpeg', 'png', 'JPG'],
                'uploadDir' => getenv('APP_UPLOAD_DIR'),
                'title' => '{random}',
                'listInput' => true,
                'editor' => array(
                    'quality' => $this->quality,
                ),
            ]);

            // tenta upload
            $upload = $uploader->upload();

            // se falhar bye
            if ($upload['hasWarnings']) {
                return $response
                    ->withStatus(400)
                    ->withJson(
                        [
                            'erros' => true,
                            'mesage' => 'Erro ao realizar o upload. Tente mais tarde.',
                        ]
                    );
            } else {
                // salva os path dos itens no banco
                switch ($uploadItem) {
                    case 'app':
                        $length = count($upload['files']);
                        $responseArray = array();

                        for ($i = 0; $i < $length; $i++) {
                            $media = [
                                'app_id' => $uploadItemId,
                                'name' => $upload['files'][$i]['name'],
                                'path_image' => '/media/' . $upload['files'][$i]['name'],
                                'width_px' => 600,
                                'height_px' => 600,
                            ];
                            AppsImagens::create($media);
                            $responseArray[] = $media;
                        }

                        return $response->withJson(
                            [
                                'success' => true,
                                'data' => $responseArray,
                            ],
                            201
                        );
                        break;
                    case 'theme':
                        // todo
                        break;
                    default:
                        break;
                }
            }
        };

        // upload icons
        $uploadIcons = function () {
            $uploader = new FileUploader('file', [
                'extensions' => ['jpg', 'jpeg', 'png', 'JPG', 'icon'],
                'uploadDir' => getenv('APP_UPLOAD_DIR'),
                'title' => '{random}',
                'replace' => false,
            ]);

            return $uploader->upload();
        };

        // define o upload
        switch ($uploadType) {
            case 'screenshots':
                $upload = $uploadScreenshot();
                break;
            case 'icon':
                $upload = $uploadIcons();
                if ($upload['hasWarnings']) {
                    return $response->withJson(['erros' => ['status' => '400', 'user_message' => 'Inválid file', 'message' => $upload['warnings']]], 400);
                } else {
                    return $response->withJson($upload['files'], 201);
                }
                break;
            default:
                break;
        }
    }

    public function delete($request, $response, $args)
    {
        $appsImagens = new AppsImagens();
        $imagen = $appsImagens->find($args['itemId']);
        $imagen->delete();
        return $response->withStatus(204);
    }
}
