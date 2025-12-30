<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
				/**
					* The name and signature of the console command.
					*
					* @var string
					*/
				protected $signature = 'migrate_in_order';

				/**
					* The console command description.
					*
					* @var string
					*/
				protected $description = 'Execute the migrations in the order specified in the file app/Console/Comands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

				/**
					* Execute the console command.
					*/
				public function handle()
				{
								/** Specify the names of the migrations files in the order you want to
									* loaded
									* $migrations =[
									*               'xxxx_xx_xx_000000_create_nameTable_table.php',
									*    ];
									*/
								$migrations = [
									'0001_01_01_000000_create_users_table.php', '0001_01_01_000001_create_cache_table.php', '0001_01_01_000002_create_jobs_table.php', '2024_07_22_031159_create_guest_books_table.php', '2024_07_22_031204_create_requests_table.php', '2024_07_24_031538_create_feedback_table.php'];

								foreach ($migrations as $migration) {
												$basePath = 'database/migrations/';
												$migrationName = trim($migration);
												$path = $basePath . $migrationName;
												$this->call('migrate', [
																'--path' => $path,
												]);
								}
				}
}
