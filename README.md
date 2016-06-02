nbd.php-gatekeeper, rule-based access control framework
=======================

[![Build Status](https://secure.travis-ci.org/behance/nbd.php-gatekeeper.svg?branch=master)](http://travis-ci.org/behance/nbd.php-gatekeeper)

## Goals

1. test
2. blah
3. k

## Basic Usage

```php
$rule_config = [
    'website_overhaul' => [
        // turn the site overhaul on for a few specific users
        [
            'type'   => \Behance\NBD\Gatekeeper\Rules\IdentifierRule::RULE_NAME,
            'params' => [
                'valid_identifiers' => [
                    123, // admin 1 user id
                    456, // admin 2 user id
                ]
            ]
        ],
        // roll out the new site to 10% of users (users who see it will remain consistent)
        [
            'type'   => \Behance\NBD\Gatekeeper\Rules\PercentageRule::RULE_NAME,
            'params' => [
                'percentage' => 10
            ]
        ],
    ]
];

$gatekeeper_config_provider = new \Behance\NBD\Gatekeeper\RulesetProviders\ConfigRulesetProvider( $rule_config );

$gatekeeper = new \Behance\NBD\Gatekeeper\Gatekeeper( $gatekeeper_config_provider );

$user_id = 456; // this can be any kind of identifier. the percentage rule hashes it consistently so the same user identifiers are always allowed/disallowed into the test

if ( $gatekeeper->canAccess( 'website_overhaul', $user_id ) {
   echo 'Congrats! You get to see the awesome new site!';
} else {
   echo 'Looks like you\'re stuck with the old stuff...';
}
```
