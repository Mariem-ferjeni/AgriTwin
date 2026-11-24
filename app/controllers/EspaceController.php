<?php
class EspaceController extends Controller
{
    public function __construct()
    {
        Auth::requireFarmer();      // tout l'espace personnel est réservé aux agriculteurs connectés
    }

    public function index(): void
    {
        $uid = (int) Auth::user()['id_utilisateur'];
        $expl = new Exploitation();
        $parcelles = new Parcelle();
        $this->view('espace/index', [
            'title' => 'Mon espace — ' . APP_NAME,
            'stats' => [
                'exploitations' => $expl->countForUser($uid),
                'parcelles'     => $parcelles->countForUser($uid),
                'superficie'    => $expl->totalAreaForUser($uid),
                'mesures'       => (new Suivi())->countForUser($uid),
            ],
            'parcelles' => array_slice($parcelles->forUser($uid), 0, 6),
            'mesures'   => (new Suivi())->latestForUser($uid, 5),
            'conseils'  => (new Conseil())->latestPublished(3),
        ], 'espace');
    }

    public function profil(): void
    {
        $this->view('espace/profil', ['title' => 'Mon profil — ' . APP_NAME, 'errors' => [], 'pwdErrors' => [], 'old' => Auth::user()], 'espace');
    }

    public function updateProfil(): void
    {
        $this->requirePost();
        $u = Auth::user();
        $model = new Utilisateur();
        $old = ['nom' => $this->post('nom'), 'prenom' => $this->post('prenom'), 'email' => strtolower($this->post('email')), 'telephone' => $this->post('telephone')];
        $errors = [];
        if (!Validator::length($old['nom'], 2, 100))    $errors['nom'] = 'Le nom doit contenir entre 2 et 100 caractères.';
        if (!Validator::length($old['prenom'], 2, 100)) $errors['prenom'] = 'Le prénom doit contenir entre 2 et 100 caractères.';
        if (!Validator::email($old['email']))           $errors['email'] = 'Adresse email invalide.';
        elseif ($model->emailTaken($old['email'], (int) $u['id_utilisateur'])) $errors['email'] = 'Cet email est déjà utilisé par un autre compte.';
        if (!Validator::phone($old['telephone']))       $errors['telephone'] = 'Numéro de téléphone invalide.';

        if (!$errors) {
            // Le rôle n'est jamais modifiable ici (seul l'administrateur peut le changer)
            $model->updateProfile((int) $u['id_utilisateur'], $old);
            flash('success', 'Votre profil a été mis à jour.');
            $this->redirect('espace/profil');
        }
        $this->view('espace/profil', ['title' => 'Mon profil — ' . APP_NAME, 'errors' => $errors, 'pwdErrors' => [], 'old' => $old], 'espace');
    }

    public function updateMotDePasse(): void
    {
        $this->requirePost();
        $u = Auth::user();
        $model = new Utilisateur();
        $full = $model->findByEmail($u['email']);
        $actuel = $_POST['actuel'] ?? '';
        $nouveau = $_POST['nouveau'] ?? '';
        $conf = $_POST['confirmation'] ?? '';
        $errors = [];
        if (!is_string($actuel) || !password_verify($actuel, $full['mot_de_passe']))  $errors['actuel'] = 'Mot de passe actuel incorrect.';
        if (!is_string($nouveau) || !Validator::password($nouveau))                   $errors['nouveau'] = 'Au moins 8 caractères, dont une lettre et un chiffre.';
        elseif ($nouveau !== $conf)                                                   $errors['confirmation'] = 'Les deux mots de passe ne sont pas identiques.';
        if (!$errors) {
            $model->updatePassword((int) $u['id_utilisateur'], $nouveau);
            session_regenerate_id(true);
            flash('success', 'Votre mot de passe a été modifié.');
            $this->redirect('espace/profil');
        }
        $this->view('espace/profil', ['title' => 'Mon profil — ' . APP_NAME, 'errors' => [], 'pwdErrors' => $errors, 'old' => $u], 'espace');
    }
}
