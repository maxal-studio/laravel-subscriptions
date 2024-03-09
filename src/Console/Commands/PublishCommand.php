<?php

declare(strict_types=1);

namespace MaxAl\Subscriptions\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maxal:publish:subscriptions {--f|force : Overwrite any existing files.} {--r|resource=* : Specify which resources to publish.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish MaxAl Subscriptions Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        collect($this->option('resource') ?: ['maxal-subscriptions-config', 'maxal-subscriptions-migrations'])->each(function ($resource) {
            $this->call('vendor:publish', ['--tag' => "{$resource}", '--force' => $this->option('force')]);
        });

        $this->line('');
    }
}
