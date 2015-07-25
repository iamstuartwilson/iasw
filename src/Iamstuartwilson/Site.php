<?php

namespace Iamstuartwilson;

use Iamstuartwilson\Site\Router;
use Iamstuartwilson\Site\TwigService;
use Iamstuartwilson\Site\Project;

class Site
{
    protected $twig;
    protected $baseUrl;
    protected $router;
    protected $dev;
    protected $project;

    function __construct($baseUrl, $dev = false)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->dev = $dev;
        $this->router = new Router($this->baseUrl);
        $this->project = new Project($this->baseUrl);

        // Get twig
        $twigService = new TwigService(! $this->isDev());
        $this->twig = $twigService->get();

        // Set base URL for templates
        $this->twig->AddGlobal('baseUrl', $this->baseUrl);
    }

    protected function isDev()
    {
        return (bool) $this->dev;
    }

    // Pull into own thing
    public function addRoutes()
    {
        // Render the template.  No context nees
        $this->router->addRoute('/', function() {
            echo $this->twig->render('home/index.twig');
        });

        // Render the project page with all project data
        $this->router->addRoute('/projects/', function() {
            $projects = $this->project->getAll();
            $context = [
                'projects' => []
            ];

            foreach ($projects as $project) {
                $context['projects'][] = $project['data'];
            }

            echo $this->twig->render('projects/index.twig', $context);
        });

        // Render the project single page with specific project data
        $this->router->addRoute('/projects/[*:slug]/', function($slug) {
            $project = $this->project->get($slug);

            if ($project) {
                echo $this->twig->render('projects/single.twig', array_merge( $project['data'],[
                    'content' => $project['html']
                ]));

                return;
            }

            return $this->render404();
        });

        // Render CV page
        $this->router->addRoute('/cv/', function() {
            echo $this->twig->render('cv/index.twig');
        });
    }

    protected function render404()
    {
        // 404 on no route match
        header("HTTP/1.0 404 Not Found");

        echo $this->twig->render('404.twig');
    }

    public function serve()
    {
        $this->addRoutes();

        $this->router->match(function() {
            return $this->render404();
        });
    }
}
