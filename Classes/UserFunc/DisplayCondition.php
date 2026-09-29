<?php

declare(strict_types=1);

namespace OliverThiele\OtCeheader\UserFunc;

use TYPO3\CMS\Core\Utility\GeneralUtility;

final class DisplayCondition
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function isContentBlock(array $parameters): bool
    {
        $record = $parameters['record'] ?? [];
        if (!is_array($record)) {
            return false;
        }

        // A select field hands the value over as a single-element array.
        $cTypeRaw = $record['CType'] ?? '';
        if (is_array($cTypeRaw)) {
            $cTypeRaw = $cTypeRaw[0] ?? '';
        }
        $cType = is_scalar($cTypeRaw) ? (string)$cTypeRaw : '';

        if ($cType === '') {
            return false;
        }

        $registryClass = 'TYPO3\\CMS\\ContentBlocks\\Registry\\ContentBlockRegistry';
        if (!class_exists($registryClass)) {
            return false;
        }

        $registry = GeneralUtility::makeInstance($registryClass);

        return $registry->getByTypeName('tt_content', $cType) !== null;
    }
}
