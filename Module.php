<?php

namespace app\modules\{_MODULE_ID_};

use app\components\ModuleAccess;
use yii\helpers\ArrayHelper;

/**
 * {_MODULE_ID_} module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\{_MODULE_ID_}\controllers';

    const moduleId = "{_MODULE_ID_}";
    
    const moduleUrl = "/".self::moduleId;

    const moduleTitle = 'Проекты';

    // удялет из меню со списком всех модулей
    const removeFromModuleMenu = true;

    // удляет из индивидуального меню для модуля
    const removeFromThisModuleMenu = true;

    public static function getBreadcrumbs($url = true){
        return [
            'label' => self::moduleTitle,
            'url' => $url ? [self::moduleUrl.'/default/index'] : null,
        ];
    }

    public static function moduleMenu(){
        $array = [
            'label' => self::moduleTitle,
            'items' => [
                [
                    'label' => 'Список проектов',
                    'url' => self::moduleUrl,
                ],
                [
                    'label' => '&nbsp;&nbsp;&nbsp;добавить проект',
                    'url' => self::moduleUrl.'/default/create',
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
