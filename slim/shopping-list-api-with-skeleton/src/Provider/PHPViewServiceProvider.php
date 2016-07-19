<?php
/**
 * This file is part of `oanhnn/slim-skeleton` project.
 *
 * (c) Oanh Nguyen <oanhnn.bk@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace App\Provider;

use Pimple\Container;
use Slim\Views\PhpRenderer;

/**
 * PHP view service provider
 * Require slim/php-view ^2.0
 */
class PHPViewServiceProvider extends AbstractServiceProvider
{
    /**
     * Get default settings
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return [
            'engine' => 'php',
            'template_path' => VIEW_PATH,
            'config' => [],
        ];
    }

    /**
     * Register PHP view service provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        $settings = array_merge([], self::getDefaultSettings(), $container['settings']['renderer']);

        $templatePath = rtrim($settings['template_path'], '/\\') . DIRECTORY_SEPARATOR;
        $config = $settings['config'];

//        var_dump($settings); die();

        $container['renderer'] = function (Container $c) use ($templatePath, $config) {
            $renderer = new PhpRenderer($templatePath, $config);

            return $renderer;
        };

        $container['templateFinder'] = $container->protect(function ($template) {
            return $template . '.php';
        });
    }
}
