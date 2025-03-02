<?php

namespace Database\Seeders;

use App\Models\PlatformType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    const __PLATFORM_TYPES__ = [
        [ 'platform_type_id' => 1, 'name' => 'Console' ],
        [ 'platform_type_id' => 2, 'name' => 'Arcade' ],
        [ 'platform_type_id' => 3, 'name' => 'Platform' ],
        [ 'platform_type_id' => 4, 'name' => 'Operating_system' ],
        [ 'platform_type_id' => 5, 'name' => 'Portable_console' ],
        [ 'platform_type_id' => 6, 'name' => 'Computer' ]
    ];
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::__PLATFORM_TYPES__ as $platformsType) {
            try {
                PlatformType::create($platformsType);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }
    }
}
