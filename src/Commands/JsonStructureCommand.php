<?php

namespace Hyperlink\JsonStructure\Commands;

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
        $result = '[' . PHP_EOL . $this->implode_recursive(',', $this->array_keys_r($json)) . PHP_EOL . ']' . PHP_EOL;
        $this->comment('Decoding json structure successful');

        $this->info('Writing result to file...');
        Storage::disk('local')->put('json_structure.txt', $result);
        $this->comment('Writing result to file successful');

        return self::SUCCESS;
    }

    private function array_keys_r($array): array
    {
        $keys = array_keys($array);
        $keys_array = [];

        foreach ($array as $idx => $i) {
            if ($this->is_array_of_arrays($i)) {
                if ($index = array_search($idx, $keys, true)) {
                    unset($keys[$index]);
                }
                $keys_array[$idx] = ['*' =>  $this->array_keys_r(array_values($i)[0])];
                continue;
            }
            if (is_array($i)) {
                if ($index = array_search($idx, $keys, true)) {
                    unset($keys[$index]);
                }
                $keys_array[$idx] = $this->array_keys_r($i);
            }
        }

        return array_merge(array_values($keys), $keys_array);
    }

    private function implode_recursive(string $separator, array $array, int $indent = 1): string
    {
        $string = '';
        foreach ($array as $i => $a) {
            if (is_array($a)) {
                $string .= (str_repeat('    ', $indent))
                    . '\''
                    . $i
                    . '\''
                    . ' => ['
                    . PHP_EOL
                    . $this->implode_recursive($separator, $a, $indent + 1)
                    . PHP_EOL
                    . (str_repeat('    ', $indent))
                    . ']';
                $array1 = array_keys($array);
                if ($i !== end($array1)) {
                    $string .= $separator . PHP_EOL;
                }
            } else {
                $string .= (str_repeat('    ', $indent)) . '\'' . $a . '\'';
                if ($i < count($array) - 1) {
                    $string .= $separator . PHP_EOL;
                }
            }
        }

        return $string;
    }

    private function is_array_of_arrays($array): bool
    {
        if (!is_array($array)) {
            return false;
        }
        foreach ($array as $item) {
            if (!is_array($item)) {
                return false;
            }
        }
        return true;
    }
}
