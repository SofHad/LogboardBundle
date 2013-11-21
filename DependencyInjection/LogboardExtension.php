<?php

namespace So\LogboardBundle\DependencyInjection;

use So\LogboardBundle\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LogboardExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');
        $loader->load('extension.xml');

        $configuration = $this->getConfiguration($configs, $container);

        $config = $this->processConfiguration($configuration, $configs);

        $index = array();

        foreach ($config as $key => $configBase) {
            if (true === (bool)$configBase["enabled"]) {

                foreach ($configBase["menu"] as $menu => $configMenu) {

                    if (false === $configMenu["enabled"]) {
                        break;
                    }

                    $engine = isset($configMenu["engine"]) ? $configMenu["engine"] : $configBase["engine"];
                    $engineService = "{$engine}_{$menu}_{$key}";

                    $splitParameter = $configMenu["split"]["parameter"];

                    //DecompilerService
                    $decompiler = isset($configMenu["decompiler"]) ? $configMenu["decompiler"] : $configBase["decompiler"];

                    $decompilerServiceId = "logboard.decompiler.{$decompiler}.{$engineService}";
                    $decompilerClassId = "logboard.decompiler.{$decompiler}.class";
                    $decompilerClass = $container->getParameter($decompilerClassId);
                    $decompilerDefinition = new Definition($decompilerClass, array($splitParameter));
                    $container->addDefinitions(array($decompilerServiceId => $decompilerDefinition));

                    //ParametersService
                    $data = isset($configMenu["data"]) ? $configMenu["data"] : $configBase["data"];
                    $source = isset($configMenu["src"]) ? $configMenu["src"] : $configBase["src"];
                    $data = $this->getDIPath($data);

                    if ('file' === $source && !file_exists($data)) {
                        throw new InvalidConfigurationException(sprintf('The LogboardBundle configuration is invalid. please check the data source for "%s > %s"', $configBase["title"], $configMenu["title"]));
                    }

                    $parametersServiceId = "logboard.parameters.{$engineService}";
                    $parametersClassId = "logboard.parameters.{$engine}.class";
                    $parametersClass = $container->getParameter($parametersClassId);
                    $parametersArguments = array(new Reference("filesystem"), $data);
                    $parametersDefinition = new Definition($parametersClass, $parametersArguments);
                    $container->addDefinitions(array($parametersServiceId => $parametersDefinition));

                    //FinderService
                    $finderServiceId = "logboard.finder.{$engineService}";
                    $finderClassId = "logboard.finder.{$engine}.class";
                    $finderClass = $container->getParameter($finderClassId);
                    $finderArguments = array(new Reference($decompilerServiceId), $configMenu["split"]["callback"]);
                    $finderDefinition = new Definition($finderClass, $finderArguments);
                    $container->addDefinitions(array($finderServiceId => $finderDefinition));

                    //MainService
                    $mainServiceId = "logboard.{$engineService}";
                    $mainServiceClassId = "logboard.{$engine}.class";
                    $mainServiceClass = $container->getParameter($mainServiceClassId);

                    $mainServiceArguments = array(new Reference("profiler"), new Reference($finderServiceId), new Reference($parametersServiceId));
                    $mainServiceDefinition = new Definition($mainServiceClass, $mainServiceArguments);
                    $container->addDefinitions(array($mainServiceId => $mainServiceDefinition));

                    //index
                    $index[$configBase["title"]][$menu]["engine_service"] = $engineService;
                    $index[$configBase["title"]][$menu]["title"] = $configMenu["title"];
                }

            }

        }

        //Inject the index
        $queryManagerDefinition = $container->findDefinition("logboard.query_manager");
        $queryManagerArguments = $queryManagerDefinition->getArguments();
        $queryManagerArguments[3] = $index;
        $queryManagerDefinition->setArguments($queryManagerArguments);
    }

    public function getDIPath($path)
    {

        if (!is_string($path)) {
            return;
        }

        return str_replace("@LogboardBundle", __DIR__, $path);
    }
}
