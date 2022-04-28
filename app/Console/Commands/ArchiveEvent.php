<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Event;

class ArchiveEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:archive-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update event as completed if event end date is expired';

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
        $this->archiveEvents();      
    }

    public function archiveEvents() {
        $currentDateTime = Carbon::now()->toDateTimeString();
		$archivedEvent = Event::where('end_datetime', '<', $currentDateTime)->update(['status'=>'archived']);
        echo true; 
    }
}
