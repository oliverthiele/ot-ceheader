<?php

declare(strict_types=1);

namespace OliverThiele\OtCeheader\ViewHelpers\Format;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

class HeaderViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    protected $escapeChildren = false;

    /**
     * @throws Exception
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'String to format', false, '');
        $this->registerArgument('fallback', 'string', 'Fallback value if the main value is empty', false, '');
    }

    public function render(): string
    {
        $fallback = (string)($this->arguments['fallback'] ?? '');

        $value = $this->arguments['value'] ?? '';
        $value = is_string($value) ? $value : '';

        if ($value === '') {
            $renderedChildren = $this->renderChildren();
            $value = is_string($renderedChildren) ? $renderedChildren : '';
        }

        if ($value === '') {
            return $fallback;
        }

        $value = str_replace('&nbsp;', ' ', $value);

        // Preserve spaces between words between spans and keep split-words without space intact.
        $value = (string)preg_replace('~</span>\s+<span~i', '</span>&#8203;&#32;<span', $value);
        $value = (string)preg_replace('~</span><span~i', '</span>&#8203;<span', $value);

        // Ensure only one of the allowed "text color" classes is present on a span (last one wins).
        $value = $this->normalizeExclusiveSpanClasses(
            $value,
            ['text-primary', 'text-secondary', 'text-accent']
        );

        // Replace <p> (also with attributes) and </p> with header-line spans
        $value = (string)preg_replace('~<p\b[^>]*>~i', '<span class="header-line">', $value);
        $value = (string)preg_replace('~</p>~i', '</span>', $value);

        // Replace <br> with a responsive line-break element.
        // Desktop: line break; Mobile: normal space
        $value = (string)preg_replace(
            '/<br\s*\/?>/i',
            '<span class="ot-ceheader-br" aria-hidden="true"></span>',
            $value
        );

        // If the value is empty or contains only whitespace (also ignore soft hyphen / zero width space), use fallback
        $strippedValue = strip_tags($value);
        $strippedValue = (string)preg_replace('/[\s\x{00AD}\x{200B}]+/u', '', $strippedValue);

        if ($strippedValue === '') {
            return $fallback;
        }

        // Remove empty header-line spans safely (DOM-based, no regex HTML parsing)
        $value = $this->removeEmptyHeaderLineSpans($value);

        // If everything got removed, fallback
        $strippedValue = strip_tags($value);
        $strippedValue = (string)preg_replace('/[\s\x{00AD}\x{200B}]+/u', '', $strippedValue);

        if ($strippedValue === '') {
            return $fallback;
        }

        return $value;
    }

    /**
     * @param string[] $exclusiveClasses
     */
    private function normalizeExclusiveSpanClasses(string $value, array $exclusiveClasses): string
    {
        $pattern = '~<span\b([^>]*)\bclass="([^"]*)"([^>]*)>~i';

        return (string)preg_replace_callback(
            $pattern,
            static function (array $matches) use ($exclusiveClasses): string {
                $before = $matches[1];
                $classAttributeValue = $matches[2];
                $after = $matches[3];

                $classes = preg_split('/\s+/', trim($classAttributeValue)) ?: [];

                $winningExclusiveClass = null;
                foreach ($classes as $className) {
                    if (in_array($className, $exclusiveClasses, true)) {
                        $winningExclusiveClass = $className;
                    }
                }

                $normalizedClasses = [];
                foreach ($classes as $className) {
                    if (in_array($className, $exclusiveClasses, true)) {
                        continue;
                    }
                    $normalizedClasses[] = $className;
                }

                if ($winningExclusiveClass !== null) {
                    $normalizedClasses[] = $winningExclusiveClass;
                }

                $newClassValue = trim(implode(' ', array_values(array_unique($normalizedClasses))));

                return '<span' . $before . 'class="' . htmlspecialchars(
                    $newClassValue,
                    ENT_QUOTES
                ) . '"' . $after . '>';
            },
            $value
        );
    }

    /**
     * Removes empty <span class="header-line">...</span> nodes without breaking nested spans.
     */
    private function removeEmptyHeaderLineSpans(string $value): string
    {
        // Wrap as a fragment so DOMDocument can parse it reliably
        $html = '<div id="ot-ceheader-root">' . $value . '</div>';

        $internalErrorsEnabled = libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(
            '<?xml encoding="UTF-8">' . $html,
            \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD
        );

        $xpath = new \DOMXPath($dom);

        $nodes = $xpath->query(
            '//*[@id="ot-ceheader-root"]//span[contains(concat(" ", normalize-space(@class), " "), " header-line ")]'
        );

        // DOMXPath::query() returns DOMNodeList|false
        if ($nodes === false) {
            libxml_clear_errors();
            libxml_use_internal_errors($internalErrorsEnabled);

            return $value;
        }

        // Iterate backwards to safely remove nodes
        for ($index = $nodes->length - 1; $index >= 0; $index--) {
            $node = $nodes->item($index);
            if (!$node instanceof \DOMElement) {
                continue;
            }

            $textContent = (string)$node->textContent;
            $textContent = (string)preg_replace('/[\s\x{00AD}\x{200B}]+/u', '', $textContent);

            if ($textContent === '') {
                $node->parentNode?->removeChild($node);
            }
        }

        $root = $dom->getElementById('ot-ceheader-root');
        $result = '';

        if ($root instanceof \DOMElement) {
            foreach ($root->childNodes as $childNode) {
                $result .= $dom->saveHTML($childNode);
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrorsEnabled);

        return $result;
    }
}
