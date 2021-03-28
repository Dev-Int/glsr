<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Administration\Infrastructure\FamilyLog\Mapper;

use Administration\Application\FamilyLog\ReadModel\FamilyLog as FamilyLogReadModel;
use Administration\Application\FamilyLog\ReadModel\FamilyLogs;
use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\FamilyLog\Model\VO\FamilyLogUuid;
use Administration\Infrastructure\Finders\Exceptions\FamilyLogNotFound;
use Core\Domain\Common\Model\VO\NameField;

class FamilyLogModelMapper
{
    public function createParentTreeFromArray(array $familyLogs): FamilyLog
    {
        foreach ($familyLogs as $key => $familyLog) {
            if (0 === $key) {
                ${'parent' . $key} = FamilyLog::create(
                    FamilyLogUuid::fromString($familyLog['uuid']),
                    NameField::fromString($familyLog['label']),
                    (int) $familyLog['level']
                );
                $parent = ${'parent' . $key};
            } else {
                ${'parent' . $key} = FamilyLog::create(
                    FamilyLogUuid::fromString($familyLog['uuid']),
                    NameField::fromString($familyLog['label']),
                    (int) $familyLog['level'],
                    ${'parent' . ($key - 1)}
                );
                unset(${'parent' . ($key - 1)});
                $parent = ${'parent' . $key};
            }
        }

        return $parent;
    }

    public function createChildrenTreeFromArray(array $result, string $uuid): FamilyLog
    {
        $familyLog = $this->createParentTreeFromArray($result);

        if ($uuid === $familyLog->uuid()) {
            return $familyLog;
        }
        if (null === $familyLog->parent()) {
            throw new FamilyLogNotFound();
        }

        return $this->getParent($familyLog, $uuid);
    }

    public function getFamilyLogsFromArray(array $data): FamilyLogs
    {
        /** @var FamilyLog[] $familyLogs */
        $familyLogs = [];

        foreach ($data as $datum) {
            $familyLogs[$datum['uuid']] = FamilyLog::create(
                FamilyLogUuid::fromString($datum['uuid']),
                NameField::fromString($datum['label']),
                (int) $datum['level'],
                null,
                $datum['path']
            );
        }

        \usort($data, static function ($a, $b) {
            return \strcmp($a['level'], $b['level']);
        });

        foreach ($data as $datum) {
            \array_map(static function (FamilyLog $familyLog) use ($datum, $familyLogs): void {
                if (null !== $datum['parent_id'] && ($datum['uuid'] === $familyLog->uuid())) {
                    $familyLog->attributeParent($familyLogs[$datum['parent_id']]);
                }
            }, $familyLogs);
        }

        return new FamilyLogs(
            ...\array_map(function (FamilyLog $familyLog) {
                return $this->createReadModelFromDomain($familyLog);
            }, \array_values($familyLogs))
        );
    }

    public function getReadModelFromDataArray(array $data): FamilyLogReadModel
    {
        $familyLog = FamilyLog::create(
            $data['uuid'],
            $data['label'],
            $data['level'],
            $data['parent_id'],
            $data['path']
        );

        return $this->createReadModelFromDomain($familyLog);
    }

    public function createReadModelFromDomain(FamilyLog $familyLog): FamilyLogReadModel
    {
        return new FamilyLogReadModel(
            $familyLog->uuid(),
            $familyLog->label(),
            $familyLog->level(),
            $familyLog->parent(),
            $familyLog->children(),
            $familyLog->path(),
            $familyLog->slug()
        );
    }

    private function getParent(FamilyLog $familyLog, string $uuid): FamilyLog
    {
        if ((null !== $familyLog->parent()) && ($uuid === $familyLog->parent()->uuid())) {
            return $familyLog->parent();
        }

        return $this->getParent($familyLog->parent(), $uuid);
    }
}
