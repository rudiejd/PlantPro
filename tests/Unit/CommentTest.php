<?php

namespace Tests\Unit;
use App\Plant;
use App\PlantSubmission;
use App\User;
use App\Comment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase {
    
    use DatabaseMigrations;

    public function setUp(): void {
        parent::setUp();
    }

    private function makeComment() {
        $user = factory(User::class)->make();
        $user->save();
        $plant = factory(Plant::class)->make();
        $plant->save();
        $submission = factory(PlantSubmission::class)->make();
        $submission->save();
        $comment = factory(Comment::class)->make();

        return $comment;
    }


    public function testCreateComment() {
        $comment = $this->makeComment();
        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertTrue($comment->save());
        $comment->delete();
    }

    public function testReadComment() {
        $comment = $this->makeComment();
        $comment->save();
        $this->assertNotNull(Comment::find(1));
        $comment->delete();
    }

    public function testUpdateComment() {
        $comment = $this->makeComment();
        $comment->save();
        $comment->body = 'this is a comment test';
        $comment->save();
        $this->assertEquals(Comment::first()['body'], 'this is a comment test');
        $comment->delete();
    }

    public function testDeleteComment() {
        $comment = $this->makeComment();
        $comment->save();
        $this->assertTrue($comment->delete());
    }
}
