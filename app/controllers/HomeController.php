<?php
class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', [
            'title'   => APP_NAME . ' — ' . APP_SLOGAN,
            'stats'   => [
                'cultures'     => (new Culture())->countAll(),
                'conseils'     => (new Conseil())->countPublished(),
                'agriculteurs' => (new Utilisateur())->countByRole('agriculteur'),
                'parcelles'    => (new Parcelle())->countAll(),
            ],
            'conseils' => (new Conseil())->latestPublished(3),
            'cultures' => (new Culture())->latest(6),
        ]);
    }

    public function about(): void
    {
        $this->view('home/about', ['title' => 'À propos — ' . APP_NAME]);
    }
}
