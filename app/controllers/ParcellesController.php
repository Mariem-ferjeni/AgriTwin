<?php
class ParcellesController extends Controller
{
    public function __construct()
    {
        Auth::requireFarmer();
    }

    private function uid(): int { return (int) Auth::user()['id_utilisateur']; }

    private function exploitation(string $key = 'exploitation'): array
    {
        $e = (new Exploitation())->findOwned($this->intParam($key), $this->uid());
        if (!$e) {
            $this->abort(404);
        }
        return $e;
    }

    private function parcelle(): array
    {
        $p = (new Parcelle())->findOwned($this->intParam('id'), $this->uid());
        if (!$p) {
            $this->abort(404);
        }
        return $p;
    }

    private function formData(array $e, ?array $p, array $old, array $errors): array
    {
        return ['title' => ($p ? 'Modifier la parcelle' : 'Nouvelle parcelle') . ' — ' . APP_NAME, 'e' => $e, 'p' => $p, 'old' => $old,
            'errors' => $errors, 'cultures' => (new Culture())->all()];
    }

    public function create(): void
    {
        $e = $this->exploitation();
        $libre = $e['superficie_totale'] - (new Parcelle())->areaUsed((int) $e['id_exploitation']);
        $this->view('parcelles/form', $this->formData($e, null, ['nom' => '', 'superficie' => '', 'type_sol' => '', 'id_culture' => '', 'date_plantation' => '', 'etat' => 'en_preparation'], []) + ['libre' => $libre], 'espace');
    }

    public function store(): void
    {
        $this->requirePost();
        $e = $this->exploitation();
        [$data, $errors] = $this->collect($e);
        if ($errors) {
            $libre = $e['superficie_totale'] - (new Parcelle())->areaUsed((int) $e['id_exploitation']);
            $this->view('parcelles/form', $this->formData($e, null, $_POST, $errors) + ['libre' => $libre], 'espace');
            return;
        }
        (new Parcelle())->create($data + ['id_exploitation' => $e['id_exploitation']]);
        flash('success', 'Parcelle ajoutée.');
        $this->redirect('exploitations/show', ['id' => $e['id_exploitation']]);
    }

    public function edit(): void
    {
        $p = $this->parcelle();
        $e = (new Exploitation())->findOwned((int) $p['id_exploitation'], $this->uid());
        $libre = $e['superficie_totale'] - (new Parcelle())->areaUsed((int) $e['id_exploitation'], (int) $p['id_parcelle']);
        $this->view('parcelles/form', $this->formData($e, $p, $p, []) + ['libre' => $libre], 'espace');
    }

    public function update(): void
    {
        $this->requirePost();
        $p = $this->parcelle();
        $e = (new Exploitation())->findOwned((int) $p['id_exploitation'], $this->uid());
        [$data, $errors] = $this->collect($e, (int) $p['id_parcelle']);
        if ($errors) {
            $libre = $e['superficie_totale'] - (new Parcelle())->areaUsed((int) $e['id_exploitation'], (int) $p['id_parcelle']);
            $this->view('parcelles/form', $this->formData($e, $p, $_POST, $errors) + ['libre' => $libre], 'espace');
            return;
        }
        (new Parcelle())->update((int) $p['id_parcelle'], $data);
        flash('success', 'Parcelle mise à jour.');
        $this->redirect('exploitations/show', ['id' => $e['id_exploitation']]);
    }

    public function destroy(): void
    {
        $this->requirePost();
        $p = $this->parcelle();
        (new Parcelle())->delete((int) $p['id_parcelle']);
        flash('success', 'Parcelle « ' . $p['nom'] . ' » supprimée, avec son suivi.');
        $this->redirect('exploitations/show', ['id' => $p['id_exploitation']]);
    }

    /** Validation commune création / modification. La somme des parcelles ne peut pas dépasser l'exploitation. */
    private function collect(array $e, int $exceptId = 0): array
    {
        $d = ['nom' => $this->post('nom'), 'type_sol' => $this->post('type_sol'), 'etat' => $this->post('etat'),
              'date_plantation' => $this->post('date_plantation'), 'id_culture' => $this->post('id_culture')];
        $errors = [];
        if (!Validator::length($d['nom'], 2, 100)) $errors['nom'] = 'Le nom doit contenir entre 2 et 100 caractères.';

        $sup = Validator::decimal($_POST['superficie'] ?? '', 0.01, 1000000);
        if ($sup === null) {
            $errors['superficie'] = 'Indiquez une superficie valide en hectares (supérieure à 0).';
        } else {
            $libre = $e['superficie_totale'] - (new Parcelle())->areaUsed((int) $e['id_exploitation'], $exceptId);
            if ($sup > $libre + 0.0001) {
                $errors['superficie'] = 'Surface disponible dans l\'exploitation : ' . number_format(max(0, $libre), 2, ',', ' ') . ' ha.';
            }
        }
        $d['superficie'] = $sup;

        if ($d['type_sol'] !== '' && !in_array($d['type_sol'], Parcelle::SOLS, true)) $errors['type_sol'] = 'Type de sol invalide.';
        $d['type_sol'] = $d['type_sol'] ?: null;
        if (!isset(Parcelle::ETATS[$d['etat']])) $errors['etat'] = 'État invalide.';

        if ($d['id_culture'] !== '') {
            if (!ctype_digit($d['id_culture']) || !(new Culture())->find((int) $d['id_culture'])) {
                $errors['id_culture'] = 'Culture inconnue.';
            }
            $d['id_culture'] = (int) $d['id_culture'];
        } else {
            $d['id_culture'] = null;
        }
        if ($d['date_plantation'] !== '' && !Validator::date($d['date_plantation'])) $errors['date_plantation'] = 'Date invalide.';
        $d['date_plantation'] = $d['date_plantation'] ?: null;
        return [$d, $errors];
    }
}
