<?php
/**
 * @package FlatCMS
 * @author shoaiyb sysa
 * @see https://www.flatcms.ml
 * @license GNU
 */

session_start();
define('VERSION', '1.0');
mb_internal_encoding('UTF-8');

if (defined('PHPUNIT_TESTING') === false) {
	$Fcms = new Fcms();
	$Fcms->init();
	$Fcms->render();
}

class Fcms
{
	private const THEMES_DIR = 'themes';
	private const PLUGINS_DIR = 'plugins';
	private const VALID_DIRS = [self::THEMES_DIR, self::PLUGINS_DIR];
	private const THEME_PLUGINS_TYPES = [
		'installs' => 'install',
		'updates' => 'update',
		'exists' => 'exist',
	];
	
	public const MIN_PASSWORD_LENGTH = 8;
	public const FCMS_REPO = 'https://raw.githubusercontent.com/shoaiyb/flatcms/master/';
	public const FCMS_CDN_REPO = 'https://raw.githubusercontent.com/shoaiyb/cdn-flatcms/master/';
	public $currentPage = '';
	public $currentPageExists = false;
	protected $db;
	public $loggedIn = false;
	public $listeners = [];
	public $dataPath;
	protected $themesPluginsCachePath;
	protected $dbPath;
	public $filesPath;
	public $rootDir;
	public $headerResponseDefault = true;
	public $headerResponse = 'HTTP/1.0 200 OK';
	
	public function __construct(
		string $dataFolder = 'data',
		string $filesFolder = 'files',
		string $dbName = 'database.js',
		string $rootDir = __DIR__
	) {
		$this->rootDir = $rootDir;
		$this->setPaths($dataFolder, $filesFolder, $dbName);
		$this->db = $this->getDb();
	}
	public function setPaths(
		string $dataFolder = 'data',
		string $filesFolder = 'files',
		string $dbName = 'database.js'
	): void {
		$this->dataPath = sprintf('%s/%s', $this->rootDir, $dataFolder);
		$this->dbPath = sprintf('%s/%s', $this->dataPath, $dbName);
		$this->filesPath = sprintf('%s/%s', $this->dataPath, $filesFolder);
		$this->themesPluginsCachePath = sprintf('%s/%s', $this->dataPath, 'cache.json');
	}
	public function init(): void
	{
		$this->pageStatus();
		$this->loginStatus();
		$this->logoutAction();
		$this->loginAction();
		$this->notFoundResponse();
		$this->loadPlugins();
		if ($this->loggedIn) {
			$this->manuallyRefreshCacheData();
			$this->addCustomThemePluginRepository();
			$this->installUpdateThemePluginAction();
			$this->changePasswordAction();
			$this->deleteFileThemePluginAction();
			$this->changePageThemeAction();
			$this->backupAction();
			$this->betterSecurityAction();
			$this->deletePageAction();
			$this->saveAction();
			$this->updateAction();
			$this->uploadFileAction();
			$this->notifyAction();
		}
	}
	public function render(): void
	{
		header($this->headerResponse);
		if ($this->loggedIn) {
			$loadingPage = null;
			foreach ($this->get('config', 'menuItems') as $item) {
				if ($this->currentPage === $item->slug) {
					$loadingPage = $item;
				}
			}
			if ($loadingPage && $loadingPage->visibility === 'hide') {
				$this->alert('info',
					'This page (' . $this->currentPage . ') is currently hidden from the menu. <a data-toggle="fcms-modal" href="#settingsModal" data-target-tab="#menu"><b>Open menu visibility settings</b></a>');
			}
		}

		$this->loadThemeAndFunctions();
	}
	public function addListener(string $hook, callable $functionName): void
	{
		$this->listeners[$hook][] = $functionName;
	}
	public function alert(string $class, string $message, bool $sticky = false): void
	{
		if (isset($_SESSION['alert'][$class])) {
			foreach ($_SESSION['alert'][$class] as $v) {
				if ($v['message'] === $message) {
					return;
				}
			}
		}
		$_SESSION['alert'][$class][] = ['class' => $class, 'message' => $message, 'sticky' => $sticky];
	}
	public function alerts(): string
	{
		if (!isset($_SESSION['alert'])) {
			return '';
		}
		$output = '';
		$output .= '<div class="alertWrapper">';
		foreach ($_SESSION['alert'] as $alertClass) {
			foreach ($alertClass as $alert) {
				$output .= '<div class="alert alert-'
					. $alert['class']
					. (!$alert['sticky'] ? ' alert-dismissible' : '')
					. '">'
					. (!$alert['sticky'] ? '<button type="button" class="close" data-dismiss="alert">&times;</button>' : '')
					. $alert['message']
					. '</div>';
			}
		}
		$output .= '</div>';
		unset($_SESSION['alert']);
		return $output;
	}
	public function asset(string $location): string
	{
		return self::url('themes/' . $this->get('config', 'theme') . '/' . $location);
	}
	public function backupAction(): void
	{
		if (!$this->loggedIn) {
			return;
		}
		$backupList = glob($this->filesPath . '/*-backup-*.zip');
		if (!empty($backupList)) {
			$this->alert('danger',
				'Backup files detected. <a data-toggle="wcms-modal" href="#settingsModal" data-target-tab="#files"><b>View and delete unnecessary backup files</b></a>');
		}
		if (isset($_POST['backup']) && $this->verifyFormActions()) {
			$this->zipBackup();
		}
	}
