<?php
class ContactController extends Controller
{
    public function index(): void
    {
        $errors = [];
        $old = ['nom' => '', 'email' => '', 'sujet' => '', 'message' => ''];
        $u = Auth::user();
        if ($u) {
            $old['nom'] = $u['prenom'] . ' ' . $u['nom'];
            $old['email'] = $u['email'];
        }

        if (is_post()) {
            Csrf::check();
            foreach ($old as $k => $_) {
                $old[$k] = $this->post($k);
            }
            if ($this->post('website') !== '') {          // champ piège réservé aux robots
                flash('success', 'Merci, votre message a bien été envoyé.');
                $this->redirect('contact');
            }
            if (!Validator::length($old['nom'], 2, 100))       $errors['nom'] = 'Indiquez votre nom (2 à 100 caractères).';
            if (!Validator::email($old['email']))              $errors['email'] = 'Adresse email invalide.';
            if (!Validator::length($old['sujet'], 3, 150))     $errors['sujet'] = 'Le sujet doit contenir entre 3 et 150 caractères.';
            if (!Validator::length($old['message'], 10, 2000)) $errors['message'] = 'Le message doit contenir entre 10 et 2000 caractères.';
            if (!$errors) {
                (new Message())->create($old);
                flash('success', 'Merci, votre message a bien été envoyé. Nous vous répondrons rapidement.');
                $this->redirect('contact');
            }
        }
        $this->view('contact/index', ['title' => 'Contact — ' . APP_NAME, 'errors' => $errors, 'old' => $old]);
    }
}
