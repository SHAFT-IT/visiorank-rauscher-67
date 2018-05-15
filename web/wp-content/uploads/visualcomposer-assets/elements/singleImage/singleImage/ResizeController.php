<?php

namespace singleImage\singleImage;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Traits\WpFiltersActions;
use VisualComposer\Modules\Elements\Traits\AddShortcodeTrait;

class ResizeController extends Container implements Module
{
    use EventsFilters;
    use AddShortcodeTrait;
    use WpFiltersActions;

    public function __construct()
    {
        $this->addFilter('vcv:ajax:setData:updatePostData:content', 'parseContent');
    }

    protected function parseContent($content)
    {
        $parsedContent = preg_replace_callback(
            '/\[vcvSingleImage (.*?)\]/si',
            function ($matches) {
                return $this->call('parseImage', ['matches' => $matches]);
            },
            $content
        );

        return $parsedContent;
    }

    protected function parseImage($content)
    {
        if (isset($content[1])) {
            preg_match('(src=["|\'](.*?)["|\'])', $content[1], $matches);
            if (isset($matches[1])) {
                $src = $matches[1];
            }

            preg_match('(data-height=["|\']([0-9]{0,4})["|\'])', $content[1], $matches);
            if (isset($matches[1])) {
                $height = $matches[1];
            }

            preg_match('(data-width=["|\']([0-9]{0,4})["|\'])', $content[1], $matches);
            if (isset($matches[1])) {
                $width = $matches[1];
            }

            preg_match('(data-default-image=["|\'](true|false)["|\'])', $content[1], $matches);
            if (isset($matches[1])) {
                $defaultImage = $matches[1];
            } else {
                $defaultImage = false;
            }

            if (isset($src) && isset($width) && isset($height)) {
                return $this->generateImage($content, $src, $defaultImage, $width, $height);
            }
        }
    }

    protected function getImageData($url, $defaultImage)
    {
        if (!$defaultImage) {
            $uploadDir = wp_upload_dir();
            $path = str_replace($uploadDir['baseurl'], '', $url);
            $pathinfo = pathinfo($path);

            $imageData = [
                'path' => $uploadDir['basedir'] . $path,
                'filename' => $pathinfo['filename'],
                'extension' => $pathinfo['extension'],
            ];
        } else {
            $hubHelper = vchelper('HubElements');
            $path = str_replace($hubHelper->getElementUrl('singleImage') . '/singleImage/public', '', $url);
            $pathinfo = pathinfo($path);

            $imageData = [
                'path' => $hubHelper->getElementPath('singleImage') . '/singleImage/public' . $path,
                'filename' => $pathinfo['filename'],
                'extension' => $pathinfo['extension'],
            ];
        }

        return $imageData;
    }

    /**
     * @param $content
     * @param $src
     * @param $defaultImage
     * @param $width
     * @param $height
     *
     * @return string
     */
    protected function generateImage($content, $src, $defaultImage, $width, $height)
    {
        $imageData = $this->getImageData($src, $defaultImage);
        $image = wp_get_image_editor($imageData['path']);
        if (!is_wp_error($image)) {
            $image->resize($width, $height, true);

            $uploadDir = wp_upload_dir();
            $newPath = $uploadDir['path'] . '/' . $imageData['filename'] . '-' . $width . 'x' . $height
                . '.' . $imageData['extension'];
            $newfile = $image->save($newPath);
        }

        $newSrc = 'src="' . $uploadDir['url'] . '/' . $newfile['file'] . '"';
        
        $attributes = preg_replace('( src=["|\'](.*?)["|\'])', $newSrc, $content[1]);
        $attributes = preg_replace('( data-default-image=["|\'](true|false)["|\'])', '', $attributes);

        return '<img ' . $attributes . '/>';
    }
}
