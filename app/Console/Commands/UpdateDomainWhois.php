<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\DomainWhois;
use Illuminate\Console\Command;
use App\Services\WhoisService;
use Exception;

class UpdateDomainWhois extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:updatewhois';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info("Updating Domain Whois");
            $this->updateDomainWhois();
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Get list of domains whose status has not been updated in last 24 hours
     * Limit it to 1000 per request as Cloudflare have API Rate Limiting to 1200 calls/min
     */

    public function updateDomainWhois()
    {
        try {
            $domains = Domain::where(function ($query) {
                $query->where('whois_updated_at', null)
                    ->orWhere('whois_updated_at', '>=', now()->subHours(24));
            })->limit(1000)->get();
            foreach ($domains as $domain) {
                $whois = (new WhoisService())->domainWhois($domain['domain']);
                if (isset($whois['domain'])) {
                    DomainWhois::updateOrCreate(['domain_id' => $domain['id']], [
                        'domain_id' => $domain['id'],
                        'registered_on' => isset($domain['created_date']) ? $domain['created_date'] : null,
                        'registrar' => isset($domain['registrar']) ? $domain['registrar'] : null,
                        'domain_age' => isset($domain['created_date']) ? Domain::computeAge($domain['created_date'], date('Y-m-d')) : null,
                        'registrant_country' => isset($domain['registrant_country']) ? $domain['registrant_country'] : null,
                        'nameservers' => isset($domain['nameservers']) ? json_encode($domain['nameservers']) : null,
                        'raw_response' => json_encode($whois),
                    ]);
                }
                $domain->touch('whois_updated_at');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
