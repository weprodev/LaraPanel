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

    protected function getTeams()
    {
        return $this->teams;
    }

    public function run(): void
    {

        $this->command->info(
            '============================================================='
        );
        $this->command->info(
            '              USER MODULE: INSERT DEPARTMENTS DATA'
        );
        $this->command->info(
            '============================================================='
        );
        $this->command->info("\n");

        foreach ($this->getTeams() as $item) {
            $parent = null;
            if ($item['parent'] != null) {
                $parent = $this->teamRepositoryInterface->findBy([
                    'title' => $item['title'],
                ])->id;
            }

            $findDepartment = $this->teamRepositoryInterface->findBy([
                'title' => $item['title'],
                'parent_id' => $parent,
            ]);

            if ($findDepartment) {
                $this->command->info(
                    'THIS DEPARTMENT << '.
                        $item['title'].
                        '] >> EXISTED! UPDATING DATA ...'
                );

                $this->teamRepositoryInterface->update($findDepartment->id, [
                    'title' => $item['title'],
                    'parent_id' => $parent,
                ]);

                continue;
            }

            $this->command->info(
                'CREATING THIS DEPARTMENT <<'.$item['title'].'] >> ...'
            );

            $this->teamRepositoryInterface->store([
                'title' => $item['title'],
                'parent_id' => $parent,
            ]);
        }

        $this->command->info("\n");
        $this->command->info(
            '============================================================='
        );
        $this->command->info(
            '              INSERTING DEPARTMENTS DATA FINALIZED!'
        );
        $this->command->info(
            '============================================================='
        );
        $this->command->info("\n");
    }
}
