<?php

namespace RimiItk\Timestuff;

use PHPUnit\Framework\TestCase;

final class TimeStuffTest extends TestCase
{
  /**
   * @dataProvider provideGetExpirationTimeData
   */
    public function testGetExpirationTime(array $options, \DateTimeImmutable $now, \DateTimeImmutable $expected = null)
    {
        $t = new TimeStuff($options);

        $actual = $t->getExpirationTime($now);

        $this->assertEquals($expected, $actual);
    }

    public function provideGetExpirationTimeData()
    {
        yield [
          [
              'expiration_times' => [
                  '+2 hours',
                  '07:00',
                  'tomorrow 07:00',
              ],
          ],
          new \DateTimeImmutable('2001-01-01'),
          new \DateTimeImmutable('2001-01-01T02:00:00'),
        ];

        yield [
          [
              'expiration_times' => [
                  '-2 hours',
              ],
          ],
          new \DateTimeImmutable('2001-01-01'),
          null,
        ];
    }
}
