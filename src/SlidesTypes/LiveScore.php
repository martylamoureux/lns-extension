<?php
namespace MartyLamoureux\LnsExtension\SlidesTypes;

use DynamicScreen\ExtensionKit\BaseSlideType;
use DynamicScreen\ExtensionKit\FormBuilder;
use DynamicScreen\ExtensionKit\SlideContract;

class LiveScore extends BaseSlideType
{
    public function getIdentifier()
    {
        return "live-score";
    }

    public function getName()
    {
        return 'Live Score LNS';
    }

    public function getIcon()
    {
        return 'fa-list-ol';
    }

    public function hasDuration()
    {
        return true;
    }

    public function hasPadding()
    {
        return false;
    }

    public function getDescription()
    {
        return 'Live Score Ligue Nationale de Speedway';
    }

    public function displayOffline()
    {
        return true;
    }

    /**
     * Get the path to the Vue component (relative to the assets directory)
     * @return string
     */
    public function getComponentPath()
    {
        return 'SlidesTypes/LiveScore.vue';
    }

    public function fetchSlide(SlideContract $slide)
    {
        $this->slide([
            'api_url' => \Illuminate\Support\Str::finish($slide->getOption("api_url"), "/"),
        ]);
    }

    public function registerOptionsForm(FormBuilder $form)
    {
        $form->text("api_url", "Adresse URL API");
    }

    public function getValidations()
    {
        return;
    }

    public function guessSlideName(SlideContract $slide)
    {
        return $this->getName();
    }
}