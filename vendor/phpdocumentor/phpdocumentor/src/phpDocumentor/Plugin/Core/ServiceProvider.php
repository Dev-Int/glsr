<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2014 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Plugin\Core;

use Cilex\Application;
use Cilex\ServiceProviderInterface;
use phpDocumentor\Translator\Translator;
use phpDocumentor\Plugin\Core\Transformer\Writer;
use phpDocumentor\Transformer\Writer\Collection;

/**
 * Register all services and subservices necessary to get phpDocumentor up and running.
 *
 * This provider exposes no services of its own but populates the Writer Collection with the basic writers for
 * phpDocumentor and, for backwards compatibility, registers the service providers for Graphs, Twig and PDF to
 * the container.
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * @param Application $app An Application instance.
     */
    public function register(Application $app)
    {
        /** @var Translator $translator  */
        $translator = $app['translator'];
        $translator->addTranslationFolder(__DIR__ . DIRECTORY_SEPARATOR . 'Messages');

        /** @var Collection $writerCollection */
        $writerCollection = $app['transformer.writer.collection'];

        $writerCollection['FileIo']     = new Writer\FileIo();
        $writerCollection['checkstyle'] = new Writer\Checkstyle();
        $writerCollection['sourcecode'] = new Writer\Sourcecode();
        $writerCollection['statistics'] = new Writer\Statistics();
        $writerCollection['xml']        = new Writer\Xml($app['transformer.routing.standard']);
        $writerCollection['xsl']        = new Writer\Xsl($app['monolog']);

        $writerCollection['checkstyle']->setTranslator($translator);
        $writerCollection['xml']->setTranslator($translator);

        Xslt\Extension::$routers           = $app['transformer.routing.queue'];
        Xslt\Extension::$descriptorBuilder = $app['descriptor.builder'];

        $app->register(new \phpDocumentor\Plugin\Graphs\ServiceProvider());
        $app->register(new \phpDocumentor\Plugin\Twig\ServiceProvider());
        $app->register(new \phpDocumentor\Plugin\Pdf\ServiceProvider());
    }
}
