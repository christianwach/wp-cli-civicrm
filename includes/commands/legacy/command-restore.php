<?php
/**
 * Restore the CiviCRM plugin files and database.
 *
 * ## EXAMPLES
 *
 *     $ wp civicrm restore
 *
 * @since 1.0.0
 */
class CLI_Tools_CiviCRM_Command_Restore extends CLI_Tools_CiviCRM_Command {

  /**
   * Restore the CiviCRM plugin files and database. Deprecated: use `wp civicrm core restore` instead.
   *
   * ## OPTIONS
   *
   * [--yes]
   * : Answer yes to the confirmation message.
   *
   * ## EXAMPLES
   *
   *     $ wp civicrm restore
   *
   * @since 1.0.0
   *
   * @param array $args The WP-CLI positional arguments.
   * @param array $assoc_args The WP-CLI associative arguments.
   */
  public function __invoke($args, $assoc_args) {

    // Grab associative arguments.
    $yes = (bool) \WP_CLI\Utils\get_flag_value($assoc_args, 'yes', FALSE);

    WP_CLI::log(WP_CLI::colorize('%CDeprecated command:%n %cuse `wp civicrm core restore` instead.%n'));

    // Pass on to "wp civicrm core restore".
    $options = ['launch' => FALSE, 'return' => FALSE];
    WP_CLI::runcommand('civicrm core restore' . (empty($yes) ? '' : ' --yes'), $options);

  }

}
