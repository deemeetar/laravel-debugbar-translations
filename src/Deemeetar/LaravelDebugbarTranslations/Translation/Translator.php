<?php namespace Deemeetar\LaravelDebugbarTranslations\Translation;

use Deemeetar\LaravelDebugbarTranslations\DataCollector\TranslationCollector;
use Illuminate\Translation\LoaderInterface;
use Illuminate\Translation\Translator as LaravelTranslator;

class Translator extends LaravelTranslator
{


    protected $debugbar;

    public function __construct(LoaderInterface $loader, $locale, $debugbar)
    {
        $this->debugbar = $debugbar;
        parent::__construct($loader, $locale);
    }


    public function get($key, array $replace = array(), $locale = null)
    {
        $translated = parent::get($key, $replace, $locale);
        $this->debugbar['translations']->addTranslation($key, $translated);
        return $translated;
    }


}