<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class InitializeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize this application including creating admin account';

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
     * @return mixed
     */
    public function handle()
    {
        $password = $this->secret('Enter pass \'survey-app\' in order to do this !');
        if($password === "survey-app"){

            $this->question("This will delete all the database current data");
            if ($this->confirm('Do you wish to continue?')) {

                $this->line("[*] As you wish ...\n");

                $bar = $this->output->createProgressBar(2);
                $bar->start();
        
                $this->line("\n\n[*] Deleting tables (if any) & Creating new tables\n");
                $this->callSilent('migrate:fresh');
                $bar->advance();

                $this->line("\n\n[*] Creating admin acount\n");
                $email = $this->ask('> What is the email for admin account ?');
                $password = $this->ask('> What is the password for admin account ?');
                $rep_password = $this->ask('> Repeat the password for validation !');

                if($password !== $rep_password) {

                    $this->error('[*] Password didn\'t match !');

                } else {

                    User::create([
                        'name' => 'Admin',
                        'email' => $email,
                        'type' => 'admin',
                        'password' => Hash::make($password),
                    ]);
                    $bar->advance();
    
                    $bar->finish();
                    $this->info("\n\n[*] Initialization completed successfully\n");
                }
            }
        }
    }
}
