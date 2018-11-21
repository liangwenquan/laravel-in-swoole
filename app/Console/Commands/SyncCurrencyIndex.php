<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;

class SyncCurrencyIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:currency_index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync currency model into elasticsearch';

    protected $mCurrency;

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
        $currencies = Currency::where('id', '<', 200)->get();
        $currencies->addToIndex();

//        Currency::deleteIndex();

        var_dump($currencies->toArray());
    }
}
