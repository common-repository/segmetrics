<?php
/**
 * The core SegMetrics connector
 *
 * @since      1.0.0
 * @package    Segmetrics
 * @subpackage Segmetrics/includes
 * @author     Keith Perhac <support@segmetrics.io>
 */
class SegmetricsService
{
    public $auth_key = 'seg_auth';
    public $snippet_key = 'seg_snippet';
    public $options_key = 'seg_options';

    private $error;
    public $snippet;


    /**
     * Check if the Account has been connected
     * @return bool
     */
    public function has_account()
    {
        $options = get_option( $this->auth_key );
        return !empty($options) && !empty($options['api_key']) ;
    }

    /**
     * Get the latest error message
     */
    public function get_error()
    {
        return $this->error;
    }

    public function break_cache()
    {
        delete_transient("seg_auth_check");
    }

    /**
     * Syncs the data from the server, or returns false if we can't connect
     */
    public function snippet()
    {
        // No Account? Return false
        if( !$this->has_account() ){ return false; }


        // Cache our check for $delay minutes
        if( get_transient("seg_auth_check") ){
            return $this->snippet ?: get_option( $this->snippet_key );
        }

        $results = $this->get_snippet_settings();

        // The response can either be an array or WP_Error
        if(is_wp_error($results)){
            $this->error = $results->get_error_message();
            return false;
        } elseif(!is_array($results) || empty($results['body'])) {
            $this->error = 'Undefined Error';
            return false;
        }

        $body = json_decode($results['body'], true);

        if($results['response']['code'] != 200){
            $this->error = $body['message'];
            return false;
        } else {
            // Update our data
            set_transient("seg_auth_check", 1, 60 * MINUTE_IN_SECONDS);

            $this->snippet = $body;
            update_option( $this->snippet_key,  $this->snippet);
            return $this->snippet;
        }
    }

    /**
     * @return array|WP_Error
     */
    private function get_snippet_settings()
    {
        $options = get_option( $this->auth_key );
        return wp_remote_get("https://api.segmetrics.io/{$options['account_hash']}/settings/snippet", [
            'headers'  => [
                'Authorization' => $options['api_key'],
                'version' => SEGMETRICS_VERSION
            ]
        ]);
    }


}