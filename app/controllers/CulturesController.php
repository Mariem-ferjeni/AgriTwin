<?php
class CulturesController extends Controller
{
    public function index(): void
    {
        $m = new Culture();
        $f = ['q' => $this->get('q'), 'type' => $this->get('type'), 'saison' => $this->get('saison')];
        $res = $m->search($f, max(1, $this->intParam('page')), 9);
        $this->view('cultures/index', [
            'title' => 'Cultures — ' . APP_NAME, 'cultures' => $res['rows'], 'pager' => $res['pager'],
            'f' => $f, 'types' => $m->types(), 'saisons' => $m->seasons(),
        ]);
    }

    public function show(): void
    {
        $m = new Culture();
        $c = $m->find($this->intParam('id'));
        if (!$c) {
            $this->abort(404);
        }
        $this->view('cultures/show', ['title' => $c['nom'] . ' — ' . APP_NAME, 'c' => $c, 'usage' => $m->usageCount((int) $c['id_culture']),
            'conseils' => (new Conseil())->latestPublished(3)]);
    }

    private function get(string $k): string
    {
        $v = $_GET[$k] ?? '';
        return is_string($v) ? trim($v) : '';
    }
}
