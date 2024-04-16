<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Team;

use Illuminate\Database\Seeder;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;

class MasterTeamTableSeeder extends Seeder
{
    protected $teams = [];

    public function __construct(private readonly TeamRepositoryInterface $teamRepositoryInterface)
    {
    }

    public function run(): void
    {
        $this->command->info('=================');
        $this->command->info('LaraPanel: Insert Teams Data');
        $this->command->info('Add new team in "database/seeders/TeamSeeder.php"');
        $this->command->info("=================\n");

        foreach ($this->getTeams() as $item) {

            if (! isset($item['name'])) {
                dd('The `name` is required!');
            }

            $parent = null;
            if ($item['parent'] != null) {
                $parent = $this->teamRepositoryInterface->findBy([
                    'name' => $item['name'],
                ])->id;
            }

            $findTeam = $this->teamRepositoryInterface->findBy([
                'name' => $item['name'],
                'parent_id' => $parent,
            ]);

            if ($findTeam) {
                $this->command->info('This team << '.$item['name'].' >> already existed! Updating data ...');

                $this->teamRepositoryInterface->update($findTeam->id, [
                    'name' => $item['name'],
                    'title' => $item['title'] ?? $item['name'],
                    'parent_id' => $parent,
                    'description' => $item['description'] ?? null,
                ]);

                continue;
            }

            $this->command->info(
                'Creating the team <<'.$item['name'].'] >> ...'
            );

            $this->teamRepositoryInterface->store([
                'name' => $item['name'],
                'title' => $item['title'] ?? $item['name'],
                'parent_id' => $parent,
                'description' => $item['description'] ?? null,
            ]);
        }

        $this->command->info("\nThe teams data has been successfully inserted!");
        $this->command->info("=============================================================\n");
    }

    protected function getTeams()
    {
        return $this->teams;
    }
}
