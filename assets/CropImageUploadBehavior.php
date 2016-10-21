<?php

/**
 * @copyright Copyright (c) 2014 karpoff
 * @link https://github.com/karpoff/yii2-crop-image-upload
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace culturePnPsu\user\assets;

class CropImageUploadBehavior extends \karpoff\icrop\CropImageUploadBehavior {

    public $attribute_folder;

    /**
     * @inheritdoc
     */
    public function beforeValidate() {
        /** @var BaseActiveRecord $model */
        $model = $this->owner;

        if (!empty($this->attribute_folder)) {
//                    echo $this->attribute_folder;
//                    echo $model->getAttribute($this->attribute_folder);
//                    exit();
            $folder = $model->getAttribute($this->attribute_folder);

            $this->path = str_replace('{extra_folder}', $folder, $this->path);
            $this->url = str_replace('{extra_folder}', $folder, $this->url);
        }

        parent::beforeValidate();
    }

}
