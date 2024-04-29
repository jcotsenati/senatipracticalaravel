<?php
namespace App\Utils;

use Illuminate\Support\Facades\Log;
use ReflectionClass;

class LogHelper {
    public static function logError($object,\Exception $e) {
        $reflector = new ReflectionClass($object);
        $className = $reflector->getShortName();
        $trace = debug_backtrace();
        $methodName = $trace[1]['function'];
        $lineaError=$trace[0]['line'];
        $archivoError=$trace[0]['file'];

        Log::error("{$className}@{$methodName} {$archivoError}({$lineaError}) ". $e->getMessage());
    }
}