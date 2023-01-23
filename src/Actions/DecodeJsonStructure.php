<?php

namespace Hyperlink\JsonStructure\Actions;

class DecodeJsonStructure
{
    public function __construct(private readonly array $array)
    {
    }

    public function __invoke(): string
    {
        return '['.PHP_EOL.$this->implode_recursive(',', $this->array_keys_r($this->array)).PHP_EOL.']'.PHP_EOL;
    }

    private function implode_recursive(string $separator, array $array, int $indent = 1): string
    {
        $string = '';
        foreach ($array as $i => $a) {
            if (is_array($a)) {
                $string .= (str_repeat('    ', $indent))
                    .'\''
                    .$i
                    .'\''
                    .' => ['
                    .PHP_EOL
                    .$this->implode_recursive($separator, $a, $indent + 1)
                    .PHP_EOL
                    .(str_repeat('    ', $indent))
                    .']';
                $array1 = array_keys($array);
                if ($i !== end($array1)) {
                    $string .= $separator.PHP_EOL;
                }
            } else {
                $string .= (str_repeat('    ', $indent)).'\''.$a.'\'';
                if ($i < count($array) - 1) {
                    $string .= $separator.PHP_EOL;
                }
            }
        }

        return $string;
    }

    private function is_array_of_arrays($array): bool
    {
        if (! is_array($array)) {
            return false;
        }
        foreach ($array as $item) {
            if (! is_array($item)) {
                return false;
            }
        }

        return true;
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
                if (count(array_values($i))) {
                    $keys_array[$idx] = ['*' => $this->array_keys_r(array_values($i)[0])];
                } else {
                    $keys_array[$idx] = ['*' => []];
                }

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
}
