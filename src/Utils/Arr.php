<?php

/**
 * Arr
 * PHP version 7.4
 *
 * @category Utils
 * @package  Punk\Query
 * @author   Rafael Pereira <rafaelrufino>
 * @license  http://www.gnu.org/copyleft/gpl.html GPL
 * @link     https://github.com/RafaelPRufino/QueryPHP
 */

namespace Punk\Query\Utils;

class Arr {

    /**
     * Retorna a chave do primeiro elemento do Array
     * @param array $array array fonte da procura
     * @return string|int|mixed
     * */
    public static function key_first(Array $array) {
        return array_key_first($array);
    }

    /**
     * Verificar se uma chave existe no array
     * @param int|string $key chave procurada
     * @param array $array array fonte da procura
     * @return bool
     * */
    public static function key_exists($key, Array $array): bool {
        return array_key_exists($key, $array);
    }

    /**
     * Verificar se um valor existe no array
     * @param int|string|mixed $value valor procurado
     * @param array $array array fonte da procura
     * @return bool
     * */
    public static function in_array($value, Array $array) {
        return in_array($value, $array);
    }

    /**
     * Verificar se um array é associativo
     * @param array $array array fonte da procura
     * @return bool
     * */
    public static function array_is_association(Array $array): bool {
        return static::is_association(static::key_first($array));
    }

    /**
     * Verificar se uma chave do array é associativa
     * @param string|int $key chave
     * @return bool
     * */
    public static function is_association($key): bool {
        return !is_int($key);
    }

    /**
     * Cria um array com o range informado
     * @param int $start posição inicial
     * @param int $end posição final
     * @return array
     * */
    public static function range(int $start = 1, int $end = 10): array {
        return array_keys(array_fill($start, $end, "range"));
    }

    /**
     * Map de array
     * @param array|mixed $array array onde será realizado o MAP
     * @param Closure $callback callback a cada interação do array
     * @return array
     * */
    public static function map($array, $callback): Array {
        $index = -1;
        $first = true;
        $map = [];

        foreach (static::toArray($array) as $key => $value) {
            $index = $index + 1;
            $first = $index <= 0 ? true : false;
            $map[$key] = $callback($value, $key, $index);
        }

        return $map;
    }

    /**
     * Retorna o valor de um determinada posição do array
     * @param array|mixed $array array onde será realizado a busca
     * @param int $find_index posição buscada
     * @return midex
     * */
    public static function findByIndex($array, int $find_index) {
        $index = -1;
        foreach (static::toArray($array) as $key => $value) {
            $index = $index + 1;
            if ($find_index === $index) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Realiza a combinação entre dois array
     * @param array|mixed $source
     * @param array|mixed $destiny
     * @return array
     * */
    public static function combineArray($source, $destiny) {
        $response = array();

        $value1 = self::toArray($source);
        $value2 = self::toArray($destiny);

        foreach ($value1 as $key => $value) {
            if (!static::is_association($key)) {
                $response[] = $value;
            } else {
                $response[$key] = $value;
            }
        }

        foreach ($value2 as $key => $value) {
            if (!static::is_association($key)) {
                $response[] = $value;
            } else {
                $response[$key] = $value;
            }
        }

        return $response;
    }

    /**
     * Realiza a combinação entre um array e valor
     * @param array|mixed $source
     * @param array|mixed $value
     * @return array
     * */
    public static function pushArray($source, $value) {
        $response = array();

        $value1 = self::toArray($source);

        foreach ($value1 as $value1_to) {
            $response [] = $value1_to;
        }

        $response [] = $value;

        return $response;
    }

    /**
     * Transforma qualquer valor recebido em array
     * @param array|mixed $value 
     * @return array
     * */
    public static function toArray($value): Array {
        if (is_array($value) == false) {
            if ($value) {
                return array($value);
            } else {
                return array();
            }
        }
        return $value;
    }

    /**
     * Efetua pesquisa em um array
     * @param array|mixed $array array onde será realizado a pesquisa
     * @param Closure $callback callback a cada interação do array
     * @return array
     * */
    public static function queryBy($array, $callback): Array {
        $response = array();
        $index = 0;
        foreach (static::toArray($array) as $key => $value) {
            $index = $index + 1;
            if ($callback($value, $key, $index)) {
                if (static::is_association($key)) {
                    $response[$key] = $value;
                } else {
                    $response[] = $value;
                }
            }
        }

        return $response;
    }

    /**
     * Preenche um objeto com as propriedades de um array
     * @param array|mixed $data array de onde será pego os valores
     * @param mixed $target objeto alvo
     * @return array
     * */
    public static function fillData(Array $data, &$target) {
        foreach ($data AS $key => $value) {
            if (static::is_association($key)) {
                $target->{$key} = $value;
            }
        }
    }

    /**
     * Transforma um array multidimenssional em array normal
     *
     * @param  iterable  $array 
     * @return array
     */
    public static function flatten($array) {
        $merged = array();
        foreach ($array as $item) {
            if (!is_array($item)) {
                $merged[] = $item;
            } else {
                $merged = Arr::combineArray($merged, $item);
            }
        }
        return $merged;
    }

    /**
     * Retorna a primeira possição de um array
     *
     * @param  array|mixed  $array 
     * @return array
     */
    public static function first($array) {
        $return = static::toArray($array);
        return array_shift($return);
    }
}
