<?php

declare(strict_types=1);

namespace Guidance\Tests\Base;

interface ProjectInfo
{
    public const OWNER = 'guidance';
    public const NAME  = 'tests_base';

    public const LAYER_NAME       = 'Base';
    public const NAMESPACE_PREFIX = 'Guidance\\Tests\\Base\\';

    public const CHILD_LAYER_NAME       = 'Project';
    public const CHILD_NAMESPACE_PREFIX = 'Guidance\\Tests\\Project\\';
    
    public const ALLURE_NAMESPACE_PREFIX = 'Yandex\\';
}
