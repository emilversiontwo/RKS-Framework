<?php

namespace Src\Core\Router\Enum;

enum GroupAttributeEnum: string
{
    case PREFIX = 'prefix';
    case MIDDLEWARE = 'middleware';
    case AS = 'alias';
    case NAMESPACE = 'namespace';
    case WHERE = 'where';
    case DEFAULTS = 'defaults';
    case DOMAIN = 'domain';
    case EXTRAS = 'extras';
}
