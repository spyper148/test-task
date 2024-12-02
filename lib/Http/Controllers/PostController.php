<?php

namespace Lib\Http\Controllers;

use ORM;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostController
{
    public function search(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $comment = $request->getQueryParams()['comment'] ?? null;

        $data = [
            'comments' => [],
            'query' => $comment
        ];

        if (!empty($comment)) {
            $data['comments'] = ORM::forTable('comments')
                ->select('posts.title', 'post_title')
                ->select('comments.body', 'comment_body')
                ->join('posts', ['posts.id', '=', 'comments.post_id'])
                ->whereRaw("to_tsvector(comments.body) @@ to_tsquery(:comment)", [
                    'comment' => $request->getQueryParams()['comment'] . ':*'
                ])
                ->find_many();
        }

        return view($response, 'index.phtml', $data);
    }
}
