<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests'])
    ->exclude(['vendor', 'var', 'cache', 'build'])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setRules([
        // Always keep up-to-date with PER-CS:
        '@PER-CS' => true, // alias for latest PER-CS ruleset :contentReference[oaicite:3]{index=3}

        // Your “minimal surprise / correctness” nudges:
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'strict_comparison' => true,
        'strict_param' => true,

        // Diff-friendly:
        'trailing_comma_in_multiline' => true,
        'array_syntax' => ['syntax' => 'short'],
        'yoda_style' => false,
    ])
    ->setFinder($finder);
