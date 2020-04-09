# Test Laravel Event Broadcasting

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jlndk/laravel-test-broadcaster.svg?style=flat-square)](https://packagist.org/packages/jlndk/laravel-test-broadcaster)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jlndk/laravel-test-broadcaster/run-tests?label=tests)](https://github.com/jlndk/laravel-test-broadcaster/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jlndk/laravel-test-broadcaster.svg?style=flat-square)](https://packagist.org/packages/jlndk/laravel-test-broadcaster)

This package lets you test if Laravel events has been broadcasted. This is useful for TDD and End-to-end testing.


## Installation

1. Install the package via composer:

```bash
composer require jlndk/laravel-test-broadcaster
```

2. Add the test broadcaster to the `connections` array in `app/config/broadcasting.php`.
```php
'connections' => [
    ...
    'test' => [
        'driver' => 'test'
    ],
],

```

3. Set the default broadcaster for testing in the `php` element of `phpunit.xml`.
```xml
<php>
    ...
    <env name="BROADCAST_DRIVER" value="test"/>
</php>
```

4. Finally add the `Jlndk\TestBroadcaster\CanTestBroadcasting` trait to `tests/TestCase.php`.
```php
use Jlndk\TestBroadcaster\CanTestBroadcasting;
abstract class TestCase extends BaseTestCase
{
    use CanTestBroadcasting;
}
```

## Usage
This package adds the `assertEventBroadcasted` method to your testing.
``` php
/**
 * @test
 */
public function it_can_assert_when_an_event_is_broadcasted()
{
    event(new TestEvent());
    $this->assertEventBroadcasted(TestEvent::class);
}
```

Futhermore it is also possible to test for how many times an even is broadcasted
```php
/**
 * @test
 */
public function it_can_assert_if_an_event_was_broadcasted_a_given_amount_of_times()
{
    event(new TestEvent());
    $this->assertEventBroadcasted(TestEvent::class, 1);

    event(new TestEvent());
    $this->assertEventBroadcasted(TestEvent::class, 2);
}
```

```php
/**
 * @test
 */
public function it_can_assert_if_an_event_was_broadcasted_a_given_amount_of_times()
{
    event(new TestEvent());
    $this->assertEventBroadcasted(TestEvent::class, 1);

    event(new TestEvent());
    $this->assertEventBroadcasted(TestEvent::class, 2);
}
```

The `assertEventBroadcasted` method can also assert on which channels the event is broadcasted to.
It can either take a single string, for a single channel, or an array of channel names.
```php
/**
 * @test
 */
public function it_can_assert_if_an_event_was_broadcasted_on_multiple_channels()
{
    event(new TestEvent());

    // 
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
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email xxx instead of using the issue tracker.

## Credits

- [jlndk](https://github.com/jlndk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
