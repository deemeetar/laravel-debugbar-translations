<?php namespace Deemeetar\LaravelDebugbarTranslations\DataCollector;


use DebugBar\DataCollector\AssetProvider;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

class TranslationCollector extends DataCollector implements Renderable, AssetProvider
{
    protected $translations = array();

    /**
     * Create a TranslationCollector
     *
     */
    public function __construct()
    {
        $this->name = 'translations';
        $this->translations = array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWidgets()
    {
        return array(
            'translations' => array(
                'icon' => 'leaf',
                'tooltip' => 'Translations',
                'widget' => 'PhpDebugBar.Widgets.TranslationsWidget',
                'map' => 'translations',
                'default' => '[]'
            ),
            'translations:badge' => array(
                'map' => 'translations.nb_translations',
                'default' => 0
            )
        );
    }

    public function getAssets()
    {
        return array(
            'base_path' => __DIR__."/../Resources",
            'css' => 'widgets/translations/widget.css',
            'js' => 'widgets/translations/widget.js'
        );
    }

    /**
     * Add a translation key to the collector
     * @param string $key
     * @param string $value
     */
    public function addTranslation($key, $value)
    {
        $this->translations[] = array(
            'key' => $key,
            'value' => $value,
            'link' => $this->getLink($key)
        );
    }

    protected function getLink($key){
        $group = substr($key, 0, strpos($key, '.'));
        $subkey = substr($key, strpos($key, '.')+1);

        return "/translations/index/$group#$subkey";
    }

    public function collect()
    {
        $translations = $this->translations;
        return array(
            'nb_translations' => count($translations),
            'translations' => $translations,
        );
    }
}
