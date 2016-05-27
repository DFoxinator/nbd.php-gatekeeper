<?php

namespace Behance\NBD\Gatekeeper\Rules;

use Behance\NBD\Gatekeeper\Test\BaseTest;

class BetweenTimesRuleTest extends BaseTest {

  /**
   * @test
   *
   * @param \DateTimeImmutable $from_time
   * @param \DateTimeImmutable $to_time
   * @param \DateTimeImmutable $current_time
   * @param bool               $expected
   *
   * @dataProvider timeProvider
   */
  public function canAccess( \DateTimeImmutable $from_time, \DateTimeImmutable $to_time, \DateTimeImmutable $current_time, $expected ) {

    $rule = $this->getMock( BetweenTimesRule::class, [ '_getCurrentTime' ], [ $from_time, $to_time ] );

    $rule->expects( $this->once() )
      ->method( '_getCurrentTime' )
      ->will( $this->returnValue( $current_time ) );

    $this->assertEquals( $expected, $rule->canAccess() );

  }

  /**
   * @return array
   */
  public function timeProvider() {
    return [
        [
            new \DateTimeImmutable( 'May 15, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 25, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 21, 2016 14:15:15' ),
            true
        ],
        [
            new \DateTimeImmutable( 'May 15, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 25, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 15, 2016 20:15:15' ),
            true
        ],
        [
            new \DateTimeImmutable( 'May 15, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 25, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 25, 2016 20:15:15' ),
            true
        ],
        [
            new \DateTimeImmutable( 'May 15, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 25, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 15, 2016 20:15:14' ),
            false
        ],
        [
            new \DateTimeImmutable( 'May 15, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 25, 2016 20:15:15' ),
            new \DateTimeImmutable( 'May 14, 2016 2:15:14' ),
            false
        ],
    ];
  } // timeProvider

} // BetweenTimesTest
