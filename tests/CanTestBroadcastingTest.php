<?php

namespace Jlndk\TestBroadcaster\Tests;

use PHPUnit\Framework\ExpectationFailedException;

class CanTestBroadcastingTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_assert_when_an_event_is_broadcasted()
    {
        try {
            $this->assertEventBroadcasted(TestEvent::class);
            $this->fail("assertEventBroadcasted asserted that an event was broadcasted when it wasn't");
        } catch (ExpectationFailedException $e) {
        }

        event(new TestEvent());

        $this->assertEventBroadcasted(TestEvent::class);
    }

    /**
     * @test
     */
    public function it_can_assert_if_an_event_was_broadcasted_a_given_amount_of_times()
    {
        try {
            $this->assertEventBroadcasted(TestEvent::class, 1);
            $this->fail("assertEventBroadcasted asserted that an event was broadcasted once when it wasn't");
        } catch (ExpectationFailedException $e) {
        }

        event(new TestEvent());
        $this->assertEventBroadcasted(TestEvent::class, 1);

        try {
            $this->assertEventBroadcasted(TestEvent::class, 2);
            $this->fail("assertEventBroadcasted asserted that an event was broadcasted twice when only was broadcasted once");
        } catch (ExpectationFailedException $e) {
        }

        event(new TestEvent());
        $this->assertEventBroadcasted(TestEvent::class, 2);
    }

    /**
     * @test
     */
    public function it_can_assert_if_an_event_was_broadcasted_on_a_single_channel()
    {
        event(new TestEvent());

        $this->assertEventBroadcasted(TestEvent::class, 'private-channel-name');

        try {
            $this->assertEventBroadcasted(TestEvent::class, 'somethingelse-fake-channel');
            $this->fail("assertEventBroadcasted asserted that an event was broadcasted on a given channel when it wasn't");
        } catch (ExpectationFailedException $e) {
        }
    }

    /**
     * @test
     */
    public function it_can_assert_if_an_event_was_broadcasted_on_multiple_channels()
    {
        event(new TestEvent());

        $this->assertEventBroadcasted(TestEvent::class, ['private-channel-name', 'private-another-channel-name']);

        try {
            $this->assertEventBroadcasted(TestEvent::class, [
                'private-channel-name',
                'somethingelse-fake-channel',
            ]);
            $this->fail("assertEventBroadcasted asserted that an event was broadcasted on given channels when it wasn't");
        } catch (ExpectationFailedException $e) {
        }
    }
}
