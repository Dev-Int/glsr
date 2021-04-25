<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container, LoaderInterface $loader): void
    {
        $container->import('../../../config/{packages}/*.yaml');
        $container->import('../../../config/{packages}/' . $this->environment . '/*.yaml');

        if (\is_file(\dirname(__DIR__, 3) . '/config/services.yaml')) {
            $container->import('../../../config/services.yaml');
            $container->import('../../../config/{services}_' . $this->environment . '.yaml');
        } elseif (\is_file($path = \dirname(__DIR__, 3) . '/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }

        $loader->load($this->getProjectDir() . '/src/**/Infrastructure/Symfony/Resources/config/services.yaml', 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../../../config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('../../../config/{routes}/*.yaml');
        $routes->import($this->getProjectDir() . '/src/**/Infrastructure/Symfony/Resources/config/routes.yaml', 'glob');

        if (\is_file(\dirname(__DIR__, 3) . '/config/routes.yaml')) {
            $routes->import('../../../config/routes.yaml');
        } elseif (\is_file($path = \dirname(__DIR__, 3) . '/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }
}
