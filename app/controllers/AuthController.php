<?php
class AuthController extends Controller
{
    public function login(): void
    {
        if (Auth::check()) {
            redirect(Auth::homeUrl());
        }
        $errors = [];
        $email = '';

        if (is_post()) {
            Csrf::check();
            $email = strtolower($this->post('email'));
            $password = $_POST['mot_de_passe'] ?? '';

            if (($_SESSION['login_block_until'] ?? 0) > time()) {
                $min = (int) ceil(($_SESSION['login_block_until'] - time()) / 60);
                $errors[] = "Trop de tentatives échouées. Réessayez dans $min minute(s).";
            } elseif ($email === '' || !is_string($password) || $password === '') {
                $errors[] = 'Saisissez votre email et votre mot de passe.';
            } else {
                $model = new Utilisateur();
                $u = $model->findByEmail($email);
                // password_verify est exécuté même si le compte n'existe pas (temps de réponse identique)
                $hash = $u['mot_de_passe'] ?? '$2y$10$usesomesillystringforsaltandhashinGBsMqvYC7xq0tCz1GkuZ3wZHy';
                if ($u && password_verify($password, $hash)) {
                    $model->rehashIfNeeded((int) $u['id_utilisateur'], $password, $hash);
                    $intended = $_SESSION['intended'] ?? '';
                    Auth::login($u);
                    unset($_SESSION['intended']);
                    flash('success', 'Bienvenue, ' . $u['prenom'] . ' !');
                    redirect($this->safeTarget($intended, $u));
                }
                $fails = ($_SESSION['login_fails'] ?? 0) + 1;
                $_SESSION['login_fails'] = $fails;
                if ($fails >= 5) {
                    $_SESSION['login_block_until'] = time() + 300;
                    $_SESSION['login_fails'] = 0;
                }
                $errors[] = 'Email ou mot de passe incorrect.';
            }
        }
        $this->view('auth/login', ['title' => 'Connexion — ' . APP_NAME, 'errors' => $errors, 'email' => $email]);
    }

    public function register(): void
    {
        if (Auth::check()) {
            redirect(Auth::homeUrl());
        }
        $errors = [];
        $old = ['nom' => '', 'prenom' => '', 'email' => '', 'telephone' => ''];

        if (is_post()) {
            Csrf::check();
            foreach ($old as $k => $_) {
                $old[$k] = $this->post($k);
            }
            $old['email'] = strtolower($old['email']);
            $pwd  = $_POST['mot_de_passe'] ?? '';
            $conf = $_POST['confirmation'] ?? '';
            $pwd = is_string($pwd) ? $pwd : '';
            $model = new Utilisateur();

            if (!Validator::length($old['nom'], 2, 100))    $errors['nom'] = 'Le nom doit contenir entre 2 et 100 caractères.';
            if (!Validator::length($old['prenom'], 2, 100)) $errors['prenom'] = 'Le prénom doit contenir entre 2 et 100 caractères.';
            if (!Validator::email($old['email']))           $errors['email'] = 'Adresse email invalide.';
            elseif ($model->emailTaken($old['email']))      $errors['email'] = 'Un compte existe déjà avec cet email.';
            if (!Validator::phone($old['telephone']))       $errors['telephone'] = 'Numéro de téléphone invalide.';
            if (!Validator::password($pwd))                 $errors['mot_de_passe'] = 'Le mot de passe doit contenir au moins 8 caractères, dont une lettre et un chiffre.';
            elseif ($pwd !== $conf)                         $errors['confirmation'] = 'Les deux mots de passe ne sont pas identiques.';

            if (!$errors) {
                // Le rôle est toujours « agriculteur » à l'inscription : il ne vient jamais du formulaire
                $id = $model->create($old + ['mot_de_passe' => $pwd, 'role' => 'agriculteur']);
                Auth::login($model->find($id));
                flash('success', 'Votre compte est créé. Commencez par déclarer votre première exploitation.');
                redirect(url('espace'));
            }
        }
        $this->view('auth/register', ['title' => 'Créer un compte — ' . APP_NAME, 'errors' => $errors, 'old' => $old]);
    }

    public function logout(): void
    {
        $this->requirePost();
        Auth::logout();
        flash('success', 'Vous êtes déconnecté(e). À bientôt !');
        redirect(url('home'));
    }

    /** N'accepte qu'une adresse interne au site, adaptée au rôle (empêche les redirections vers l'extérieur). */
    private function safeTarget(string $intended, array $u): string
    {
        $base = base_url();
        $ok = $intended !== '' && $intended[0] === '/' && !str_starts_with($intended, '//') && !str_contains($intended, "\n")
            && !str_contains($intended, "\r") && str_starts_with($intended, $base . '/');
        if ($ok) {
            $isAdminUrl = str_starts_with($intended, $base . '/admin/');
            if (($u['role'] === 'admin') === $isAdminUrl && !str_contains($intended, 'auth/')) {
                return $intended;
            }
        }
        return Auth::homeUrl($u);
    }
}
