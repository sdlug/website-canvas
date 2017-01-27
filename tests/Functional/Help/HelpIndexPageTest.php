<?php

class HelpIndexPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_refresh_the_user_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/help')
            ->click('Refresh Help');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/help');
    }
}
