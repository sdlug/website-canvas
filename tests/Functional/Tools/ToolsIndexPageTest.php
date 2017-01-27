<?php

class ToolsIndexPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_refresh_the_tools_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tools')
            ->click('Refresh Tools');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/tools');
    }

    /** @test */
    public function it_can_clear_the_application_cache()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tools')
            ->click('Clear Cache');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/tools');
    }

    /** @test */
    public function it_can_enable_maintenance_mode()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tools')
            ->press('maintenance_mode')
            ->assertSessionMissing('errors');
        $this->seePageIs('/admin/tools');
        $this->see('Success! The application is now in maintenance mode.');
    }

    /** @test */
    public function it_displays_the_503_maintenance_mode_page_while_app_is_down()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(503, $response->status());
    }

    /** @test */
    public function it_can_disable_maintenance_mode()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tools')
            ->press('maintenance_mode')
            ->assertSessionMissing('errors');
        $this->seePageIs('/admin/tools');
        $this->see('Success! The application is now in active mode.');
    }

    /** @test */
    public function it_removes_the_503_maintenance_mode_page_while_app_is_up()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_download_the_archive_data()
    {
        $this->actingAs($this->user)->visit('/admin/tools')->see('Download Archive');
    }

    /** @test */
    public function it_cannot_access_the_tools_page_if_user_is_not_an_admin()
    {
        $this->user['role'] = 0;
        $this->actingAs($this->user)->visit('/admin/tools');
        $this->seePageIs('/admin');
        $this->assertSessionMissing('errors');
    }
}
