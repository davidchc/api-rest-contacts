<?php

namespace App\Models\Mappers;

use App\Models\Entities\Contact;

class ContactMapper
{
  protected $pdo;

  public function __construct(\PDO $pdo)
  {
      $this->pdo = $pdo;
  }

  public function insert(Contact $contact)
  {
        $stmt = $this->pdo->prepare("INSERT INTO contacts SET name = :name, email = :email, telephone = :telephone ");
        $stmt->bindValue(':name', $contact->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $contact->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $contact->getTelephone(), \PDO::PARAM_STR);
        $stmt->execute();
        $last_id =  $this->pdo->lastInsertId();
        return $this->getContact($last_id);
  }

    public function update(Contact $contact)
    {
        $stmt = $this->pdo->prepare("UPDATE  contacts SET name = :name, email = :email, telephone = :telephone WHERE id = :id");
        $stmt->bindValue(':name', $contact->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $contact->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $contact->getTelephone(), \PDO::PARAM_STR);
        $stmt->bindValue(':id', $contact->getId(), \PDO::PARAM_INT);
        $stmt->execute();
        return $this->getContact($contact->getId());

    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM contacts WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getContact($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Entities\Contact');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getContacts(array $filtes = [])
    {
        $stmt = $this->pdo->prepare("SELECT * FROM contacts");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Entities\Contact');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}