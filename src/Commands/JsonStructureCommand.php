<?php

namespace Hyperlink\JsonStructure\Commands;

use Illuminate\Console\Command;

class JsonStructureCommand extends Command
{
    public $signature = 'laravel-json-structure';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
