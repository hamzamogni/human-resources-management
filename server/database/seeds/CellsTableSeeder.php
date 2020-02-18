<?php

use Illuminate\Database\Seeder;

class CellsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Cell::class, 10)
            ->create()
            ->each(function ($cell) {
                $cell->children()->createMany(
                    factory(App\Cell::class, 3)->make()->toArray()
                );
            });
    }
}
