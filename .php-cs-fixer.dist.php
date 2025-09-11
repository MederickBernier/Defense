<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests'])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'single_quote' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_superfluous_phpdoc_tags' => true,
        'phpdoc_trim' => true,
        'phpdoc_align' => false,
        'native_function_invocation' => ['include' => ['@compiler_optimized']],
    ])
    ->setFinder($finder);
