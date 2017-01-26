<?php
declare(strict_types = 1);
namespace RabbitCMS\Galleries;

use RabbitCMS\Modules\ModuleProvider as BaseModuleProvider;

/**
 * Class ModuleProvider.
 */
class ModuleProvider extends BaseModuleProvider
{
    /**
     * @inheritdoc
     */
    protected function name(): string
    {
        return 'galleries';
    }
}
