<?php

require_once __DIR__ . '/functions.php';
$customers = findCustomer();

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <h1 class="title"><a href="index.php">顧客管理アプリ</a></h1>
        <div class="customer-area">
            <h2 class="sub-title">顧客リスト</h2>
            <table class="customer-list">
                <thead>
                    <tr>
                        <th class="customer-company">会社名</th>
                        <th class="customer-name">氏名</th>
                        <th class="customer-email">メールアドレス</th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= h($customer['company']) ?></td>
                            <td><?= h($customer['name']) ?></td>
                            <td><?= h($customer['email']) ?></td>
                            <td><a href="edit.php?id=<?= h($customer['id']) ?>" class="btn edit-btn">編集</a></td>
                            <td><a href="delete.php?id=<?= h($customer['id']) ?>" class="btn delete-btn">削除</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <a href="new.php" class="btn new-btn">新規登録</a>

        </div>
    </div>
</body>

</html>