<?php

namespace phptemplate\compilers;

abstract class CompilerConfiguration {

    public $configuration = array(
        'COMPILE_CACHE' => false,
        'CACHE_PATH' => '',
        'RAW_TAG_OPEN' => '{!!',
        'RAW_TAG_CLOSE' => '!!}',
        'CONTENT_TAG_OPEN' => '{{',
        'CONTENT_TAG_CLOSE' => '}}',
        'COMMENT_TAG_OPEN' => '{{',
        'COMMENT_TAG_CLOSE' => '}}',
        'ESCAPE_TAG_OPEN' => '{{{',
        'ESCAPE_TAG_CLOSE' => '}}}',
        'STATEMENT_TAG' => '@',
        'ECHO' => 'e', /* This should be a function name */
    );

}
