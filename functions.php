<?php

require_once __DIR__ . '/config.php';

function connectdb()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function findCustomer()
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            customers;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addCustomer($company, $name, $email)
{
    $dbh = connectDb();
    $sql = <<<EOM
        INSERT INTO
            customers
            (company, name, email)
            VALUES
            (:company, :name, :email);
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
}

function findCustomerForId($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        SELECT
            *
        FROM
            customers
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function editCustomer($id, $company, $name, $email)
{
    $dbh = connectDb();
    $sql = <<<EOM
        UPDATE
            customers
        SET
            company = :company,
            name = :name,
            email = :email
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':company', $company, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
}

function deleteCustomer($id)
{
    $dbh = connectDb();
    $sql = <<<EOM
        DELETE FROM
            customers
        WHERE
            id = :id;
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function insertValidate($company, $name, $email)
{
    $validates = [];
    if (empty($company)) {
        $validates[] = MSG_COMPANY_REQUIRED;
    }
    if (empty($name)) {
        $validates[] = MSG_NAME_REQUIRED;
    }
    if (empty($email)) {
        $validates[] = MSG_EMAIL_REQUIRED;
    }
    return $validates;
}

function insertEditValidate($customer, $company, $name, $email)
{
    $validates = [];
    if ($customer['company'] == $company && $customer['name']  == $name && $customer['email'] == $email) {
        $validates[] = MSG_NO_CHANGE;
    }
    if (empty($company)) {
        $validates[] = MSG_COMPANY_REQUIRED;
    }
    if (empty($name)) {
        $validates[] = MSG_NAME_REQUIRED;
    }
    if (empty($email)) {
        $validates[] = MSG_EMAIL_REQUIRED;
    }
    return $validates;
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

?>