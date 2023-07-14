<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'crescent:auth:permission {name} {--R|remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding Permission In Database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissions = $this->generatePermissions();

        if ($this->option('remove')) {
            if (Permission::where('name', 'LIKE', '%'.$this->getNameArgument())->delete()) {
                $this->warn('Permissions '.implode(', ', $permissions).' deleted.');
            } else {
                $this->warn('No permissions for '.$this->getNameArgument().' found!');
            }
        } else {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            $this->info('Permissions '.implode(', ', $permissions).' created.');
        }

        // sync role for admin
        if ($role = Role::where('name', 'admin')->first()) {
            $role->syncPermissions(Permission::all());
            $this->info('Adding Permission In Database');
        }
    }

    private function generatePermissions()
    {
        $abilities = ['view', 'add', 'edit', 'delete'];
        $name = $this->getNameArgument();

        return array_map(function ($val) use ($name) {
            return $val.'_'.$name;
        }, $abilities);
    }

    private function getNameArgument()
    {
        return strtolower(str_plural($this->argument('name')));
    }
}
