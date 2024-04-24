<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Group;

use Illuminate\Database\Seeder;
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
                ])->id;
            }

            $findGroup = $this->groupRepositoryInterface->findBy([
                'name' => $item['name'],
                'parent_id' => $parent,
            ]);

            if ($findGroup) {
                $this->command->info('This group << '.$item['name'].' >> already existed! Updating data ...');

                $this->groupRepositoryInterface->update($findGroup->id, [
                    'name' => $item['name'],
                    'title' => $item['title'] ?? $item['name'],
                    'parent_id' => $parent,
                    'description' => $item['description'] ?? null,
                ]);

                continue;
            }

            $this->command->info(
                'Creating the group <<'.$item['name'].'] >> ...'
            );

            $this->groupRepositoryInterface->store([
                'name' => $item['name'],
                'title' => $item['title'] ?? $item['name'],
                'parent_id' => $parent,
                'description' => $item['description'] ?? null,
            ]);
        }

        $this->command->info("\nThe groups data has been successfully inserted!");
        $this->command->info("=============================================================\n");
    }

    protected function getGroups()
    {
        return $this->groups;
    }
}
