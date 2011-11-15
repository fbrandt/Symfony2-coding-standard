<?php
/**
 * This sniff detects missing blank lines before return statements.
 *
 * It verifies that either
 * <ul>
 *  <li>there is a blank line before a return statement or</li>
 *  <li>the return statement is the only statement inside a block</li>
 * </ul>
 *
 * @package   PHP_CodeSniffer
 * @author    Felix Brandt <mail@felixbrandt.de>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Symfony2_Sniffs_WhiteSpace_BlankLineBeforeReturnSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens we want to listen for (T_RETURN)
     *
     * @return array
     */
    public function register()
    {
        return array(T_RETURN);
    } // end register()

    /**
     * Processes this test, when one of its tokens is encountered.
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $line = $tokens[$stackPtr]['line'];

        $blankLinePresent =  $tokens[$stackPtr - 3]['code'] === T_WHITESPACE &&
                             $tokens[$stackPtr - 3]['line'] == $line - 2;

        $onlyStatement = $tokens[$stackPtr - 3]['code'] == T_OPEN_CURLY_BRACKET &&
                         $tokens[$stackPtr - 3]['line'] == $line - 1;

        if (!$blankLinePresent && !$onlyStatement) {
            $error = 'Neither blank line before return nor the only statement';
            $phpcsFile->addError($error, $stackPtr, 'LoneReturn');
        }

    } // end process()

} // end class

?>
