<?php

namespace AppBundle\Service;


use Artgris\Bundle\FileManagerBundle\Service\FileTypeService as FileType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Asset\Packages;

class FileTypeService extends FileType
{
    private $router;

    private $packages;

    public function __construct(Router $router, Packages $packages)
    {
        $this->router = $router;
        $this->packages = $packages;
    }

    public function fileIcon($filePath, $extension = null, $size = 75)
    {
        if ($extension === null) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        }

        $filePath = str_replace('\\', '/', substr($filePath, 1));
        $filePath = $this->packages->getUrl($filePath);

        switch (true) {
            case preg_match('/(gif|png|jpe?g|svg)$/i', $extension):
                /** @var FileManager $fileManager */
                return [
                    "path" => $filePath,
                    "html" => "<img src=\"{$filePath}\" height='{$size}'>"
                ];
            case preg_match('/(mp4|ogg|webm)$/i', $extension):
                $fa = 'fa-file-video-o';
                break;
            case preg_match('/(pdf)$/i', $extension):
                $fa = 'fa-file-pdf-o';
                break;
            case preg_match('/(docx?)$/i', $extension):
                $fa = 'fa-file-word-o';
                break;
            case preg_match('/(xlsx?|csv)$/i', $extension):
                $fa = 'fa-file-excel-o';
                break;
            case preg_match('/(pptx?)$/i', $extension):
                $fa = 'fa-file-powerpoint-o';
                break;
            case preg_match('/(zip|rar|gz)$/i', $extension):
                $fa = 'fa-file-archive-o';
                break;
            default :
                $fa = 'fa-file-o';
        }
        return [
            "path" => $filePath,
            "html" => "<i class='fa {$fa}' aria-hidden='true'></i>"
        ];
    }
}