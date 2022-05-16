<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/src')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return (new Config)->setFinder($finder)->setRules([
    '@PHP81Migration' => true,
    '@PhpCsFixer' => true,
    'new_with_braces' => ['named_class' => false, 'anonymous_class' => false],
    'concat_space' => ['spacing' => 'one'],
    'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    'no_superfluous_phpdoc_tags' => false,
    'single_line_comment_style' => false,
    'global_namespace_import' => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
    'control_structure_continuation_position' => true,
    'phpdoc_line_span' => true,
    'date_time_create_from_format_call' => true,
    'declare_parentheses' => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'simplified_if_return' => true,
    'simplified_null_return' => true,
]);
