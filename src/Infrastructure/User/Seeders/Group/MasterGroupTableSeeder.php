<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Group;

use Illuminate\Database\Seeder;
use WeProDev\LaraPanel\Core\User\Dto\GroupDto;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;

class MasterGroupTableSeeder extends Seeder
{
    protected $groups = [];

    public function __construct(private readonly GroupRepositoryInterface $groupRepositoryInterface)
    {
    }

    public function run(): void
    {
        $this->command->info('=================');
        $this->command->info('LaraPanel: Insert Groups Data');
        $this->command->info('Add new group in "database/seeders/GroupSeeder.php"');
        $this->command->info("=================\n");

        foreach ($this->getGroups() as $item) {

            if (! isset($item['name'])) {
                dd('The `name` is required!');
            }

            $parent = null;
            if ($item['parent'] != null) {
                $parent = $this->groupRepositoryInterface->findBy([
                    'name' => $item['name'],
                ])->getId();
            }

            $findGroup = $this->groupRepositoryInterface->findBy([
                'name' => $item['name'],
                'parent_id' => $parent,
            ]);

            $groupDto = GroupDto::make(
                $item['name'],
                $item['title'] ?? $item['name'],
                $parent,
                $item['description'] ?? null
            );

            if ($findGroup) {
                $this->command->info('This group << '.$item['name'].' >> already existed! Updating data ...');
                $this->groupRepositoryInterface->update($findGroup, $groupDto);

                continue;
            }

            $this->command->info('Creating the group <<'.$item['name'].'] >> ...');

            $this->groupRepositoryInterface->create($groupDto);
        }

        $this->command->info("\nThe groups data has been successfully inserted!");
        $this->command->info("=============================================================\n");
    }

    protected function getGroups()
    {
        return $this->groups;
    }
}
