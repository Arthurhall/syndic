<?php

namespace Syndic\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SyndicCommentBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSCommentBundle';
    }
}
