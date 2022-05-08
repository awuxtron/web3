<?php

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Providers\HttpProvider;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Arr;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Boolean;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Types\Filter;
use Awuxtron\Web3\Types\Fixed;
use Awuxtron\Web3\Types\Integer;
use Awuxtron\Web3\Types\Obj;
use Awuxtron\Web3\Types\Plain;
use Awuxtron\Web3\Types\Str;
use Awuxtron\Web3\Types\Topics;
use Awuxtron\Web3\Types\Transaction;
use Awuxtron\Web3\Types\Tuple;
use Awuxtron\Web3\Types\Whisper;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Web3;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

$mapTypes = [
    Address::class => '\\' . Hex::class . '|string',
    Arr::class => 'array',
    Block::class => 'mixed',
    Boolean::class => 'bool',
    Bytes::class => '\\' . Hex::class . '|string',
    Filter::class => 'array',
    Fixed::class => 'mixed',
    Integer::class => 'mixed',
    Obj::class => 'array',
    Plain::class => 'mixed',
    Str::class => 'string',
    Topics::class => 'array',
    Transaction::class => 'array',
    Tuple::class => 'array',
    Whisper::class => 'array',
];

require __DIR__ . '/../vendor/autoload.php';

$finder = (new Finder)->name('/\.php$/')->files();

// Get all method namespaces.
$namespaces = [];
$namespaceDir = __DIR__ . '/../src/Methods';

/** @var SplFileInfo $file */
foreach ($finder->in($namespaceDir)->contains('extends MethodNamespace') as $file) {
    $namespaces[] = $file->getFilenameWithoutExtension();
}

unset($file);

// Get all methods.
$st = get_declared_classes();

foreach ($namespaces as $namespace) {
    foreach ((array) glob("{$namespaceDir}/{$namespace}/*.php") as $file) {
        require_once $file;
    }
}

$classes = array_values(array_filter(array_diff(get_declared_classes(), $st), function ($class) {
    return is_subclass_of($class, Method::class);
}));

/**
 * Get the method description.
 *
 * @param string $doc
 * @param string $key
 *
 * @return string
 */
function getMethodDescription(string $doc, string $key = '@description'): string
{
    $description = [];
    $flag = false;

    foreach (explode(PHP_EOL, $doc) as $line) {
        $line = ltrim($line, $characters = " \t\n\r\0\x0B*/#");

        if (str_starts_with($line, $key)) {
            $flag = true;
        } elseif (str_starts_with($line, '@')) {
            $flag = false;
        }

        if ($flag) {
            $description[] = trim($line, $characters);
        }
    }

    return trim(substr(implode(' ', $description), strlen($key)));
}

/**
 * Get all use statements from reflection class.
 *
 * @param mixed $class
 *
 * @return array<mixed>
 */
function getUseStatements(mixed $class): array
{
    $lines = array_slice(
        explode(PHP_EOL, (string) file_get_contents((string) $class->getFileName())),
        0,
        (int) $class->getStartLine() - 1
    );

    $result = [];

    foreach ($lines as $line) {
        $line = trim($line);

        if (!str_starts_with($line, 'use')) {
            continue;
        }

        $line = substr(trim(str_replace_first('use', '', $line)), 0, -1);

        preg_match('/^(function|const) /i', $line, $matches);

        if (!empty($matches)) {
            $line = substr($line, strlen($matches[0]));
        }

        foreach (explode(',', $line) as $use) {
            [$name, $as] = array_pad(array_map('trim', explode('as', trim($use))), 2, null);

            if (empty($as)) {
                $parsed = explode('\\', $name);
                $as = end($parsed);
            }

            $result[$as] = $name;
        }
    }

    if ($class->getParentClass() instanceof ReflectionClass) {
        $result = array_merge($result, getUseStatements($class->getParentClass()));
    }

    return $result;
}

/**
 * Get the return type from method.
 *
 * @template T of object
 *
 * @param ReflectionClass<T> $class
 * @param string             $method
 *
 * @return array<mixed>
 * @throws ReflectionException
 */
function getReturnType(ReflectionClass $class, string $method): array
{
    $method = $class->getMethod($method);
    $return = (string) $method->getReturnType();

    if (empty($return)) {
        return ['void', 'void'];
    }

    $fromComment = getMethodDescription((string) $method->getDocComment(), '@return');

    if (empty($fromComment)) {
        $fromComment = $return;
    }

    $uses = getUseStatements($class);

    $formatter = function ($type, $ignores = []) use (&$formatter, $uses) {
        preg_match_all('/[a-z\d\\\\]+/i', $type, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $match) {
            if (!in_array($match[0], $ignores, true) && class_exists($match[0])) {
                $type = substr_replace($type, $ignores[] = '\\' . ltrim($match[0], '\\'), $match[1], strlen($match[0]));

                return $formatter($type, $ignores);
            }

            if (array_key_exists($match[0], $uses)) {
                $type = substr_replace($type, $ignores[] = '\\' . $uses[$match[0]], $match[1], strlen($match[0]));

                return $formatter($type, $ignores);
            }
        }

        return $type;
    };

    return [$formatter($fromComment), $formatter($return)];
}

// Generate auto complete.
$properties = [];
$methods = [];
$uses = [];

foreach ($classes as $method) {
    $reflection = new ReflectionClass($method);
    $description = getMethodDescription((string) $reflection->getDocComment());
    $params = $method::getParametersSchema();
    $required = array_filter($params, fn ($v) => $v['default'] === null);

    // Get method name.
    $parseMethod = explode('\\', $method);
    $name = lcfirst(array_pop($parseMethod));
    $namespace = array_pop($parseMethod);

    // Add to properties if method has no required params.
    if (empty($required)) {
        $properties[$namespace][] = [
            'name' => $name,
            'description' => $description,
            'return' => getReturnType($reflection, 'value'),
        ];
    }

    // Get method arguments.
    foreach ($params as $key => $param) {
        $param['type'] = array_map(function ($t) use ($mapTypes) {
            $t = EthereumType::resolve($t);

            if ($t instanceof Plain) {
                return $t->getPhpType();
            }

            return $mapTypes[get_class($t)];
        }, $param['type']);

        $params[$key] = $param;
    }

    $methods[$namespace][] = [
        'name' => $name,
        'description' => $description,
        'arguments' => $params,
        'return' => '\\' . $method,
    ];
}

// Write to ide helper file.
$result = "<?php\n\nnamespace Awuxtron\\Web3\\Methods;\n\n";

foreach ($namespaces as $namespace) {
    $comments = [
        'properties' => [],
        'methods' => [],
    ];

    $result .= "class {$namespace}\n{\n";

    // Properties.
    foreach ($properties[$namespace] as $property) {
        $genCmt = fn ($p) => rtrim(" * @property {$p['return'][0]} \${$p['name']} {$p['description']}\n");

        $comments['properties'][] = $genCmt($property);

        $formatter = function ($property) {
            $result = "    /**\n";

            if (!empty($property['description'])) {
                $result .= "     * {$property['description']}\n     *\n";
            }

            $result .= "     * @var {$property['return'][0]}\n";
            $result .= "     */\n";

            $result .= "    public {$property['return'][1]} \${$property['name']};\n\n";

            return $result;
        };

        $result .= $formatter($property);

        if (str_starts_with($property['name'], 'get')) {
            $property['name'] = lcfirst(substr($property['name'], 3));

            if (empty(array_filter($properties[$namespace], fn ($p) => $p['name'] == $property['name']))) {
                $result .= $formatter($property);
                $comments['properties'][] = $genCmt($property);
            }
        }
    }

    // Methods.
    foreach ($methods[$namespace] as $method) {
        $m = " * @method {$method['return']} {$method['name']}(";
        $result .= "    /**\n";

        if (!empty($method['description'])) {
            $result .= "     * {$method['description']}\n     *\n";
        }

        foreach ($method['arguments'] as $name => $arg) {
            $result .= '     * @param ';

            $type = implode('|', $arg['type']);

            if (str_contains($type, 'mixed')) {
                $type = 'mixed';
            }

            $type = str_replace('array', 'array<mixed>', $type);

            $result .= "{$type} \${$name} {$arg['description']}\n";
        }

        if (!empty($method['arguments'])) {
            $result .= "     *\n";
        }

        $result .= "     * @return {$method['return']}\n     */\n";

        $args = [];

        foreach ($method['arguments'] as $name => $arg) {
            $a = implode('|', $arg['type']);

            if (str_contains($a, 'mixed')) {
                $a = 'mixed';
            }

            $a .= " \${$name}";

            if ($arg['default'] !== null) {
                $a .= ' = ';

                if (is_string($arg['default'])) {
                    $a .= "'{$arg['default']}'";
                } elseif (is_array($arg['default'])) {
                    $a .= '[]';
                } elseif (is_bool($arg['default'])) {
                    $a .= $arg['default'] ? 'true' : 'false';
                } else {
                    $a .= $arg['default'];
                }
            }

            $args[] = $a;
        }

        $result .= "    public function {$method['name']}(";
        $result .= $b = implode(', ', $args);
        $result .= "): {$method['return']}\n    {\n";
        $result .= '        return (new \\' . Web3::class . '(new \\' . HttpProvider::class . "('http://localhost')))";
        $result .= "->method({$method['return']}::class)";
        $result .= ";\n    }\n\n";

        $comments['methods'][] = rtrim($m . "{$b}) {$method['description']}");
    }

    $result .= "}\n\n";

    // Write to method namespace.
    $cmt = "/**\n";
    $cmt .= implode(PHP_EOL, $comments['properties']);
    $cmt .= "\n *\n";
    $cmt .= implode(PHP_EOL, $comments['methods']);
    $cmt .= "\n */";

    /** @var class-string $c */
    $c = "Awuxtron\\Web3\\Methods\\{$namespace}";
    $class = new ReflectionClass($c);
    $source = (string) file_get_contents($path = (string) $class->getFileName());
    $start = (int) $class->getStartLine();

    if (!empty($doc = $class->getDocComment()) && ($pos = strpos($source, $doc)) !== false) {
        $source = substr_replace($source, '', $pos, strlen($doc));
        $start -= count(explode(PHP_EOL, $doc)) - 1;
    }

    $lines = explode(PHP_EOL, $source);

    $result = implode(PHP_EOL, array_slice($lines, 0, $start - 1));
    $result .= "{$cmt}\n";
    $result .= implode(PHP_EOL, array_slice($lines, $start - 1));

    file_put_contents($path, $result);
}

file_put_contents(__DIR__ . '/../.ide-helper.php', $result);
