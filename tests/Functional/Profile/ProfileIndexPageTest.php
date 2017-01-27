<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileIndexPageTest extends TestCase
{
    use DatabaseMigrations, CreatesUser;

    protected $optionalFields = [
        'bio' => 'Summary',
        'gender' => '<dt>Gender</dt>',
        'birthday' => '<dt>Birthday</dt>',
        'relationship' => '<dt>Relationship Status</dt>',
        'phone' => '<dt>Mobile Phone</dt>',
        'twitter' => '<dt>Twitter</dt>',
        'facebook' => '<dt>Facebook</dt>',
        'github' => '<dt>GitHub</dt>',
        'linkedin' => '<dt>LinkedIn</dt>',
        'resume_cv' => '<dt>Resume/CV</dt>',
        'url' => '<dt>Website</dt>',
        'address' => '<dt>Address</dt>',
        'city' => '<dt>City</dt>',
        'country' => '<dt>Country</dt>',
    ];

    protected $requiredFields = [
        'first_name',
        'last_name',
        'display_name',
        'email',
    ];

    public function it_can_refresh_the_profile_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/profile')
            ->click('Refresh Profile');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/profile');
    }

    /** @test */
    public function it_shows_error_messages_for_required_fields()
    {
        $this->actingAs(factory(Canvas\Models\User::class)->create())
            ->visit('/admin/profile');

        // Fill in all of the required fields with an empty string
        foreach ($this->requiredFields as $name) {
            $this->type('', $name);
        }

        $this->press('Save');

        // Assert response contains an error message for each field
        foreach ($this->requiredFields as $name) {
            $this->see('The '.str_replace('_', ' ', $name).' field is required.');
        }
    }

    /** @test */
    public function it_can_update_the_authenticated_users_profile()
    {
        $this->actingAs($this->user)->visit('/admin/profile');
        $this->type('Luke Skywalker', 'display_name')->press('Save')->see('Success! Profile has been updated.');
        $this->assertSessionMissing('errors');
        $this->seePageIs('admin/profile');
    }
}
