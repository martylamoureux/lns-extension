<?php
namespace MartyLamoureux\LnsExtension;

use DynamicScreen\ExtensionKit\BaseExtensionProvider;
use Mink\GifiExtension\SlidesTypes\BorneVente;

class ExtensionProvider extends BaseExtensionProvider
{
    public function getExtensionName()
    {
        return 'lns';
    }
    public function getExtensionLabel()
    {
        return "FFM LNS";
    }
    public function getExtensionAuthor()
    {
        return 'Marty Lamoureux';
    }

    public function getAssetsPath()
    {
        return __DIR__ . '/Resources/assets';
    }

    public function registerExtension()
    {
        $this->registerSlideType(\MartyLamoureux\LnsExtension\SlidesTypes\LiveScore::class);
        $this->publish('public','/');
    }

    public function bootExtension()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lns-extension');
    }

}
