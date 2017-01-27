<?php

class PostEditPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser, TestHelper;

    /** @test */
    public function it_can_edit_posts()
    {
//        $this->callRouteAsUser('admin.post.edit', 1)
//            ->submitForm('Update', ['title' => 'Foo'])
//            ->see('Success! Post has been updated')
//            ->see('Foo')
//            ->seePostInDatabase();
//        $this->actingAs($this->user)
//            ->visit('/admin/post/1/edit')
//            ->type('NewTitle', 'title')
//            ->press('action');
    }

    /** @test */
    public function it_can_preview_a_post()
    {
        $this->callRouteAsUser('admin.post.edit', 1)
            ->click('permalink')
            ->seePageIs('blog/post/hello-world')
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function it_can_delete_a_post_from_the_database()
    {
        $this->callRouteAsUser('admin.post.edit', 1)
            ->press('Delete Post')
            ->see($this->getDeleteMessage())
            ->dontSeePostInDatabase(1)
            ->assertSessionMissing('errors');
    }

    /**
     * Get the post deletion success message.
     *
     * @return string
     */
    protected function getDeleteMessage()
    {
        return 'Success! Post has been deleted.';
    }
}