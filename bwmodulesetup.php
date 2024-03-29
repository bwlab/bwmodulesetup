<?php

/**
 * 2007-2021 Bwlab
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@bwlab.it so we can send you a copy immediately.
 *
 *  @author    PrestaShop SA <info@bwlab.it>
 *  @copyright 2007-2022 Bwlab
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Bwmodulesetup extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bwmodulesetup';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'www.bwlab.it';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Setup new module');
        $this->description = $this->l('This module setup new module');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {

        return parent::install();
    }

    public function uninstall()
    {

        return parent::uninstall();
    }
}
