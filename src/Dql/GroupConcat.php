<?php

namespace App\Dql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * "GroupConcat" "(" {StateFieldPathExpression }")"
 */
class GroupConcat extends FunctionNode {

    public  $firstElement = "";

    public function parse(\Doctrine\ORM\Query\Parser $parser) {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstElement = $parser->StateFieldPathExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {

        $query = " GROUP_CONCAT(" . $this->firstElement->dispatch($sqlWalker) . ")";

        return $query;
    }

}
