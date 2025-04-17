<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\System\Database\Seeders\RegionSeeder;
use Modules\System\Database\Seeders\SystemAdminSeeder;
use Modules\System\Database\Seeders\SystemConfigSeeder;
use Modules\System\Database\Seeders\SystemMenuSeeder;
use Modules\System\Database\Seeders\SystemRoleSeeder;
use Nwidart\Modules\Facades\Module;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemAdminSeeder::class);
        $this->call(SystemConfigSeeder::class);
        $this->call(SystemMenuSeeder::class);
        $this->call(SystemRoleSeeder::class);
        $this->call(RegionSeeder::class);

        $this->runModuleSeeder();
    }

    /**
     * 运行模块自定义数据填充
     */
    protected function runModuleSeeder()
    {
        $modules = json_decode(file_get_contents(base_path('modules_statuses.json')), true);

        foreach ($modules as $name => $value) {

            if ($value) {

                if (file_exists(module_path($name, "Database/Seeders/{$name}DatabaseSeeder.php"))) {

                    $this->call("Modules\\{$name}\Database\Seeders\\{$name}DatabaseSeeder");
                }
            }
        }
    }
}
