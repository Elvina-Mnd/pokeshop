<?php

namespace App\Model;

/**
 *
 */
class PokemonManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'pokemon';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function searchPokemon(string $term): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE name LIKE :search ORDER BY name ASC");
        $statement->bindValue('search', $term.'%', \PDO::PARAM_STR);
        $statement->execute();
        $pokemons = $statement->fetchAll();
        return $pokemons;
    }

    /**
     * @param array $pokemon
     * @return int
     */
    public function insert(array $pokemon): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, img, content) VALUES (:name, :img, :content)");
        $statement->bindValue('name', $pokemon['name'], \PDO::PARAM_STR);
        $statement->bindValue('img', $pokemon['img'], \PDO::PARAM_STR);
        $statement->bindValue('content', $pokemon['content'], \PDO::PARAM_STR);

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
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET name=:name, price=:price, img=:img WHERE id=:id");
        $statement->bindValue('id', $pokemon['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $pokemon['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $pokemon['price'], \PDO::PARAM_INT);
        $statement->bindValue('img', $pokemon['img'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
