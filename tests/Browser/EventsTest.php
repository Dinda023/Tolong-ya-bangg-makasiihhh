<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EventsTest extends DuskTestCase
{
    public function testIndex()
    {
        $admin = \App\Models\user::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin);
            $browser->visit(route('events.index'));
            $browser->assertRouteIs('events.index');
        });
    }
}
