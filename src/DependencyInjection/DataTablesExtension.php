<?php

namespace Symfony\UX\DataTables\DependencyInjection;

use Symfony\UX\DataTables\Twig\DataTableExtension;
use Symfony\UX\DataTables\Builder\DataTableBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\UX\DataTables\Builder\DataTableBuilderInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class DataTablesExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container
            ->setDefinition('datatables.builder', new Definition(DataTableBuilder::class))
            ->setPublic(false)
        ;

        $container
            ->setAlias(DataTableBuilderInterface::class, 'datatables.builder')
            ->setPublic(false)
        ;

        $container
            ->setDefinition('datatables.twig_extension', new Definition(DataTableExtension::class))
            ->addArgument(new Reference('stimulus.helper'))
            ->addTag('twig.extension')
            ->setPublic(false)
        ;
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$this->isAssetMapperAvailable($container)) {
            return;
        }

        $container->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    __DIR__.'/../../assets/dist' => '@symfony/ux-datatables',
                ],
            ],
        ]);
    }

    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'].'/Resources/config/asset_mapper.php');
    }
}