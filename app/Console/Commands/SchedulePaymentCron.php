<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Contract;
use App\Models\Domain;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SchedulePaymentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SchedulePayment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send mail to the lesse for the payment';

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
        try {
            Log::info('Starting DocusignKeyUpdate command.');
            $todayTime = \Carbon\Carbon::now()->format('Y-m-d H:i');

            $contracts = Contract::get();

            foreach ($contracts as $key => $contract) {
                if (!empty($contract->payment_due_date)) {

                    $futureContractTime = \Carbon\Carbon::parse($contract->payment_due_date)->subHours(24)->format('Y-m-d H:i');

                    $contractTime = \Carbon\Carbon::parse($contract->payment_due_date)->format('Y-m-d H:i');

                    if ($futureContractTime == $todayTime) {
                        $domainName = Domain::where('id', $contract->domain_id)->first()->domain;
                        $user = User::where('id', $contract->lessee_id)->first();
                        $scheduleSends[$key]['user_id'] = $contract->lessee_id;
                        $scheduleSends[$key]['period_payment'] = $contract->period_payment;
                        $scheduleSends[$key]['contract_id'] = $contract->contract_id;
                        $scheduleSends[$key]['domain_id'] = $contract->domain_id;
                        $scheduleSends[$key]['domain_name'] = $domainName;
                        $scheduleSends[$key]['user_email'] = $user->email;
                        $scheduleSends[$key]['user_name'] = $user->name;
                        $scheduleSends[$key]['date'] = $todayTime;
                    } else if ($contractTime == $todayTime) {
                        $domainName = Domain::where('id', $contract->domain_id)->first()->domain;
                        $user = User::where('id', $contract->lessee_id)->first();
                        $missedPayments[$key]['domain_name'] = $domainName;
                        $missedPayments[$key]['user_email'] = $user->email;
                        $missedPayments[$key]['user_name'] = $user->name;
                        $missedPayments[$key]['payment_due_date'] = $contractTime;
                        $missedPayments[$key]['contract_id'] = $contract->contract_id;
                        $missedPayments[$key]['period_payment'] = $contract->period_payment;
                        Contract::where('contract_id', $contract->contract_id)->update(['contract_status_id' => 0]);
                    }
                }
            }

            if (isset($scheduleSends)) {
                foreach ($scheduleSends as $scheduleSend) {
                    Log::info('schedule send email');
                    // Mail to the user to pay there lease
                    Mail::send('emails.schedule-send', ['scheduleSend' => $scheduleSend], function ($m) use ($scheduleSend) {
                        $m->from(\App\Models\Option::get_option('admin_email'), \App\Models\Option::get_option('site_title'));
                        $m->to($scheduleSend['user_email'])->subject('Lease Payment Received for ' . $scheduleSend['domain_name'] . '');
                    });
                }
            } else if (isset($missedPayments)) {
                foreach ($missedPayments as $missedPayment) {
                    Log::info('Missed payment email');
                    // mail to the user when they forget to pay the lease
                    Mail::send('emails.missed-payment', ['missedPayment' => $missedPayment], function ($m) use ($missedPayment) {
                        $m->from(\App\Models\Option::get_option('admin_email'), \App\Models\Option::get_option('site_title'));
                        $m->to($missedPayment['user_email'])->subject('Rent for ' . $missedPayment['domain_name'] . ' is Past Due');
                    });
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage() . ' ' . 'at line number' . ' ' . $e->getline() . ' ' . 'in file name' . ' ' . $e->getFile());
        }
    }
}
