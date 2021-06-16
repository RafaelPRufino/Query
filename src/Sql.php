<?php

namespace Punk\Query;

use \Punk\Query\Connections\ConnectionInterface;

class Sql {

    public static Database $instance;
    
    protected static array $observables = [];

    /**
     * Configura conexão com banco de dados.
     *
     * @param  array  $configuration
     * @return Void
     */
    public static function setConnection(Array $configuration): void {
        static::$instance = new Database($configuration);
    }

    public static function extend($class): void {
        static::$observables [] = $class;
        if(!empty(static::$instance)){
            static::$instance->config(static::$observables);
        }
    }

    /**
     * retorna conexão com banco de dados.
     *
     * @return ConnectionInterface
     */
    public static function connection(): ConnectionInterface {
        return static::$instance->connection();
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters) {
        return static::connection()->$method(...$parameters);
    }

}
