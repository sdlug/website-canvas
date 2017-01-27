<?php

class MediaIndexPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_refresh_the_media_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/upload')
            ->click('Refresh Media');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/upload');
    }
}
