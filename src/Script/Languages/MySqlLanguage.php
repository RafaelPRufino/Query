<?php

/**
 * Script Language
 * PHP version 7.4
 *
 * @category Language
 * @package  Punk\Query\Script
 * @author   Rafael Pereira <rafaelrufino>
 * @license  http://www.gnu.org/copyleft/gpl.html GPL
 * @link     https://github.com/RafaelPRufino/QueryPHP
 */

namespace Punk\Query\Script\Languages;

use \Punk\Query\Script\Builder;
use \Punk\Query\Script\Expression;
use \Punk\Query\Script\Clauses\Where;
use \Punk\Query\Utils\Arr;

class MySqlLanguage extends Language {

    public function __construct() {
        $this->escape_char = "`";
        $this->end_char = '';
    }

    /**
     * Extrai a Paginação
     * @param  string $abstract Expressão
     * @return string
     */
    public function extractPagination(Builder $query, int $limitForPage, int $numberPage) {
        $currentpage = ($numberPage - 1) * $limitForPage;
        return new Expression(" limit " . $currentpage . " , " . $limitForPage);
    }

    /**
     * Faz a compilacão da Expressão Like da Clausula Where 
     * @param  Builder  $query QueryBuilder
     * @return string
     */
    protected function compileExpressionWhereLike(Where $where, bool $first) {
        $column = $where->getColumn();
        $operator = $where->getOperator();
        $boolean = $where->getBoolean();
        $assoc = $where->isAssociationColumn();
        $parameters = $where->getParameters();
        $parameters_values = $where->getBindings();

        return ($first ? '' : ' ' . $boolean . ' ') .
                ($assoc ? $column : $this->dymamicResolveGrammar($column))
                . (' ' . $operator . ' ')
                . (" CONCAT('%', " . $this->concatenate(Arr::map($parameters, function ($parameter)use($parameters_values) {
                            return !is_int($parameters_values[$parameter]) && $parameters_values[$parameter] == null ? '' : (Arr::is_association($parameter) ? $parameter : ' ?');
                        }), ' ') . ", '%')");
    }

}
