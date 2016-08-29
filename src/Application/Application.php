<?php
namespace Application;

require_once(__DIR__.'/Page/PageInterface.php');
require_once(__DIR__.'/Renderer.php');
require_once(__DIR__.'/NavigationItem.php');

use Application\Page\PageInterface;

/**
 * Objektmodell der Webanwendung. Verwaltet die Seiten und die Navigation.
 * @package Application
 */
class Application{

    const PAGE_PARAMETER = 'page';

    /** @var Renderer  */
    protected $renderer;
	/** @var PageInterface[] */
    protected $pages;
	/** @var NavigationItem[] */
    protected $navigation;

    /**
     * @param PageInterface[] $pages
     * @param NavigationItem[] $navigation
     */
    public function __construct($pages = [], $navigation = [])
    {
        $this->renderer = new Renderer();
        $this->pages = $pages;
        $this->navigation = $navigation;
    }

    /**
     * Fügt neue Seite mit angegebener Id hinzu. Existert die Id bereits, wird die gespeicherte Seite überschrieben
     * @param string $id Id der Seite
     * @param PageInterface $page Seitenklasse
     */
    public function addPage($id, PageInterface $page)
    {
        $this->pages[$id] = $page;
    }

    /**
     * Fügt einen Navigationspunkt am Ende hinzu
     * @param NavigationItem $item
     */
    public function addNavigationItem(NavigationItem $item)
    {
        $this->navigation[] = $item;
    }

    /**
     * Führt das Programm aus
     */
    public function run()
    {
        // Standardseite
        $pageId = array_keys($this->pages)[0];
        if(isset($_GET[self::PAGE_PARAMETER]) && !empty($this->pages[$_GET[self::PAGE_PARAMETER]])){
            // Wenn GET Parameter angegeben, nutze diesen
            $pageId = $_GET[self::PAGE_PARAMETER];
        }
        if(isset($this->pages[$pageId])){
            $page = $this->pages[$pageId];
        }
        $variables = array(
            'pageTitle' => $page->getTitle(),
            'pageContent' => $this->renderer->render($page),
            'activePageId' => $pageId,
            'navigation' => $this->navigation
        );
        $this->renderer->showViewScript(__DIR__.'/../../view/layout.phtml', $variables);
    }
}