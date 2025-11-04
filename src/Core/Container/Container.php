<?php

namespace Src\Core\Container;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use Src\Core\Container\Enum\BindingTypeEnum;
use Src\Core\Container\Exceptions\ContainerException;
use Src\Core\Container\Exceptions\ServiceNotFoundException;

/**
 * Хранит обьекты типов
 * Singleton (shared) - один и тот же объект создаётся один раз и переиспользуется при всех get() в пределах контейнера.
 * Transient / Prototype - новый объект создаётся при каждом get(). репозитории (если не хранят state), валидаторы, небольшие сервисы, которые не должны делить состояние.
 * Instance - в контейнер явно заносится уже созданный объект
 * Factory / Callable - сервисы с кастомной логикой создания, требующие доступа к container params.
 * Lazy / Proxy - тяжёлые ресурсы (ORM, внешние клиенты).
 * Parameters - всё конфиг значения
 */
class Container implements ContainerInterface
{
    /** @var array<string, Binding> $bindings */
    protected array $bindings = [];

    public function set(Binding $binding): void
    {
        $this->bindings[$binding->id] = $binding;
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     * @throws ContainerException
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException('Undefined service: ' . $id);
        }

        $binding = $this->bindings[$id];

        switch ($binding->scope)
        {
            case BindingTypeEnum::PROTOTYPE:
                $object = $this->make($binding->concrete, $binding->arguments);
                break;

            case BindingTypeEnum::SHARED:
                if ($binding->instance !== null) {
                    $object = $binding->instance;
                } else {
                    $object = $this->make($binding->concrete, $binding->arguments);
                }
                break;

            case BindingTypeEnum::INSTANCE:
                if ($binding->instance !== null) {
                    $object = $binding->instance;
                } else {
                    throw new ContainerException('Instance not set');
                }
                break;

            default:
                throw new ContainerException('Invalid binding scope: ' . $binding->scope->value);

        }

        return $object;
    }

    public function has(string $id): bool
    {
        if (isset($this->bindings[$id])) {
            if (class_exists($id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     */
    public function make(string $id, array $parametrs = []): object
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException('Undefined service: ' . $id);
        }

        $reflection = new ReflectionClass($id);
        $reflectionMethod = $reflection->getConstructor();

        $args = [];

        if ($reflectionMethod !== null) {
            foreach ($reflectionMethod->getParameters() as $arg) {
                $name = $arg->getName();
                $type = $arg->getType();
                if (array_key_exists($name, $parametrs)) {
                    $args[$name] = $parametrs[$name];
                } else {
                    $args[$name] = $this->get($type->getName());
                }
            }
        }

        return $reflection->newInstanceArgs($args);
    }
}