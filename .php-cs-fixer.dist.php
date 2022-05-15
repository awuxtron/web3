<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/src')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config)->setFinder($finder)->setRules([
    '@PHP81Migration' => true,
    '@PhpCsFixer' => true,
    'new_with_braces' => ['named_class' => false, 'anonymous_class' => false],
    'concat_space' => ['spacing' => 'one'],
    'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    'no_superfluous_phpdoc_tags' => false,
    'single_line_comment_style' => false,
]);
