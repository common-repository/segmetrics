<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://segmetrics.io
 * @since      1.0.0
 *
 * @package    Segmetrics
 * @subpackage Segmetrics/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap page-segmetrics">

    <h2>Settings - SegMetrics</h2>
    <h2 class="nav-tab-wrapper" id="segmetrics-tabs">
        <a class="nav-tab nav-tab-active" id="dashboard-tab" href="#general">General</a>
    </h2>

    <br/>

    <?php if ( ! $this->service->has_account() ) : ?>
    <div class="seg-notice seg-success">
        <img src="<?= plugins_url( 'img/icon.png', dirname(__FILE__)) ?>" />
        <div class="seg-content">
            <h3>Connect your SegMetrics Account</h3>
            <p>
                Enter your SegMetrics API information below to install your tracking snippet.<br/>
                SegMetrics will import your tracking snippet information and keep it up to date automatically.
            </p>
        </div>
    </div>

    <?php elseif ( false != $this->service->snippet() ): ?>

    <!-- Check for configuration -->
        <div class="seg-notice seg-success">
            <div class="seg-content">
            <strong>SegMetrics is successfully configured!</strong>
            </div>
        </div>

    <?php else: ?>

        <div class="seg-notice seg-error">
            <img src="<?= plugins_url( 'img/icon.png', dirname(__FILE__)) ?>" />
            <div class="seg-content">
                <h3>Looks like we can't connect to your account.</h3>
                <p>
                    Make sure that your SegMetrics API information is configured correctly and that you have access to the account you're connecting to.<br/>
                    <strong>Error:</strong> <?= $this->service->get_error() ?>
                </p>
            </div>
        </div>

    <?php endif ?>

    <div class="seg-panel">
        <form action='options.php' method='post' name="segmetrics-settings-form" autocomplete="off">
            <?php
            settings_fields( 'segmetrics_auth' );
            do_settings_sections( 'segmetrics_auth' );
            submit_button();
            ?>
        </form>
    </div>

    <?php if( ! $this->service->snippet()) : ?>
    <div class="seg-panel seg-signup-block">
        <h5>Don't have an account?</h5>
        <h2>Stop Wasting Your Marketing Dollars</h2>
        <p>SegMetrics gives 100% clarity on where your leads come from,
            how they act, and how much your marketing is really worth.</p>
        <a href="https://app.segmetrics.io/signup/?utm_source=wp-plugin&utm_medium=link&utm_campaign=dashboard" target="_blank" class="seg-btn cta">Start Your 14-Day Free Trial</a>
    </div>
    <?php endif ?>


</div>