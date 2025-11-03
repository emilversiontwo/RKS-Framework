<?php

namespace Src\Core\Container\Enum;

enum BindingTypeEnum: string
{
    case SHARED = 'shared';

    case PROTOTYPE = 'prototype';

    case INSTANCE = 'instance';
}
