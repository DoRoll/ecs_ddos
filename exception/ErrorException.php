<?php
namespace app\exception;

use yii\base\Exception;

/**
 * 基类
 *
 * @author xiaoyi
 * @date 2015-7-4
 */
class ErrorException extends Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'ErrorException';
    }
}