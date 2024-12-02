<?php

namespace Lib\Services\Import\Importers;

use ORM;
use Lib\Services\Import\Dto\CommentDto;

class CommentsImporter
{
    protected array $actual = [];

    /**
     * @param array<int, CommentDto[]> $postComments
     * @return int Колличество импортированных комментариев
     */
    public function import(array $postComments): int
    {
        foreach ($postComments as $postId => $comments) {
            $this->savePostComments($postId, $comments);
        }
        $this->removeNotActual();
        return count($this->actual);
    }

    protected function commentsTable(): ORM
    {
        return ORM::forTable('comments');
    }

    protected function savePostComments(int $postId, array $comments): void
    {
        foreach ($comments as $comment) {
            $post = ORM::forTable('posts')
                ->where('external_id', $postId)
                ->findOne();
            $this->saveComment($comment, $post);
        }
    }

    protected function saveComment(CommentDto $commentDto, ORM $post): void
    {
        $comment = $this->commentsTable()
            ->where('external_id', $commentDto->id)
            ->findOne();

        $this->actual[] = $comment
            ? $this->update($comment, $commentDto, $post)
            : $this->create($commentDto, $post);

    }

    protected function create(CommentDto $commentDto, ORM $post): int
    {
        $comment = $this->commentsTable()->create([
            'external_id' => $commentDto->id,
            'body' => $commentDto->body,
            'name' => $commentDto->name,
            'email' => $commentDto->email,
            'post_id' => $post->get('id'),
        ]);

        $comment->save();

        return $comment->id();
    }

    protected function update(ORM $comment, CommentDto $commentDto, ORM $post): int
    {
        $comment = $comment->set([
            'body' => $commentDto->body,
            'name' => $commentDto->name,
            'email' => $commentDto->email,
            'post_id' => $post->get('id'),
        ]);

        $comment->save();

        return $comment->id();
    }

    protected function removeNotActual(): void
    {
        $this->commentsTable()->whereNotIn('id', $this->actual)->delete_many();
    }
}