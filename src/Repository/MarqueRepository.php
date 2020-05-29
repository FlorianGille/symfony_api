<?php

namespace App\Repository;

use App\Entity\Marque;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Marque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marque[]    findAll()
 * @method Marque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(EntityManagerInterface $manager, ManagerRegistry $registry)
    {
        parent::__construct($registry, Marque::class);
        $this->manager = $manager;
    }

    public function saveMarque($nom)
    {
        $newMarque = new Marque();

        $newMarque->setNom($nom);

        $this->manager->persist($newMarque);
        $this->manager->flush();
    }

    public function updateMarque(Marque $marque): Marque
    {
        $this->manager->persist($marque);
        $this->manager->flush();

        return $marque;
    }

    public function removeMarque(Marque $marque)
    {
        $this->manager->remove($marque);
        $this->manager->flush();
    }
}
