<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use File;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cree una copia del volcado mysql para la base de datos existente.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        // Cree una carpeta de respaldo y configura el permiso si no existe.
        $storageAt = public_path() . "/app/backup/";
        if(!File::exists($storageAt)) {
            File::makeDirectory($storageAt, 0755, true, true);
        }
        $command = "".env('DB_DUMP_PATH', 'mysqldump')." --column-statistics=0 --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . $storageAt . $filename;
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);
    }
}
