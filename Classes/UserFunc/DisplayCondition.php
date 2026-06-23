<?php

declare(strict_types=1);

namespace OliverThiele\OtCeheader\UserFunc;

use TYPO3\CMS\Core\Utility\GeneralUtility;

final class DisplayCondition
{
    public function isContentBlock(array $parameters): bool
    {
        $record = $parameters['record'] ?? [];
        $cTypeRaw = $record['CType'] ?? '';
        $cType = is_array($cTypeRaw) ? (string)($cTypeRaw[0] ?? '') : (string)$cTypeRaw;

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
