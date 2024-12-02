<?php

namespace Lib\Services\Import\Importers;

use ORM;
use Lib\Services\Import\Dto\PostDto;

class PostsImporter
{
    protected int $count = 0;
    protected array $actual = [];

    /**
     * @param PostDto[] $posts
     * @return int Колличество импортированных записей
     */
    public function import(array $posts): int
    {
        foreach ($posts as $post) {
            $this->save($post);
        }
        $this->removeNotActual();
        return count($this->actual);
    }

    protected function postsTable(): ORM
    {
        return ORM::forTable('posts');
    }

    protected function save(PostDto $postDto): void
    {
        $post = $this->postsTable()
            ->where('external_id', $postDto->id)
            ->findOne();

        $this->actual[] = $post
            ? $this->update($post, $postDto)
            : $this->create($postDto);

    }

    protected function create(PostDto $postDto): int
    {
        $post = $this->postsTable()->create([
            'external_id' => $postDto->id,
            'title' => $postDto->title,
            'body' => $postDto->body,
            'user_id' => $postDto->userId,
        ]);
        $post->save();

        return $post->id();
    }

    protected function update(ORM $post, PostDto $postDto): int
    {
        $post = $post->set([
            'title' => $postDto->title,
            'body' => $postDto->body,
            'user_id' => $postDto->userId,
        ]);
        $post->save();

        return $post->id();
    }

    protected function removeNotActual(): void
    {
        $this->postsTable()->whereNotIn('id', $this->actual)->delete_many();
    }
}