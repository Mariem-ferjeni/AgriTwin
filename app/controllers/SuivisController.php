<?php
class SuivisController extends Controller
{
    public function __construct()
    {
        Auth::requireFarmer();
    }

    private function uid(): int { return (int) Auth::user()['id_utilisateur']; }

    private function parcelle(string $key = 'parcelle'): array
    {
        $p = (new Parcelle())->findOwned($this->intParam($key), $this->uid());
        if (!$p) {
            $this->abort(404);
        }
        return $p;
    }

    private function render(array $p, array $old = [], array $errors = []): void
    {
        $this->view('suivis/index', ['title' => 'Suivi de ' . $p['nom'] . ' — ' . APP_NAME, 'p' => $p,
            'suivis' => (new Suivi())->forParcelle((int) $p['id_parcelle']),
            'old' => $old + ['date_suivi' => date('Y-m-d'), 'humidite_sol' => '', 'temperature' => '', 'ph_sol' => '', 'observation' => ''],
            'errors' => $errors], 'espace');
    }

    public function index(): void
    {
        $this->render($this->parcelle());
    }

    public function store(): void
    {
        $this->requirePost();
        $p = $this->parcelle();
        $errors = [];
        $date = $this->post('date_suivi');
        $obs = $this->post('observation');
        if (!Validator::date($date))      $errors['date_suivi'] = 'Date invalide.';
        elseif ($date > date('Y-m-d'))    $errors['date_suivi'] = 'La date ne peut pas être dans le futur.';

        $hum = $this->optional('humidite_sol', 0, 100, 'Humidité entre 0 et 100 %.', $errors);
        $tmp = $this->optional('temperature', -20, 60, 'Température entre -20 et 60 °C.', $errors);
        $ph  = $this->optional('ph_sol', 0, 14, 'pH entre 0 et 14.', $errors);
        if (mb_strlen($obs) > 1000) $errors['observation'] = 'Observation limitée à 1000 caractères.';
        if (!$errors && $hum === null && $tmp === null && $ph === null && $obs === '') {
            $errors['observation'] = 'Renseignez au moins une mesure ou une observation.';
        }
        if ($errors) {
            $this->render($p, $_POST, $errors);
            return;
        }
        (new Suivi())->create((int) $p['id_parcelle'], ['date_suivi' => $date, 'humidite_sol' => $hum, 'temperature' => $tmp,
            'ph_sol' => $ph === null ? null : round($ph, 1), 'observation' => $obs ?: null]);
        flash('success', 'Mesure enregistrée.');
        $this->redirect('suivis', ['parcelle' => $p['id_parcelle']]);
    }

    public function destroy(): void
    {
        $this->requirePost();
        $s = (new Suivi())->findOwned($this->intParam('id'), $this->uid());
        if (!$s) {
            $this->abort(404);
        }
        (new Suivi())->delete((int) $s['id_suivi']);
        flash('success', 'Mesure supprimée.');
        $this->redirect('suivis', ['parcelle' => $s['id_parcelle']]);
    }

    private function optional(string $key, float $min, float $max, string $msg, array &$errors): ?float
    {
        $raw = trim((string) ($_POST[$key] ?? ''));
        if ($raw === '') {
            return null;
        }
        $v = Validator::decimal($raw, $min, $max);
        if ($v === null) {
            $errors[$key] = $msg;
        }
        return $v;
    }
}
