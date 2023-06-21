<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Abstract Blog Controller
 *
 * @package Phlexus\Modules\Blog\Controllers
 */
abstract class AbstractController extends Controller
{
    /**
     * Get Base Position
     *
     * @return string Current base position (module/controller)
     */
    public function getBasePosition(): string
    {
        $module = strtolower($this->dispatcher->getModuleName());
        $controller = strtolower($this->dispatcher->getControllerName());

        if ($module !== $controller) {
            $basePosition = $module . '/' . $controller;
        } else {
            $basePosition = $controller;
        }

        return '/' . $basePosition;
    }
}
