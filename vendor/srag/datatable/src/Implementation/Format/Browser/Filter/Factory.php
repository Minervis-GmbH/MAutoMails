<?php

namespace srag\DataTableUI\SrAutoMails\Implementation\Format\Browser\Filter;

use srag\CustomInputGUIs\SrAutoMails\FormBuilder\FormBuilder as FormBuilderInterface;
use srag\DataTableUI\SrAutoMails\Component\Format\Browser\BrowserFormat;
use srag\DataTableUI\SrAutoMails\Component\Format\Browser\Filter\Factory as FactoryInterface;
use srag\DataTableUI\SrAutoMails\Component\Settings\Settings;
use srag\DataTableUI\SrAutoMails\Component\Table;
use srag\DataTableUI\SrAutoMails\Implementation\Utils\DataTableUITrait;
use srag\DIC\SrAutoMails\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\SrAutoMails\Implementation\Format\Browser\Filter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function formBuilder(BrowserFormat $parent, Table $component, Settings $settings) : FormBuilderInterface
    {
        return new FormBuilder($parent, $component, $settings);
    }
}
