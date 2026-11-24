<?php
class ConseilsController extends Controller
{
    public function index(): void
    {
        $q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
        $cat = $this->intParam('cat');
        $res = (new Conseil())->published(['q' => $q, 'cat' => $cat], max(1, $this->intParam('page')), 6);
        $this->view('conseils/index', [
            'title' => 'Conseils agricoles — ' . APP_NAME, 'conseils' => $res['rows'], 'pager' => $res['pager'],
            'q' => $q, 'cat' => $cat, 'categories' => (new Categorie())->withPublishedCount(),
        ]);
    }

    public function show(): void
    {
        $m = new Conseil();
        $c = $m->findPublished($this->intParam('id'));
        if (!$c) {
            $this->abort(404);
        }
        $this->view('conseils/show', ['title' => $c['titre'] . ' — ' . APP_NAME, 'c' => $c,
            'similaires' => $c['id_categorie'] ? $m->related((int) $c['id_categorie'], (int) $c['id_conseil']) : []]);
    }
}
