<?php

use App\HTML\Form;
use App\Table\AgentsTable;
use Database\DBConnection;
use Valitron\Validator;

$title = 'Editions';

$pdo = new DBConnection();
$agentTable = new AgentsTable($pdo->getPDO());
$agent = $agentTable->find($params['id']);
$success = false;

$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new Validator($_POST);
    $v->labels(array(
        'lastname' => 'Le nom',
        'firstname' => 'Prénom',
        'bod' => 'date de naissance'
    ));
    $v->rule('required', ['agents_lastname', 'agents_firstname']);
    $agent->setAgentsLastname($_POST['agents_lastname']);
    $agent->setAgentsFirstname($_POST['agents_firstname']);
    $agent->setAgentsBod($_POST['agents_bod']);

    if ($v->validate()) {
        $agentTable->update($agent);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($agent, $errors);
?>

<?php if ($success): ?>
    <div class="alert alert-success">
        L'agent a bien été modifié
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'agent n'a pas pu être modifié, merci de corriger vos erreurs.
    </div>
<?php endif; ?>
<h1>Editer l'agent <?= e($agent->getAgentsLastname()) ?></h1>

<form action="" method="post">
    <?= $form->input('agents_lastname', 'Nom'); ?>
    <?= $form->input('agents_firstname', 'Prénom'); ?>
    <?= $form->input('agents_bod', 'Date de naissance'); ?>
    <button class="btn btn-primary mt-3">Modifier</button>
</form>
