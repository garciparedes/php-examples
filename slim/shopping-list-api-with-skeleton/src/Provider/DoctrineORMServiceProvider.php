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

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Pimple\Container;

/**
 * Doctrine ORM service provider
 * Require doctrine/ORM
 */
class DoctrineORMServiceProvider extends AbstractServiceProvider
{
    /**
     * Get default settings
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return [
            'connection' => [
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'your-db',
                'user'     => 'your-user-name',
                'password' => 'your-password',
            ],
            'meta' => [
                'entity_path' => [
                    ROOT_PATH . '/src/Models/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' => CACHE_PATH . '/proxies',
                'cache' => null,
            ],
        ];
    }

    /**
     * Register log service provider.
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        //$container->get('logger')->addInfo("Something interesting happened: " . __DIR__ . "/../Model/Entity");;

        $settings = array_merge([], self::getDefaultSettings(), $container['settings']['database']);

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../Model/Entity"));

        $container['database'] = EntityManager::create($settings['connection'], $config);
    }
}
