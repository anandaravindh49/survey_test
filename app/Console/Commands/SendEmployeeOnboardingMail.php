<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\EmployeeOnboardingMail;
use Illuminate\Support\Facades\Mail;

class SendEmployeeOnboardingMail extends Command
{
    protected $signature = 'employees:send-onboarding-mail';
    protected $description = 'Send onboarding mail to new employees';

    public function handle()
    {
        $users = User::where('onboarding_mail_sent', false)->get();
        if ($users->isEmpty()) {
            $this->info('No users found with onboarding_mail_sent = false. Creating an onboarding user.');
            $newUser = User::create([
                'name' => 'Auto Onboard User '.time(),
                'email' => 'autoonboard+'.time().'@example.com',
                'password' => bcrypt('password'),
                'onboarding_mail_sent' => false,
            ]);

            $users = collect([$newUser]);
        }
        foreach ($users as $user) {
            Mail::to($user->email)->send(new EmployeeOnboardingMail($user));
            $user->update(['onboarding_mail_sent' => true]);
        }
        $this->info('Onboarding emails processed: '.$users->count());
    }
}