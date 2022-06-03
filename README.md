# Updates Log

Log Drupal project update statuses.

Why? When having many Drupals around then keeping track of security updates can
be challenging. One option is to log statuses of the modules on daily bases,
and create alerts (for example on Slack) based on the logs. It makes sense on
centralized logging systems like SumoLogic. It allows to create all kinds stats
and analysis.

As an alternative there is Warden, but it lacks highly configurable alerting.

## Install

1. `composer config repositories.updates_log vcs https://github.com/wunderio/drupal-updates-log.git`
2. `composer require wunderio/updates_log`
3. `drush en -y updates_log`

## Usage

On daily bases it logs module statuses like this:

```
  14309326   19/May 09:31   updates_log   Info       {"project":"webform","status":"NOT_CURRENT"}
  14309325   19/May 09:31   updates_log   Info       {"project":"warden","status":"NOT_SECURE"}
  14309324   19/May 09:31   updates_log   Info       {"project":"video_embed_field","status":"CURRENT"}
```

Status codes are taken from the Drupal code:

- `web/core/modules/update/src/UpdateManagerInterface.php`
  - `NOT_SECURE`
  - `REVOKED`
  - `NOT_SUPPORTED`
  - `NOT_CURRENT`
  - `CURRENT`

- `web/core/modules/update/src/UpdateFetcherInterface.php`
  - `NOT_CHECKED`
  - `UNKNOWN`
  - `NOT_FETCHED`
  - `FETCH_PENDING`

## Timing

Essentially two date strings are compared in format of `YYYYMMDD`.
If last datestamp and current one differ, the logs are issued.
The dates are generated according to the local time.

## State

The state of the module is kept in Drupal State `updates_log.last`.
The value represent the last time the logs were issued.
The value is stored as seconds since epoch.
It is needed for deciding when to send out the next batch of logs.

- `drush sget updates_log.last`
- `drush sset updates_log.last 1654253832`

## Development of `updates_log`

- `lando install` - Install development packages of the module.
- `lando scan` - Run code scanners after development and before committing.
- `lando start` - Start up the development environment
- `lando test` - Run tests during/after development and before committing.
