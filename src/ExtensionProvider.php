<?php
namespace MartyLamoureux\LnsExtension;

use App\Models\Display;
use App\Models\Space;
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

        $this->apiGet("update", function () {
            $res = ['success' => true, 'displays' => []];
            Space::whereHas('extensions', function ($q) {
                $q->where('extension', 'marty-lamoureux.lns');
            })->each(function ($space) use (&$res) {
                Display::where('space_id', $space->id)->isConnected()->chunk(10, function ($displays) use (&$res) {
                    $displays->each(function ($display) use (&$res) {
                        $display->dispatchSharedEvent("lns.update");
                        $res["displays"][$display->api_key] = $display->name;
                    });
                });
            });

            return $res;
        });
    }

}
