<?php

namespace app\modules\project;

use app\components\ModuleAccess;
use yii\helpers\ArrayHelper;

/**
 * project module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\project\controllers';

    const moduleTitle = 'Проекты';
    const moduleUrl = "/project/";

    const moduleId = "project";

    // удялет из меню со списком всех модулей
    const removeFromModuleMenu = true;

    // удляет из индивидуального меню для модуля
    const removeFromThisModuleMenu = true;

    public static function getBreadcrumbs($url = true){
        return [
            'label' => 'Проекты',
            'url' => $url ? ['/project/default/index'] : null,
        ];
    }

    public static function moduleMenu(){
        $array = [
            'label' => 'Проекты',
            'items' => [
                [
                    'label' => 'Список проектов',
                    'url' => '/project/',
                ],
                [
                    'label' => '&nbsp;&nbsp;&nbsp;добавить проект',
                    'url' => '/project/default/create',
                ],
            ]
        ];

        ArrayHelper::multisort($array, 'label');

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {

        ModuleAccess::check($this->id);

        parent::init();

        // custom initialization code goes here
    }
}
