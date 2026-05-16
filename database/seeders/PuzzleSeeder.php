<?php
// File: database/seeders/PuzzleSeeder.php
namespace Database\Seeders;

use App\Models\PuzzleSet;
use App\Models\PuzzleFragment;
use Illuminate\Database\Seeder;

class PuzzleSeeder extends Seeder
{
    public function run(): void
    {
        $sets = PuzzleSet::factory(5)->create();

        foreach ($sets as $set) {
            for ($i = 1; $i <= 7; $i++) {
                PuzzleFragment::create([
                    'puzzle_set_id' => $set->id,
                    'name' => "Fragment {$i}",
                    'number' => $i,
                    'rarity' => $i === 7 ? 'legendary' : 'common',
                ]);
            }
        }
    }
}