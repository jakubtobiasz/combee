<?php
$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src');

return new PhpCsFixer\Config()
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => false,
    ])
    ->setFinder($finder)
;
