<?php

class TagCreatePageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_press_cancel_to_return_to_the_tag_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tag/create')
            ->click('Cancel');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/tag');
    }

    /** @test */
    public function it_validates_the_tag_create_form()
    {
        $this->actingAs($this->user)->post('admin/tag', ['title' => 'example']);
        $this->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_create_a_tag_and_save_it_to_the_database()
    {
        $this->actingAs($this->user)->post('admin/tag', [
            'tag'               => 'example',
            'title'             => 'foo',
            'subtitle'          => 'bar',
            'meta_description'  => 'FooBar',
            'layout'            => config('blog.tag_layout'),
            'reverse_direction' => 0,
        ]);

        $this->seeInDatabase(CanvasHelper::TABLES['tags'], [
            'tag'               => 'example',
            'title'             => 'foo',
            'subtitle'          => 'bar',
            'meta_description'  => 'FooBar',
            'layout'            => config('blog.tag_layout'),
            'reverse_direction' => 0,
        ]);

        $this->assertSessionHas('_new-tag', trans('messages.create_success', ['entity' => 'tag']));
        $this->assertRedirectedTo('admin/tag');
    }
}
