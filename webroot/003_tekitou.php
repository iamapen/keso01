<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';
$result = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['source'] ?? '';
    $result = array_values((new \Keso01\Domain\UseCase\TekitouUseCase())->invoke($input));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<h1>手抜きな前処理</h1>
<a href="/">戻る</a>
<hr>

<div>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
        <textarea name="source" cols="70" rows="10"><?= htmlspecialchars($_POST['source'] ?? '') ?></textarea>
        <br>
        <button type="submit">送信</button>
    </form>
</div>

<div style="background-color: #ccc; height:300px; overflow:scroll; font-size: small">
    <table>
        <tr>
            <th>seq</th>
            <th>形態素</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($result as $i => $item): ?>
            <tr>
                <td><?= $i+1?></td>
                <td><?= htmlspecialchars(array_shift($item), ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars(implode(',', $item), ENT_QUOTES) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
