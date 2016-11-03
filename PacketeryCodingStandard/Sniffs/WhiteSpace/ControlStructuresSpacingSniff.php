<?php
class PacketeryCodingStandard_Sniffs_WhiteSpace_ControlStructuresSpacingSniff implements PHP_CodeSniffer_Sniff
{
    const CODE_NOT_ALLOWED = 'notAllowed';

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
                                   'PHP',
                                   'JS',
                                  );

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = true;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_IF,
                T_ELSEIF,
                T_FOREACH,
                T_WHILE,
                T_SWITCH,
                T_FOR,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if($tokens[$stackPtr + 1]['code'] !== T_WHITESPACE) {
            return;
        }

        $fix = $phpcsFile->addFixableError('Whitespaces after control structures are not allowed', $stackPtr + 1, self::CODE_NOT_ALLOWED);

        if ($fix === true) {
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($stackPtr + 1, '');
            while($tokens[$stackPtr + 1] === T_WHITESPACE) {
                $phpcsFile->fixer->replaceToken(++$stackPtr, '');
            }

            $phpcsFile->fixer->endChangeset();
        }//end if

    }//end process()


}//end class
