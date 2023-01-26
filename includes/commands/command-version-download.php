<?php
/**
 * Download a CiviCRM stable release archive or language archive.
 *
 * ## EXAMPLES
 *
 *     $ wp civicrm version-dl --release=5.57.2
 *     $ wp civicrm version-dl --release=5.57.2 --lang
 *
 * @since 1.0.0
 */
class CLI_Tools_CiviCRM_Command_Version_Download extends CLI_Tools_CiviCRM_Command {

  /**
   * Download a CiviCRM stable release archive or language archive.
   *
   * ## OPTIONS
   *
   * [--release=<release>]
   * : Specify the CiviCRM stable version to get. Defaults to latest stable version.
   *
   * [--lang]
   * : Get the localization file for the specified version.
   *
   * [--destination=<destination>]
   * : Specify the absolute path to put the archive file. Defaults to local temp dir.
   *
   * [--insecure]
   * : Retry without certificate validation if TLS handshake fails. Note: This makes the request vulnerable to a MITM attack.
   *
   * ## EXAMPLES
   *
   *     $ wp civicrm version-dl --release=5.17.2
   *     /tmp/civicrm-5.17.2-wordpress.zip
   *
   *     $ wp civicrm version-dl --release=5.17.2 --lang
   *     /tmp/civicrm-5.17.2-l10n.tar.gz
   *
   *     $ wp civicrm version-dl --release=5.57.2 --lang --destination=/some/path
   *     /some/path/civicrm-5.17.2-l10n.tar.gz
   *
   *
   * @since 1.0.0
   *
   * @param array $args The WP-CLI positional arguments.
   * @param array $assoc_args The WP-CLI associative arguments.
   */
  public function __invoke($args, $assoc_args) {

    // Grab incoming data.
    $release = \WP_CLI\Utils\get_flag_value($assoc_args, 'release', 'latest');
    $lang = \WP_CLI\Utils\get_flag_value($assoc_args, 'lang', FALSE);
    $destination = \WP_CLI\Utils\get_flag_value($assoc_args, 'destination', \WP_CLI\Utils\get_temp_dir());
    $insecure = \WP_CLI\Utils\get_flag_value($assoc_args, 'insecure', FALSE);

    // Use "wp civicrm version-get" to find out which file to download.
    $options = ['launch' => FALSE, 'return' => TRUE];
    $command = 'civicrm version-get --release=' . $release . (empty($lang) ? '' : ' --lang');
    $url = WP_CLI::runcommand($command, $options);

    // Configure the download.
    $headers = [];
    $options = [
      'insecure' => (bool) $insecure,
    ];

    // Do the download now.
    $response = $this->file_download($url, $destination, $headers, $options);
    echo $response . "\n";

  }

}
