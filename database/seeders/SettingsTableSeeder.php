<?php

namespace Database\Seeders;

use App\Services\SettingService;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class SettingsTableSeeder
 * @package Database\Seeder
 */
class SettingsTableSeeder extends Seeder
{
    use HasTimestamps;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = app(SettingService::class)->getDefaultSettingsList();
        $items = [];

        foreach ($data as $key => $value) {
            $items[] = [
                'key' => $key,
                'value' => $value,
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            ];
        }

        DB::table('settings')->insert($items);
    }
}
