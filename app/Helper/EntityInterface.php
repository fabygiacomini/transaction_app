<?php


namespace App\Helper;


interface EntityInterface
{
    /**
     * Generate an Entity from a Model.
     * @param $model
     * @return mixed
     */
    public static function newEntityFromModel($model);
}
