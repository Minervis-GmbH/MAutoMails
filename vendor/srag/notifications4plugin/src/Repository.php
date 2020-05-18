<?php

namespace srag\Notifications4Plugin\SrAutoMails;

use LogicException;
use srag\DataTableUI\SrAutoMails\Implementation\Utils\DataTableUITrait;
use srag\DIC\SrAutoMails\DICTrait;
use srag\DIC\SrAutoMails\Plugin\PluginInterface;
use srag\DIC\SrAutoMails\Util\LibraryLanguageInstaller;
use srag\Notifications4Plugin\SrAutoMails\Notification\Repository as NotificationsRepository;
use srag\Notifications4Plugin\SrAutoMails\Notification\RepositoryInterface as NotificationsRepositoryInterface;
use srag\Notifications4Plugin\SrAutoMails\Parser\Repository as ParserRepository;
use srag\Notifications4Plugin\SrAutoMails\Parser\RepositoryInterface as ParserRepositoryInterface;
use srag\Notifications4Plugin\SrAutoMails\Sender\Repository as SenderRepository;
use srag\Notifications4Plugin\SrAutoMails\Sender\RepositoryInterface as SenderRepositoryInterface;
use srag\Notifications4Plugin\SrAutoMails\Utils\Notifications4PluginTrait;

/**
 * Class Repository
 *
 * @package srag\Notifications4Plugin\SrAutoMails
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository implements RepositoryInterface
{

    use DICTrait;
    use Notifications4PluginTrait;
    use DataTableUITrait;

    /**
     * @var RepositoryInterface|null
     */
    protected static $instance = null;


    /**
     * @return RepositoryInterface
     */
    public static function getInstance() : RepositoryInterface
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @var string
     */
    protected $table_name_prefix = "";
    /**
     * @var PluginInterface
     */
    protected $plugin;
    /**
     * @var array
     */
    protected $placeholder_types;


    /**
     * Repository constructor
     */
    private function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function dropTables()/* : void*/
    {
        $this->notifications()->dropTables();
        $this->parser()->dropTables();
        $this->sender()->dropTables();
    }


    /**
     * @inheritDoc
     */
    public function getPlaceholderTypes() : array
    {
        if (empty($this->placeholder_types)) {
            throw new LogicException("placeholder types is empty - please call withPlaceholderTypes earlier!");
        }

        return $this->placeholder_types;
    }


    /**
     * @inheritDoc
     */
    public function getPlugin() : PluginInterface
    {
        if (empty($this->plugin)) {
            throw new LogicException("plugin is empty - please call withPlugin earlier!");
        }

        return $this->plugin;
    }


    /**
     * @inheritDoc
     */
    public function getTableNamePrefix() : string
    {
        if (empty($this->table_name_prefix)) {
            throw new LogicException("table name prefix is empty - please call withTableNamePrefix earlier!");
        }

        return $this->table_name_prefix;
    }


    /**
     * @inheritDoc
     */
    public function installLanguages()/* : void*/
    {
        LibraryLanguageInstaller::getInstance()->withPlugin($this->getPlugin())->withLibraryLanguageDirectory(__DIR__
            . "/../lang")->updateLanguages();

        self::dataTableUI()->installLanguages($this->plugin);
    }


    /**
     * @inheritDoc
     */
    public function installTables()/* : void*/
    {
        $this->notifications()->installTables();
        $this->parser()->installTables();
        $this->sender()->installTables();
    }


    /**
     * @inheritDoc
     */
    public function notifications() : NotificationsRepositoryInterface
    {
        return NotificationsRepository::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function parser() : ParserRepositoryInterface
    {
        return ParserRepository::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function sender() : SenderRepositoryInterface
    {
        return SenderRepository::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function withPlaceholderTypes(array $placeholder_types) : RepositoryInterface
    {
        $this->placeholder_types = $placeholder_types;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function withPlugin(PluginInterface $plugin) : RepositoryInterface
    {
        $this->plugin = $plugin;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function withTableNamePrefix(string $table_name_prefix) : RepositoryInterface
    {
        $this->table_name_prefix = $table_name_prefix;

        return $this;
    }
}
