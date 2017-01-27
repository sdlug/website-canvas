<?php

class PostCreatePageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser, TestHelper;

    /** @test */
    public function it_can_press_cancel_to_return_to_the_post_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/post/create')
            ->click('Cancel');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/post');
    }

    /** @test */
    public function it_validates_the_post_create_form()
    {
        $this->callRouteAsUser('admin.post.store', null, ['title' => 'example'])
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_create_a_post_and_save_it_to_the_database()
    {
        $data = [
            'id'            => 2,
            'user_id'       => 1,
            'title'         => 'example',
            'slug'          => 'foo',
            'subtitle'      => 'bar',
            'content'       => 'FooBar',
            'published_at'  =>  Carbon\Carbon::now(),
            'layout'        => config('blog.post_layout'),
        ];

        $this->callRouteAsUser('admin.post.store', null, $data)
            ->seePostInDatabase(['title' => 'example', 'content_raw' => 'FooBar', 'content_html' => '<p>FooBar</p>'])
            ->seeInSession('_new-post', trans('messages.create_success', ['entity' => 'post']))
            ->assertRedirectedTo('admin/post/2/edit')
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
