<?php

namespace App\Dql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * "DIV" "(" {StateFieldPathExpression },  InParameter  ")"
 */
class Divide extends FunctionNode {

    public  $firstElement = "";
    public  $secondElement = "";

    public function parse(\Doctrine\ORM\Query\Parser $parser) {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstElement = $parser->StateFieldPathExpression();
        $parser->match(Lexer::T_COMMA);
        $this->secondElement = $parser->simpleArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {

        $query = "( " . $this->firstElement->dispatch($sqlWalker) .
            " DIV " . $this->secondElement->dispatch($sqlWalker) . " )";

        return $query;
    }

}
