<?php
declare(strict_types=1);

namespace App\Shared\DockerListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class TablePrefixEventListener
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if (!$classMetadata->isInheritanceTypeSingleTable() || $classMetadata->getName() === $classMetadata->rootEntityName) {
            $classMetadata->setPrimaryTable([
                'name' => $this->resolveTableName($classMetadata->getName(), $classMetadata->getTableName())
            ]);
        }

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide']) {
                $mappedTableName = $mapping['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->resolveTableName(
                    $mapping['targetEntity'],
                    $mappedTableName
                );
            }
        }
    }

    private function resolveTableName(string $className, string $tableName): string
    {
        $nameSpaces = explode('\\', $className);
        $bundleName = isset($nameSpaces[1]) ? strtolower($nameSpaces[1]) : null;

        if (!$bundleName) {
            return $tableName;
        }

        return strtolower($bundleName) . '_' . $tableName;
    }
}