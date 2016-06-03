<?php

namespace Behance\NBD\Gatekeeper;

class IdentifierHashBucket {

  const DEFAULT_NUM_BUCKETS = 100;

  /**
   * @var array
   */
  private static $_bucket_cache = [];

  /**
   * @param $identifier
   * @param $salt
   * @param int $num_buckets
   * @return int
   */
  public static function getBucket( $identifier, $salt, $num_buckets = self::DEFAULT_NUM_BUCKETS ) {

    $cache_key = $salt . $identifier . $num_buckets;

    if ( isset( self::$_bucket_cache[ $cache_key ] ) ) {
      return self::$_bucket_cache[ $cache_key ];
    }

    $hash = abs( crc32( $salt . $identifier ) );

    self::$_bucket_cache[ $cache_key ] = ( $hash % $num_buckets ) + 1;

    return self::$_bucket_cache[ $cache_key ];

  } // getBucket

} // IdentifierHashBucket
