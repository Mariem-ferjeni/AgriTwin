<?php
require_once __DIR__ . "/../app/bootstrap.php";
Auth::requireAdmin();
require_once __DIR__ . "/../includes/admin_layout.php";

$modele = new Message();

// Actions (POST + CSRF) : marquer comme lu / supprimer
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Csrf::check();
    $id = ctype_digit((string) ($_POST['id'] ?? '')) ? (int) $_POST['id'] : 0;
    $action = $_POST['action'] ?? '';
    if ($id && $action === 'lu') {
        $modele->markRead($id);
        flash('success', "Message marqué comme lu.");
    } elseif ($id && $action === 'supprimer') {
        $modele->delete($id);
        flash('success', "Message supprimé.");
    }
    header("Location: messages.php");
    exit;
}

$messages = $modele->all();
admin_head("Messages de contact");
?>
            <h2>Messages de contact</h2>
            <section class="panel">
                <p style="margin-bottom:15px;"><?= count($messages) ?> message(s), dont <?= $modele->countUnread() ?> non lu(s).</p>
                <?php foreach ($messages as $m): ?>
                    <article class="message-card <?= $m['lu'] ? '' : 'unread' ?>">
                        <strong><?= htmlspecialchars($m['sujet']) ?></strong>
                        <div class="message-meta">
                            <?= htmlspecialchars($m['nom']) ?> —
                            <a href="mailto:<?= htmlspecialchars($m['email']) ?>"><?= htmlspecialchars($m['email']) ?></a> —
                            <?= htmlspecialchars(date('d/m/Y H:i', strtotime($m['date_envoi']))) ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($m['message'])) ?></p>
                        <div class="message-actions">
                            <?php if (!$m['lu']): ?>
                                <form method="POST"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $m['id_message'] ?>"><input type="hidden" name="action" value="lu"><button class="view-button" type="submit">Marquer comme lu</button></form>
                            <?php endif; ?>
                            <form method="POST" onsubmit="return confirm('Supprimer ce message ?');"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $m['id_message'] ?>"><input type="hidden" name="action" value="supprimer"><button class="delete-button" type="submit">Supprimer</button></form>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php if (!$messages): ?><p class="empty-message">Aucun message reçu pour le moment.</p><?php endif; ?>
            </section>
<?php admin_foot();
