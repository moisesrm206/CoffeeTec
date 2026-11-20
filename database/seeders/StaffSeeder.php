<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    /**
     * Create the first administrator account.
     *
     * Configure STAFF_ADMIN_EMAIL and STAFF_ADMIN_PASSWORD in .env to choose
     * the credentials; otherwise a random password is generated and printed.
     */
    public function run(): void
    {
        $email = (string) config('staff.admin.email');
        $password = (string) (config('staff.admin.password') ?: Str::password(12));

        $user = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => (string) config('staff.admin.name'),
                'password' => $password,
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ],
        );

        if ($user->wasRecentlyCreated) {
            $this->command?->info('Cuenta de administrador creada.');
            $this->command?->line("  Correo:     {$email}");
            $this->command?->line("  Contraseña: {$password}");
            $this->command?->warn('Cambia la contraseña desde "Mi cuenta" después del primer acceso.');
        } else {
            $this->command?->info("La cuenta {$email} ya existe; no se modificó.");
        }
    }
}
