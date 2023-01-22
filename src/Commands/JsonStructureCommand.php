<?php

namespace Hyperlink\JsonStructure\Commands;

use Hyperlink\JsonStructure\Actions\DecodeJsonStructure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class JsonStructureCommand extends Command
{
    public $signature = 'json:structure
                         {endpoint? : The api route name to get the json structure from}';
//                         {array?* : The array to get the json structure from}';

    public $description = 'Converts a json structure to an array with the json keys';

    public function handle(): int
    {
        $this->info('Starting json structure command...');

//        if ($this->argument('endpoint')) {
        $this->info('Getting json structure from endpoint...');
        $response = Http::get(route($this->argument('endpoint')));

        if ($response->failed()) {
            $this->error('Could not get json structure from endpoint');

            return Command::FAILURE;
        }
        $this->comment('Getting json structure from endpoint successful');

        $json = $response->json();
//        } else {
//            $this->info('Getting json structure from array...');
//
//            $json = $this->argument('array');
//        }

        if (is_null($json)) {
            $this->error('The json structure is null');

            return Command::FAILURE;
        }

        $this->info('Attempting to decode json structure...');
        $result = call_user_func(new DecodeJsonStructure($json));
        $this->comment('Decoding json structure successful');

        $this->info('Writing result to file...');
        Storage::disk('local')->put('json_structure.txt', $result);
        $this->comment('Writing result to file successful');

        return self::SUCCESS;
    }
}
