<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

$config = new PhpCsFixer\Config();
return $config
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder($finder)
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        'simplified_null_return' => false,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_summary' => false,
        'linebreak_after_opening_tag' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'declare_strict_types' => true,
        'no_superfluous_phpdoc_tags' => true,
        'yoda_style' => false,
        'phpdoc_types_order' => ['null_adjustment' => 'none', 'sort_algorithm' => 'none'],
        'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays', 'match', 'parameters']],
        'single_line_throw' => false,
        'visibility_required' => false,
        'native_function_invocation' => true,
        'native_constant_invocation' => true,
    ]);
