<?php

namespace App\Model;


class CommandManager extends AbstractManager
{
    
    const TABLE = 'command';

    
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $pokemon
     * @return int
     */
    public function insert(array $data): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, address, total, created_at) VALUES (:name, :address, :total, :created_at)");
        $statement->bindValue('name', $data['name'], \PDO::PARAM_STR);
        $statement->bindValue('address', $data['address'], \PDO::PARAM_STR);
        $statement->bindValue('total', $data['total'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $data['date']);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $pokemon
     * @return bool
     */
    public function update(array $pokemon):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name=:name, img=:img, content=:content, price=:price WHERE id=:id");
        $statement->bindValue('id', $pokemon['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $pokemon['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $pokemon['price'], \PDO::PARAM_INT);
        $statement->bindValue('img', $pokemon['img'], \PDO::PARAM_STR);
        $statement->bindValue('content', $pokemon['content'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
